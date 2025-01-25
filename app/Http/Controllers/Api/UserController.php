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
    public function getUsersByRole(Request $request)
    {
        // Validation du rôle passé dans la requête
        $request->validate([
            'role' => 'required|string',
        ]);

        // Recherche des utilisateurs ayant le rôle spécifié
        $users = User::role($request->role)->get();
        // Retourner les utilisateurs avec ce rôle
        return response()->json(['users' => $users]);
    }
}
