<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::select('id', 'name', 'product_code', 'price', 'stock', 'tax', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create(): View
    {
        return view('products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit(int $id): View
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
