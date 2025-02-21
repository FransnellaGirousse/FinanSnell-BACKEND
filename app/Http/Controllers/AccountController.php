<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Afficher tous les comptes
     */
    public function index()
    {
        return response()->json(Account::all());
    }

    /**
     * Créer un nouveau compte
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email',
            'role' => 'required|string|in:user,visitor,administrator,accountant,director',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $account = Account::create($validated);

        return response()->json([
            'message' => 'Compte créé avec succès !',
            'account' => $account
        ], 201);
    }

    /**
     * Afficher un compte spécifique
     */
    public function show($userId)
    {

        
    $account = Account::where('user_id', $userId)->first();

        if (!$account) {
            return response()->json(['error' => 'Compte non trouvé'], 404);
        }

        return response()->json($account);
    }

    /**
     * Mettre à jour un compte
     */
    public function update(Request $request, $userId)
    {
        $account = Account::where('user_id', $userId)->first();
        if (!$account) {
        return response()->json(['error' => 'Compte non trouvé'], 404);

        if (!$account) {
            return response()->json(['error' => 'Compte non trouvé'], 404);
        }

        $validated = $request->validate([
            'firstname' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:accounts,email,' . $id,
            'role' => 'sometimes|string|in:user,visitor,administrator,accountant,director',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $account->update($validated);

        return response()->json([
            'message' => 'Compte mis à jour avec succès !',
            'account' => $account
        ], 200);
    }
    }

    /**
     * Supprimer un compte
     */
    public function destroy($id)
    {
        $account = Account::find($id);

        if (!$account) {
            return response()->json(['error' => 'Compte non trouvé'], 404);
        }

        $account->delete();

        return response()->json(['message' => 'Compte supprimé avec succès !'], 200);
    }
}
