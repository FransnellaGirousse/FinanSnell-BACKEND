<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    // Redirection vers Google pour l'authentification
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    

    // Callback pour gérer la réponse de Google
    public function handleGoogleCallback()
    {
        try {
                        
                $googleUser = Socialite::driver('google')->user();

                $user = User::where('google_id', $googleUser->getId())->first();

                if (!$user) {
                    $new_user = User::create([
                        'firstname' => $googleUser->user['given_name'], 
                        'lastname' => $googleUser->user['family_name'], 
                        'email' => $googleUser->getEmail(),
                        'password' => bcrypt('password'), 
                        'google_id' => $googleUser->getId(),
                        ]);

                        Auth::login($new_user);
                        return redirect()->intended('dashboard'); 
                        }
                        else {
                            Auth::login($user);
                            return redirect()->intended('dashboard'); 

                        }        

        } catch (Exception $e) {
            return redirect('auth/google')->withErrors(['message' => 'Login with Google failed. Please try again.']);
                     }
        }
    }

