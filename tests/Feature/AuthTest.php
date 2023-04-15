<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test user registration with valid data
     *
     * @return void
     */
    public function test_user_can_register_with_valid_data()
    {
        $data = [
            'pseudo' => $this->faker->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'confirm_password' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'token_type',
            ]);
    }

    /**
     * Test user registration with missing data
     *
     * @return void
     */
    // public function test_user_cannot_register_with_missing_data()
    // {
    //     $response = $this->postJson('/api/register', []);

    //     $response->assertStatus(422)
    //         ->assertJsonValidationErrors([
    //             'pseudo',
    //             'email',
    //             'password',
    //             'confirm_password',
    //         ]);
    // }

    /**
     * Test user registration with invalid email
     *
     * @return void
     */
    // public function test_user_cannot_register_with_invalid_email()
    // {
    //     $data = [
    //         'pseudo' => $this->faker->userName,
    //         'email' => 'invalid-email',
    //         'password' => 'password123',
    //         'confirm_password' => 'password123',
    //     ];

    //     $response = $this->postJson('/api/register', $data);

    //     $response->assertStatus(422)
    //         ->assertJsonValidationErrors(['email']);
    // }

    /**
     * Test user registration with existing email
     *
     * @return void
     */
    // public function test_user_cannot_register_with_existing_email()
    // {
    //     $user = User::factory()->create();

    //     $data = [
    //         'pseudo' => $this->faker->userName,
    //         'email' => $user->email,
    //         'password' => 'password123',
    //         'confirm_password' => 'password123',
    //     ];

    //     $response = $this->postJson('/api/register', $data);

    //     $response->assertStatus(422)
    //         ->assertJsonValidationErrors(['email']);
    // }

    /**
     * Test user registration with short password
     *
     * @return void
     */
    // public function test_user_cannot_register_with_short_password()
    // {
    //     $data = [
    //         'pseudo' => $this->faker->userName,
    //         'email' => $this->faker->unique()->safeEmail,
    //         'password' => 'pass',
    //         'confirm_password' => 'pass',
    //     ];

    //     $response = $this->postJson('/api/register', $data);

    //     $response->assertStatus(422)
    //         ->assertJsonValidationErrors(['password']);
    // }

    /**
     * Test user registration with mismatched passwords
     *
     * @return void
     */
    // public function test_user_cannot_register_with_mismatched_passwords()
    // {
    //     $data = [
    //         'pseudo' => $this->faker->userName,
    //         'email' => $this->faker->unique()->safeEmail,
    //         'password' => 'password123',
    //         'confirm_password' => 'password456',
    //     ];

    //     $response = $this->postJson('/api/register', $data);

    //     $response->assertStatus(422)
    //         ->assertJsonValidationErrors(['confirm_password']);
    // }

    /**
     * Test user registration creates a new user
     *
     * @return void
     */
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
}
