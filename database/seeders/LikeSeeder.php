<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Seeder;
use Faker\Factory;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {
            $resource_type = $faker->randomElement(['App\Models\Media', 'App\Models\Commentary']);
            try {
                Like::factory()->create([
                    'user_id' => $faker->numberBetween(1, 10),
                    'likeable_id' => $faker->numberBetween(1, 3),
                    'likeable_type' => $resource_type,
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
