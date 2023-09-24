<?php

use App\Http\Controllers\Api\Product\ProductController;
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
    Route::name('image.')->group(function () {
        Route::delete('{product}/images/{image}', [ProductController::class, 'destroyImage'])->name('destroy');
    });
    Route::name('warehouse.')->group(function () {
        Route::put('{product}/warehouses/{warehouse}', [ProductController::class, 'updateWarehouse'])->name('update');
    });
});
