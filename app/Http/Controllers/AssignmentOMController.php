<?php

namespace App\Http\Controllers;

use App\Models\AssignmentOm;
use Illuminate\Http\Request;

class AssignmentOmController extends Controller
{
    // Afficher tous les enregistrements
    public function index()
    {
        $assignments = AssignmentOm::all();
        return response()->json($assignments);
    }

    // Créer un nouvel enregistrement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'traveler' => 'required|string',
            'purpose_of_the_mission' => 'required|string',
            'date_hour' => 'required|date',
            'starting_point' => 'required|string',
            'destination' => 'required|string',
            'authorization_airfare' => 'required|string',
            'fund_speedkey' => 'required|string',
            'price' => 'required|string',
            'name_of_the_hotel' => 'required|string',
            'room_rate' => 'required|string',
            'confirmation_number' => 'required|integer',
            'date_hotel' => 'required|date',
            'other_details_hotel' => 'nullable|string',
            'other_logistical_requirments' => 'nullable|string',
            'tdr_id' => 'required|exists:create_tdr,id',
        ]);

        $assignment = AssignmentOm::create($validated);
        return response()->json($assignment, 201);
    }

    // Afficher un enregistrement spécifique
    public function show($id)
    {
        $assignment = AssignmentOm::findOrFail($id);
        return response()->json($assignment);
    }

    // Mettre à jour un enregistrement
    public function update(Request $request, $id)
    {
        $assignment = AssignmentOm::findOrFail($id);

        $validated = $request->validate([
            'date' => 'sometimes|date',
            'traveler' => 'sometimes|string',
            'purpose_of_the_mission' => 'sometimes|string',
            'date_hour' => 'sometimes|date',
            'starting_point' => 'sometimes|string',
            'destination' => 'sometimes|string',
            'authorization_airfare' => 'sometimes|string',
            'fund_speedkey' => 'sometimes|string',
            'price' => 'sometimes|string',
            'name_of_the_hotel' => 'sometimes|string',
            'room_rate' => 'sometimes|string',
            'confirmation_number' => 'sometimes|integer',
            'date_hotel' => 'sometimes|date',
            'other_details_hotel' => 'nullable|string',
            'other_logistical_requirments' => 'nullable|string',
            'tdr_id' => 'sometimes|exists:create_tdr,id',
        ]);

        $assignment->update($validated);
        return response()->json($assignment);
    }

    // Supprimer un enregistrement
    public function destroy($id)
    {
        $assignment = AssignmentOm::findOrFail($id);
        $assignment->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
