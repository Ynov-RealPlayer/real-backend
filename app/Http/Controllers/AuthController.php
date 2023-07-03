<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NotificationController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Registration of a new user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request) : JsonResponse
    {
        $messages = [
            'pseudo.required' => __('lang.pseudo.required'),
            'pseudo.unique' => __('lang.pseudo.unique'),
            'email.required' => __('lang.email.required'),
            'email.email' => __('lang.email.email'),
            'email.unique' => __('lang.email.unique'),
            'password.required' => __('lang.password.required'),
            'password.min' => __('lang.password.min'),
            'confirm_password.required' => __('lang.confirm_password.required'),
            'confirm_password.same' => __('lang.confirm_password.same'),
        ];

        $validator = Validator::make($request->all(), [
            'pseudo' => 'required|unique:users,pseudo',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create(
            [
                'pseudo' => $request->input('pseudo'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]
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
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request) : JsonResponse
    {
        $messages = [
            'email.required' => __('lang.email.required'),
            'email.email' => __('lang.email.email'),
            'password.required' => __('lang.password.required'),
            'password.min' => __('lang.password.min'),
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => __('lang.login.bad_credentials'),
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        $user->refresh_token = $token;
        $user->remember_token = $token;
        //$user->device_token = $request->input('device_token');
        $user->save();

        //NotificationController::store('Connexion', 'Vous êtes connecté !');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Return the current user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request) : JsonResponse
    {
        $user = User::where('id', $request->user()->id)
            ->with('rank', 'role', 'badges', 'medias', 'comments', 'likes', 'badges.badge')
            ->first();

        if ($user) {
            return response()->json($user);
        }
        return response()->json(['error' => __('lang.unauthorized')], 403);
    }

    /**
     * Logout the current user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request) : JsonResponse
    {
        $user = $request->user();
        if ($user) {
            $tokenId = $user->currentAccessToken()->id;
            $user->tokens()->where('id', $tokenId)->delete();
            return response()->json(['message' => __('lang.logout')]);
        }
        return response()->json(['error' => __('lang.unauthorized')], 403);
    }

}
