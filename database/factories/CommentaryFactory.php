<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentary>
 */
class CommentaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nb_like' => fake()->numberBetween(0, 100),
            'user_id' => fake()->numberBetween(1, 10),
            'media_id' => fake()->numberBetween(1, 10),
        ];
    }
}
