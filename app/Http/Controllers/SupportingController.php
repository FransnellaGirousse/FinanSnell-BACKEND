<?php

namespace App\Http\Controllers;

use App\Models\Supporting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportingController extends Controller
{
    public function index()
    {
        return Supporting::latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'name' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $filePath = $file->storeAs('supportings', $fileName, 'public');

        $supporting = Supporting::create([
            'date' => $request->date,
            'description' => $request->description,
            'name' => $request->name,
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);

        return response()->json($supporting, 201);
    }

    public function show(Supporting $supporting)
    {
        return response()->json($supporting);
    }

    public function download(Supporting $supporting)
    {
        return Storage::disk('public')->download($supporting->file_path);
    }
}
