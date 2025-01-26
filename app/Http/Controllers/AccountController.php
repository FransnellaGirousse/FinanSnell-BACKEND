<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // Méthode pour gérer l'enregistrement classique des utilisateurs
    public function store(Request $request)
    {
        // Valider les données reçues
        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:15',
            'role' => 'required|string|in:user,visitor,administrator,accountant,director',
            'address' => 'nullable|string|max:255',
        ]);

        // Créer un nouvel utilisateur dans la base de données
        try {
            $user = User::create([
                'firstname' => $validated['firstname'],
                'lastname' => $validated['lastname'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'role' => $validated['role'],
                'address' => $validated['address'],
                'password' => '', // Ajouter un mot de passe vide
            ]);

            return response()->json(['message' => 'Compte créé avec succès !', 'user' => $user ,  'roles' => $user->getRoleNames()], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création du compte', 'details' => $e->getMessage()], 500);
        }
    }

    // Méthode pour gérer l'enregistrement des utilisateurs via Google
    public function registerGoogleUser(Request $request)
    {
        // Vérifiez si l'utilisateur existe déjà avec son Google ID
        $user = User::where('google_id', $request->google_id)->first();

        if (!$user) {
            // Si l'utilisateur n'existe pas, enregistrez-le
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'google_id' => $request->google_id,
                'image' => $request->image,
                // Vous pouvez ajouter d'autres champs comme "role" si nécessaire
            ]);
        } else {
            // Si l'utilisateur existe déjà, vous pouvez mettre à jour ses informations si nécessaire
            $user->update([
                'name' => $request->name,
                'image' => $request->image,
            ]);
        }

        // Retourner les données de l'utilisateur, y compris son ID et son rôle
        return response()->json(['id' => $user->id, 'email' => $user->email, 'role' => $user->role]);
    }

    // Méthode pour obtenir le rôle d'un utilisateur
    public function getRole(Request $request)
    {
        $user = $request->user();  

        // Retourner le rôle de l'utilisateur
        return response()->json(['role' => $user->role]);  // Si tu utilises Spatie Laravel-Permission, tu pourrais faire : $user->getRoleNames()
    }
}
