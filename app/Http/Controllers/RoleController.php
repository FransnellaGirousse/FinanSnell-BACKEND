<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\User;


class RoleController extends Controller
{
    /**
     * Liste tous les rôles.
     */
    public function index()
    {
        return response()->json(Role::with('company')->get());
    }

    /**
     * Crée un rôle.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'id_companies' => 'nullable|exists:companies,id',
            'key' => 'required|string|unique:role,key|max:255',
        ]);

          // Vérification : est-ce que id_companies existe bien dans la table companies ?
    if ($request->id_companies && !Company::find($request->id_companies)) {
        return response()->json([
            'success' => false,
            'message' => "L'entreprise avec l'ID {$request->id_companies} n'existe pas.",
        ], 404);
    }

         // Création du rôle
    $role = Role::create([
        'name' => $request->name, // Le rôle envoyé dans "name"
        'id_companies' => $request->id_companies,
        'key' => $request->key
    ]);

     // Création de l'utilisateur avec le rôle attribué
    $user = User::create([
        'role' => $role->name, 
        'id_companies' => $request->id_companies 
    ]);


        return response()->json([
            'success' => true,
            'message' => 'Rôle créé avec succès',
            'data' => [
            'user_id' => $user->id,
            'role_name' => $user->role,
            'id_company' => $role->id_companies,
            'name' => $role->name 
        ]
        ], 201);
    }

    /**
     * Affiche un rôle spécifique.
     */
    public function show(Role $role)
    {
        return response()->json($role->load('company'));
    }

    /**
     * Met à jour un rôle.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'id_companies' => 'nullable|exists:companies,id',
            'key' => 'sometimes|string|unique:role,key,' . $role->id . '|max:255',
        ]);

        $role->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'data' => $role
        ]);
    }

    /**
     * Supprime un rôle.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rôle supprimé avec succès'
        ], 204);
    }
}
