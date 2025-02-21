<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Vérifie si l'utilisateur existe et lui attribue un rôle si nécessaire.
     */
    public function checkAndAddUser(Request $request)
    {
        // Validation de l'email dans la requête
        $request->validate([
            'email' => 'required|email',
            'firstname' => 'nullable|string|max:255', // Optionnel
            'lastname' => 'nullable|string|max:255',  // Optionnel
        ]);

        // Vérifier si l'utilisateur existe déjà
        $user = User::where('email', $request->email)->first();

        // Si l'utilisateur n'existe pas, on l'insère
        if (!$user) {
            $user = User::create([
                'email' => $request->email,
                'firstname' => $request->firstname ?? 'Utilisateur', // Nom par défaut
                'lastname' => $request->lastname ?? 'Inconnu',        // Nom par défaut
            ]);
        }

        // Retourner l'utilisateur et son rôle
        return response()->json([
            'user' => $user,
        ], 200);
    }

    /**
     * Récupère le rôle de l'utilisateur authentifié
     */
    public function getRole(Request $request)
    {
        $user = $request->user();  // Récupérer l'utilisateur connecté

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        // Retourne les rôles de l'utilisateur
        return response()->json([
            'roles' => $user->getRoleNames()
        ]);
    }
}
