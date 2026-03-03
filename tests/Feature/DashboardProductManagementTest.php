<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('authenticated users can visit dashboard products index', function () {
    $user = User::factory()->create();

    $category = Category::query()->create([
        'name' => 'Spa',
        'icon' => 'Flower2',
        'sort_order' => 1,
    ]);

    Product::factory()->create([
        'name' => 'Jabón facial',
        'product_code' => 'PRD-1001',
        'price_sale' => 29.99,
        'category_id' => $category->id,
    ]);

    $response = $this->actingAs($user)->get(route('dashboard.products.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('products/Index')
        ->has('products', 1)
        ->where('products.0.name', 'Jabón facial')
        ->where('categories.0.name', 'Spa')
    );
});

test('product create, update and delete actions are reflected on dashboard products index', function () {
    $user = User::factory()->create();

    $category = Category::query()->create([
        'name' => 'Corporal',
        'icon' => 'Flower2',
        'sort_order' => 1,
    ]);

    $secondCategory = Category::query()->create([
        'name' => 'Facial',
        'icon' => 'Smile',
        'sort_order' => 2,
    ]);

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->post(route('dashboard.products.store'), [
            'name' => 'Crema Hidratante',
            'description' => 'Descripción inicial',
            'product_code' => 'PRD-1100',
            'price_sale' => 49.90,
            'status' => true,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => $category->id,
        ])
        ->assertRedirect(route('dashboard.products.index'));

    $product = Product::query()->firstOrFail();

    $this->actingAs($user)
        ->get(route('dashboard.products.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('products/Index')
            ->has('products', 1)
            ->where('products.0.name', 'Crema Hidratante')
            ->where('products.0.product_code', 'PRD-1100')
            ->where('products.0.category_name', 'Corporal')
        );

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->put(route('dashboard.products.update', $product), [
            'name' => 'Crema Hidratante Plus',
            'description' => 'Descripción editada',
            'product_code' => 'PRD-1100',
            'price_sale' => 59.90,
            'status' => false,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => $secondCategory->id,
        ])
        ->assertRedirect(route('dashboard.products.index'));

    $this->actingAs($user)
        ->get(route('dashboard.products.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->where('products.0.name', 'Crema Hidratante Plus')
            ->where('products.0.category_name', 'Facial')
            ->where('products.0.status', false)
        );

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->delete(route('dashboard.products.destroy', $product))
        ->assertRedirect(route('dashboard.products.index'));

    $this->actingAs($user)
        ->get(route('dashboard.products.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->has('products', 0)
        );
});

test('dashboard products store requires a valid category', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->post(route('dashboard.products.store'), [
            'name' => 'Aceite esencial',
            'description' => 'Texto',
            'product_code' => 'PRD-2100',
            'price_sale' => 39.90,
            'status' => true,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => 99999,
        ])
        ->assertRedirect(route('dashboard.products.index'))
        ->assertSessionHasErrors('category_id');
});
