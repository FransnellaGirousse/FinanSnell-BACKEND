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
        // Validation des données de la requête
        $request->validate([
            'email'     => 'required|email',
            'firstname' => 'nullable|string|max:255',
            'lastname'  => 'nullable|string|max:255',
        ]);

        // Vérifier si l'utilisateur existe déjà
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            $user = User::create([
                'email'     => $request->email,
                'firstname' => $request->firstname ?? 'Utilisateur',
                'lastname'  => $request->lastname ?? 'Inconnu',
            ]);
        }

        return response()->json([
            'user' => $user,
        ], 200);
    }

    /**
     * Récupère le rôle de l'utilisateur authentifié.
     */
    public function getRole(Request $request)
    {
        $user = $request->user(); 

        if (!$user) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        return response()->json([
            'roles' => $user->getRoleNames(),
        ], 200);
    }

    /**
     * Vérifie si l'utilisateur existe par son ID et met à jour ses informations.
     */
    public function updateUserById(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'nullable|string|max:255',
            'lastname'  => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'role' => 'sometimes|string|in:user,visitor,administrator,accountant,director',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $user->update([
            'firstname' => $request->firstname ?? $user->firstname,
            'lastname'  => $request->lastname ?? $user->lastname,
            'phone_number' => $request->phone_number ?? $user->phone_number,
            'role' => $request->role ?? $user->role,
        ]);

        return response()->json([
            'message' => 'Utilisateur mis à jour avec succès',
            'user'    => $user,
        ], 200);
    }
}
