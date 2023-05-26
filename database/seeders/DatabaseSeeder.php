<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Faker\Factory;
use App\Models\Like;
use App\Models\Rank;
use App\Models\Role;
use App\Models\User;
use App\Models\Badge;
use App\Models\Media;
use App\Models\Category;
use App\Models\Commentary;
use Cloudinary\Cloudinary;
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

        // ROLE
        /**
         * Création d'un role admin
         */
        Role::factory()->create([
            'name' => 'admin',
        ]);

        /**
         * Création d'un role user
         */
        Role::factory()->create([
            'name' => 'user',
        ]);

        // BADGE
        /**
         * Création d'un badge licorne
         */
        Badge::factory()->create([
            'name' => 'Licorne',
            'description' => 'Badge de la licorne',
            'icon' => 'licorne.png',
        ]);

        /**
         * Création d'un badge panda
         */
        Badge::factory()->create([
            'name' => 'Panda',
            'description' => 'Badge du panda',
            'icon' => 'panda.png',
        ]);

        /**
         * Création d'un badge chat
         */
        Badge::factory()->create([
            'name' => 'Chat',
            'description' => 'Badge du chat',
            'icon' => 'chat.png',
        ]);

        /**
         * Création d'un badge chien
         */
        Badge::factory()->create([
            'name' => 'Chien',
            'description' => 'Badge du chien',
            'icon' => 'chien.png',
        ]);

        // RANK
        /**
         * Création d'un rank noob
         */
        Rank::factory()->create([
            'name' => 'Noob',
            'experience_cap' => 100,
            'description' => 'Rank du noob',
            'color' => '#0000FF',
            'icon' => 'noob.png',
        ]);

        /**
         * Création d'un rank player
         */
        Rank::factory()->create([
            'name' => 'Player',
            'experience_cap' => 200,
            'description' => 'Rank du player',
            'color' => '#00FF00',
            'icon' => 'player.png',
        ]);

        /**
         * Création d'un rank proPlayer
         */
        Rank::factory()->create([
            'name' => 'ProPlayer',
            'experience_cap' => 300,
            'description' => 'Rank du proPlayer',
            'color' => '#FFFF00',
            'icon' => 'proPlayer.png',
        ]);

        /**
         * Création d'un rank RealPlayer
         */
        Rank::factory()->create([
            'name' => 'RealPlayer',
            'experience_cap' => 500,
            'description' => 'Rank du realPlayer',
            'color' => '#FF0000',
            'icon' => 'realPlayer.png',
        ]);

        // CATEGORY
        /**
         * Création d'une catégorie minecraft
         */
        Category::factory()->create([
            'name' => 'Minecraft',
            'description' => 'Catégorie Minecraft',
            'symbol' => '🗡️',
        ]);

        /**
         * Création d'une catégorie fortnite
         */
        Category::factory()->create([
            'name' => 'Fortnite',
            'description' => 'Catégorie Fortnite',
            'symbol' => '🚩',
        ]);

        /**
         * Création d'une catégorie league of legends
         */
        Category::factory()->create([
            'name' => 'League of Legends',
            'description' => 'Catégorie League of Legends',
            'symbol' => '🏆',
        ]);

        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]
        );

        // https://i.seadn.io/gae/2hDpuTi-0AMKvoZJGd-yKWvK4tKdQr_kLIpB_qSeMau2TNGCNidAosMEvrEXFO9G6tmlFlPQplpwiqirgrIPWnCKMvElaYgI-HiVvXc?auto=format&dpr=1&w=1000
        $resource = 'https://i.seadn.io/gae/2hDpuTi-0AMKvoZJGd-yKWvK4tKdQr_kLIpB_qSeMau2TNGCNidAosMEvrEXFO9G6tmlFlPQplpwiqirgrIPWnCKMvElaYgI-HiVvXc?auto=format&dpr=1&w=1000';
        $public_id = bin2hex(random_bytes(12));
        $cloudinary->uploadApi()->upload(
            $resource,
            [
                'public_id' => $public_id,
                'folder' => $public_id,
            ]
        );
        $url = $public_id . '/' . $public_id;

        // MEDIA
        /**
         * Création d'un media minecraft
         */
        Media::factory()->create([
            'name' => 'Minecraft',
            'description' => 'Minecraft',
            'media_type' => 'SCREEN',
            'url' => $url,
            'duration' => 0,
            'category_id' => 1,
            'user_id' => 1,
        ]);

        /**
         * Création d'un media fortnite
         */
        Media::factory()->create([
            'name' => 'Fortnite',
            'description' => 'Fortnite',
            'media_type' => 'SCREEN',
            'url' => $url,
            'duration' => 0,
            'category_id' => 2,
            'user_id' => 3,
        ]);

        /**
         * Création d'un media league of legends
         */
        Media::factory()->create([
            'name' => 'League of Legends',
            'description' => 'League of Legends',
            'media_type' => 'CLIP',
            'url' => $url,
            'duration' => 6,
            'category_id' => 3,
            'user_id' => 5,
        ]);

        /**
         * Création d'un compte admin
         */
        User::factory()->create([
            'pseudo' => 'admin',
            'experience' => 300,
            'picture' => $faker->imageUrl(),
            'banner' => $faker->imageUrl(),
            'email' => 'real@player.fr',
            'password' => bcrypt('boursettes'),
            'phone' => $faker->phoneNumber,
            'description' => $faker->text,
            'role_id' => 1,
            'rank_id' => 4,
        ]);

        for ($i = 0; $i < 10; $i++) {
            User::factory()->create([
                'pseudo' => $faker->userName,
                'experience' => $faker->numberBetween(0, 200),
                'picture' => $faker->imageUrl(),
                'banner' => $faker->imageUrl(),
                'email' => $faker->email,
                'password' => bcrypt('boursettes'),
                'phone' => $faker->phoneNumber,
                'description' => $faker->text,
                'role_id' => 2,
                'rank_id' => $faker->numberBetween(1, 2),
            ]);
        }

        // COMMENTARY
        /**
         * Création d'un commentaire minecraft
         */
        Commentary::factory()->create([
            'content' => 'Minecraft',
            'media_id' => 1,
            'user_id' => 1,
        ]);

        /**
         * Création d'un commentaire fortnite
         */
        Commentary::factory()->create([
            'content' => 'Fortnite',
            'media_id' => 2,
            'user_id' => 3,
        ]);

        /**
         * Création de likes
         */
        for ($i = 0; $i < 10; $i++) {
            $resource_type = $faker->randomElement(['App\Models\Media', 'App\Models\Commentary']);
            Like::factory()->create([
                'user_id' => $faker->numberBetween(1, 10),
                'resource_type' => $resource_type,
                'resource_id' => $faker->numberBetween(1, 3),
            ]);
        }
    }
}
