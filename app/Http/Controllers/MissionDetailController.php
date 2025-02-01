<?php

// app/Http/Controllers/MissionDetailController.php

namespace App\Http\Controllers;

use App\Models\MissionDetail;
use Illuminate\Http\Request;

class MissionDetailController extends Controller
{
    // Afficher tous les MissionDetails
    public function index()
    {
        $missionDetails = MissionDetail::all();  // Récupérer tous les MissionDetails
        return response()->json($missionDetails);
    }

    // Afficher un MissionDetail spécifique
    public function show($id)
    {
        $missionDetail = MissionDetail::findOrFail($id);  // Trouver un MissionDetail par ID
        return response()->json($missionDetail);
    }

    // Créer un nouveau MissionDetail
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_om_id' => 'required|exists:assignment_oms,id',  // Assure-toi que l'AssignmentOM existe
            'date_hour' => 'required|date_format:Y-m-d H:i:s',
            'starting_point' => 'required|string',
            'destination' => 'required|string',
            'authorization_airfare' => 'required|string',
            'fund_speedkey' => 'required|string',
            'price' => 'required|string',
        ]);

        $missionDetail = MissionDetail::create($validated);
        return response()->json($missionDetail, 201);
    }

    // Mettre à jour un MissionDetail existant
    public function update(Request $request, $id)
    {
        $missionDetail = MissionDetail::findOrFail($id);
        
        $validated = $request->validate([
            'assignment_om_id' => 'required|exists:assignment_oms,id',
            'date_hour' => 'required|date_format:Y-m-d H:i:s',
            'starting_point' => 'required|string',
            'destination' => 'required|string',
            'authorization_airfare' => 'required|string',
            'fund_speedkey' => 'required|string',
            'price' => 'required|string',
        ]);

        $missionDetail->update($validated);
        return response()->json($missionDetail);
    }

    // Supprimer un MissionDetail
    public function destroy($id)
    {
        $missionDetail = MissionDetail::findOrFail($id);
        $missionDetail->delete();
        return response()->json(['message' => 'MissionDetail deleted successfully']);
    }
}
