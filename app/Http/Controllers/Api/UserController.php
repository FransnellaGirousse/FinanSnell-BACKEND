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
        // Validation de l'email passé dans la requête
        $request->validate([
            'email' => 'required|email',
        ]);

        // Recherche de l'utilisateur par son email
        $user = User::where('email', $request->email)->first();

        // Si l'utilisateur n'existe pas, on le crée
        if (!$user) {
            $user = User::create([
                'email' => $request->email,
                'name' => 'Utilisateur ' . $request->email,
            ]);
        }

        // Vérifier si l'utilisateur a déjà un rôle
        // S'il n'a pas de rôle, on lui assigne un rôle par défaut
        if ($user->roles->isEmpty()) {
            // Vous pouvez assigner un rôle par défaut, comme 'user'
            $user->assignRole('user');
        }

        // Retourner les rôles de l'utilisateur
        $roles = $user->getRoleNames();

        return response()->json(['roles' => $roles]);
    }

    /**
     * Recherche les utilisateurs en fonction du rôle spécifié
     */
    public function getRole(Request $request)
{
    $user = $request->user();  // Utilise l'utilisateur authentifié

    // Retourner le rôle de l'utilisateur
    return response()->json(['role' => $user->role]);  // Si tu utilises Spatie Laravel-Permission, tu pourrais faire : $user->getRoleNames()
}


}
