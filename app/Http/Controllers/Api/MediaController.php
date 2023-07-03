<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Utils\ExperienceController;
use Intervention\Image\Image;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $medias = Media::orderBy('created_at', 'desc')->take(10)->get();
        return response()->json($medias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $file = $request->file('resource');
        $img = Image::make($file->path());
        $file = $img->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        $s3 = Storage::disk('s3');
        $path = time() . $file->getClientOriginalExtension();
        $s3->put($path, file_get_contents($file));
        $request->merge([
            'url' => $path,
            'user_id' => auth()->user()->id,
        ]);
        $media = Media::create($request->all());
        ExperienceController::giveExperience(auth()->user(), 10);
        return response()->json($media);
    }

    /**
     * Display the specified resource.
     *
     * @param Media $media
     * @return JsonResponse
     */
    public function show(Media $media) : JsonResponse
    {
        $media = Media::where('id', $media->id)->with('user')->first();
        $s3 = Storage::disk('s3');
        $media->user->picture = $s3->temporaryUrl($media->user->picture, now()->addMinutes(5));
        $media->user->banner = $s3->temporaryUrl($media->user->banner, now()->addMinutes(5));
        return response()->json($media);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Media $media
     * @return JsonResponse
     */
    public function update(Request $request, Media $media) : JsonResponse
    {
        $media = auth()->user()->medias()->findOrfail($media->id);
        $media->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category_id'),
        ]);
        return response()->json($media);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Media $media
     * @return JsonResponse
     */
    public function destroy(Request $request, Media $media) : JsonResponse
    {
        $media = auth()->user()->medias()->findOrfail($media->id);
        $media->delete();
        return response()->json(null, 204);
    }

    /**
     * Display a listing of the resource with the specified category.
     * @param  Category  $category
     * @return JsonResponse
     */
    public function category(Category $category) : JsonResponse
    {
        $media = Media::where('category_id', $category->id)->orderBy('created_at', 'desc')->take(10)->get();
        return response()->json($media);
    }
}
