<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;  
use App\Http\Controllers\RequestInAdvanceController;
use App\Http\Controllers\MissionReportController;


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

