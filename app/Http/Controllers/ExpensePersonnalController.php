<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpensePersonnal;

class ExpensePersonnalController extends Controller
{
    public function index()
    {
        return response()->json(ExpensePersonnal::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'date' => 'required|date',
        ]);

        $expense = ExpensePersonnal::create($request->all());
        return response()->json($expense, 201);
    }

    public function update(Request $request, $id)
    {
        $expense = ExpensePersonnal::findOrFail($id);
        $expense->update($request->all());
        return response()->json($expense, 200);
    }

    public function destroy($id)
    {
        ExpensePersonnal::destroy($id);
        return response()->json(['message' => 'Expense deleted'], 200);
    }
}
