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
            'picture' => 'https://i.pinimg.com/originals/2c/f6/77/2cf677c38353058ae3d5f0eaefb77137.jpg',
            'banner' => 'https://static.bandainamcoent.eu/high/tales-of/tales-of-arise/00-page-setup/toa_game-thumbnail.jpg',
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
                'picture' => 'https://static.vecteezy.com/ti/vecteur-libre/p1/2292333-dessin-anime-drole-ragondin-comique-personnage-animal-vectoriel.jpg',
                'banner' => 'https://wallpapers.com/images/featured/wfcih60h2h5ploke.jpg',
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
