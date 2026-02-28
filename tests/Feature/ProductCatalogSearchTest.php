<?php

use App\Models\Product;
use Inertia\Testing\AssertableInertia as Assert;

test('catalog page filters products by search term', function () {
    Product::query()->create([
        'name' => 'Shampoo Hidratante',
        'description' => 'Producto de prueba para hidratación.',
        'price_sale' => 19.90,
        'product_code' => 'PLN-SH-01',
        'status' => true,
    ]);

    Product::query()->create([
        'name' => 'Serum Nocturno',
        'description' => 'Producto de prueba para nutrición.',
        'price_sale' => 15.50,
        'product_code' => 'PLN-SE-01',
        'status' => true,
    ]);

    $this->get(route('catalogo', ['search' => 'Shampoo']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Catalogo')
            ->has('products', 1)
            ->where('products.0.name', 'Shampoo Hidratante')
            ->where('search', 'Shampoo')
        );
});

test('product search endpoint redirects to catalog preserving search term', function () {
    Product::query()->create([
        'name' => 'Mascarilla Reparadora',
        'description' => 'Producto para prueba de redirección.',
        'price_sale' => 22.00,
        'product_code' => 'PLN-MA-01',
        'status' => true,
    ]);

    $this->get(route('products.search', ['search' => 'Mascarilla']))
        ->assertRedirect(route('catalogo', ['search' => 'Mascarilla']));
});
