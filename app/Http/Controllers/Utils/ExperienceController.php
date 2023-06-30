<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ExperienceController extends Controller
{
    /**
     * Give the specified amount of experience to the user.
     *
     * @param User $user
     * @param int $amount
     * @return JsonResponse
     */
    public static function giveExperience(User $user, int $amount) : JsonResponse
    {
        $user->experience += $amount;
        $user->save();
        return response()->json($user);
    }
}
