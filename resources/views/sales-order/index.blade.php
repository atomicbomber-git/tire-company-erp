@extends("layouts.app")
@section('content')
    <div>
        <h1> Sales Orders</h1>

        @include("layouts._messages")

        <table class="table table-striped table-sm">
            <thead class="thead thead-dark">
            <tr>
                <th> #</th>
                <th> Customer</th>
                <th> Sold At</th>
                <th> To Be Paid Before</th>
                <th class="text-right"> Total Paid (Rp.)</th>
                <th> Control</th>
            </tr>
            </thead>

            <tbody>
            @foreach($sales_orders AS $sales_order)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $sales_order->customer->name }} </td>
                    <td> {{ $sales_order->sold_at }} </td>
                    <td> {{ $sales_order->to_be_paid_before }} </td>
                    <td class="text-right"> {{ \App\Helpers\Formatter::currency($sales_order->price_sum) }} </td>
                    <td>
                        <form
                            class="d-inline-block"
                            method="POST"
                            action="{{ route("sales-order.destroy", $sales_order) }}">
                            @csrf
                            @method("DELETE")
                            <button class="btn btn-danger btn-sm">
                                Delete
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
