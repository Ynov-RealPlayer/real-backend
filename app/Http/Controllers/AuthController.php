<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registration of a new user
     *
     * @param UserStoreRequest $request
     * @return json
     */
    public function register(Request $request)
    {
        // check if the data are valid
        $attributes = $request->validate([
            'pseudo' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        // create a new user
        $user = User::create(
            array_merge(
                $attributes,
                ['password' => Hash::make($attributes['password'])]
            )
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Connection of an existing user
     *
     * @param UserStoreRequest $request
     * @return json
     */
    public function login(Request $request)
    {
        // check if the data are valid
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // check if the user exists
        $user = User::where('email', $attributes['email'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Return the current user
     *
     * @param Request $request
     * @return json
     */
    public function me(Request $request)
    {
        $user = $request->user();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
