<?php

namespace App\Http\Controllers\Api;

use Aws\S3\S3Client;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Utils\ExperienceController;

class MediaController extends Controller
{
    private $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('s3');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medias = Media::orderBy('created_at', 'desc')->take(10)->get();
        foreach ($medias as $media) {
            $media_type = $media->media_type;
            $media->url = Storage::disk('s3')->temporaryUrl(
                $media->url,
                now()->addMinutes(20)
            );
        }
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
        $file = $request->file('resource');
        $s3 = Storage::disk('s3');
        $name = time() . $request->file('resource')->getClientOriginalExtension();
        $s3->put($name, file_get_contents($file));
        $request->merge(['url' => $name]);
        $media = Media::create($request->all());
        ExperienceController::giveExperience($media->user_id, 10);
        return response()->json($media);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        $media_type = $media->media_type;
        if ($media_type == 'video') {
            $media->url = $this->cloudinary->video($media->url)->toUrl();
        } else {
            $media->url = $this->cloudinary->image($media->url)->toUrl();
        }
        $media->nb_likes = $media->likes();
        $media->has_liked = $media->hasLiked();
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
        $media->update($request->all());
        return response()->json($media);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
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
        $medias = Media::where('category_id', $category)->orderBy('created_at', 'desc')->take(10)->get();
        foreach ($medias as $media) {
            $media_type = $media->media_type;
            if ($media_type == 'video') {
                $media->url = $this->cloudinary->video($media->url)->toUrl();
            } else {
                $media->url = $this->cloudinary->image($media->url)->toUrl();
            }
        }
        return response()->json($media);
    }
}
