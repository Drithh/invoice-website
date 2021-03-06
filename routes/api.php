<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('invoices/create/penjualan', [InvoiceController::class, 'createPenjualan'])->middleware(['auth'])->name('invoices.penjualan');
Route::post('invoices/create/pembelian', [InvoiceController::class, 'createPembelian'])->middleware(['auth'])->name('invoices.pembelian');

Route::get('invoices/all', [InvoiceController::class, 'getAllInvoices'])->middleware('auth')->name('invoices.all');
Route::get('invoices/year', [InvoiceController::class, 'getDataPerYear'])->middleware('auth')->name('invoices.year');
Route::get('invoices/month', [InvoiceController::class, 'getDataPerMonth'])->middleware('auth')->name('invoices.month');
Route::get('invoices/week', [InvoiceController::class, 'getDataPerWeek'])->middleware('auth')->name('invoices.week');
Route::get('invoices/user', [InvoiceController::class, 'getUserInvoices'])->middleware('auth')->name('invoices.user');
Route::get('invoices/average', [InvoiceController::class, 'getAverageSale'])->middleware('auth')->name('invoices.average');
Route::get('invoices/sell/{id}', [InvoiceController::class, 'getInvoiceSell'])->middleware('auth')->name('invoices.sell');
Route::get('invoices/buy/{id}', [InvoiceController::class, 'getInvoiceBuy'])->middleware('auth')->name('invoices.buy');
Route::post('invoices/toggle/{invoiceNumber}', [InvoiceController::class, 'toggleLink'])->middleware('auth')->name('invoices.toggle');
Route::get('invoices/{invoiceNumber}', [InvoiceController::class, 'getInvoice'])->name('invoices.show');

Route::get('items/list', [ItemController::class, 'getItemsList'])->middleware('auth')->name('items.list');
Route::get('items/grid', [ItemController::class, 'getItemsGrid'])->middleware('auth')->name('items.grid');
Route::get('item/getItemDetails/{id}', [ItemController::class, 'getItemDetail'])->middleware(['auth'])->name('item.get.detail');


Route::post('item/search', [ItemController::class, 'itemSearch'])->middleware(['auth'])->name('item.search');
Route::post('item/updateStock', [ItemController::class, 'updateStock'])->middleware(['auth'])->name('item.update.stock');
Route::get('item/getStock', [ItemController::class, 'getStock'])->middleware(['auth'])->name('item.get.stock');
Route::get('item/pieChart', [ItemController::class, 'pieChart'])->middleware(['auth'])->name('item.pie.chart');
Route::get('item/getAll', [ItemController::class, 'getAll'])->middleware(['auth'])->name('item.get.all');

Route::post('supplier/search', [SupplierController::class, 'search'])->middleware(['auth'])->name('supplier.search');

Route::get('user/get', [UserController::class, 'index'])->middleware(['auth'])->name('user.index');
Route::get('user/get/{id}', [UserController::class, 'get'])->middleware(['auth'])->name('user.get');
Route::get('user/get', [UserController::class, 'index'])->middleware(['auth'])->name('user.get');
Route::post('user/update', [UserController::class, 'update'])->middleware(['auth'])->name('user.update');
