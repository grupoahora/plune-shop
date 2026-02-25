<?php

use Inertia\Testing\AssertableInertia as Assert;

test('returns a successful response', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Welcome')
            ->has('canRegister')
            ->has('canResetPassword')
            ->has('products')
        );
});

test('catalog page provides login modal reset password availability', function () {
    $response = $this->get(route('catalogo'));

    $response->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Catalogo')
            ->has('canResetPassword')
            ->has('categories')
        );
});
