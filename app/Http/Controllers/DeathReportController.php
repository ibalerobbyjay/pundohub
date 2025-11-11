<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeathReport;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\DeathReportedNotification;
use Illuminate\Support\Facades\Notification;

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
        // Validate input
        $request->validate([
            'name_of_deceased' => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'cause_of_death' => 'required|string|max:255',
            'other_cause' => 'nullable|string|max:255',
            'location_of_death' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'death_certificate' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Store uploaded file
        $path = $request->file('death_certificate')->store('death_certificates', 'public');

        // Save death report
        $report = DeathReport::create([
            'user_id' => Auth::id(),
            'name_of_deceased' => $request->name_of_deceased,
            'date_of_death' => $request->date_of_death,
            'cause_of_death' => $request->cause_of_death,
            'other_cause' => $request->other_cause,
            'location_of_death' => $request->location_of_death,
            'notes' => $request->notes,
            'death_certificate' => $path,
            'is_verified' => false,
        ]);

        // Notify all admins (in-app notification)
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new DeathReportedNotification($report));

        return redirect()->back()
            ->with('success', 'Death report submitted successfully. Waiting for admin approval.');
    }
}