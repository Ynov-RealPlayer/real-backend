<?php

namespace Database\Seeders;

use App\Models\Commentary;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CommentarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 200; $i++) {
            Commentary::factory()->create([
                'content' => $faker->text,
                'media_id' => $faker->numberBetween(1, 21),
                'user_id' => $faker->numberBetween(1, 31),
            ]);
        }
    }
}
