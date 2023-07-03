<?php

namespace App\Http\Controllers\Api;

use App\Models\Commentary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Utils\ExperienceController;

class CommentaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Commentary $commentary
     * @return JsonResponse
     */
    public function index(Request $request, Commentary $commentary) : JsonResponse
    {
        $commentaries = $commentary->where('media_id', $request->input('media_id'))
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        return response()->json($commentaries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
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
     * @param Commentary $commentary
     * @return JsonResponse
     */
    public function show(Commentary $commentary) : JsonResponse
    {
        return response()->json($commentary);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Commentary  $commentary
     * @return JsonResponse
     */
    public function update(Request $request, Commentary $commentary) : JsonResponse
    {
        $commentary = auth()->user()->comments()->findOrFail($commentary->id);
        $commentary->update($request->all());
        return response()->json($commentary);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Commentary  $commentary
     * @return JsonResponse
     */
    public function destroy(Commentary $commentary)
    {
        $commentary = auth()->user()->comments()->findOrFail($commentary->id);
        $commentary->delete();
        return response()->json($commentary);
    }
}
