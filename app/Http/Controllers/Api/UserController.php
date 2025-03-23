<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;


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
        'gestion_type' => 'sometimes|string|in:personnel,entreprise', // Validation du type de gestion
        'key_company' => 'nullable|string|exists:companies,key', // Validation pour la clé d'entreprise
    ]);

    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }

    // Définir le rôle en fonction du type de gestion
    $role = null;

    // Si le type de gestion est 'personnel', on assigne le rôle 'visitor'
    if ($request->gestion_type === 'personnel') {
        $user->company_id = null;
        $role = 'visitor'; // Le rôle 'visitor' pour les utilisateurs de type personnel
    }

    // Si le type de gestion est 'entreprise', vérifier la clé d'entreprise et assigner le rôle approprié
    if ($request->gestion_type === 'entreprise') {
        // Vérifier si la clé `key_company` est fournie
        if (!$request->filled('key_company')) {
            return response()->json([
                'message' => 'Le champ key_company est requis pour les utilisateurs de type entreprise.'
            ], 400);
        }

        // Vérifier si la clé d'entreprise est fournie et valide
        $company = Company::where('key', $request->key_company)->first();

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => "Aucune entreprise trouvée avec la clé fournie.",
            ], 404);
        }

        // Assigner le rôle en fonction de l'entreprise
        // Utilisation de la table 'role' correctement définie dans le modèle Role
        $role = Role::where('key', $request->key_role)
                    ->where('id_companies', $company->id)
                    ->first();

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => "Aucun rôle trouvé pour cette entreprise.",
            ], 404);
        }
    }

    // Mise à jour des autres informations de l'utilisateur
    $user->update([
        'firstname' => $request->firstname ?? $user->firstname,
        'lastname'  => $request->lastname ?? $user->lastname,
        'phone_number' => $request->phone_number ?? $user->phone_number,
        'role' => $role ? $role->name : $user->role, // Si un rôle a été trouvé, on l'utilise, sinon on conserve l'ancien rôle
        'gestion_type' => $request->gestion_type ?? $user->gestion_type,
        'key_company' => $request->key_company ?? $user->key_company,
    ]);

    return response()->json([
        'message' => 'Utilisateur mis à jour avec succès',
        'user'    => $user,
    ], 200);
}




        /**
     * Récupère un utilisateur par son ID.
     */
    public function getUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function checkUserRoleByCompany(Request $request)
    {
        // Validation des données de la requête
        $request->validate([
            'key_company' => 'required|string|exists:companies,key', // Validation de la clé de l'entreprise
            'role'         => 'required|string|exists:roles,name',    // Validation du rôle
        ]);

        // Récupérer l'entreprise par la clé
        $company = Company::where('key', $request->key_company)->first();

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => "Aucune entreprise trouvée avec cette clé."
            ], 404);
        }

        // Vérifier si l'utilisateur avec le rôle spécifié existe pour cette entreprise
        $userWithRole = User::whereHas('roles', function ($query) use ($request, $company) {
            $query->where('name', $request->role)
                  ->where('company_id', $company->id);
        })->first();

        if ($userWithRole) {
            return response()->json([
                'success' => true,
                'message' => "Un utilisateur avec le rôle '{$request->role}' existe pour cette entreprise.",
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => "Aucun utilisateur avec le rôle '{$request->role}' pour cette entreprise.",
        ], 404);
    }


   /**
 * Vérifie le rôle de l'utilisateur à partir de la clé d'entreprise.
 */
/**
 * Vérifie le rôle de l'utilisateur à partir de la clé d'entreprise.
 */
public function verifyUserRole(Request $request)
{
    $request->validate([
        'key_company' => 'required|string|exists:companies,key', // Validation pour la clé d'entreprise
        'role'        => 'required|string|exists:role,name',    // Validation pour le rôle
    ]);

    // Trouver l'utilisateur associé à cette entreprise
    $user = User::where('key_company', $request->key_company)
                ->where('role', $request->role)  // Vérifie si l'utilisateur a ce rôle
                ->first();

    if (!$user) {
        return response()->json(false, 404);
    }

    return response()->json(true, 200);
}

}
