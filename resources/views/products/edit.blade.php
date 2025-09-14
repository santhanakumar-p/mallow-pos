@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

    <div class="container mb-4 mt-4">
        <div class="row justify-content-center">
            <div class="col col-md-8">
                <div class="card">
                    <div class="card-header">
                        Edit Product
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary float-end">Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update', ['id' => $product->id]) }}" method="post">
                            @csrf
                            @method('PUT')

                            <div class="mb-2">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label><br>
                                <input type="text" name="name"
                                    id="name"class="form-control @error('name') is-invalid @enderror"
                                    value="{{ $product->name }}" placeholder="Enter name">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="product-code" class="form-label">Product Code <span
                                        class="text-danger">*</span></label><br>
                                <input type="number" name="product_code" id="product-code"
                                    class="form-control @error('product_code') is-invalid @enderror"
                                    value="{{ $product->product_code }}" placeholder="Enter product code">

                                @error('product_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="price" class="form-label">Price <span
                                        class="text-danger">*</span></label><br>
                                <input type="number" name="price" id="price"
                                    class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}" placeholder="Enter price">

                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="stock" class="form-label">Stock <span
                                        class="text-danger">*</span></label><br>
                                <input type="number" name="stock" id="stock"
                                    class="form-control @error('stock') is-invalid @enderror" value="{{ $product->stock }}"
                                    placeholder="Enter stock">

                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="tax" class="form-label">Tax <span class="text-danger">*</span></label><br>
                                <select name="tax" id="tax" class="form-control form-select @error('tax') is-invalid @enderror">
                                    <option value="" disabled {{ $product->tax === null ? 'selected' : '' }}> -- select tax -- </option>
                                    <option value="0"  @selected((int)$product->tax === 0)>0%</option>
                                    <option value="5"  @selected((int)$product->tax === 5)>5%</option>
                                    <option value="18" @selected((int)$product->tax === 18)>18%</option>
                                    <option value="40" @selected((int)$product->tax === 40)>40%</option>
                                    </select>

                                    @error('tax')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="mb-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection