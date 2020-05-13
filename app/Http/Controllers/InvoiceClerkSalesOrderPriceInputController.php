<?php

namespace App\Http\Controllers;

use App\SalesOrder;
use Illuminate\Http\Request;

class InvoiceClerkSalesOrderPriceInputController extends Controller
{
    public function create(Request $request, SalesOrder $sales_order)
    {
        $sales_order->load([
            "customer",
            "sales_order_items.item"
        ]);

        return response()->view("invoice-clerk-sales-order-price-input.create", compact(
            "sales_order"
        ));
    }

    public function store(Request $request, SalesOrder $sales_order)
    {
        return $sales_order;
    }
}
