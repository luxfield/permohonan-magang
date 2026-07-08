<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('guest cannot access admin dashboard', function () {
    get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

test('authenticated admin can access dashboard and see whats new button', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee("What's New", false)
        ->assertSee('id="whats-new-btn"', false)
        ->assertSee('id="whats-new-modal"', false);
});
