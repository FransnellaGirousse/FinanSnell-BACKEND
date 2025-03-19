<?php

namespace App\Http\Controllers;

use App\Models\RequestInAdvance;
use Illuminate\Http\Request;

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
            'rows' => 'required|array', 
            'rows.*.location' => 'required|string',
            'rows.*.per_diem_rate' => 'required|string',
            'rows.*.percentage_of_advance_required' => 'required|string',
            'rows.*.number_of_days' => 'required|string',
            'rows.*.total_amount' => 'required|string',
        ]);

        // Créer la demande principale
        $requestInAdvance = RequestInAdvance::create($validated);

        // Créer les lignes de la demande
        foreach ($request->rows as $row) {
            $requestInAdvance->rows()->create($row);
        }

        return response()->json([
            'message' => 'Votre demande a bien été envoyer !',
            'data' => $requestInAdvance->load('rows'),
        ], 201);

        return response()->json([
            'message' => 'Failed to create request in advance.',
            'errors' => $errors, // ou toute autre information sur l'erreur
        ], 400);
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



}
