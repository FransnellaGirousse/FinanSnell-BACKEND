<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function index()
    {
        return response()->json(Mission::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'traveler' => 'required|string',
            'purpose_of_the_mission' => 'required|string',
            'travel_data' => 'required|array',
            'travel_data.date_hour' => 'required|date',
            'travel_data.starting_point' => 'required|string',
            'travel_data.destination' => 'required|string',
            'travel_data.authorization_airfare' => 'required|string',
            'travel_data.fund_speedkey' => 'required|string',
            'travel_data.price' => 'required|string',
            'name_of_the_hotel' => 'required|string',
            'room_rate' => 'required|string',
            'confirmation_number' => 'required|integer',
            'date_hotel' => 'required|date',
            'other_details_hotel' => 'nullable|string',
            'other_logistical_requirments' => 'nullable|string',
            'tdr_id' => 'required|exists:create_tdr,id',
            'key_company' => 'nullable|string',
        ]);

        $mission = Mission::create($validated);

        return response()->json($mission, 201);
    }

    public function show($id)
    {
        $mission = Mission::findOrFail($id);
        return response()->json($mission);
    }

    public function update(Request $request, $id)
    {
        $mission = Mission::findOrFail($id);

        $validated = $request->validate([
            'date' => 'sometimes|date',
            'traveler' => 'sometimes|string',
            'purpose_of_the_mission' => 'sometimes|string',
            'travel_data' => 'sometimes|array',
            'travel_data.date_hour' => 'sometimes|date',
            'travel_data.starting_point' => 'sometimes|string',
            'travel_data.destination' => 'sometimes|string',
            'travel_data.authorization_airfare' => 'sometimes|string',
            'travel_data.fund_speedkey' => 'sometimes|string',
            'travel_data.price' => 'sometimes|string',
            'name_of_the_hotel' => 'sometimes|string',
            'room_rate' => 'sometimes|string',
            'confirmation_number' => 'sometimes|integer',
            'date_hotel' => 'sometimes|date',
            'other_details_hotel' => 'nullable|string',
            'other_logistical_requirments' => 'nullable|string',
            'tdr_id' => 'sometimes|exists:create_tdr,id',
            'key_company' => 'nullable|string',
        ]);

        $mission->update($validated);

        return response()->json($mission);
    }

    public function destroy($id)
    {
        $mission = Mission::findOrFail($id);
        $mission->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
