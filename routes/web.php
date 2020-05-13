<?php

use App\Helpers\DefaultRouteNameResolver;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceClerkSalesOrderController;
use App\Http\Controllers\InvoiceClerkSalesOrderPriceInputController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalespersonSalesOrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    "register" => false,
    "reset" => false,
    "confirm" => false,
    "verify" => false,
]);

Route::get('/', function () {
    return redirect()->route(
        DefaultRouteNameResolver::get(auth()->user())
    );
});

Route::resource('customer', class_basename(CustomerController::class));
Route::resource('sales-order', class_basename(SalesOrderController::class));
Route::resource('item', class_basename(ItemController::class));
Route::resource('salesperson-sales-order', class_basename(SalespersonSalesOrderController::class));
Route::resource('invoice-clerk-sales-order', class_basename(InvoiceClerkSalesOrderController::class));

Route::get('invoice-clerk-sales-order/{sales_order}/price-input', [InvoiceClerkSalesOrderPriceInputController::class, "create"])
    ->name('invoice-clerk-sales-order-price-input');

Route::post('invoice-clerk-sales-order/{sales_order}/price-input', [InvoiceClerkSalesOrderPriceInputController::class, "store"])
    ->name('invoice-clerk-sales-order-price-input');
