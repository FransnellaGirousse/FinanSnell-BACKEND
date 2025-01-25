<?php  

namespace App\Http\Controllers;  

use Illuminate\Http\Request;  
use App\Models\User;  
use Illuminate\Support\Facades\Auth;  
use Laravel\Socialite\Facades\Socialite;  

class AuthController extends Controller  
{  
    // Redirection vers Google OAuth  
    public function redirectToGoogle()  
    {  
        return Socialite::driver('google')->redirect();  
    }  

    // Callback après l'authentification  
    public function handleGoogleCallback(Request $request)  
    {  
        $user = Socialite::driver('google')->user();  
        
        // Création ou récupération de l'utilisateur  
        $authUser = User::firstOrCreate([  
            'google_id' => $user->id,  
        ], [  
            'name' => $user->name,  
            'email' => $user->email,  
        ]);  

        // Authentifier l'utilisateur  
        Auth::login($authUser, true);  
        
        // Vous pourriez aussi renvoyer un token ou rediriger ailleurs  
        return response()->json($authUser);  
    }  

    // Méthode de déconnexion  
    public function logout()  
    {  
        Auth::logout();  
        return response()->json(['message' => 'Déconnecté avec succès']);  
    }  

    // Autres méthodes d'authentification peuvent aussi être ajoutées ici  
}