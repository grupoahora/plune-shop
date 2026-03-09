<?php

use Spatie\Permission\Models\Role;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});


test('authenticated users without allowed roles cannot visit the dashboard', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertForbidden();
});

test('authenticated users can visit the dashboard', function () {
    Role::findOrCreate('cliente');

    $user = User::factory()->create();
    $user->assignRole('cliente');

    $this->actingAs($user);

    $response = $this->get(route('dashboard'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('categories/Index')
        ->has('categories')
    );
});
