<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

// Redirect `/` always to login unless authenticated
Route::get('/', function () {
    return session('authenticated') ? redirect()->route('dashboard') : redirect()->route('login');
});

// Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Protected Routes
Route::middleware(['web', 'auth.session'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/restock', [OrderController::class, 'restock'])->name('orders.restock');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// Fallback
Route::fallback(function () {
    return redirect()->route('login');
});
