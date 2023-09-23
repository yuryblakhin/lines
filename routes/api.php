<?php

use App\Http\Controllers\Api\ProductImage\ProductImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('products')->name('product.')->group(function () {
    Route::prefix('images')->name('image.')->group(function () {
        Route::delete('{productImageId}', [ProductImageController::class, 'destroy'])->name('destroy');
    });
});
