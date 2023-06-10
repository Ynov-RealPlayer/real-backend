<?php

namespace App\Http\Controllers\Utils;

use App\Models\User;
use App\Models\Badge;
use App\Models\BadgeUser;
use App\Http\Controllers\Controller;

class BadgeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * Give the specified badge to the user.
     * @param  Badge  $badge
     * @param  User  $user
     * @return void
     */
    public static function store(Badge $badge, User $user) : void
    {
        $badgeUser = BadgeUser::create([
            'badge_id' => $badge->id,
            'user_id' => $user->id,
        ]);
        $badgeUser->save();
    }
}
