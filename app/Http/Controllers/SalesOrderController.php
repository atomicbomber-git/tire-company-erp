<?php

namespace App\Http\Controllers;

use App\Constants\MessageState;
use App\SalesOrder;
use App\SalesOrderItem;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales_orders = SalesOrder::query()
            ->with("customer")
            ->leftJoinSub(
                SalesOrderItem::query()
                    ->select("sales_order_id")
                    ->selectRaw("SUM(price) AS price_sum")
                    ->groupBy("sales_order_id")
                , "sales_order_items", "sales_orders.id", "=", "sales_order_items.sales_order_id"
            )
            ->get();

        return response()->view("sales-order.index", compact(
            "sales_orders"
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SalesOrder  $sales_order
     * @return \Illuminate\Http\Response
     */
    public function show(SalesOrder $sales_order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalesOrder  $sales_order
     * @return \Illuminate\Http\Response
     */
    public function edit(SalesOrder $sales_order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalesOrder  $sales_order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SalesOrder $sales_order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalesOrder  $sales_order
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(SalesOrder $sales_order)
    {
        $sales_order->forceDelete();

        return redirect()
            ->route("sales-order.index")
            ->with("messages", [
                [
                    "state" => MessageState::STATE_SUCCESS,
                    "content" => __("messages.delete.success")
                ]
            ]);
    }
}
