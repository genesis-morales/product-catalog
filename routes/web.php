<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;

Route::get('/', function () {
    return redirect('articulos');
});

Route::get('articulos', [ArticuloController::class, 'index'])->name('articulos.index');

Route::get('articulos/create', [ArticuloController::class, 'create'])->name('articulos.create');

Route::post('articulos', [ArticuloController::class, 'store'])->name('articulos.store');

Route::get('articulos/{articulo}', [ArticuloController::class, 'show'])->name('articulos.show');