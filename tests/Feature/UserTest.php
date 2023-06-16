<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Media;
use App\Models\Category;
use App\Models\Commentary;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\CommentaryController;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(TestCase::class);

// ! Index Tests
test('index : error if not logged in', function () {
    $response = $this->get('/api/media');
    expect($response->status())->toBe(401);
});

test('index : show 10 users', function () {
    Sanctum::actingAs(
        User::factory()->create()
    );
    for ($i = 0; $i < 10; $i++) {
        User::factory()->create();
    }
    $response = $this->getJson('/api/users');
    expect($response->status())->toBe(200);
});

// ! Show Tests
test('show : error if not logged in', function () {
    $response = $this->get('/api/media/1');
    expect($response->status())->toBe(401);
});

test('show : error user does not exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/users/3');
    expect($response->status())->toBe(404);
});

test('show : can show a user', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/users/'.$user->id);
    expect($response->status())->toBe(200);
});

// ! Update Tests
test('update : error if not logged in', function () {
    $response = $this->put('/api/users/1');
    expect($response->status())->toBe(401);
});

test('update : can update a user', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $user_data = [
        'pseudo' => 'test name',
    ];
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->putJson('/api/users/'.$user->id, $user_data);
    expect($response->status())->toBe(200);
});

// ! Destroy Tests
test('destroy : error if not logged in', function () {
    $response = $this->delete('/api/users/1');
    expect($response->status())->toBe(401);
});

test('destroy : can delete a user', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->deleteJson('/api/users/'.$user->id);
    expect($response->status())->toBe(204);
});

// ! Top Tests
test('top : error if not logged in', function () {
    $response = $this->get('/api/users/top');
    expect($response->status())->toBe(401);
});

test('top : show users ordered by experience', function () {
    $user = User::factory()->create();
    for ($i = 0; $i < 10; $i++) {
        User::factory()->create();
    }
    $token = $user->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/users/top');
    expect($response->status())->toBe(200);
});