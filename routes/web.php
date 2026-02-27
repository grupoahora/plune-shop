<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/catalogo', [ProductController::class, 'index'])->name('catalogo');
Route::get('/productos/buscar', [ProductController::class, 'search'])->name('products.search');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard/categorias', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('dashboard/categorias', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('dashboard/categorias/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('dashboard/categorias/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('dashboard/categorias/deshacer', [CategoryController::class, 'undoDestroy'])->name('categories.undo-destroy');
});

require __DIR__.'/settings.php';
