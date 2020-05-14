@extends('layouts.app')

@section('content')
    <h1> Sales Order Price Input </h1>

    @include("layouts._messages")

    <invoice-clerk-sales-order-price-input-create
        :sales_order='{{ json_encode($sales_order) }}'
        submit_url="{{ route("invoice-clerk-sales-order-price-input", $sales_order) }}"
        redirect_url="{{ route("invoice-clerk-sales-order.index") }}"
    ></invoice-clerk-sales-order-price-input-create>
@endsection
