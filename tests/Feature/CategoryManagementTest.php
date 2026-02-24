<?php

use App\Models\Category;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('authenticated users can visit categories index', function () {
    $user = User::factory()->create();

    Category::query()->create([
        'name' => 'Spa',
        'icon' => 'spa',
        'sort_order' => 1,
    ]);

    $response = $this->actingAs($user)->get(route('categories.index'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('categories/Index')
        ->has('categories', 1)
    );
});

test('authenticated users can create update and delete categories', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('categories.store'), [
            'name' => 'Aromaterapia',
            'icon' => 'spa',
            'sort_order' => 2,
        ])
        ->assertRedirect();

    $category = Category::query()->firstOrFail();

    expect($category->name)->toBe('Aromaterapia');

    $this->actingAs($user)
        ->put(route('categories.update', $category), [
            'name' => 'Aromaterapia Premium',
            'icon' => 'local_florist',
            'sort_order' => 3,
        ])
        ->assertRedirect();

    $category->refresh();

    expect($category->name)->toBe('Aromaterapia Premium')
        ->and($category->icon)->toBe('local_florist')
        ->and($category->sort_order)->toBe(3);

    $this->actingAs($user)
        ->delete(route('categories.destroy', $category))
        ->assertRedirect();

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});

test('authenticated users can undo a category deletion', function () {
    $user = User::factory()->create();

    $category = Category::query()->create([
        'name' => 'Mascarillas',
        'icon' => 'face',
        'sort_order' => 4,
    ]);

    $deleteResponse = $this->actingAs($user)
        ->delete(route('categories.destroy', $category));

    $deleteResponse->assertRedirect();

    $undoToken = session('toast.undoToken');

    expect($undoToken)->toBeString();

    $this->actingAs($user)
        ->post(route('categories.undo-destroy'), [
            'undo_token' => $undoToken,
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('categories', [
        'name' => 'Mascarillas',
        'icon' => 'face',
        'sort_order' => 4,
    ]);
});
