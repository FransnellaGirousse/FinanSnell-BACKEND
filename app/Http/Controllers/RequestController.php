<?php

namespace App\Http\Controllers;

use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\JsonResponse;

class RequestController extends Controller
{
    /**
     * Afficher toutes les requêtes.
     */
    public function index(): JsonResponse
    {
        return response()->json(Request::all(), 200);
    }

    /**
     * Stocker une nouvelle requête.
     */
    public function store(HttpRequest $request): JsonResponse
    {
        $validatedData = $request->validate([
            'social_security_number' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_need_by' => 'required|date',
            'date_requested' => 'required|date',
            'special_mailing_instruction' => 'nullable|string',
            'purpose_of_travel' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'per_diem_rate' => 'required|numeric',
            'daily_rating_coefficient' => 'required|numeric',
            'percentage_of_advance_required' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'additional_costs_motif' => 'nullable|string',
            'additional_costs' => 'nullable|numeric',
            'total_sum' => 'required|numeric',
            'amount_requested' => 'required|numeric',
            'bank' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'number_of_days' => 'required|integer',
            'total_general' => 'required|numeric',
            'final_total' => 'required|numeric',
        ]);

        $newRequest = Request::create($validatedData);

        return response()->json($newRequest, 201);
    }

    /**
     * Afficher une requête spécifique.
     */
    public function show($id): JsonResponse
    {
        $request = Request::find($id);
        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }
        return response()->json($request, 200);
    }

    /**
     * Mettre à jour une requête existante.
     */
    public function update(HttpRequest $request, $id): JsonResponse
    {
        $existingRequest = Request::find($id);
        if (!$existingRequest) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $validatedData = $request->validate([
            'social_security_number' => 'sometimes|string|max:255',
            'nationality' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'date_need_by' => 'sometimes|date',
            'date_requested' => 'sometimes|date',
            'special_mailing_instruction' => 'nullable|string',
            'purpose_of_travel' => 'sometimes|string|max:255',
            'destination' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'per_diem_rate' => 'sometimes|numeric',
            'daily_rating_coefficient' => 'sometimes|numeric',
            'percentage_of_advance_required' => 'sometimes|numeric',
            'total_amount' => 'sometimes|numeric',
            'additional_costs_motif' => 'nullable|string',
            'additional_costs' => 'nullable|numeric',
            'total_sum' => 'sometimes|numeric',
            'amount_requested' => 'sometimes|numeric',
            'bank' => 'sometimes|string|max:255',
            'branch' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255',
            'account_number' => 'sometimes|string|max:255',
            'number_of_days' => 'sometimes|integer',
            'total_general' => 'sometimes|numeric',
            'final_total' => 'sometimes|numeric',
        ]);

        $existingRequest->update($validatedData);

        return response()->json($existingRequest, 200);
    }

    /**
     * Supprimer une requête.
     */
    public function destroy($id): JsonResponse
    {
        $request = Request::find($id);
        if (!$request) {
            return response()->json(['message' => 'Request not found'], 404);
        }

        $request->delete();

        return response()->json(['message' => 'Request deleted successfully'], 200);
    }
}
