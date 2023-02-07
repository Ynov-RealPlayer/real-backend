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

        /**
         * Création d'un compte admin
         */
        User::factory()->create([
            'pseudo' => 'admin',
            'experience' => 1000,
            'experience_cap' => 2000,
            'rank_id' => 1,
            'picture' => $faker->imageUrl(),
            'banner' => $faker->imageUrl(),
            'email' => 'admin@real.fr',
            'password' => bcrypt('boursettes'),
            'phone' => $faker->phoneNumber,
            'refresh_token' => $faker->password,
            'description' => $faker->text,
            'followers' => $faker->numberBetween(0, 10000),
            'role_id' => 0
        ]);


        /**
         * Création de 10 fausses données dans les tables
         */
        for ($i = 0; $i < 10; $i++) {

            /**
             * Seeders classiques
             */
            $exp = $faker->numberBetween(0, 1000);
            User::factory()->create([
                'pseudo' => $faker->userName,
                'experience' => $exp,
                'experience_cap' => $exp * 2,
                'rank_id' => $faker->numberBetween(1, 3),
                'picture' => $faker->imageUrl(),
                'banner' => $faker->imageUrl(),
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'phone' => $faker->phoneNumber,
                'refresh_token' => $faker->password,
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

            UserBadge::factory()->create([
                'user_id' => $faker->numberBetween(1, 10),
                'badge_id' => $faker->numberBetween(1, 10),
            ]);
        }
    }
}
