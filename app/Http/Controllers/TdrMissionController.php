<?php

namespace App\Http\Controllers;

use App\Models\Tdrmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;


class TdrMissionController extends Controller
{
    public function index()
    {
        $missions = Tdrmission::all();
        return response()->json($missions, 200);
    }

    public function store(Request $request)
    {
 
        $validatedData = $request->validate([
            'date_tdr' => 'required|date',
            'traveler' => 'required|string|max:255',
            'mission_title' => 'required|string|max:255',
            'introduction' => 'required|string',
            'mission_objectives' => 'required|string',
            'planned_activities' => 'required|string',
            'necessary_resources' => 'required|string',
            'conclusion' => 'required|string',
            'status' => 'sometimes|string|in:En attente,Validé,Rejeté',
            'user_id' => 'nullable|integer|exists:users,id',
            'key_company' => 'nullable|string',
        ]);
            // Ne remplacer `user_id` par Auth::id() que s'il est NULL
        $validatedData['user_id'] = $validatedData['user_id'] ?? Auth::id();
        $userOffer = User::where('role', 'administrator')
            ->join('create_tdr', 'users.key_company', '=', 'create_tdr.key_company')
            ->select('users.id') // Sélectionnez les colonnes que vous souhaitez
            ->first();

        $mission = Tdrmission::create($validatedData);

        // Création de la notification
        Notification::create([
        'id_user_request' => $validatedData['user_id'], // L'utilisateur qui crée la mission
        'type' => 'TDR',
        'id_user_offer' => $userOffer ? $userOffer->id : null,
        'date_requested'=> now(),
        'id_type_request' => $mission->id,
        'read' => false,
        'message' => "Une nouvelle mission TDR a été ajoutée : {$mission->mission_title}",
    ]);

    return response()->json($mission, 201);
    }

    public function show($id)
    {
        $mission = Tdrmission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission not found'], 404);
        }

        return response()->json($mission, 200);
    }

    public function update(Request $request, $id)
    {
        $mission = Tdrmission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission not found'], 404);
        }

        $validatedData = $request->validate([
            'date_tdr' => 'required|date',
            'traveler' => 'required|string|max:255',
            'mission_title' => 'required|string|max:255',
            'introduction' => 'sometimes|required|string',
            'mission_objectives' => 'sometimes|required|string',
            'planned_activities' => 'sometimes|required|string',
            'necessary_resources' => 'sometimes|required|string',
            'conclusion' => 'sometimes|required|string',
            'status' => 'sometimes|string|in:En attente,Validé,Rejeté', 
             'key_company' => 'nullable|string',
        ]);

      

        $mission->update($validatedData);

        return response()->json($mission, 200);
    }

    public function updateStatus(Request $request, $id)
{
    $mission = Tdrmission::find($id);

    if (!$mission) {
        return response()->json(['message' => 'Mission not found'], 404);
    }

    $validatedData = $request->validate([
        'status' => 'required|string|in:En attente,Validé,Rejeté', 
    ]);

    $mission->update(['status' => $validatedData['status']]);
    $notification = Notification::where('id_type_request', $id)
                             ->where('type', 'TDR')
                             ->first();
    Notification::create([
        'id_user_request' => $notification->id_user_offer, // L'utilisateur qui crée la mission
        'type' => 'TDR_RESPONSE',
        'id_user_offer' => $notification->id_user_request,
        'date_requested'=> now(),
        'id_type_request' => $mission->id,
        'read' => false,
        'message' => "Une nouvelle mission TDR a été ajoutée : {$mission->mission_title}",
    ]);

    return response()->json([
        'message' => 'Statut mis à jour avec succès',
        'tdr' => $mission
    ], 200);
}


    public function destroy($id)
    {
        $mission = Tdrmission::find($id);

        if (!$mission) {
            return response()->json(['message' => 'Mission not found'], 404);
        }

        $mission->delete();

        return response()->json(['message' => 'Mission deleted'], 200);
    }

    
   public function approveMission($id)
{
    $mission = Tdrmission::find($id);

    if (!$mission) {
        return response()->json(['message' => 'Mission non trouvée'], 404);
    }

    // Mettre à jour le statut en "Validé"
    $mission->status = 'Validé';
    $mission->save();

    // Ajouter une notification ou toute autre logique si nécessaire

    return response()->json([
        'message' => 'Mission approuvée avec succès',
        'mission' => $mission
    ], 200);
}

public function approvedMissions()
{
    $missions = Tdrmission::where('status', 'Validé')->get();

    return response()->json([
        'message' => 'Liste des missions approuvées',
        'missions' => $missions
    ], 200);
}

public function getMissionWithApprovalStatus($id)
{
    $mission = Tdrmission::find($id);

    if (!$mission) {
        return response()->json(['message' => 'Mission non trouvée'], 404);
    }

    return response()->json([
        'message' => 'Mission récupérée avec succès',
        'mission' => $mission
    ], 200);
}

public function getCompanies()
{
    // Récupère toutes les entreprises basées sur la relation 'key_company' dans la table 'create_tdr'
    $companies = User::whereNotNull('key_company') // Filtrer par 'key_company' non null
        ->distinct('key_company') // Pour récupérer des valeurs uniques de 'key_company'
        ->get(['key_company']);

    return response()->json($companies, 200);
}

public function getMissionsForAuthenticatedUser()
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Vérifier si l'utilisateur est connecté et s'il a un key_company
    if (!$user || !$user->key_company) {
        return response()->json(['message' => 'Utilisateur non connecté ou sans key_company'], 400);
    }

    // Récupérer le key_company de l'utilisateur
    $keyCompany = $user->key_company;

    // Récupérer les missions associées à ce key_company
    $missions = Tdrmission::where('key_company', $keyCompany)
        ->select('id', 'title')  // Sélectionner l'ID et le titre des missions
        ->get();

    // Vérifier si des missions ont été trouvées
    if ($missions->isEmpty()) {
        return response()->json(['message' => 'Aucune mission trouvée pour ce key_company'], 404);
    }

    // Retourner le key_company et les missions associées
    return response()->json([
        'keyCompany' => $keyCompany,
        'missions' => $missions
    ]);
}

// Dans TdrMissionController

public function getTdrIdsByKeyCompany($keyCompany)
{
    // Récupérer tous les IDs des missions pour un key_company donné
    $missions = Tdrmission::where('key_company', $keyCompany)
        ->get(['id', 'mission_title']);  // On récupère uniquement l'ID des missions

    // Vérifier si des missions sont trouvées pour ce key_company
    if ($missions->isEmpty()) {
        return response()->json(['message' => 'Aucune mission trouvée pour ce key_company'], 404);
    }

    return response()->json($missions, 200);  // Retourner les IDs des missions
}



}

