<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Media;
use App\Models\Commentary;
use App\Http\Controllers\Api\CommentaryController;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(TestCase::class);

// ! Index Tests
test('index : error if not logged in', function () {
    $response = $this->get('/api/commentaries');
    expect($response->status())->toBe(401);
});

test('index : show all the existing commentaries', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/commentaries');
    expect($response->status())->toBe(200);
});

// ! Store Tests
test('store : error if not logged in', function () {
    $response = $this->post('/api/commentaries');
    expect($response->status())->toBe(401);
});

test('store : error if media_id is missing', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $headers = $this->withHeaders([
        'Authorization'=>'Bearer '.$token,
        'Accept' => 'application/json'
    ]);
    $data = [
        'content' => 'test commentary',
        'user_id' => $user->id,
    ];
    $response = $headers->postJson('/api/commentaries', $data);
    expect($response->status())->toBe(422);
});

test('store : error if content is missing', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $headers = $this->withHeaders([
        'Authorization'=>'Bearer '.$token,
        'Accept' => 'application/json'
    ]);
    $data = [
        'media_id' => 1,
        'user_id' => $user->id,
    ];
    $response = $headers->postJson('/api/commentaries', $data);
    expect($response->status())->toBe(422);
});

test('store : create a commentary', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $headers = $this->withHeaders([
        'Authorization'=>'Bearer '.$token,
        'Accept' => 'application/json'
    ]);
    $data = [
        'content' => 'test commentary',
        'media_id' => 1,
        'user_id' => $user->id,
    ];
    $response = $headers->postJson('/api/commentaries', $data);
    expect($response->status())->toBe(200);
});

// ! Show Tests
test('show : error if not logged in', function () {
    $response = $this->get('/api/commentaries/1');
    expect($response->status())->toBe(401);
});

test('show : show a commentary', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'media_type' => 'screen',
        'url' => 'test_url',
        'duration' => 10,
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $media = Media::factory()->create($media_data);
    $com_data = [
        'content' => 'test commentary',
        'media_id' => $media->id,
        'user_id' => $user->id,
    ];
    $commentary = Commentary::factory()->create($com_data);
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->getJson('/api/commentaries/'.$commentary->id);
    expect($response->status())->toBe(200);
});

// ! Update Tests
test('update : error if not logged in', function () {
    $response = $this->put('/api/commentaries/1');
    expect($response->status())->toBe(401);
});

test('update : can update', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'media_type' => 'screen',
        'url' => 'test_url',
        'duration' => 10,
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $media = Media::factory()->create($media_data);
    $com_data = [
        'content' => 'test commentary',
        'media_id' => $media->id,
        'user_id' => $user->id,
    ];
    $commentary = Commentary::factory()->create($com_data);
    $new_data = [
        'content' => 'new commentary',
        'media_id' => $media->id,
        'user_id' => $user->id,
    ];
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->putJson('/api/commentaries/'.$commentary->id, $new_data);
    expect($response->status())->toBe(200);
});

test('update : error if not owner of the commentary', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'media_type' => 'screen',
        'url' => 'test_url',
        'duration' => 10,
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $media = Media::factory()->create($media_data);
    $com_data = [
        'content' => 'test commentary',
        'media_id' => $media->id,
        'user_id' => $user->id,
    ];
    $commentary = Commentary::factory()->create($com_data);
    $new_data = [
        'content' => 'new commentary',
        'media_id' => $media->id,
        'user_id' => $user->id,
    ];
    $user2 = User::factory()->create();
    $token2 = $user2->createToken('auth_token')->plainTextToken;
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token2,
            'Accept' => 'application/json'
        ])
        ->putJson('/api/commentaries/'.$commentary->id, $new_data);
    expect($response->status())->toBe(403);
});

// ! Destroy Tests
test('destroy : error if not logged in', function () {
    $response = $this->delete('/api/commentaries/1');
    expect($response->status())->toBe(401);
});

test('destroy : can destroy', function () {
    $user = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'media_type' => 'screen',
        'url' => 'test_url',
        'duration' => 10,
        'category_id' => 1,
        'user_id' => $user->id,
    ];
    $media = Media::factory()->create($media_data);
    $com_data = [
        'content' => 'test commentary',
        'media_id' => $media->id,
        'user_id' => $user->id,
    ];
    $commentary = Commentary::factory()->create($com_data);
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->deleteJson('/api/commentaries/'.$commentary->id);
    expect($response->status())->toBe(200);
});

test('destroy : cannot destroy if not owner', function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();
    $token = $user->createToken('auth_token')->plainTextToken;
    $media_data = [
        'name' => 'test media',
        'description' => 'test description',
        'media_type' => 'screen',
        'url' => 'test_url',
        'duration' => 10,
        'category_id' => 1,
        'user_id' => $user2->id,
    ];
    $media = Media::factory()->create($media_data);
    $com_data = [
        'content' => 'test commentary',
        'media_id' => $media->id,
        'user_id' => $user2->id,
    ];
    $commentary = Commentary::factory()->create($com_data);
    $response = $this->withHeaders([
            'Authorization'=>'Bearer '.$token,
            'Accept' => 'application/json'
        ])
        ->deleteJson('/api/commentaries/'.$commentary->id);
    expect($response->status())->toBe(403);
});