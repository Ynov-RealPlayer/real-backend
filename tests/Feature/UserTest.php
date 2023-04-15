<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    // public function testIndexReturnsJsonResponse()
    // {
    //     $user = factory(User::class)->create();
    //     $token = $user->createToken('Test Token')->plainTextToken;
    //     $response = $this->get('/api/test/users');
    //     $response->assertStatus(200);
    //     $response->assertHeader('Content-Type', 'application/json');
    // }

    // public function testIndexReturnsPaginatedUsers()
    // {
    //     $users = factory(User::class, 20)->create();
    //     $response = $this->get('/api/test/users');
    //     $response->assertJsonCount(10, 'data');
    //     $response->assertJsonFragment([
    //         'total' => 20,
    //         'per_page' => 10,
    //         'current_page' => 1,
    //         'last_page' => 2,
    //     ]);
    // }

    // public function testIndexReturnsCorrectUsers()
    // {
    //     $users = factory(User::class, 20)->create();
    //     $response = $this->get('/api/test/users');
    //     $response->assertJsonFragment([
    //         'name' => $users[0]->name,
    //         'email' => $users[0]->email,
    //     ]);
    //     $response->assertJsonFragment([
    //         'name' => $users[9]->name,
    //         'email' => $users[9]->email,
    //     ]);
    // }
}
