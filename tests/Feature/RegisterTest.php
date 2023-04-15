<?php

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);
uses(TestCase::class);

it('user can register with valid data', function () {
    $faker = Factory::create('fr_FR');
    $data = [
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => 'password123',
        'confirm_password' => 'password123',
    ];
    $response = $this->postJson('/api/register', $data);
    expect($response->status())->toBe(200);
    expect($response->json())->toHaveKeys(['access_token', 'token_type']);
});

it('user cannot register with missing data', function () {
    $response = $this->postJson('/api/register', []);
    expect($response->status())->toBe(422);
});

it('user cannont register with invalid email', function () {
    $faker = Factory::create('fr_FR');
    $data = [
        'pseudo' => $faker->userName,
        'email' => 'invalid-email',
        'password' => 'password123',
        'confirm_password' => 'password123',
    ];
    $response = $this->postJson('/api/register', $data);
    expect($response->status())->toBe(422);
});

it('user cannot register with existing email', function () {
    $faker = Factory::create('fr_FR');
    $user = User::factory()->create([
        'pseudo' => 'aaaaaa',
        'email' => 'aaaaaa@gmail.com',
        'password' => 'password123',
    ]);
    $data = [
        'pseudo' => $faker->userName,
        'email' => $user->email,
        'password' => 'password123',
        'confirm_password' => 'password123',
    ];
    $response = $this->postJson('/api/register', $data);
    expect($response->status())->toBe(422);
});
