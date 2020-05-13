@extends('layouts.app')

@section('content')
    <div>
        <h1> Sales Orders </h1>

        @include("layouts._messages")

        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Customer </th>
                    <th> Created At </th>
                    <th> Control </th>
                </tr>
            </thead>

            <tbody>
            @foreach($sales_orders AS $sales_order)
                <tr>
                    <td> {{ $sales_order->customer->name }} </td>
                    <td> {{ $sales_order->customer->name }} </td>
                    <td> {{ $sales_order->customer->name }} </td>
                    <td> {{ $sales_order->customer->name }} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
