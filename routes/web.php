<?php

use App\Http\Controllers\CategoryController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    $products = Product::all();

    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'products' => $products,
    ]);
})->name('home');

Route::get('/catalogo', function () {
    return Inertia::render('Catalogo', [
        'categories' => Category::query()->orderBy('sort_order')->get(['id', 'name', 'icon']),
    ]);
})->name('catalogo');
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard/categorias', [CategoryController::class, 'index'])->name('categories');
    Route::post('dashboard/categorias', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('dashboard/categorias/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('dashboard/categorias/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/settings.php';
