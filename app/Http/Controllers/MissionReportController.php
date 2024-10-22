<?php

namespace App\Http\Controllers;

use App\Models\MissionReport;
use Illuminate\Http\Request;

class MissionReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'object' => 'required|string',
            'mission_objectives' => 'required|string',
            'mission_location' => 'required|string',
            'next_steps' => 'nullable|string',
            'point_to_improve' => 'nullable|string',
            'strong_points' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'progress_of_activities' => 'nullable|string',
            'name_of_missionary' => 'required|string',
        ]);

        $missionReport = MissionReport::create($validated);

        return response()->json([
            'message' => 'Mission Report created successfully!',
            'data' => $missionReport,
        ], 201);
    }

    public function index()
    {
        $reports = MissionReport::all();
        return response()->json($reports);
    }

    public function show($id)
    {
        $report = MissionReport::findOrFail($id);
        return response()->json($report);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'object' => 'required|string',
            'mission_objectives' => 'required|string',
            'mission_location' => 'required|string',
            'next_steps' => 'nullable|string',
            'point_to_improve' => 'nullable|string',
            'strong_points' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'progress_of_activities' => 'nullable|string',
            'name_of_missionary' => 'required|string',
        ]);

        $report = MissionReport::findOrFail($id);
        $report->update($validated);

        return response()->json([
            'message' => 'Mission Report updated successfully!',
            'data' => $report,
        ]);
    }

    public function destroy($id)
    {
        $report = MissionReport::findOrFail($id);
        $report->delete();

        return response()->json(['message' => 'Mission Report deleted successfully!']);
    }
}
