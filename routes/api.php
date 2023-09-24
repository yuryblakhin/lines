<?php

use App\Http\Controllers\Api\ProductImage\ProductImageController;
use App\Http\Controllers\Api\ProductWarehouse\ProductWarehouseController;
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
        Route::delete('{productImage}', [ProductImageController::class, 'destroy'])->name('destroy');
    });
    Route::name('warehouse.')->group(function () {
        Route::put('{product}/warehouses/{warehouse}', [ProductWarehouseController::class, 'update'])->name('update');
    });
});
