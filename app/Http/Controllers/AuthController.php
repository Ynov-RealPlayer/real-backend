<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Inscription d'un nouvel utilisateur
     *
     * @param UserStoreRequest $request
     * @return void
     */
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

    /**
     * Connexion d'un utilisateur
     *
     * @param UserStoreRequest $request
     * @return void
     */
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

    /**
     * Donne les informations de l'utilisateur connecté
     *
     * @param Request $request
     * @return void
     */
    public function me(UserStoreRequest $request)
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = $request->user();

        // Vérifier si l'utilisateur est authentifié
        if ($user) {
            // Si l'utilisateur est authentifié, retourner les informations de l'utilisateur
            return response()->json($user);
        } else {
            // Si l'utilisateur n'est pas authentifié, retourner une réponse d'erreur
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
