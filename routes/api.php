<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', ProductController::class)->name('api.products.index');

    // Jika Anda juga memerlukan detail produk, buat route lain
    Route::get('/{slug}', [ProductController::class, 'show'])->name('api.products.show');
});

Route::get('/category', CategoryController::class);