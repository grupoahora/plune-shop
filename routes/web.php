<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/catalogo', [ProductController::class, 'index'])->name('catalogo');
Route::get('/productos/buscar', [ProductController::class, 'search'])->name('products.search');
Route::get('/productos/{product}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['auth', 'verified', 'role:cliente,admin'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('dashboard/categorias', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('dashboard/categorias', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('dashboard/categorias/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('dashboard/categorias/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('dashboard/categorias/deshacer', [CategoryController::class, 'undoDestroy'])->name('categories.undo-destroy');

    Route::get('dashboard/productos', [DashboardProductController::class, 'index'])->name('dashboard.products.index');
    Route::post('dashboard/productos', [DashboardProductController::class, 'store'])->name('dashboard.products.store');
    Route::put('dashboard/productos/{product}', [DashboardProductController::class, 'update'])->name('dashboard.products.update');
    Route::delete('dashboard/productos/{product}', [DashboardProductController::class, 'destroy'])->name('dashboard.products.destroy');
});

require __DIR__.'/settings.php';
