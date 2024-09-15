<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\AttachmentController;
use App\Http\Controllers\Dashboard\PaidInvoiceController;
use App\Http\Controllers\Dashboard\UnPaidInvoiceController;
use App\Http\Controllers\Dashboard\InvoiceDetailsController;
use App\Http\Controllers\Dashboard\ArchivingInvoiceController;
use App\Http\Controllers\Dashboard\PartiallyInvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});






Route::resources([
    'invoices' => InvoiceController::class,
    'invoice_details' => InvoiceDetailsController::class,
    'sections' => SectionController::class,
    'products' => ProductController::class,
    'attachments' => AttachmentController::class,
    'paid_invoices' => PaidInvoiceController::class,
    'unpaid_invoices' => UnPaidInvoiceController::class,
    'partially_invoices' => PartiallyInvoiceController::class,
    'archiving_invoices' => ArchivingInvoiceController::class,



]);
Route::post('restoreDelete/{id}',[InvoiceController::class,'restoreDelete'])->name('invoices.restore');
Route::delete('forceDelete/{id}',[InvoiceController::class,'forceDelete'])->name('invoices.force');
Route::post('statusUpdate/{id}',[InvoiceController::class,'statusUpdate'])->name('invoices.statusUpdate');
Route::get('print_invoice/{id}',[InvoiceController::class,'print'])->name('invoices.print');
Route::get('Mark_All_Read',[InvoiceController::class,'MarkAllRead'])->name('invoices.Mark_All_Read');


Route::get('section/{product_id}',[InvoiceController::class, 'getProduct']);
Route::get('getFile/{invoice_number}/{file_name}',[InvoiceDetailsController::class, 'getFile'])->name('getFile');
Route::get('openFile/{invoice_number}/{file_name}',[InvoiceDetailsController::class, 'openFile'])->name('openFile');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
