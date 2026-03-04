<?php

use App\Models\Category;
use App\Models\Product;
use Inertia\Testing\AssertableInertia as Assert;

test('catalog page filters products by search term', function () {
    $category = Category::query()->create([
        'name' => 'Categoría base',
        'icon' => 'sparkles',
        'sort_order' => 1,
    ]);

    Product::query()->create([
        'name' => 'Shampoo Hidratante',
        'description' => 'Producto de prueba para hidratación.',
        'price_sale' => 19.90,
        'product_code' => 'PLN-SH-01',
        'image' => 'https://cdn.example.com/shampoo-hidratante.jpg',
        'status' => true,
        'category_id' => $category->id,
    ]);

    Product::query()->create([
        'name' => 'Serum Nocturno',
        'description' => 'Producto de prueba para nutrición.',
        'price_sale' => 15.50,
        'product_code' => 'PLN-SE-01',
        'status' => true,
        'category_id' => $category->id,
    ]);

    $this->get(route('catalogo', ['search' => 'Shampoo']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Catalogo')
            ->has('products', 1)
            ->where('products.0.name', 'Shampoo Hidratante')
            ->where('products.0.productCode', 'PLN-SH-01')
            ->where('products.0.image', 'https://cdn.example.com/shampoo-hidratante.jpg')
            ->has('allProducts', 2)
            ->where('allProducts.1.name', 'Shampoo Hidratante')
            ->where('search', 'Shampoo')
        );
});

test('product search endpoint redirects to catalog preserving search term', function () {
    $category = Category::query()->create([
        'name' => 'Categoría para búsqueda',
        'icon' => 'leaf',
        'sort_order' => 1,
    ]);

    Product::query()->create([
        'name' => 'Mascarilla Reparadora',
        'description' => 'Producto para prueba de redirección.',
        'price_sale' => 22.00,
        'product_code' => 'PLN-MA-01',
        'status' => true,
        'category_id' => $category->id,
    ]);

    $this->get(route('products.search', ['search' => 'Mascarilla']))
        ->assertRedirect(route('catalogo', ['search' => 'Mascarilla']));
});

test('catalog page filters products by selected category', function () {
    $hairCareCategory = Category::query()->create([
        'name' => 'Cuidado capilar',
        'icon' => 'sparkles',
        'sort_order' => 1,
    ]);

    $skinCareCategory = Category::query()->create([
        'name' => 'Cuidado facial',
        'icon' => 'leaf',
        'sort_order' => 2,
    ]);

    Product::query()->create([
        'name' => 'Shampoo Reparador',
        'description' => 'Producto para categoría capilar.',
        'price_sale' => 18.50,
        'product_code' => 'PLN-CA-01',
        'status' => true,
        'category_id' => $hairCareCategory->id,
    ]);

    Product::query()->create([
        'name' => 'Serum Facial',
        'description' => 'Producto para categoría facial.',
        'price_sale' => 21.40,
        'product_code' => 'PLN-FA-01',
        'status' => true,
        'category_id' => $skinCareCategory->id,
    ]);

    $this->get(route('catalogo', ['category' => $hairCareCategory->id]))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Catalogo')
            ->has('products', 1)
            ->where('products.0.name', 'Shampoo Reparador')
            ->where('selectedCategoryId', $hairCareCategory->id)
        );
});



test('catalog category filter ignores search term when both are present', function () {
    $targetCategory = Category::query()->create([
        'name' => 'Capilar',
        'icon' => 'sparkles',
        'sort_order' => 1,
    ]);

    $otherCategory = Category::query()->create([
        'name' => 'Facial',
        'icon' => 'leaf',
        'sort_order' => 2,
    ]);

    Product::query()->create([
        'name' => 'Crema capilar nutritiva',
        'description' => 'Producto de categoría objetivo.',
        'price_sale' => 20.00,
        'product_code' => 'PLN-CP-20',
        'status' => true,
        'category_id' => $targetCategory->id,
    ]);

    Product::query()->create([
        'name' => 'Shampoo buscado',
        'description' => 'Producto que coincide por búsqueda en otra categoría.',
        'price_sale' => 21.00,
        'product_code' => 'PLN-SB-21',
        'status' => true,
        'category_id' => $otherCategory->id,
    ]);

    $this->get(route('catalogo', ['category' => $targetCategory->id, 'search' => 'Shampoo']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Catalogo')
            ->has('products', 1)
            ->where('products.0.name', 'Crema capilar nutritiva')
            ->where('selectedCategoryId', $targetCategory->id)
            ->where('search', '')
        );
});

test('catalog category filter uses partial inertia payload when requested', function () {
    $firstCategory = Category::query()->create([
        'name' => 'Capilar',
        'icon' => 'sparkles',
        'sort_order' => 1,
    ]);

    $secondCategory = Category::query()->create([
        'name' => 'Facial',
        'icon' => 'leaf',
        'sort_order' => 2,
    ]);

    Product::query()->create([
        'name' => 'Shampoo Diario',
        'description' => 'Producto capilar para prueba parcial.',
        'price_sale' => 18.00,
        'product_code' => 'PLN-CA-10',
        'status' => true,
        'category_id' => $firstCategory->id,
    ]);

    Product::query()->create([
        'name' => 'Gel Limpiador',
        'description' => 'Producto facial para prueba parcial.',
        'price_sale' => 17.00,
        'product_code' => 'PLN-FA-10',
        'status' => true,
        'category_id' => $secondCategory->id,
    ]);

    $response = $this->withHeaders([
        'X-Inertia' => 'true',
        'X-Inertia-Partial-Component' => 'Catalogo',
        'X-Inertia-Partial-Data' => 'products,search,selectedCategoryId',
    ])->get(route('catalogo', ['category' => $firstCategory->id]));

    $response
        ->assertOk()
        ->assertJsonPath('props.selectedCategoryId', $firstCategory->id)
        ->assertJsonPath('props.products.0.name', 'Shampoo Diario')
        ->assertJsonMissingPath('props.categories')
        ->assertJsonMissingPath('props.allProducts');
});
