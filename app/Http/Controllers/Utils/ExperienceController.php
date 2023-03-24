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
    public static function giveExperience(int $user_id, int $amount)
    {
        $user = User::find($user_id);
        $user->experience += $amount;
        $user->save();
        return response()->json($user);
    }
}
