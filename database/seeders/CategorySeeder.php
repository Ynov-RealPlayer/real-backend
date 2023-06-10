<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            'name' => 'Minecraft',
            'description' => 'Catégorie Minecraft',
            'symbol' => '🗡️',
        ]);
        Category::factory()->create([
            'name' => 'Fortnite',
            'description' => 'Catégorie Fortnite',
            'symbol' => '🚩',
        ]);
        Category::factory()->create([
            'name' => 'League of Legends',
            'description' => 'Catégorie League of Legends',
            'symbol' => '🏆',
        ]);
        Category::factory()->create([
            'name' => 'Valorant',
            'description' => 'Catégorie Valorant',
            'symbol' => '🔫',
        ]);
        Category::factory()->create([
            'name' => 'Call of Duty',
            'description' => 'Catégorie Call of Duty',
            'symbol' => '🎖️',
        ]);
        Category::factory()->create([
            'name' => 'Rocket League',
            'description' => 'Catégorie Rocket League',
            'symbol' => '🚗',
        ]);
        Category::factory()->create([
            'name' => 'Autre',
            'description' => 'Catégorie Autre',
            'symbol' => '🎮',
        ]);
    }
}
