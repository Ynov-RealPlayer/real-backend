<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Utils\ExperienceController;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request = $request->all();
        $user = $request['user_id'];

        $like = Like::where([
            'user_id' => $user,
            'resource_id' => $request['resource_id'],
            'resource_type' => $request['resource_type'],
        ])->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => $user,
                'resource_id' => $request['resource_id'],
                'resource_type' => $request['resource_type'],
            ]);
            ExperienceController::giveExperience($commentary->user_id, 1);
        }

        return response()->json([
            'message' => 'success',
            'like' => $like ? 'deleted' : 'created',
        ]);
    }
}
