<?php  

namespace App\Http\Controllers\Auth;  

use App\Http\Controllers\Controller;  
use App\Models\User; 
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Validator;  

class RegisterController extends Controller  
{  
    public function register(Request $request)  
    {  
        // Data validation  
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

        // Create user with the assigned role  
        $user = User::create([  
            'firstname' => $request->firstname, 
            'lastname' => $request->lastname,  
            'email' => $request->email,  
            'password' => Hash::make($request->password),  
            'phone_number' => $request->phone_number,  
            'role' => $request->role,  
        ]);  

        return response()->json([  
            'success' => true,  
            'message' => 'Utilisateur créé avec succès',  
            'user' => $user,  
        ], 201);  
    } 
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function getRole(Request $request)
{
    $user = $request->user();  // Utilise l'utilisateur authentifié

    // Retourner le rôle de l'utilisateur
    return response()->json(['role' => $user->role]);  // Si tu utilises Spatie Laravel-Permission, tu pourrais faire : $user->getRoleNames()
}

public function getEmail(Request $request)
{
    $user = $request->user();  // Utilise l'utilisateur authentifié

    // Retourner l'email de l'utilisateur
    return response()->json(['email' => $user->email]);
}

}