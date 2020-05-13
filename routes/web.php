<?php

use App\Helpers\DefaultRouteNameResolver;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceClerkSalesOrder;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalespersonSalesOrder;
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
Route::resource('salesperson-sales-order', class_basename(SalespersonSalesOrder::class));
Route::resource('invoice-clerk-sales-order', class_basename(InvoiceClerkSalesOrder::class));
