@extends('layouts.app')

@section('title', 'Order List')

@section('content')

<div class="container mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col col-md-12">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Order List
                    <a href="{{ route('orders.create') }}" class="btn btn-sm btn-success float-end">Create</a>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-end">S. No.</th>
                                    <th>Order ID</th>
                                    <th>Customer Email</th>
                                    <th>Order Date</th>
                                    <th class="text-end">Total Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-end">{{ $loop->iteration }}</td>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer_email }}</td>
                                        <td>{{ $order->order_date->format('M d, Y') }}</td>
                                        <td class="text-end">{{$order->formatted_total_amount }}</td>
                                        <td>
                                            <a href="{{ route('orders.details', $order->id) }}" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    @else
                        <p>No orders found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
