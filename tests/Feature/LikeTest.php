<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Media;
use App\Models\Commentary;
use App\Http\Controllers\Api\CommentaryController;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(TestCase::class);

// ! Store Tests
test('store : error if not logged in', function () {
    $response = $this->post('/api/likes');
    expect($response->status())->toBe(401);
});

test('store : error if likeable_id is missing', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'url' => 'test_url',
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $media = Media::factory()->create($media_data);
    $headers = $this->withHeaders([
        'Authorization'=>'Bearer '.$token,
        'Accept' => 'application/json'
    ]);
    $data = [
        'likeable_type' => 'App\Models\Media',
    ];
    $response = $headers->postJson('/api/likes', $data);
    expect($response->status())->toBe(422);
});

test('store : error if likeable_type is missing', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'url' => 'test_url',
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $media = Media::factory()->create($media_data);
    $headers = $this->withHeaders([
        'Authorization'=>'Bearer '.$token,
        'Accept' => 'application/json'
    ]);
    $data = [
        'likeable_id' => $media->id,
    ];
    $response = $headers->postJson('/api/likes', $data);
    expect($response->status())->toBe(422);
});

test('store : can store a media like', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'url' => 'test_url',
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $media = Media::factory()->create($media_data);
    $headers = $this->withHeaders([
        'Authorization'=>'Bearer '.$token,
        'Accept' => 'application/json'
    ]);
    $data = [
        'likeable_id' => $media->id,
        'likeable_type' => 'App\Models\Media',
    ];
    $response = $headers->postJson('/api/likes', $data);
    expect($response->status())->toBe(200);
});

test('store : can store a commentary like', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $commentary_data = [
        'content' => 'test commentary',
        'user_id' => $user->id,
        'media_id' => 1,
    ];
    $commentary = Commentary::factory()->create($commentary_data);
    $headers = $this->withHeaders([
        'Authorization'=>'Bearer '.$token,
        'Accept' => 'application/json'
    ]);
    $data = [
        'likeable_id' => $commentary->id,
        'likeable_type' => 'App\Models\Commentary',
    ];
    $response = $headers->postJson('/api/likes', $data);
    expect($response->status())->toBe(200);
});
