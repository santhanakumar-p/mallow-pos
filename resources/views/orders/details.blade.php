@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Order Details - #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p><strong>Order Date:</strong> {{ $order->order_date->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Order Summary</h6>
                            <p><strong>Total Amount: </strong>{{ $order->formatted_total_amount }}</p>
                        </div>
                    </div>

                    <h6>Order Items</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Product Code</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Tax %</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->product->product_code }}</td>
                                        <td>{{ $item->formatted_unit_price }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->formatted_tax_percentage  }}</td>
                                        <td>{{ $item->formatted_total_amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
