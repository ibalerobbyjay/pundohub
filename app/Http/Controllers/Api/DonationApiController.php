<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationApiController extends Controller
{
    public function index()
    {
        $donations = Donation::with(['member', 'bereavementCase'])->get();
        return response()->json($donations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'bereavement_case_id' => 'required|exists:bereavement_cases,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|string',
        ]);

        $donation = Donation::create($validated);
        return response()->json($donation, 201);
    }

    public function show($id)
    {
        $donation = Donation::with(['member', 'bereavementCase'])->findOrFail($id);
        return response()->json($donation);
    }

    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'bereavement_case_id' => 'required|exists:bereavement_cases,id',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|string',
        ]);

        $donation->update($validated);
        return response()->json($donation);
    }

    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return response()->json(['message' => 'Donation deleted successfully']);
    }
}
