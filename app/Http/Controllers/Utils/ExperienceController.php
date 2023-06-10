<?php

namespace App\Http\Controllers\Utils;

use App\Http\Controllers\Controller;
use App\Models\User;

class ExperienceController extends Controller
{
    /**
     * Give the specified amount of experience to the user.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public static function giveExperience(User $user, int $amount)
    {
        $user->experience += $amount;
        $user->save();
        return response()->json($user);
    }
}
