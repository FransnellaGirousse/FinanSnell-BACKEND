<?php  

namespace App\Http\Controllers\Auth;  

use App\Http\Controllers\Controller;  
use App\Models\User; 
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Validator;  

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
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',  
            'phone_number' => 'nullable|string|unique:users',  
            'role' => 'required|string|in:user,visitor,administrator,accountant,director',  
        ]);  

        if ($validator->fails()) {  
            return response()->json([  
                'success' => false,  
                'errors' => $validator->errors(),  
            ], 200);  
        }  

        // Création de l'utilisateur avec le rôle
        $user = User::create([  
            'firstname' => $request->firstname, 
            'lastname' => $request->lastname,  
            'email' => $request->email,  
            'password' => Hash::make($request->password),  
            'phone_number' => $request->phone_number,  
            'role' => $request->role,  
        ]);  

        // Retourner une réponse avec les données de l'utilisateur
        return response()->json([  
            'success' => true,  
            'message' => 'Utilisateur créé avec succès',  
            'user' => $user,  
        ], 201);  
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
        $user = $request->user();  // Utilise l'utilisateur authentifié

        // Retourne l'email de l'utilisateur
        return response()->json(['email' => $user->email]);
    }
}
