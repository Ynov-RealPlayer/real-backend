<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Badge::factory()->create([
            'name' => 'Licorne',
            'description' => 'Mais où avez-vous trouvé cet animal !?',
            'icon' => '🦄',
        ]);

        Badge::factory()->create([
            'name' => 'Panda',
            'description' => 'Mangez des bambous !',
            'icon' => '🐼',
        ]);

        Badge::factory()->create([
            'name' => 'Poule',
            'description' => 'Cocorico !',
            'icon' => '🐔',
        ]);

        Badge::factory()->create([
            'name' => 'Poisson',
            'description' => 'Nemo ?',
            'icon' => '🐟',
        ]);

        Badge::factory()->create([
            'name' => 'Chien',
            'description' => 'Qui est le meilleur ami de l\'homme ?',
            'icon' => '🐶',
        ]);

        Badge::factory()->create([
            'name' => 'Chat',
            'description' => 'Miaou !',
            'icon' => '🐱',
        ]);

        Badge::factory()->create([
            'name' => 'Lapin',
            'description' => 'C\'est pas faux !',
            'icon' => '🐰',
        ]);
    }
}
