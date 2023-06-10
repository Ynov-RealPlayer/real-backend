<?php

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(RefreshDatabase::class);
uses(TestCase::class);

// ! Register Tests
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

// ! Login Tests
test('user can login with valid data', function () {
    $faker = Factory::create('fr_FR');
    $password = $faker->password(8);
    $user = User::create([
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($password),
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => $password,
    ]);
    $response->assertOk()
        ->assertJsonStructure([
            'access_token',
            'token_type',
        ]);
});

test('user cannot login with invalid email', function () {
    $faker = Factory::create('fr_FR');
    $password = $faker->password(8);
    $user = User::create([
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($password),
    ]);
    $response = $this->postJson('/api/login', [
        'email' => 'invalid-email',
        'password' => $password,
    ]);
    $response->assertStatus(422);
    expect($response->json())->toHaveKey('email');
});

test('user cannot login with invalid password', function () {
    $faker = Factory::create('fr_FR');
    $password = 'password123';
    $user = User::create([
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($password),
    ]);
    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'invalid-password',
    ]);
    $response->assertStatus(401);
    expect($response->json())->toHaveKey('message');
});

test('user login creates new token', function () {
    $faker = Factory::create('fr_FR');
    $password = $faker->password(8);
    $user = User::create([
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($password),
    ]);
    $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => $password,
    ]);
    $this->assertDatabaseHas('personal_access_tokens', [
        'tokenable_id' => $user->id,
    ]);
});

// ! Logout Tests
test('user can logout', function () {
    $faker = Factory::create('fr_FR');
    $password = $faker->password(8);
    $user = User::create([
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($password),
    ]);
    $response = $this->actingAs($user)->postJson('/api/logout');
    $response->assertOk()
        ->assertJsonStructure([
            'message',
        ]);
});

test('user logout deletes token', function () {
    $faker = Factory::create('fr_FR');
    $password = $faker->password(8);
    $user = User::create([
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($password),
    ]);
    $this->actingAs($user)->postJson('/api/logout');
    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $user->id,
    ]);
});

test('user cannot logout without token', function () {
    $response = $this->postJson('/api/logout');
    $response->assertStatus(401);
    expect($response->json())->toHaveKey('message');
});

// ! User /me Tests
test('user can get own data', function () {
    $faker = Factory::create('fr_FR');
    $password = $faker->password(8);
    $user = User::create([
        'pseudo' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make($password),
    ]);
    $response = $this->actingAs($user)->postJson('/api/me');
    $response->assertOk()
        ->assertJsonStructure([
            'id',
            'pseudo',
            'email',
            'created_at',
            'updated_at',
        ]);
});

test('user cannot get own data without token', function () {
    $response = $this->postJson('/api/me');
    $response->assertStatus(401);
    expect($response->json())->toHaveKey('message');
});
