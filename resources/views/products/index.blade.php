@extends('layouts.app')

@section('title', 'Product List')

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
                        Product List
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-success float-end">Create</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-end">S. No.</th>
                                    <th>Name</th>
                                    <th>Product Code</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-end">Stock</th>
                                    <th class="text-end">Tax</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="text-end">{{ $loop->iteration }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->product_code }}</td>
                                        <td class="text-end">{{ $product->formatted_price }}</td>
                                        <td class="text-end">{{ $product->stock }}</td>
                                        <td class="text-end">{{ $product->formatted_tax }}</td>
                                        <td>{{ $product->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('products.edit', ['id' => $product->id]) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('products.destroy', ['id' => $product->id]) }}"
                                                class="d-inline-block" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection