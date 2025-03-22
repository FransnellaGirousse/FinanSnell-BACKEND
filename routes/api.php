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
use App\Http\Controllers\AssignmentOMController;
use App\Http\Controllers\MissionDetailController;
use App\Http\Controllers\SuperAdminAuthController;
use App\Http\Controllers\ExpensePersonnalController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\SupportingController;

Route::get('/get-companies', [TdrMissionController::class, 'getCompanies']);
Route::get('/get-tdr-ids-by-key-company/{keyCompany}', [TdrMissionController::class, 'getTdrIdsByKeyCompany']);
Route::get('/user/mission-list', [TdrMissionController::class, 'getMissionsForAuthenticatedUser']);


Route::prefix('supportings')->group(function () {
    Route::get('/', [SupportingController::class, 'index']);
    Route::post('/', [SupportingController::class, 'store']);
    Route::get('/{supporting}', [SupportingController::class, 'show']);
    Route::get('/{supporting}/download', [SupportingController::class, 'download']);
});


{/* Api Mission create OM */}
    Route::apiResource('missions', MissionController::class);

{/* Api Entreprise */}
    Route::apiResource('companies', CompanyController::class);


    {/* Api Notifications*/}
    Route::put('/notifications/mark-as-read/{userId}', [NotificationController::class, 'markAsRead']);
    Route::get('/notifications/unread-count/{userId}', [NotificationController::class, 'countUnreadNotifications']);
    Route::get('/notifications/user-offer/{userId}', [NotificationController::class, 'getNotificationsByUserOffer']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);
    Route::put('/notifications/{id}', [NotificationController::class, 'update']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    Route::get('/requests', [RequestController::class, 'index']); // Obtenir toutes les requêtes
    Route::post('/requests', [RequestController::class, 'store']); // Créer une nouvelle requête
    Route::get('/requests/{id}', [RequestController::class, 'show']); // Obtenir une requête spécifique
    Route::put('/requests/{id}', [RequestController::class, 'update']); // Mettre à jour une requête
    Route::delete('/requests/{id}', [RequestController::class, 'destroy']); // Supprimer une requête


// Route expense personnal
Route::middleware('api')->group(function () {
    Route::get('/expenses', [ExpensePersonnalController::class, 'index']);
    Route::post('/expenses', [ExpensePersonnalController::class, 'store']);
    Route::put('/expenses/{id}', [ExpensePersonnalController::class, 'update']);
    Route::delete('/expenses/{id}', [ExpensePersonnalController::class, 'destroy']);
});

Route::post('/superadmin/login', [SuperAdminAuthController::class, 'login']);
Route::get('/create-superadmin', [SuperAdminAuthController::class, 'createAdmin']);
Route::middleware('auth:sanctum')->post('/superadmin/logout', [SuperAdminAuthController::class, 'logout']);



// Route::post('/assignment_oms', [AssignmentOMController::class, 'store']);
// Route::get('/assignment_oms', [AssignmentOMController::class, 'index']);
// Route::get('/assignment_oms/{id}', [AssignmentOMController::class, 'show']);
// Route::put('/assignment_oms/{id}', [AssignmentOMController::class, 'update']);
// Route::delete('/assignment_oms/{id}', [AssignmentOMController::class, 'destroy']);

Route::apiResource('create_om', AssignmentOMController::class);



Route::post('/accounts', [AccountController::class, 'store']); // Créer un compte
Route::put('/users/{id}/account', [AccountController::class, 'update']); // Mettre à jour un compte via user_id
Route::get('/users/{id}/account', [AccountController::class, 'show']); // Récupérer un compte via user_id

Route::post('/test-google-callback', [\App\Http\Controllers\AuthController::class, 'handleGoogleCallbackTest']);



{/* Mission OM */}
Route::prefix('assignment-oms')->group(function () {
    Route::get('/', [AssignmentOMController::class, 'index']); // Afficher toutes les missions
    Route::get('{id}', [AssignmentOMController::class, 'show']); // Afficher une mission spécifique
    Route::post('/', [AssignmentOMController::class, 'store']); // Créer une nouvelle mission
    Route::put('{id}', [AssignmentOMController::class, 'update']); // Mettre à jour une mission
    Route::delete('{id}', [AssignmentOMController::class, 'destroy']); // Supprimer une mission
});


{/* Mission OM tableau */}
Route::prefix('mission-details')->group(function () {
    Route::get('/', [MissionDetailController::class, 'index']); // Afficher tous les détails de mission
    Route::get('{id}', [MissionDetailController::class, 'show']); // Afficher un détail de mission spécifique
    Route::post('/', [MissionDetailController::class, 'store']); // Créer un nouveau détail de mission
    Route::put('{id}', [MissionDetailController::class, 'update']); // Mettre à jour un détail de mission
    Route::delete('{id}', [MissionDetailController::class, 'destroy']); // Supprimer un détail de mission
});



// routes/api.php
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

{/** Users reccuperation */}
Route::post('/check-and-add-user', [UserController::class, 'checkAndAddUser']);
Route::put('/users/{id}', [UserController::class, 'updateUserById']);
Route::get('/users/{id}', [UserController::class, 'getUser']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

{/* Mission Tdr */}
Route::get('/approvalmission/{id}', [TdrMissionController::class, 'getMissionWithApprovalStatus']);
Route::put('/approvalmission/{id}', [TdrMissionController::class, 'approveMission']);
Route::get('/approvalmission', [TdrMissionController::class, 'approvedMissions']);
Route::get('/create-tdr', [TdrMissionController::class, 'index']);
Route::get('/create-tdr/{id}', [TdrMissionController::class, 'show']);
Route::post('/create-tdr', [TdrMissionController::class, 'store']);
Route::put('/create-tdr/{id}', [TdrMissionController::class, 'update']);
Route::delete('/create-tdr/{id}', [TdrMissionController::class, 'destroy']);
Route::put('/tdr/update-status/{id}', [TdrMissionController::class, 'updateStatus']);



{/*Mission Report */}
Route::get('/mission-report', [MissionReportController::class, 'index']); 
Route::get('/mission-report/{id}', [MissionReportController::class, 'show']); 
Route::post('/mission-report', [MissionReportController::class, 'store']);
Route::put('/mission-report/{id}', [MissionReportController::class, 'update']); 
Route::delete('/mission-report/{id}', [MissionReportController::class, 'destroy']); 


{/* Request in advance*/}
Route::put('request-in-advance/update-status/{id}', [RequestInAdvanceController::class, 'updateStatus']);
Route::put('request-in-advance/{id}/update-status', [RequestInAdvanceController::class, 'updateStatus']);
Route::put('/request-in-advance/{id}/approval', [RequestInAdvanceController::class, 'approvaladvance']);
Route::get('/approvaladvance/{id}', [RequestInAdvanceController::class, 'getRequestWithApprovalStatus']);
Route::post('/request-in-advances', [RequestInAdvanceController::class, 'store']);
Route::get('/request-in-advances', [RequestInAdvanceController::class, 'index']);       
Route::get('/request-in-advances/{id}', [RequestInAdvanceController::class, 'show']);   
Route::put('/request-in-advances/{id}', [RequestInAdvanceController::class, 'update']); 
Route::delete('/request-in-advances/{id}', [RequestInAdvanceController::class, 'destroy']);




Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);
Route::get('/users', [RegisterController::class, 'getUsers']);
Route::delete('/users/{id}', [RegisterController::class, 'getUsers']);


Route::middleware('auth:sanctum')->get('/user', [RegisterController::class, 'getUserData']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::post('register/google', [AccountController::class, 'store']);
Route::post('/register/google', [AccountController::class, 'registerGoogleUser']);  // Pour l'enregistrement via Google
Route::get('/role', [AccountController::class, 'getRole']);  // Pour obtenir le rôle de l'utilisateur

