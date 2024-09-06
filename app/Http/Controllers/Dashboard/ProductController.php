<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        $data  = Product::latest()->get();
        $sections  = Section::all();
       return view('products.products',compact('data','sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
         

        $data = $request->validated();

        Product::create($data);

        return redirect()->route('products.index')->with('success','تم انشاء بالنجاح');



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {



       $product = Product::findOrFail($id);
       $sections = Section::all();

       return view('products.productsEdit',compact('product','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {

        $data = $request->validated();


        $product = Product::findOrFail($id);

        $product->update($data);

        return redirect()->route('products.index')->with('success','تم تعديل بالنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

       $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success','تم الحذف بالنجاح');

    }
}
