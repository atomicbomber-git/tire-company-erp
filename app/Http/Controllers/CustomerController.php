<?php

namespace App\Http\Controllers;

use App\Customer;
use App\SalesOrder;
use App\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            "auth"
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $sales_order_items = SalesOrderItem::query()
            ->select("sales_order_id")
            ->selectRaw("COALESCE(SUM(price * quantity), 0) AS total")
            ->groupBy("sales_order_id");

        $sales_orders = SalesOrder::query()
            ->where("is_paid", false)
            ->leftJoinSub($sales_order_items, "total", "total.sales_order_id", "=", "sales_orders.id");

        $customers = Customer::query()
            ->selectRaw("customers.*")
            ->addSelect(DB::raw("COALESCE(sales_orders_total.total, 0) AS used_credit_limit"))
            ->addSelect(DB::raw("credit_limit - COALESCE(sales_orders_total.total, 0) AS remaining_credit_limit"))
            ->leftJoinSub($sales_orders, "sales_orders_total", "sales_orders_total.customer_id", "=", "customers.id")
            ->get();

        return view("customer.index", compact(
            "customers"
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
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
