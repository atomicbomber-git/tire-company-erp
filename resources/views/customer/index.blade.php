@extends("layouts.app")

@section("content")
    <div>
        <h1> Customers </h1>

        <table class="table table-striped table-sm">
            <thead class="thead thead-dark">
            <tr>
                <th> # </th>
                <th> Name </th>
                <th> Address </th>
                <th class="text-right" style="width: 400px"> Credit Limit / Remaining (Rp.) </th>
                <th class="text-center"> Control </th>
            </tr>
            </thead>

            <tbody>
            @foreach($customers AS $customer)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $customer->name }} </td>
                    <td> {{ $customer->address }} </td>
                    <td class="text-right" style="width: 400px">
                        {{ \App\Helpers\Formatter::currency($customer->credit_limit) }} /
                        {{ \App\Helpers\Formatter::currency($customer->remaining_credit_limit) }}
                    </td>
                    <td class="d-flex justify-content-center">

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
