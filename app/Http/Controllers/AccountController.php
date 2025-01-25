<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // Ou le modèle Account si vous utilisez un modèle distinct

class AccountController extends Controller
{
    // Ajoutez la méthode store pour gérer la création de comptes
    public function store(Request $request)
{
    // Valider les données reçues
    $validated = $request->validate([
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone_number' => 'nullable|string|max:15',
        'role' => 'nullable|string|max:50',
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

        return response()->json(['message' => 'Compte créé avec succès !', 'user' => $user], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la création du compte', 'details' => $e->getMessage()], 500);
    }
}

public function getRole(Request $request)
{
    $user = $request->user();  // Utilise l'utilisateur authentifié

    // Retourner le rôle de l'utilisateur
    return response()->json(['role' => $user->role]);  // Si tu utilises Spatie Laravel-Permission, tu pourrais faire : $user->getRoleNames()
}


    // Vous pouvez également ajouter d'autres méthodes comme `update()` si nécessaire
}
