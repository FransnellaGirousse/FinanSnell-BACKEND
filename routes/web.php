<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\AuthController;  

Route::get('/', function () {
    return view('welcome');
});



Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);  
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);  
Route::post('/auth/logout', [AuthController::class, 'logout']);
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);



// Routes pour tous les utilisateurs
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('permission:view_dashboard');

// Routes pour éditer les posts
Route::get('/edit-posts', function () {
    return view('edit-posts');
})->middleware('permission:edit_posts');

// Routes spécifiques aux utilisateurs (user)
Route::middleware('role:user')->group(function () {
    Route::get('/mission', function () {
        return view('mission');
    })->middleware('permission:view_mission');
    
    Route::get('/mission-reports', function () {
        return view('mission_reports');
    })->middleware('permission:view_mission_reports');
    
    Route::get('/request-in-advance', function () {
        return view('request_in_advance');
    })->middleware('permission:view_request_in_advance');
    
    Route::get('/purchase-request', function () {
        return view('purchase_request');
    })->middleware('permission:view_purchase_request');
    
    Route::get('/expense', function () {
        return view('expense');
    })->middleware('permission:view_expense');
});

// Routes spécifiques pour l'admin (administrator)
Route::middleware('role:administrator')->group(function () {
    Route::get('/admin/approve-mission', function () {
        return view('approve_mission');
    })->middleware('permission:approve_mission_admin');
});

// Routes spécifiques pour l'accountant
Route::middleware('role:accountant')->group(function () {
    Route::get('/accountant/approve-mission', function () {
        return view('approve_mission');
    })->middleware('permission:approve_mission_accountant');
});

// Routes spécifiques pour le director
Route::middleware('role:director')->group(function () {
    Route::get('/director/approve-mission', function () {
        return view('approve_mission');
    })->middleware('permission:approve_mission_director');
});

// Routes pour les visiteurs (qui peuvent voir les interfaces, mais ne peuvent pas interagir)
Route::middleware('role:visitor')->group(function () {
    Route::get('/mission', function () {
        return view('mission');
    })->middleware('permission:view_mission');

    Route::get('/mission-reports', function () {
        return view('mission_reports');
    })->middleware('permission:view_mission_reports');
});