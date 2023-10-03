<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\Product\ProductController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Warehouse\WarehouseController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->group(function () {
    Route::name('auth.')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('index');
        Route::post('login', [LoginController::class, 'login'])->name('login');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
    Route::name('password.')->group(function () {
        Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('index');
        Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
        Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
        Route::post('reset', [ResetPasswordController::class, 'reset'])->name('update');
    });
});

Route::middleware('auth')->name('dashboard.')->group(function () {
    // Home
    Route::name('home.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');
    });

    // Warehouses
    Route::prefix('warehouses')->name('warehouse.')->group(function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('index');
        Route::get('/create', [WarehouseController::class, 'create'])->name('create');
        Route::post('/', [WarehouseController::class, 'store'])->name('store');
        Route::get('/{warehouse}', [WarehouseController::class, 'show'])->name('show')->whereNumber('warehouse');
        Route::get('/{warehouse}/edit', [WarehouseController::class, 'edit'])->name('edit')->whereNumber('warehouse');
        Route::put('/{warehouse}', [WarehouseController::class, 'update'])->name('update')->whereNumber('warehouse');
        Route::delete('/{warehouse}', [WarehouseController::class, 'destroy'])->name('destroy');
    });

    // Categories
    Route::prefix('categories')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit')->whereNumber('category');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update')->whereNumber('category');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Products
    Route::prefix('products')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show')->whereNumber('product');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit')->whereNumber('product');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update')->whereNumber('product');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Users
    Route::prefix('users')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit')->whereNumber('user');
        Route::put('/{user}', [UserController::class, 'update'])->name('update')->whereNumber('user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});
