<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Dashboard\HomeController;
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
    Route::name('home.')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('index');
    });
});
