<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\Category\CategoryController;
use App\Http\Controllers\Dashboard\Home\HomeController;
use App\Http\Controllers\Dashboard\User\UserController;
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

    // Categories
    Route::prefix('categories')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [CategoryController::class, 'edit'])->name('edit')->whereNumber('category');
        Route::put('/{user}', [CategoryController::class, 'update'])->name('update')->whereNumber('category');
        Route::delete('/{user}', [CategoryController::class, 'destroy'])->name('destroy');
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
