@extends('layouts.app')

@section('content')
    <div>
        <h1> Sales Orders</h1>

        @include("layouts._messages")

        <table class="table table-striped table-sm">
            <thead class="thead thead-dark">
            <tr>
                <th> #</th>
                <th> Customer</th>
                <th> Created At</th>
                <th class="text-center"> Control</th>
            </tr>
            </thead>

            <tbody>
            @foreach($sales_orders AS $sales_order)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $sales_order->customer->name }} </td>
                    <td> {{ $sales_order->created_at }} </td>
                    <td>
                        <a class="btn btn-dark btn-sm"
                           href="{{ route("invoice-clerk-sales-order-price-input", $sales_order) }}">
                            Input Price / Approve
                        </a>

                        <form
                            class="d-inline-block"
                            method="POST"
                              action="{{ route("invoice-clerk-sales-order-mark-paid", $sales_order)  }}">
                            @csrf

                            <button class="btn btn-success btn-sm">
                                Mark As Paid
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
