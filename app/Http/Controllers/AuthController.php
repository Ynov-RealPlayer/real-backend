<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserStoreRequest $request)
    {
        // vérifie si les données sont valides
        $attributes = $request->validated();

        // crée un nouvel utilisateur
        $user = User::create(
            array_merge(
                $attributes,
                ['password' => Hash::make($attributes['password'])]
            )
        );

        // génère un token d'authentification
        $token = $user->createToken('auth_token')->plainTextToken;

        // retourne le token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(UserStoreRequest $request)
    {
        // vérifie si les données sont valides
        $attributes = $request->validated();

        // vérifie si l'utilisateur existe
        $user = User::where('email', $attributes['email'])->first();

        // vérifie si le mot de passe est correct
        if (!$user || !Hash::check($attributes['password'], $user->password)) {
            return response()->json([
                'message' => 'Mauvais identifiants',
            ], 401);
        }

        // génère un token d'authentification
        $token = $user->createToken('auth_token')->plainTextToken;

        // retourne le token
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
