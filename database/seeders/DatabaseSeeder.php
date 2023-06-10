<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Faker\Factory;
use App\Models\Like;
use App\Models\Commentary;
use Illuminate\Database\Seeder;
use Database\Seeders\LikeSeeder;
use Database\Seeders\RankSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\BadgeSeeder;
use Database\Seeders\MediaSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentarySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        $this->call([
            RoleSeeder::class,
            BadgeSeeder::class,
            RankSeeder::class,
            CategorySeeder::class,
            MediaSeeder::class,
            UserSeeder::class,
            CommentarySeeder::class,
            LikeSeeder::class,
            BadgeUserSeeder::class,
        ]);
    }
}
