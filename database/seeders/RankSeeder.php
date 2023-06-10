<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rank::factory()->create([
            'name' => 'Noob',
            'experience_cap' => 100,
            'description' => 'Rank du noob',
            'color' => '#0000FF',
            'icon' => 'noob.png',
        ]);
        Rank::factory()->create([
            'name' => 'Player',
            'experience_cap' => 200,
            'description' => 'Rank du player',
            'color' => '#00FF00',
            'icon' => 'player.png',
        ]);
        Rank::factory()->create([
            'name' => 'ProPlayer',
            'experience_cap' => 300,
            'description' => 'Rank du proPlayer',
            'color' => '#FFFF00',
            'icon' => 'proPlayer.png',
        ]);
        Rank::factory()->create([
            'name' => 'RealPlayer',
            'experience_cap' => 500,
            'description' => 'Rank du realPlayer',
            'color' => '#FF0000',
            'icon' => 'realPlayer.png',
        ]);
    }
}
