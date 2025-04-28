<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::patch('products/{product}/status', [ProductController::class, 'changeStatus'])->name('products.updateStatus');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::get('products/{product}', [ProductController::class, 'show'])
    ->where('product','[0-9]+')->name('products.show');
    Route::get('products', [ProductController::class, 'productFilter'])->name('products.filter');
});
