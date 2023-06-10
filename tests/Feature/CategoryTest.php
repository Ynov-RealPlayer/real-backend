<?php

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(TestCase::class);

test('error if not logged in', function () {
    $response = $this->get('/api/categories');
    expect($response->status())->toBe(401);
});

test('show all the existing categories', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->get('/api/categories');
    expect($response->status())->toBe(200);
});