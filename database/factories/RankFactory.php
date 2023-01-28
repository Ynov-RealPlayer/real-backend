<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rank>
 */
class RankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'experience_cap' => fake()->numberBetween(0, 100),
            'description' => fake()->text(),
            'color' => fake()->hexColor(),
            'rank_icon' => fake()->name(),
        ];
    }
}
