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
                <th class="text-right"> Credit Limit (Rp.) </th>
                <th class="text-center"> Control </th>
            </tr>
            </thead>

            <tbody>
            @foreach($customers AS $customer)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $customer->name }} </td>
                    <td> {{ $customer->address }} </td>
                    <td class="text-right">
                        {{ \App\Helpers\Formatter::currency($customer->credit_limit) }}
                    </td>
                    <td class="d-flex justify-content-center">
                        <a
                            class="btn btn-dark btn-sm mr-2"
                            href="{{ route("customer.edit", $customer) }}">
                            Edit
                            <i class="fas fa-pencil-alt  "></i>
                        </a>

                        <button class="btn btn-sm btn-danger">
                            Delete
                            <i class="fas fa-trash  "></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
