<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\ProductImageController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}/subcategories', [CategoryController::class, 'subcategories']);
Route::get('/subcategories', [SubcategoryController::class, 'index']);
Route::get('/subcategories/{id}/products', [SubcategoryController::class, 'products']);
Route::apiResource('products', ProductController::class);
Route::post('/products/upload-image', [ProductImageController::class, 'store']);