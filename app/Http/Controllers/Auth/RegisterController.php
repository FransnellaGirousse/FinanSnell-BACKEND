<?php  

namespace App\Http\Controllers\Auth;  

use App\Http\Controllers\Controller;  
use App\Models\User; 
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Validator; 
use App\Models\Company;
use App\Models\Role;

class RegisterController extends Controller  
{  
    // Méthode d'enregistrement d'un utilisateur
    public function register(Request $request)  
    {  
        // Validation des données envoyées
        $validator = Validator::make($request->all(), [  
            'firstname' => 'required|string|max:255',  
            'lastname' => 'required|string|max:255',  
            'email' => 'required|string|email|max:255|unique:users',  
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&-_]/',  
            'phone_number' => 'nullable|string|unique:users',  
            'gestion_type' => 'required|string|in:personnel,entreprise',  
            'key_company' => 'nullable|string|exists:companies,key',
        ]);  

        if ($validator->fails()) {  
            return response()->json([  
                'success' => false,  
                'errors' => $validator->errors(),  
            ], 200);  
        }  

        // 🔹 Cas où `gestion_type` est `personnel`
if ($request->gestion_type === 'personnel') {
    $user = User::create([
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone_number' => $request->phone_number,
        'role' => 'visitor', // 🔥 Assignation du rôle "visitor"
        'gestion_type' => 'personnel',
        'company_id' => null
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Utilisateur personnel créé avec succès',
        'user' => $user,
    ], 201);
}




         // 🔹 Cas où `gestion_type` est `entreprise`
        if ($request->gestion_type === 'entreprise') {
            // Vérifier si la clé `key_company` est bien fournie
            if (!$request->filled('key_company')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le champ key_company est requis pour les utilisateurs de type entreprise.'
                ], 400);
            }

            // Vérifier si l'entreprise existe via `key_company`
            $company = Company::where('key', $request->key_company)->first();
            if (!$company) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aucune entreprise trouvée avec la clé fournie.'
                ], 404);
            }

            // Vérifier si le rôle existe et correspond bien à `id_companies`
            if (!$request->filled('key_role')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le champ key_role est requis pour les utilisateurs de type entreprise.'
                ], 400);
            }



          // Vérifier si la clé d'entreprise est fournie et valide
    $company = null;
    if ($request->key_company) {
        $company = Company::where('key', $request->key_company)->first();

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => "Aucune entreprise trouvée avec la clé fournie.",
            ], 404);
        }
    }

      // 🔹 Vérifier si le rôle existe et correspond bien à l'entreprise
    $role = Role::where('key', $request->key_role)
                    ->where('id_companies', $company->id)
                    ->first();

    if (!$role) {
        return response()->json([
            'success' => false,
            'message' => "Aucun rôle trouvé pour cette entreprise.",
        ], 404);
    }


         // Vérification conditionnelle de key_company
        if ($request->gestion_type === 'entreprise') {
            if (!$request->filled('key_company')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le champ key_company est requis pour les utilisateurs de type entreprise.'
                ], 400);
            }

            $companyExists = Company::where('key', $request->key_company)->exists();
            if (!$companyExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'La clé company fournie est invalide. Aucun enregistrement trouvé dans la base de données.'
                ], 400);
            }
        }

        // Création de l'utilisateur avec le rôle
        $user = User::create([  
            'firstname' => $request->firstname, 
            'lastname' => $request->lastname,  
            'email' => $request->email,  
            'password' => Hash::make($request->password),  
            'phone_number' => $request->phone_number,  
            'role' => $role->name,
            'key_company' => $request->key_company,
            'gestion_type' => 'entreprise',
            'company_id' => $company ? $company->id : null
        ]);  

        // Retourner une réponse avec les données de l'utilisateur
        return response()->json([  
            'success' => true,  
            'message' => 'Utilisateur créé avec succès',  
            'user' => $user,  
        ], 201);  
    } 
}

    // Méthode de connexion de l'utilisateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Recherche de l'utilisateur par son email
        $user = User::where('email', $request->email)->first();

        // Vérification du mot de passe
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

        // Création du token pour l'utilisateur
        $token = $user->createToken('API Token')->plainTextToken;

        // Retourne les données de l'utilisateur, y compris le token
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Récupère les données complètes de l'utilisateur (dont le rôle)
    public function getUserData(Request $request)
    {
        $user = $request->user(); // Utilise l'utilisateur authentifié via Sanctum

        // Retourne toutes les données utilisateur, y compris le rôle
        return response()->json([
            'user' => $user,
            'role' => $user->role, // Renvoie également le rôle de l'utilisateur
        ]);
    }

    // Méthode pour récupérer uniquement le rôle de l'utilisateur
    public function getRole(Request $request)
    {
        $user = $request->user();  // Utilise l'utilisateur authentifié

        // Retourne uniquement le rôle de l'utilisateur
        return response()->json(['role' => $user->role]);
    }

    // Méthode pour récupérer l'email de l'utilisateur
    public function getEmail(Request $request)
    {
        $user = $request->user();  

        // Retourne l'email de l'utilisateur
        return response()->json(['email' => $user->email]);
    }
    public function getUsers()
    {
        return response()->json(User::all(), 200);
    }

     
}
