<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::get('/products', function () {
        return 'Los productos';
    });
});
