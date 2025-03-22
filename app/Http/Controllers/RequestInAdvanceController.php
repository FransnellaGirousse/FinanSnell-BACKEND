<?php

namespace App\Http\Controllers;

use App\Models\RequestInAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class RequestInAdvanceController extends Controller
{

    public function index()
    {
        $requests = RequestInAdvance::with('rows')->get();

        return response()->json($requests, 200);
    }


   public function store(Request $request)
{
    $validated = $request->validate([
        'tdr_id' => 'required|integer|exists:create_tdr,id', // si obligatoire
        'user_id' => 'nullable|integer|exists:users,id',
        'social_security_number' => 'required|string',
        'nationality' => 'required|string',
        'address' => 'required|string',
        'date_need_by' => 'required|date',
        'date_requested' => 'required|date',
        'purpose_of_travel' => 'required|string',
        'destination' => 'required|string',
        'additional_costs_motif' => 'nullable|string',
        'additional_costs' => 'nullable|string',
        'amount_requested' => 'required|numeric',
        'bank' => 'required|string',
        'branch' => 'required|string',
        'name' => 'required|string',
        'account_number' => 'required|string',
        'total_general' => 'required|string',
        'final_total' => 'required|string',
        'key_company' => 'nullable|string',
        'status' => 'required|in:en attente,validé,rejeté,envoyé',
        'rows' => 'required|array',
        'rows.*.location' => 'required|string',
        'rows.*.per_diem_rate' => 'required|string',
        'rows.*.percentage_of_advance_required' => 'required|string',
        'rows.*.number_of_days' => 'required|string',
        'rows.*.total_amount' => 'required|string',
    ]);

    // Utilisateur courant si user_id non fourni
    $validated['user_id'] = $validated['user_id'] ?? Auth::id();

    // Cherche l'utilisateur à notifier
    $userOffer = User::where('role', 'accountant')
        ->join('request_in_advances', 'users.key_company', '=', 'request_in_advances.key_company')
            ->select('users.id') // Sélectionnez les colonnes que vous souhaitez
            ->first();

    // Créer la demande principale
    $requestInAdvance = RequestInAdvance::create($validated);

    // Créer les lignes de la demande
    foreach ($validated['rows'] as $row) {
        $requestInAdvance->rows()->create($row);
    }

   if ($userOffer) {
    Notification::create([
        'id_user_request' => $validated['user_id'],
        'type' => 'REQUEST_IN_ADVANCE',
        'id_user_offer' => $userOffer->id,
        'date_requested' => now(),
        'id_type_request' => $requestInAdvance->id,
        'read' => false,
        'message' => "Une nouvelle demande d'avance a été ajoutée : {$requestInAdvance->purpose_of_travel}",
    ]);
} else {
    // Optionnel : tu peux logguer ou notifier que l'utilisateur destinataire est introuvable
    Log::warning("Aucun accountant trouvé pour key_company : {$validated['key_company']}");
}


    return response()->json([
        'message' => 'Votre demande a bien été envoyée !',
        'data' => $requestInAdvance->load('rows'),
    ], 201);
}

   

    public function show($id)
    {
        $requestInAdvance = RequestInAdvance::with('rows')->find($id);

        if ($requestInAdvance) {
            return response()->json($requestInAdvance, 200);
        } else {
            return response()->json(['message' => 'Request In Advance not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'social_security_number' => 'required|string',
            'nationality' => 'required|string',
            'address' => 'required|string',
            'date_need_by' => 'required|date',
            'date_requested' => 'required|date',
            'purpose_of_travel' => 'required|string',
            'destination' => 'required|string',
            'additional_costs_motif' => 'nullable|string',
            'additional_costs' => 'nullable|string',
            'amount_requested' => 'required|numeric',
            'bank' => 'required|string',
            'branch' => 'required|string',
            'name' => 'required|string',
            'account_number' => 'required|string',
            'total_general' => 'required|string',
            'final_total' => 'required|string',
            'key_company' => 'nullable|string',
            'user_id' => 'nullable|integer|exists:users,id',
            'status' => 'required|in:en attente,validé,rejeté,envoyé',
            'rows' => 'required|array', 
            'rows.*.location' => 'required|string',
            'rows.*.per_diem_rate' => 'required|string',
            'rows.*.percentage_of_advance_required' => 'required|string',
            'rows.*.number_of_days' => 'required|string',
            'rows.*.total_amount' => 'required|string',
        ]);

        $requestInAdvance = RequestInAdvance::find($id);

        if ($requestInAdvance) {
            $requestInAdvance->update($validated);

            $requestInAdvance->rows()->delete();

            foreach ($request->rows as $row) {
                $requestInAdvance->rows()->create($row);
            }

            return response()->json([
                'message' => 'Request in advance updated successfully!',
                'data' => $requestInAdvance->load('rows'),
            ], 200);
        } else {
            return response()->json(['message' => 'Request In Advance not found'], 404);
        }
    }


    public function destroy($id)
    {
        $requestInAdvance = RequestInAdvance::find($id);

        if ($requestInAdvance) {
            $requestInAdvance->delete();

            return response()->json(['message' => 'Request In Advance deleted successfully!'], 200);
        } else {
            return response()->json(['message' => 'Request In Advance not found'], 404);
        }
    }

    public function approvaladvance($id)
{
    // Recherche la demande d'avance par son ID
    $requestInAdvance = RequestInAdvance::find($id);

    // Vérifie si la demande existe
    if ($requestInAdvance) {
        // Met à jour le statut de la demande à "validé" ou selon la logique métier
        $requestInAdvance->status = 'validé';  // Ou un autre statut selon ton besoin
        $requestInAdvance->save();

        // Envoie une notification si nécessaire (tu peux personnaliser la notification)
        $userOffer = User::where('role', 'accountant')
            ->join('request_in_advances', 'users.key_company', '=', 'request_in_advances.key_company')
            ->select('users.id')
            ->first();

        if ($userOffer) {
            Notification::create([
                'id_user_request' => $requestInAdvance->user_id,
                'type' => 'APPROVAL_REQUEST_IN_ADVANCE',
                'id_user_offer' => $userOffer->id,
                'date_requested' => now(),
                'id_type_request' => $requestInAdvance->id,
                'read' => false,
                'message' => "La demande d'avance de {$requestInAdvance->purpose_of_travel} a été approuvée.",
            ]);
        } else {
            Log::warning("Aucun accountant trouvé pour key_company : {$requestInAdvance->key_company}");
        }

        // Retourne une réponse JSON avec le message de succès et la demande mise à jour
        return response()->json([
            'message' => 'La demande a été validée avec succès!',
            'data' => $requestInAdvance,
        ], 200);
    } else {
        // Si la demande d'avance n'a pas été trouvée
        return response()->json(['message' => 'Request In Advance not found'], 404);
    }


    
}


public function getRequestWithApprovalStatus($id)
{
    // Recherche la demande d'avance par son ID
    $requestInAdvance = RequestInAdvance::with('rows')->find($id);

    // Vérifie si la demande existe
    if ($requestInAdvance) {
        // Retourne la réponse JSON avec la demande d'avance et ses lignes associées
        return response()->json($requestInAdvance, 200);
    } else {
        // Si la demande n'est pas trouvée, retourne un message d'erreur
        return response()->json(['message' => 'Request In Advance not found'], 404);
    }
}

public function updateStatus(Request $request, $id)
{
    // Valider la demande de changement de statut
    $validated = $request->validate([
        'status' => 'required|in:en attente,validé,rejeté,envoyé',
    ]);

    // Recherche la demande
    $requestInAdvance = RequestInAdvance::find($id);

    if ($requestInAdvance) {
        // Mise à jour du statut
        $requestInAdvance->status = $validated['status'];
        $requestInAdvance->save();

        // Retourne la réponse après la mise à jour
        return response()->json([
            'message' => 'Statut mis à jour avec succès',
            'data' => $requestInAdvance,
        ], 200);
    } else {
        // Retourne un message d'erreur si la demande n'est pas trouvée
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }
}




}
