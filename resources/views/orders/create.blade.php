@extends('layouts.app')

@section('title', 'Create Bill')

@section('content')

<div class="container mb-4 mt-4">
    <div class="row justify-content-center">
        <div class="col col-md-10">
            <div class="card">
                <div class="card-header">
                    Create Bill
                    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('orders.store') }}" method="POST" id="billingForm">
                        @csrf
                        
                        <div class="mb-2">
                            <label for="customer_email" class="form-label">Customer Email <span class="text-danger">*</span></label><br>
                            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                                   id="customer_email" name="customer_email" 
                                   value="{{ old('customer_email') }}" placeholder="Enter customer email" required>
                            @error('customer_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>Bill Section</h5>
                                    <button type="button" class="btn btn-secondary" id="addProduct">Add New</button>
                                </div>
                                
                                <div id="productsContainer">
                                    <div class="product-row row mb-2">
                                        <div class="col-md-5">
                                            <label class="form-label">Product ID</label>
                                            <select class="form-select product-select" name="products[0][product_id]" required>
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                            data-price="{{ $product->price }}" 
                                                            data-tax="{{ $product->tax }}"
                                                            data-stock="{{ $product->stock }}">
                                                        {{ $product->product_code }} - {{ $product->name }} (Stock: {{ $product->stock }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" class="form-control quantity-input" name="products[0][quantity]" 
                                                   min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" class="btn btn-danger btn-sm remove-product" style="display: none;">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-4">
                            <div class="col-12">
                                <h5>Denominations</h5>
                                <div class="row">
                                    @php
                                        $denominations = [500, 200, 100, 50, 20, 10, 5, 2, 1];
                                    @endphp
                                    @foreach($denominations as $denomination)
                                        <div class="col-md-3 mb-2">
                                            <div class="d-flex align-items-center">
                                                <label class="form-label me-2 mb-0">{{ $denomination }}:</label>
                                                <input type="number" class="form-control denomination-input" 
                                                       name="denominations[{{ $denomination }}]" 
                                                       min="0" value="0" data-denomination="{{ $denomination }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="amount_paid" class="form-label">Cash paid by customer</label>
                                <input type="number" class="form-control" id="amount_paid" name="amount_paid" 
                                       step="0.01" min="0" value="{{ old('amount_paid') }}" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <button type="submit" class="btn btn-primary">Generate Bill</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productCount = 1;
    const container = document.getElementById('productsContainer');
    const addBtn = document.getElementById('addProduct');
    const denominationInputs = document.querySelectorAll('.denomination-input');
    const amountPaidInput = document.getElementById('amount_paid');

    addBtn.onclick = function() {
        const newRow = document.querySelector('.product-row').cloneNode(true);
        newRow.querySelector('.product-select').name = `products[${productCount}][product_id]`;
        newRow.querySelector('.quantity-input').name = `products[${productCount}][quantity]`;
        newRow.querySelector('.quantity-input').value = 1;
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.remove-product').style.display = 'block';
        
        container.appendChild(newRow);
        productCount++;
        updateRemoveButtons();
    };

    container.onclick = function(e) {
        if (e.target.classList.contains('remove-product')) {
            e.target.closest('.product-row').remove();
            updateRemoveButtons();
        }
    };

    function updateRemoveButtons() {
        const rows = document.querySelectorAll('.product-row');
        rows.forEach(row => {
            const removeBtn = row.querySelector('.remove-product');
            removeBtn.style.display = rows.length > 1 ? 'block' : 'none';
        });
    }

    function calculateTotal() {
        let total = 0;
        denominationInputs.forEach(input => {
            const value = parseInt(input.dataset.denomination);
            const count = parseInt(input.value) || 0;
            total += value * count;
        });
        amountPaidInput.value = total;
    }

    denominationInputs.forEach(input => {
        input.oninput = calculateTotal;
    });

    document.getElementById('billingForm').onsubmit = function(e) {
        const selects = document.querySelectorAll('.product-select');
        const quantities = document.querySelectorAll('.quantity-input');
        
        let hasProduct = false;
        for (let select of selects) {
            if (select.value) {
                hasProduct = true;
                break;
            }
        }
        
        if (!hasProduct) {
            e.preventDefault();
            alert('Please select at least one product.');
            return;
        }
        
        for (let i = 0; i < selects.length; i++) {
            if (selects[i].value) {
                const option = selects[i].options[selects[i].selectedIndex];
                const stock = parseInt(option.dataset.stock);
                const quantity = parseInt(quantities[i].value);
                
                if (quantity > stock) {
                    e.preventDefault();
                    alert(`Insufficient stock. Available: ${stock}`);
                    return;
                }
            }
        }
    };
});
</script>
@endsection
