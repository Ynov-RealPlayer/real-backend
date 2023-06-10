<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Badge;
use App\Models\BadgeUser;
use Illuminate\Database\Seeder;

class BadgeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 30; $i++) {
            $badge = Badge::find(rand(1, 7));
            $user = User::find(rand(1, 31));
            if (!$user->badges()->where('badge_id', $badge->id)->exists()) {
                BadgeUser::factory()->create([
                    'badge_id' => $badge->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
