<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\ProductStock;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleDetailController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\ProductProblemController;
use App\Http\Controllers\PurchaseDetailController;
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

    Route::resource('problems', ProductProblemController::class);
    Route::resource('products.stock', ProductStockController::class)->only(['index', 'update']);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);

    Route::get('purchase/details/invoice/{id}', [PurchaseDetailController::class, 'createPDF'])->name('purchase.invoice');
    Route::resource('purchase.details', PurchaseDetailController::class);

    Route::resource('purchases', PurchaseController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('sale/details/invoice/{id}', [SaleDetailController::class, 'createPDF'])->name('sale.invoice');
    Route::resource('sale.details', SaleDetailController::class);

    Route::resource('sales', SaleController::class);

    Route::delete('/stock/log/{productStockLog}', [ProductStockLogController::class, 'destroy']);
});
