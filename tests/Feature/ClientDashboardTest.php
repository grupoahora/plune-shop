<?php

use App\Models\Product;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected when visiting the client dashboard', function () {
    $response = $this->get(route('client.dashboard'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view the client dashboard and edit profile form', function () {
    Product::factory()->count(2)->create([
        'status' => true,
    ]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('client.dashboard'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('ClienteDashboard')
        ->has('allProducts', 2)
        ->has('canResetPassword')
        ->where('mustVerifyEmail', true)
    );
});
