<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('orders.create');
});

Route::controller(ProductController::class)->prefix('products')->name('products.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('{id}/edit', 'edit')->name('edit');
    Route::put('{id}', 'update')->name('update');
    Route::delete('{id}', 'destroy')->name('destroy');
});

Route::controller(OrderController::class)->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('{order}/details', 'orderDetails')->name('details');
});
