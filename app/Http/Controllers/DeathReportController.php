<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeathReport;
use Illuminate\Support\Facades\Auth;

class DeathReportController extends Controller
{
    // Show the death report form
    public function create()
    {
        return view('death-reports.create');
    }

    // Handle the form submission
    public function store(Request $request)
    {
        $request->validate([
            'name_of_deceased' => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'notes' => 'nullable|string',
            'death_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Store file
        $path = $request->file('death_certificate')->store('death_certificates', 'public');

        // Save to database
        DeathReport::create([
            'user_id' => Auth::id(), // ✅ Add this line
            'name_of_deceased' => $request->name_of_deceased,
            'date_of_death' => $request->date_of_death,
            'notes' => $request->notes,
            'death_certificate' => $path,
            'is_verified' => false,
        ]);

        return redirect()->back()->with('success', 'Death report submitted successfully. Awaiting admin verification.');
    }
}
