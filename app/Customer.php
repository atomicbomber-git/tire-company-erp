<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property double credit_limit
 */
class Customer extends Model
{
    public static function remainingCreditLimitQuery()
    {
        // Check if the credit limit is exceeded
        $sales_order_items = SalesOrderItem::query()
            ->select("sales_order_id")
            ->selectRaw("COALESCE(SUM(price * quantity), 0) AS total")
            ->groupBy("sales_order_id");

        $sales_orders = SalesOrder::query()
            ->select(DB::raw("SUM(total.total) AS total"), "customer_id")
            ->where("is_paid", false)
            ->groupBy("customer_id")
            ->leftJoinSub($sales_order_items, "total", "total.sales_order_id", "=", "sales_orders.id");

        return Customer::query()
            ->addSelect(DB::raw("COALESCE(sales_orders_total.total, 0) AS used_credit_limit"))
            ->addSelect(DB::raw("credit_limit - COALESCE(sales_orders_total.total, 0) AS remaining_credit_limit"))
            ->leftJoinSub($sales_orders, "sales_orders_total", "sales_orders_total.customer_id", "=", "customers.id");
    }
}
