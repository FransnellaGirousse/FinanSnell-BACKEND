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

   public function store(Request $request)
{
        $validated = $request->validate([
            'date' => 'required|date',
            'traveler' => 'required|string',
            'purpose_of_the_mission' => 'required|string',
            'name_of_the_hotel' => 'required|string',
            'room_rate' => 'required|string',
            'confirmation_number' => 'required|integer',
            'date_hotel' => 'required|date',
            'other_details_hotel' => 'nullable|string',
            'other_logistical_requirments' => 'nullable|string',
            'rows' => 'required|array',
            'rows.*.date_hour' => 'required|date_format:Y-m-d H:i:s',
            'rows.*.starting_point' => 'required|string',
            'rows.*.destination' => 'required|string',
            'rows.*.authorization_airfare' => 'required|string',
            'rows.*.fund_speedkey' => 'required|string',
            'rows.*.price' => 'required|string',
        ]);

        $assignment = AssignmentOM::create($validated);
         // Créer les lignes de la demande
        foreach ($request->rows as $row) {
            $assignment->rows()->create($row);
        }

        return response()->json(['message' => 'AssignmentOM créé avec succès' ,
        'data' => $assignment->load('rows'),],
         201);
    
}



    public function update(Request $request, $id)
    {
        $assignment = AssignmentOM::findOrFail($id);
        
        $validated = $request->validate([
            'date' => 'required|date',
            'traveler' => 'required|string',
            'purpose_of_the_mission' => 'required|string',
            'name_of_the_hotel' => 'required|string',
            'room_rate' => 'required|string',
            'confirmation_number' => 'required|integer',
            'date_hotel' => 'required|date',
            'other_details_hotel' => 'nullable|string',
            'other_logistical_requirments' => 'nullable|string',
            'rows' => 'required|array',
            'rows.*.date_hour' => 'required|date_format:Y-m-d H:i:s',
            'rows.*.starting_point' => 'required|string',
            'rows.*.destination' => 'required|string',
            'rows.*.authorization_airfare' => 'required|string',
            'rows.*.fund_speedkey' => 'required|string',
            'rows.*.price' => 'required|string',
        ]);

        $assignment->update($validated);
        return response()->json($assignment);
    }

    public function destroy($id)
    {
        $assignment = AssignmentOM::findOrFail($id);
        $assignment->delete();
        return response()->json(['message' => 'AssignmentOM deleted successfully']);
    }
}

