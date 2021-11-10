<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\ProductStockLogController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('dashboard');
    } else {
        return redirect('login');
    }
});

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'register']);

// Pages

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function() {
        return view('dashboard.index', [
            'title' => 'Beranda'
        ]);
    });

    Route::get('products/checkSlug', [ProductController::class, 'checkSlug']);
    Route::get('categories/checkSlug', [CategoryController::class, 'checkSlug']);
    Route::get('suppliers/checkSlug', [SupplierController::class, 'checkSlug']);
    Route::get('customers/checkSlug', [CustomerController::class, 'checkSlug']);

    Route::resource('products.stock', ProductStockController::class)->only(['index', 'update']);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);

    Route::delete('/stock/log/{productStockLog}', [ProductStockLogController::class, 'destroy']);
});
