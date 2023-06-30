<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Media;
use App\Models\Category;
use App\Models\Commentary;
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

test('index : show all the existing media', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/media');
    expect($response->status())->toBe(200);
});

// ! Show Tests
test('show : error if not logged in', function () {
    $response = $this->get('/api/media/1');
    expect($response->status())->toBe(401);
});

test('show : error if media does not exist', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'url' => 'test_url',
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    Media::factory()->create($media_data);
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/media/1');
    expect($response->status())->toBe(404);
});

test('show : can show a media', function () {
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
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/media/'.$media->id);
    expect($response->status())->toBe(200);
});

// ! Update Tests
test('update : error if not logged in', function () {
    $response = $this->put('/api/media/1');
    expect($response->status())->toBe(401);
});

test('update : error if media does not exist', function () {
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
    $data = [
        'name' => 'test media',
        'description' => 'test description',
        'url' => 'test_url',
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->putJson('/api/media/'.($media->id + 1), $data);
    expect($response->status())->toBe(404);
});

// ! Delete Tests
test('delete : error if not logged in', function () {
    $response = $this->delete('/api/media/1');
    expect($response->status())->toBe(401);
});

test('delete : error if media does not exist', function () {
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
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->deleteJson('/api/media/2');
    expect($response->status())->toBe(404);
});

test('delete : can delete a media', function () {
    Storage::fake('public');
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
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->deleteJson('/api/media/'.$media->id);
    expect($response->status())->toBe(204);
});
