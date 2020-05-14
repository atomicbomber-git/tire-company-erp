<?php

namespace App\Http\Controllers;

use App\Constants\MessageState;
use App\Customer;
use App\Helpers\Formatter;
use App\SalesOrder;
use App\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

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
        $credit_limit = $sales_order->customer->credit_limit;

        $initial_remaining_credit_limit = Customer::remainingCreditLimitQuery()
            ->where("id", $sales_order->customer_id)
            ->value("remaining_credit_limit");

        $data = $request->validate([
            "sales_order_items" => ["required", "array"],
            "sales_order_items.*.id" => ["required", "exists:sales_order_items,id"],
            "sales_order_items.*.price" => ["required", "numeric"],
        ]);

        DB::beginTransaction();

        foreach ($data["sales_order_items"] as $sales_order_item_data) {
            SalesOrderItem::query()->where([
                "id" => $sales_order_item_data["id"],
            ])->update([
                "price" => $sales_order_item_data["price"]
            ]);
        }

        $remaining_credit_limit = Customer::remainingCreditLimitQuery()
            ->where("id", $sales_order->customer_id)
            ->value("remaining_credit_limit");

        $request->validate([
            "sales_order_items" => function($attribute, $value, $fail) use($remaining_credit_limit, $initial_remaining_credit_limit) {
                if ($remaining_credit_limit < 0) {
                    $fail("Remaining credit limit is " . Formatter::currency($initial_remaining_credit_limit) );
                }
            }
        ]);

        DB::commit();

        session()->flash("messages", [
            [
                "state" => MessageState::STATE_SUCCESS,
                "content" => __("messages.update.success")
            ]
        ]);

        return new Response($data, 200);
    }
}
