<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::apiResource('products', ProductController::class);
});
