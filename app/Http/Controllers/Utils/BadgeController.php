<?php

namespace App\Http\Controllers;

use App\Models\BadgeUser;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(int $badgeId, int $userId)
    {
        $badgeUser = BadgeUser::create([
            'badge_id' => $badgeId,
            'user_id' => $userId,
        ]);

        return response()->json($badgeUser, 201);
    }
}
