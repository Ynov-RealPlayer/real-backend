<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        /**
         * Création d'un compte admin
         */
        User::factory()->create([
            'pseudo' => 'admin',
            'experience' => 300,
            'picture' => '1686902653png',
            'banner' => '1686902662jpg',
            'email' => 'real@player.fr',
            'password' => bcrypt('ypenderie'),
            'phone' => $faker->phoneNumber,
            'description' => $faker->text,
            'role_id' => 1,
            'rank_id' => 4,
        ]);

        for ($i = 0; $i < 30; $i++) {
            User::factory()->create([
                'pseudo' => $faker->userName,
                'experience' => $faker->numberBetween(0, 200),
                'picture' => '1686902715jpg',
                'banner' => '1686902698jpg',
                'email' => $faker->email,
                'password' => bcrypt('ypenderie'),
                'phone' => $faker->phoneNumber,
                'description' => $faker->text,
                'role_id' => 2,
                'rank_id' => $faker->numberBetween(1, 2),
            ]);
        }
    }
}
