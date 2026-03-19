<?php

use App\Models\User;

test('guest cannot access admin dashboard', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('user role cannot access admin dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(403);
});

test('admin role can access admin dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
});

test('user role can access user dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);

    $response = $this->get(route('userDashboard'));
    $response->assertStatus(200);
});

test('admin role can access user dashboard', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->actingAs($admin);

    $response = $this->get(route('userDashboard'));
    $response->assertStatus(200);
});
