<?php

namespace App\Http\Controllers;

use App\Models\Tdrmission;
use Illuminate\Http\Request;

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
            'status' => 'sometimes|string|in:En attente,Validé,Rejeté', // Permet de modifier le statut

        ]);

        $mission = Tdrmission::create($validatedData);

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
        ]);

      

        $mission->update($validatedData);

        return response()->json($mission, 200);
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

    

    
}

