<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}/subcategories', [CategoryController::class, 'subcategories']);
Route::get('/subcategories', [SubcategoryController::class, 'index']);
Route::get('/subcategories/{id}/products', [SubcategoryController::class, 'products']);

Route::post('/products/upload-image', [ProductImageController::class, 'store']);
Route::get('/products/all', [ProductController::class, 'all']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::apiResource('products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);

Route::prefix('cart')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\CartController::class, 'show']);
    Route::post('/items', [\App\Http\Controllers\Api\CartController::class, 'addItem']);
    Route::put('/items/{item}', [\App\Http\Controllers\Api\CartController::class, 'updateItem']);
    Route::delete('/items/{item}', [\App\Http\Controllers\Api\CartController::class, 'removeItem']);
    Route::post('/checkout', [\App\Http\Controllers\Api\CartController::class, 'prepareCheckout']);
});
