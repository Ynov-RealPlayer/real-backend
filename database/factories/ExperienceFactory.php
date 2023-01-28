<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'exp' => fake()->numberBetween(0, 100),
            'rank_id' => fake()->numberBetween(1, 3),
            'user_id' => fake()->numberBetween(1, 10),
        ];
    }
}
