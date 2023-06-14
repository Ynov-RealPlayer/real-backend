<?php

namespace App\Http\Controllers\Api;

use Aws\S3\S3Client;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Utils\ExperienceController;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medias = Media::orderBy('created_at', 'desc')->take(10)->get();
        return response()->json($medias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make((array) $request, [
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'media_type' => 'required',
            'duration' => 'required',
            'resource' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $file = $request->file('resource');
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
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Media $media)
    {
        $media = Media::where('id', $media->id)->with('user')->first();
        return response()->json($media);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        if (auth()->user()->id != $media->user_id) {
            return response()->json(['error' => __('lang.unauthorized')], 403);
        }
        $media->update([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);
        return response()->json($media);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Media $media)
    {
        if (auth()->user()->id != $media->user_id) {
            return response()->json(['error' => __('lang.unauthorized')], 403);
        }
        $media->delete();
        return response()->json(null, 204);
    }

    /**
     * Display a listing of the resource with the specified category.
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function category($category)
    {
        $media = Media::where('category_id', $category)->orderBy('created_at', 'desc')->take(10)->get();
        return response()->json($media);
    }
}
