<?php

namespace App\Http\Controllers\Api;

use App\Models\Media;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        foreach ($medias as $media) {
            $media->nb_likes = $media->likes();
            $media->has_liked = $medias->hasLiked();
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
        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]
        );
        $public_id = bin2hex(random_bytes(12));
        $cloudinary->uploadApi()->upload(
            $request->url,
            [
                'public_id' => $public_id,
                'folder' => $request->media_type,
            ]
        );
        $request->merge(['url' => $request->media_type . '/' . $public_id]);
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
        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key' => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
            ]
        );
        $media->url = $cloudinary->image($media->url)->toUrl();
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
        $media = Media::where('category_id', $category)->orderBy('created_at', 'desc')->take(10)->get();
        return response()->json($media);
    }
}
