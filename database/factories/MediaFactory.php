<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
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
            'description' => fake()->text(),
            'media_type' => fake()->name(),
            'url' => fake()->url(),
            'duration' => fake()->numberBetween(0, 10),
            'nb_like' => fake()->numberBetween(0, 100),
            'category_id' => fake()->numberBetween(1, 3),
        ];
    }
}
