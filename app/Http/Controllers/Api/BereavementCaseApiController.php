<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BereavementCase;
use Illuminate\Http\Request;

class BereavementCaseApiController extends Controller
{
    public function index()
    {
        $cases = BereavementCase::with('member')->latest()->get();
        return response()->json($cases);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'title' => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $case = BereavementCase::create($validated);

        return response()->json($case, 201);
    }

    public function show($id)
    {
        $case = BereavementCase::with('member')->findOrFail($id);
        return response()->json($case);
    }

    public function update(Request $request, $id)
    {
        $case = BereavementCase::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'title' => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $case->update($validated);

        return response()->json($case);
    }

    public function destroy($id)
    {
        $case = BereavementCase::findOrFail($id);
        $case->delete();

        return response()->json(['message' => 'Bereavement case deleted successfully']);
    }
}
