<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'pseudo' => fake()->name(),
            'experience' => fake()->numberBetween(0, 1000),
            'experience_cap' => fake()->numberBetween(0, 1000),
            'rank_id' => fake()->numberBetween(1, 3),
            'picture' => fake()->imageUrl(),
            'banner' => fake()->imageUrl(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => fake()->phoneNumber(),
            'remember_token' => Str::random(10),
            'refresh_token' => Str::random(10),
            'created_at' => now(),
            'blocked_at' => null,
            'description' => fake()->text(),
            'followers' => fake()->numberBetween(0, 1000),
            'role_id' => fake()->numberBetween(1, 3),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
