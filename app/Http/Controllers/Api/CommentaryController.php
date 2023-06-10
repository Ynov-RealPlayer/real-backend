<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\ExperienceController;
use App\Models\Commentary;
use Illuminate\Http\Request;

class CommentaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Commentary $commentary)
    {
        $commentaries = $commentary->where('media_id', $request->media_id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        foreach ($commentaries as $commentary) {
            $commentary->nb_likes = $commentary->likes();
            $commentary->has_liked = $commentary->hasLiked();
        }
        return response()->json($commentaries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'user_id' => auth()->user()->id,
        ]);
        $commentary = Commentary::create($request->all());
        ExperienceController::giveExperience(auth()->user(), 4);
        return response()->json($commentary);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commentary  $commentary
     * @return \Illuminate\Http\Response
     */
    public function show(Commentary $commentary)
    {
        $commentary->nb_likes = $commentary->likes();
        $commentary->has_liked = $commentary->hasLiked();
        return response()->json($commentary);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Commentary  $commentary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commentary $commentary)
    {
        if (auth()->user()->id != $commentary->user_id) {
            return response()->json(['error' => __('lang.unauthorized')], 401);
        }
        $commentary->update($request->all());
        return response()->json($commentary);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Commentary  $commentary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commentary $commentary)
    {
        if (auth()->user()->id != $commentary->user_id) {
            return response()->json(['error' => __('lang.unauthorized')], 401);
        }
        $commentary->delete();
        return response()->json($commentary);
    }
}
