<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;  
use App\Http\Controllers\RequestInAdvanceController;
use App\Http\Controllers\MissionReportController;
use App\Http\Controllers\TdrMissionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UserController;


Route::middleware('auth:sanctum')->get('/get-role', [AccountController::class, 'getRole']);
Route::middleware('auth:sanctum')->get('/get-email', [RegisterController::class, 'getEmail']);


Route::post('/accounts', [AccountController::class, 'store']);


// routes/api.php

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/get-user-info', function (Request $request) {
    // Récupère l'utilisateur connecté via la session
    $user = $request->user(); // Utilise le middleware d'authentification pour récupérer l'utilisateur authentifié

    if ($user) {
        // Si un utilisateur est connecté, retourne son email et son rôle
        return response()->json([
            'email' => $user->email,
            'role' => $user->role,  // Assure-toi que le rôle de l'utilisateur est stocké dans la colonne `role` de la table `users`
        ]);
    }

    // Si l'utilisateur n'est pas trouvé ou n'est pas connecté, retourne une erreur
    return response()->json(['error' => 'Utilisateur non trouvé'], 404);
});


Route::post('/check-and-add-user', [UserController::class, 'checkAndAddUser']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);





{/* Mission Tdr */}
Route::get('/create-tdr', [TdrMissionController::class, 'index']);
Route::get('/create-tdr/{id}', [TdrMissionController::class, 'show']);
Route::post('/create-tdr', [TdrMissionController::class, 'store']);
Route::put('/create-tdr/{id}', [TdrMissionController::class, 'update']);
Route::delete('/create-tdr/{id}', [TdrMissionController::class, 'destroy']);


{/*Mission Report */}
Route::get('/mission-report', [MissionReportController::class, 'index']); 
Route::get('/mission-report/{id}', [MissionReportController::class, 'show']); 
Route::post('/mission-report', [MissionReportController::class, 'store']);
Route::put('/mission-report/{id}', [MissionReportController::class, 'update']); 
Route::delete('/mission-report/{id}', [MissionReportController::class, 'destroy']); 


{/* Request in advance*/}
Route::post('/request-in-advances', [RequestInAdvanceController::class, 'store']);
Route::get('/request-in-advances', [RequestInAdvanceController::class, 'index']);       
Route::get('/request-in-advances/{id}', [RequestInAdvanceController::class, 'show']);   
Route::put('/request-in-advances/{id}', [RequestInAdvanceController::class, 'update']); 
Route::delete('/request-in-advances/{id}', [RequestInAdvanceController::class, 'destroy']);

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::post('register/google', [AccountController::class, 'store']);
