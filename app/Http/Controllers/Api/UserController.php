<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return response()->json($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return Response
     */
    public function show(User $user)
    {
        $user = User::where('id', $user->id)
            ->with('badges', 'medias')
            ->first();
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        if (auth()->user()->id != $user->id) {
            return response()->json(['error' => __('lang.unauthorized')], 403);
        }
    
        $user->fill($request->all());

        if ($user->isDirty('description')) {
            $user->description = $request->description;
        }

        if ($user->isDirty('pseudo')) {
            $user->pseudo = $request->pseudo;
        }

        if ($user->isDirty('banner')) {
            $s3 = Storage::disk('s3');
            $file = $request->file('banner');
            $path = time() . $file->getClientOriginalExtension();
            $s3->put($path, file_get_contents($file));
            $user->banner = $path;
        }
    
        if ($user->isDirty('picture')) {
            $s3 = Storage::disk('s3');
            $file = $request->file('picture');
            $path = time() . $file->getClientOriginalExtension();
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
     * @return Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->id != $user->id) {
            return response()->json(['error' => __('lang.unauthorized')], 403);
        }
        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the top 100 of the users with the most experience.
     *
     * @return Response
     */
    public function top()
    {
        $users = User::orderBy('experience', 'desc')->take(100)->get();
        return response()->json($users);
    }
}
