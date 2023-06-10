<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Création d'un media minecraft
         */
        for ($i = 0; $i < 3; $i++) {
            $resource = 'https://cdn.icon-icons.com/icons2/2699/PNG/512/minecraft_logo_icon_168974.png';
            $public_id = bin2hex(random_bytes(12));
            $s3 = Storage::disk('s3');
            $s3->put($public_id, file_get_contents($resource));
            Media::factory()->create([
                'name' => 'Minecraft - ' . $i,
                'description' => 'Minecraft description - ' . $i,
                'media_type' => 'screen',
                'url' =>  $public_id,
                'duration' => 0,
                'category_id' => 1,
                'user_id' => rand(1, 10),
            ]);
        }

        /**
         * Création d'un media fortnite
         */
        for ($i = 0; $i < 3; $i++) {
            $resource = 'https://upload.wikimedia.org/wikipedia/commons/7/7c/Fortnite_F_lettermark_logo.png';
            $public_id = bin2hex(random_bytes(12));
            $s3 = Storage::disk('s3');
            $s3->put($public_id, file_get_contents($resource));
            Media::factory()->create([
                'name' => 'Fortnite - ' . $i,
                'description' => 'Fortnite description - ' . $i,
                'media_type' => 'screen',
                'url' =>  $public_id,
                'duration' => 10,
                'category_id' => 2,
                'user_id' => rand(1, 10),
            ]);
        }

        /**
         * Création d'un media league of legends
         */
        for ($i = 0; $i < 3; $i++) {
            $resource = 'https://cdn.domestika.org/c_limit,dpr_auto,f_auto,q_auto,w_820/v1415399107/content-items/001/127/064/LoL_Logo_1-original.jpg?1415399107';
            $public_id = bin2hex(random_bytes(12));
            $s3 = Storage::disk('s3');
            $s3->put($public_id, file_get_contents($resource));
            Media::factory()->create([
                'name' => 'League of Legends - ' . $i,
                'description' => 'League of Legends description - ' . $i,
                'media_type' => 'clip',
                'url' =>  $public_id,
                'duration' => 10,
                'category_id' => 3,
                'user_id' => rand(1, 10),
            ]);
        }

        /**
         * Création d'un media valorant
         */
        for ($i = 0; $i < 3; $i++) {
            $resource = 'https://i.giphy.com/media/TQOTjlzMHRmoqF27CC/giphy.webp';
            $public_id = bin2hex(random_bytes(12));
            $s3 = Storage::disk('s3');
            $s3->put($public_id, file_get_contents($resource));
            Media::factory()->create([
                'name' => 'Valorant - ' . $i,
                'description' => 'Valorant description - ' . $i,
                'media_type' => 'clip',
                'url' =>  $public_id,
                'duration' => 6,
                'category_id' => 4,
                'user_id' => rand(1, 10),
            ]);
        }

        /**
         * Création d'un media call of duty
         */
        for ($i = 0; $i < 3; $i++) {
            $resource = 'https://image.api.playstation.com/vulcan/img/rnd/202008/1900/lTSvbByTYMqy6R22teoybKCg.png';
            $public_id = bin2hex(random_bytes(12));
            $s3 = Storage::disk('s3');
            $s3->put($public_id, file_get_contents($resource));
            Media::factory()->create([
                'name' => 'Call of Duty - ' . $i,
                'description' => 'Call of Duty description - ' . $i,
                'media_type' => 'clip',
                'url' =>  $public_id,
                'duration' => 6,
                'category_id' => 5,
                'user_id' => rand(1, 10),
            ]);
        }

        /**
         * Création d'un media rocket league
         */
        for ($i = 0; $i < 3; $i++) {
            $resource = 'https://media3.giphy.com/media/xT0xepBLaRaduNgkne/giphy.gif';
            $public_id = bin2hex(random_bytes(12));
            $s3 = Storage::disk('s3');
            $s3->put($public_id, file_get_contents($resource));
            Media::factory()->create([
                'name' => 'Rocket League - ' . $i,
                'description' => 'Rocket League description - ' . $i,
                'media_type' => 'clip',
                'url' =>  $public_id,
                'duration' => 6,
                'category_id' => 6,
                'user_id' => rand(1, 10),
            ]);
        }

        /**
         * Création d'un media autre
         */
        for ($i = 0; $i < 3; $i++) {
            $resource = 'https://m.media-amazon.com/images/I/81HDXkdDOeL._AC_UF1000,1000_QL80_.jpg';
            $public_id = bin2hex(random_bytes(12));
            $s3 = Storage::disk('s3');
            $s3->put($public_id, file_get_contents($resource));
            Media::factory()->create([
                'name' => 'Autre - ' . $i,
                'description' => 'Autre description - ' . $i,
                'media_type' => 'clip',
                'url' =>  $public_id,
                'duration' => 6,
                'category_id' => 7,
                'user_id' => rand(1, 10),
            ]);
        }
    }
}
