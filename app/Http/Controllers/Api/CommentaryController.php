<?php

namespace App\Http\Controllers\Api;

use App\Models\Commentary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Utils\ExperienceController;

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
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
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
        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'user_id' => 'required',
            'media_id' => 'required',
        ], [
            'content.required' => 'Le contenu est obligatoire',
            'user_id.required' => 'L\'utilisateur est obligatoire',
            'media_id.required' => 'Le média est obligatoire',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
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
            return response()->json(['error' => __('lang.unauthorized')], 403);
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
            return response()->json(['error' => __('lang.unauthorized')], 403);
        }
        $commentary->delete();
        return response()->json($commentary);
    }
}
