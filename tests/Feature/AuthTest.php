<?php

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);
uses(TestCase::class);

test('user can register with valid data', function () {
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

test('user cannot register with missing data', function () {
    $response = $this->postJson('/api/register', []);
    expect($response->status())->toBe(422);
});

test('user cannont register with invalid email', function () {
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

test('user cannot register with existing email', function () {
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

test('user cannot register with short password', function () {
    $faker = Factory::create('fr_FR');
    $data = [
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => 'pass',
        'confirm_password' => 'pass',
    ];
    $response = $this->postJson('/api/register', $data);
    expect($response->status())->toBe(422);
    expect($response->json())->toHaveKey('password');
});

test('user cannont register with mismatched passwords', function () {
    $faker = Factory::create('fr_FR');
    $data = [
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => 'password123',
        'confirm_password' => 'password456',
    ];
    $response = $this->postJson('/api/register', $data);
    expect($response->status())->toBe(422);
    expect($response->json())->toHaveKey('confirm_password');
});

// public function test_user_registration_creates_new_user()
// {
//     $data = [
//         'pseudo' => $this->faker->userName,
//         'email' => $this->faker->unique()->safeEmail,
//         'password' => 'password123',
//         'confirm_password' => 'password123',
//     ];

//     $this->postJson('/api/register', $data);

//     $this->assertDatabaseHas('users', [
//         'pseudo' => $data['pseudo'],
//         'email' => $data['email'],
//     ]);
// }
test('user registration creates new user', function () {
    $faker = Factory::create('fr_FR');
    $data = [
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => 'password123',
        'confirm_password' => 'password123',
    ];
    $this->postJson('/api/register', $data);
    $this->assertDatabaseHas('users', [
        'pseudo' => $data['pseudo'],
        'email' => $data['email'],
    ]);
});
