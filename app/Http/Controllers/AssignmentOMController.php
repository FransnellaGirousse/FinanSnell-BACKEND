<?php

// app/Http/Controllers/AssignmentOMController.php

namespace App\Http\Controllers;

use App\Models\AssignmentOM;
use Illuminate\Http\Request;

class AssignmentOMController extends Controller
{
    public function index()
    {
        $assignments = AssignmentOM::all();  
        return response()->json($assignments);
    }

    public function show($id)
    {
        $assignment = AssignmentOM::findOrFail($id);  
        return response()->json($assignment);
    }

    // Créer un nouveau AssignmentOM
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'traveler' => 'required|string',
            'purpose_of_the_mission' => 'required|string',
            'date_hour' => 'required|date_format:Y-m-d H:i:s',
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
            'tdr_id' => 'required|exists:tdrs,id',
        ]);

        $assignment = AssignmentOM::create($validated);
        return response()->json(['message' => 'AssignmentOM created successfully']);
    }

    // Mettre à jour un AssignmentOM existant
    public function update(Request $request, $id)
    {
        $assignment = AssignmentOM::findOrFail($id);
        
        $validated = $request->validate([
            'date' => 'required|date',
            'traveler' => 'required|string',
            'purpose_of_the_mission' => 'required|string',
            'date_hour' => 'required|date_format:Y-m-d H:i:s',
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
            'tdr_id' => 'required|exists:tdrs,id',
        ]);

        $assignment->update($validated);
        return response()->json($assignment);
    }

    // Supprimer un AssignmentOM
    public function destroy($id)
    {
        $assignment = AssignmentOM::findOrFail($id);
        $assignment->delete();
        return response()->json(['message' => 'AssignmentOM deleted successfully']);
    }



}

