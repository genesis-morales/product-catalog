<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\AdminOrderController;
use App\Http\Controllers\Api\AdminDashboardController;

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
    
    Route::get('/orders',       [OrderController::class, 'index']);
    Route::post('/orders',      [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    Route::post('/products/upload-image', [ProductImageController::class, 'store']);
    Route::apiResource('products', ProductController::class)->only(['index', 'store', 'update', 'destroy']);
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/orders',                      [AdminOrderController::class, 'index']);
    Route::get('/orders/{order}',              [AdminOrderController::class, 'show']);
    Route::put('/orders/{order}/shipping', [AdminOrderController::class, 'updateShipping']);
    Route::put('/orders/{order}/status',     [AdminOrderController::class, 'updateStatus']);

    Route::prefix('dashboard')->group(function () {
        Route::get('/stats',         [AdminDashboardController::class, 'stats']);
        Route::get('/monthly-sales', [AdminDashboardController::class, 'monthlySales']);
        Route::get('/recent-orders', [AdminDashboardController::class, 'recentOrders']);
        Route::get('/top-products',  [AdminDashboardController::class, 'topProducts']);
    });
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}/subcategories', [CategoryController::class, 'subcategories']);
Route::get('/subcategories', [SubcategoryController::class, 'index']);
Route::get('/subcategories/{id}/products', [SubcategoryController::class, 'products']);


Route::get('/products/all', [ProductController::class, 'all']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::prefix('cart')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\CartController::class, 'show']);
    Route::post('/items', [\App\Http\Controllers\Api\CartController::class, 'addItem']);
    Route::put('/items/{item}', [\App\Http\Controllers\Api\CartController::class, 'updateItem']);
    Route::delete('/items/{item}', [\App\Http\Controllers\Api\CartController::class, 'removeItem']);
    Route::post('/checkout', [\App\Http\Controllers\Api\CartController::class, 'prepareCheckout']);
});