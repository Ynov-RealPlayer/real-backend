<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Utils\ExperienceController;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $request = (object) $request->all();
        $messages = [
            'likeable_id.required' => 'Le champ likeable_id est requis.',
            'likeable_type.required' => 'Le champ likeable_type est requis.',
        ];
        $validator = Validator::make((array) $request, [
            'likeable_id' => 'required',
            'likeable_type' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
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
            ExperienceController::giveExperience(auth()->user(), 1);
        }

        return response()->json([
            'message' => 'success',
            'like' => $like ? 'deleted' : 'created',
        ]);
    }
}
