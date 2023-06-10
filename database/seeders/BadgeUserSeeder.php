<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            $badge = Badge::find(rand(1, 10));
            $user = User::find(rand(1, 10));
            if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                $user->badges()->attach($badge);
            }
        }
    }
}
