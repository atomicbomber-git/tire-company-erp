@extends('layouts.app')

@section('content')
    <h1> Sales Order Price Input </h1>

    <invoice-clerk-sales-order-price-input-create
        :sales_order='{{ json_encode($sales_order) }}'
    ></invoice-clerk-sales-order-price-input-create>
@endsection
