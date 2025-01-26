<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                'role' => 'user', // Attribuez un rôle par défaut, ou ce que vous souhaitez
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
}
