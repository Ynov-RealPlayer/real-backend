<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Badge;
use App\Models\Category;
use App\Models\Commentary;
use App\Models\Experience;
use App\Models\Media;
use App\Models\Rank;
use App\Models\Role;
use Faker\Factory;
use App\Models\User;
use App\Models\UserBadge;
use App\Models\UserMedia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {

            /**
             * Seeders classiques
             */
            User::factory()->create([
                'pseudo' => $faker->userName,
                'picture' => $faker->imageUrl(),
                'banner' => $faker->imageUrl(),
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'phone' => $faker->phoneNumber,
                'refresh_token' => $faker->password,
                'blocked_at' => $faker->dateTime,
                'description' => $faker->text,
                'followers' => $faker->numberBetween(0, 10000),
                'role_id' => $faker->numberBetween(1, 3)
            ]);

            Badge::factory()->create([
                'name' => $faker->word,
                'description' => $faker->text,
                'icon' => $faker->name(),
            ]);

            Category::factory()->create([
                'name' => $faker->name,
                'description' => $faker->text,
                'symbol' => $faker->name,
            ]);

            Rank::factory()->create([
                'name' => $faker->name,
                'experience_cap' => $faker->numberBetween(0, 100),
                'description' => $faker->text,
                'color' => $faker->hexColor,
                'rank_icon' => $faker->name,
            ]);

            Role::factory()->create([
                'name' => $faker->name,
            ]);

            
            /**
             * Les seeders suivant ont besoin de foreign key
             */
            Commentary::factory()->create([
                'nb_like' => $faker->numberBetween(0, 100),
                'user_id' => $faker->numberBetween(1, 10),
                'media_id' => $faker->numberBetween(1, 10),
            ]);
            
            Media::factory()->create([
                'name' => $faker->name,
                'description' => $faker->text,
                'category_id' => $faker->numberBetween(1, 10),
                'media_type' => $faker->name,
                'url' => $faker->url,
                'duration' => $faker->numberBetween(0, 10),
                'nb_like' => $faker->numberBetween(0, 100),
            ]);

            UserMedia::factory()->create([
                'user_id' => $faker->numberBetween(1, 10),
                'media_id' => $faker->numberBetween(1, 10),
            ]);

            UserBadge::factory()->create([
                'user_id' => $faker->numberBetween(1, 10),
                'badge_id' => $faker->numberBetween(1, 10),
            ]);
            
            Experience::factory()->create([
                'exp' => $faker->numberBetween(0, 100),
                'rank_id' => $faker->numberBetween(1, 3),
                'user_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
