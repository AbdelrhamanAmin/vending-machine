<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Product List Route
Route::get('/products', [ProductController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    // Product  Routes
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Create order route
    Route::post('/orders', [OrderController::class, 'create']);

    // Add / Rest deposit
    Route::post('/deposit', [AccountController::class, 'deposit']);
    Route::post('/reset-credit', [AccountController::class, 'resetCredit']);

    // Get / update / log out routes
    Route::get('me', [AuthController::class, 'me']);
    Route::put('account/update', [AccountController::class, 'update']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Auth routes
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

