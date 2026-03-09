<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

test('authenticated users can visit dashboard products index', function () {
    Storage::fake('public');

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
        ->where('products.0.image', null)
        ->where('categories.0.name', 'Spa')
    );
});

test('product create, update and delete actions are reflected on dashboard products index', function () {
    Storage::fake('public');

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

    $firstImage = UploadedFile::fake()->image('crema-hidratante.jpg');

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->post(route('dashboard.products.store'), [
            'name' => 'Crema Hidratante',
            'description' => 'Descripción inicial',
            'product_code' => 'PRD-1100',
            'image' => $firstImage,
            'price_sale' => 49.90,
            'status' => true,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => $category->id,
        ])
        ->assertRedirect(route('dashboard.products.index'));

    $product = Product::query()->firstOrFail();
    $storedFirstPath = $product->images()->first()?->url;

    expect($storedFirstPath)->not->toBeNull();
    Storage::disk('public')->assertExists((string) $storedFirstPath);

    expect((string) $storedFirstPath)->toStartWith('productos/');

    $this->actingAs($user)
        ->get(route('dashboard.products.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('products/Index')
            ->has('products', 1)
            ->where('products.0.name', 'Crema Hidratante')
            ->where('products.0.product_code', 'PRD-1100')
            ->where('products.0.image', '/productos/'.basename((string) $storedFirstPath))
            ->where('products.0.category_name', 'Corporal')
        );

    $secondImage = UploadedFile::fake()->image('crema-hidratante-plus.jpg');

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->put(route('dashboard.products.update', $product), [
            'name' => 'Crema Hidratante Plus',
            'description' => 'Descripción editada',
            'product_code' => 'PRD-1100',
            'image' => $secondImage,
            'price_sale' => 59.90,
            'status' => false,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => $secondCategory->id,
        ])
        ->assertRedirect(route('dashboard.products.index'));

    $storedSecondPath = $product->fresh()->images()->first()?->url;

    expect($storedSecondPath)->not->toBeNull();
    expect($storedSecondPath)->not->toBe($storedFirstPath);

    Storage::disk('public')->assertMissing((string) $storedFirstPath);
    Storage::disk('public')->assertExists((string) $storedSecondPath);

    $this->actingAs($user)
        ->get(route('dashboard.products.index'))
        ->assertInertia(fn (Assert $page) => $page
            ->where('products.0.name', 'Crema Hidratante Plus')
            ->where('products.0.image', '/productos/'.basename((string) $storedSecondPath))
            ->where('products.0.category_name', 'Facial')
            ->where('products.0.status', false)
        );

    expect((string) $storedSecondPath)->toStartWith('productos/');

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
    Storage::fake('public');

    $user = User::factory()->create();

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->post(route('dashboard.products.store'), [
            'name' => 'Aceite esencial',
            'description' => 'Texto',
            'product_code' => 'PRD-2100',
            'image' => 'https://cdn.example.com/aceite-esencial.jpg',
            'price_sale' => 39.90,
            'status' => true,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => 99999,
        ])
        ->assertRedirect(route('dashboard.products.index'))
        ->assertSessionHasErrors('category_id');
});

test('dashboard products store validates image as a valid file', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $category = Category::query()->create([
        'name' => 'Aromaterapia',
        'icon' => 'Flower2',
        'sort_order' => 1,
    ]);

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->post(route('dashboard.products.store'), [
            'name' => 'Bruma relajante',
            'description' => 'Texto',
            'product_code' => 'PRD-2200',
            'image' => 'imagen-invalida',
            'price_sale' => 35.90,
            'status' => true,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => $category->id,
        ])
        ->assertRedirect(route('dashboard.products.index'))
        ->assertSessionHasErrors('image');
});

test('dashboard products update allows clearing product image', function () {
    Storage::fake('public');

    $user = User::factory()->create();

    $category = Category::query()->create([
        'name' => 'Corporal',
        'icon' => 'Flower2',
        'sort_order' => 1,
    ]);

    $product = Product::query()->create([
        'name' => 'Aceite corporal',
        'description' => 'Texto',
        'product_code' => 'PRD-3300',
        'price_sale' => 19.90,
        'status' => true,
        'discount_value' => null,
        'discount_type' => null,
        'category_id' => $category->id,
    ]);

    $storedPath = UploadedFile::fake()->image('aceite-corporal.jpg')->store('productos', 'public');

    $product->images()->create([
        'url' => $storedPath,
    ]);

    $this->actingAs($user)
        ->from(route('dashboard.products.index'))
        ->put(route('dashboard.products.update', $product), [
            'name' => 'Aceite corporal',
            'description' => 'Texto',
            'product_code' => 'PRD-3300',
            'remove_image' => true,
            'price_sale' => 19.90,
            'status' => true,
            'discount_value' => null,
            'discount_type' => null,
            'category_id' => $category->id,
        ])
        ->assertRedirect(route('dashboard.products.index'));

    expect($product->fresh()->images()->exists())->toBeFalse();
    Storage::disk('public')->assertMissing($storedPath);
});
