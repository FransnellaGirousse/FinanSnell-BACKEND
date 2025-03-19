<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    /**
     * Affiche la liste des entreprises.
     */
    public function index()
    {
        return response()->json(Company::all());
    }

    /**
     * Stocke une nouvelle entreprise et crée 5 rôles par défaut.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies,name|max:255',
            'key' => 'required|unique:companies,key|max:255',
            'description' => 'nullable|string',
        ]);

        // Création de l'entreprise
        $company = Company::create($request->all());

        // Liste des rôles à insérer
        $roles = ["user", "administrator", "director", "accountant", "admin"];

        // Tableau pour stocker les clés des rôles créés
        $roleKeys = [];

        // Insertion des rôles avec des clés uniques
        foreach ($roles as $roleName) {
            $key = $this->generateUniqueKey();
            Role::create([
                'name' => $roleName,
                'id_companies' => $company->id, // Associe à l'entreprise créée
                'key' => $key,
            ]);

            // Ajouter la clé dans le tableau
            $roleKeys[$roleName] = $key;
        }

        return response()->json([
            'success' => true,
            'message' => 'Entreprise et rôles créés avec succès !',
            'data' => [
                'id' => $company->id,
                'name' => $company->name,
                'key' => $company->key,
                'role_keys' => $roleKeys
            ]
        ], 201);
    }

    /**
     * Génère une clé aléatoire unique pour un rôle.
     */
    private function generateUniqueKey()
    {
        do {
            $key = Str::random(16); // Génère une clé aléatoire de 10 caractères
        } while (Role::where('key', $key)->exists()); // Vérifie l'unicité

        return $key;
    }

    /**
     * Affiche une entreprise spécifique.
     */
    public function show(Company $company)
    {
        return response()->json($company);
    }

    /**
     * Met à jour une entreprise existante.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'sometimes|unique:companies,name,' . $company->id . '|max:255',
            'key' => 'sometimes|unique:companies,key,' . $company->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        $company->update($request->all());

        return response()->json($company);
    }

    /**
     * Supprime une entreprise.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json(null, 204);
    }
}
