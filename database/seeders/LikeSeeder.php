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
            $user_id = $faker->numberBetween(1, 31);
            $likeable_id = $faker->numberBetween(1, 21);
            $like = Like::where('user_id', $user_id)
                ->where('likeable_id', $likeable_id)
                ->where('likeable_type', $resource_type)->get();
            if (count($like) === 0) {
                Like::factory()->create([
                    'user_id' => $user_id,
                    'likeable_id' => $likeable_id,
                    'likeable_type' => $resource_type,
                ]);
            }
        }
    }
}
