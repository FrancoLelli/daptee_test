<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::get('/products/{id}/total-stock-value', [ProductController::class, 'totalStockValue']);
    Route::get('/products/highest-price', [ProductController::class, 'highestPrice']);
    Route::get('/products/tags/most-used', [ProductController::class, 'mostUsedTags']);

    Route::apiResource('products', ProductController::class);
});
