<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('articulos');
});

//Route::get('articulos', [ArticuloController::class, 'index'])->name('articulos.index');

//Route::get('articulos/create', [ArticuloController::class, 'create'])->name('articulos.create');

//Route::post('articulos', [ArticuloController::class, 'store'])->name('articulos.store');

//Route::get('articulos/{articulo}', [ArticuloController::class, 'show'])->name('articulos.show');

//Route::get('articulos/{articulo}/edit', [ArticuloController::class, 'edit'])->name('articulos.edit');

//Route::put('articulos/{articulo}', [ArticuloController::class, 'update'])->name('articulos.update');

//Route::delete('articulos/{articulo}', [ArticuloController::class, 'destroy'])->name('articulos.destroy');

