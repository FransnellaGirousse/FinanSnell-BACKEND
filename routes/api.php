<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;  
use App\Http\Controllers\RequestInAdvanceController;

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

