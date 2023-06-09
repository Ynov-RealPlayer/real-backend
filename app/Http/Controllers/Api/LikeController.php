<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\ExperienceController;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request = (object) $request->all();
        $like = Like::where([
            'user_id' => auth()->user()->id,
            'likeable_id' => $request->likeable_id,
            'likeable_type' => $request->likeable_type,
        ])->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => auth()->user()->id,
                'likeable_id' => $request->likeable_id,
                'likeable_type' => $request->likeable_type,
            ]);
            ExperienceController::giveExperience(auth()->user()->id, 1);
        }

        return response()->json([
            'message' => 'success',
            'like' => $like ? 'deleted' : 'created',
        ]);
    }
}
