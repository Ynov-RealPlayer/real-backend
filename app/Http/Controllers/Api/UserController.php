<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        $users = User::paginate(10);
        return response()->json($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function show(User $user) : JsonResponse
    {
        $user = User::where('id', $user->id)
            ->with('badges', 'medias', 'rank')
            ->first();
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function update(Request $request, User $user) : JsonResponse
    {
        $user = auth()->user()->findOrFail($user->id);
        $user->fill($request->all());

        if ($user->isDirty('banner')) {
            $file = $request->file('banner');
            $extension = $file->getClientOriginalExtension();
            $path = time() . $file->getClientOriginalExtension();
            $file = Image::make($file)->resize(1200, 360)->encode($extension)->save();
            Storage::disk('s3')->put($path, $file);
            $s3 = Storage::disk('s3');
            $s3->put($path, file_get_contents($file));
            $user->banner = $path;
        }

        if ($user->isDirty('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $path = time() . $file->getClientOriginalExtension();
            $file = Image::make($file)->resize(900, 900)->encode($extension)->save();
            Storage::disk('s3')->put($path, $file);
            $s3 = Storage::disk('s3');
            $s3->put($path, file_get_contents($file));
            $user->picture = $path;
        }

        $user->save();
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return JsonResponse
     */
    public function destroy(User $user) : JsonResponse
    {
        $user = auth()->user()->findOrFail($user->id);
        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the top 100 of the users with the most experience.
     *
     * @return JsonResponse
     */
    public function top()
    {
        $users = User::orderBy('experience', 'desc')->take(100)->get();
        return response()->json($users);
    }
}
