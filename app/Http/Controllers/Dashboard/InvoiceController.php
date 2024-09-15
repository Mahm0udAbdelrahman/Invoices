<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use App\Notifications\add_invoice_new;
use App\Notifications\AddInvoice;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachment;
use App\Http\Controllers\Controller;
use App\Mail\EmailAddInoivce;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Invoice::all();
        return view('invoices.invoices',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $invoice = Invoice::create([
            'invoice_number' => $request->invoice_number ,
            'invoice_Date' => $request->invoice_Date ,
            'Due_date' => $request->Due_date ,
            'product' => $request->product,
            'section_id' => $request->Section ,
            'Amount_collection' => $request->Amount_collection ,
            'Amount_Commission' => $request->Amount_Commission ,
            'Discount' => $request->Discount ,
            'Value_VAT' => $request->Value_VAT ,
            'Rate_VAT' => $request->Rate_VAT ,
            'Total' => $request->Total ,
            'note' => $request->note ,
        ]);
$invoice_id = Invoice::latest()->first()->id;
        InvoiceDetails::create([
        'invoice_id' => $invoice->id,
        'invoice_number' => $request->invoice_number,
        'product' => $request->product,
        'section' => $request->Section,
        'note' => $request->note ,
        'user' => Auth::user()->name
        ]);

        if ($request->hasFile('file_name')) {
            $image = $request->file('file_name');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;
            InvoiceAttachment::create([
                'invoice_id' => $invoice->id,
                'invoice_number' => $request->invoice_number,
                'file_name' => $request->file_name,
                'created_by' => Auth::user()->name
                ]);
            $imageName = $request->file_name->getClientOriginalName();
            $request->file_name->move(public_path('invoice/' . $invoice_number), $imageName);
        }
        // $user = User::first();
        // Notification::send($user , new AddInvoice($invoice_id));

        $user = User::get();
        $invoices = Invoice::latest()->first();
        Notification::send($user , new add_invoice_new($invoices));

        return back()->with('Add','تم اضافه الفاتوره بالنجاح');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $invoice = Invoice::findOrFail($id);
        $sections =  Section::all();
        $products =  Product::all();


        return view('invoices.status_update',compact('invoice','sections','products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $sections =  Section::all();
        $products =  Product::all();


        return view('invoices.edit_invoice',compact('invoice','sections','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        return back()->with('Add','تم تعديل الفاتوره بالنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return back()->with('Add','تم الحذف موقت الفاتوره بالنجاح');
    }
    public function restoreDelete(string $id)
    {

        $invoice = Invoice::withTrashed()->findOrFail($id);
        $invoice->restore();
        return back()->with('Add','تم الحذف موقت الفاتوره بالنجاح');
    }

    public function forceDelete(string $id ,Request $request)
    {

        $invoice = Invoice::withTrashed()->findOrFail($id);
         $details = InvoiceAttachment::where('invoice_id',$invoice)->pluck('invoice_number');
        if(!$details)
        {
            Storage::disk('public_uploads')->deleteDirectory($details);
        }
        $invoice->forceDelete();
        return back()->with('Add','تم الحذف موقت الفاتوره بالنجاح');
    }

    public function getProduct($product_id)
    {
        $product = Product::where('section_id',$product_id)->pluck('name','id');
        return json_encode($product);
    }

    public function statusUpdate(string $id ,Request $request)
    {


            $invoices = Invoice::findOrFail($id);

            if ($request->status === '1') {

                $invoices->update([
                    'status' => 1,
                    'Payment_Date' => $request->Payment_Date,
                ]);

                InvoiceDetails::create([
                    'invoice_id' => $request->invoice_id,
                    'invoice_number' => $request->invoice_number,
                    'product' => $request->product,
                    'section' => $request->section,
                    'status' => 1,
                    'note' => $request->note,
                    'Payment_Date' => $request->Payment_Date,
                    'user' => (Auth::user()->name),
                ]);
            }

            else {
                $invoices->update([
                    'status' => 3,
                    'Payment_Date' => $request->Payment_Date,
                ]);
                InvoiceDetails::create([
                    'invoice_id' => $request->invoice_id,
                    'invoice_number' => $request->invoice_number,
                    'product' => $request->product,
                    'section' => $request->section,
                    'status' => 3,
                    'note' => $request->note,
                    'Payment_Date' => $request->Payment_Date,
                    'user' => (Auth::user()->name),
                ]);
            }



            session()->flash('Status_Update');
            return redirect()->route('invoices.index');



    }

    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);



        return view('invoices.print_invoice',compact('invoice'));
    }

    public function MarkAllRead()
    {
       $notification =  auth()->user()->unreadNotifications;
       if($notification)
       {
            $notification->markAsRead();
            return back();
       }
    }
}
