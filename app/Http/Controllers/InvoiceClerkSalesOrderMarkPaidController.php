<?php

namespace App\Http\Controllers;

use App\Constants\MessageState;
use App\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceClerkSalesOrderMarkPaidController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, SalesOrder $sales_order)
    {
        $sales_order->update([
            "is_paid" => true,
        ]);

        session()->flash("messages", [
            [
                "state" => MessageState::STATE_SUCCESS,
                "content" => __("messages.update.success")
            ]
        ]);

        return redirect()->back();
    }
}
