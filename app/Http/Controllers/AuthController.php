<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Account;

class AuthController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        $googleUser = $request->user; // Supposons que vous recevez un utilisateur Google avec ces informations

        // Vérifier si l'utilisateur existe en fonction de son google_id ou email
        $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

        if (!$user) {
            // Si l'utilisateur n'existe pas, créez-le avec les informations de Google
            $user = User::create([
                'firstname' => $googleUser->given_name,
                'lastname' => $googleUser->family_name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'image' => $googleUser->picture,
                'role' => 'user', 
            ]);
        }

        // Connecter l'utilisateur via Sanctum (ou Laravel Passport)
        Auth::login($user);

        // Vous pouvez aussi retourner un token JWT si vous utilisez JWT
        $token = $user->createToken('YourApp')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function handleGoogleCallbackTest(Request $request)
    {
        // Simuler les données récupérées depuis Google à partir du payload Insomnia
        $request->validate([
            'name'  => 'required|string',
            'email' => 'required|email',
        ]);

        // Créer un objet simulé pour représenter l'utilisateur Google
        $googleUser = new \stdClass();
        $googleUser->name = $request->name;   // Vous pouvez adapter si besoin pour séparer prénom et nom
        $googleUser->email = $request->email;

        // Créer ou récupérer l'utilisateur dans la table users
        $user = User::firstOrCreate(
            ['email' => $googleUser->email],
            [
                'firstname' => $googleUser->name,
                'lastname'  => 'Inconnu',
                'role'      => 'visiteur',
            ]
        );

        // Vérifier si un compte existe déjà dans la table accounts via l'email
        if (!Account::where('email', $user->email)->exists()) {
            $user->account()->create([
                'firstname'    => $user->firstname,
                'lastname'     => $user->lastname,
                'email'        => $user->email,
                'role'         => $user->role,
                'phone_number' => $user->phone_number, // peut être NULL
                'address'      => $user->address,      // peut être NULL
            ]);
        }

        return response()->json(['message' => 'Test Google callback réussi'], 200);
    }
}
