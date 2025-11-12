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
    $request->validate([
        'name_of_deceased' => 'required|string|max:255',
        'date_of_death' => 'required|date',
        'cause_of_death' => 'required|string',
        'location_of_death' => 'required|string|max:255',
        'death_certificate' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // ✅ Check for duplicate report by name
    $existingReport = \App\Models\DeathReport::where('name_of_deceased', $request->name_of_deceased)->first();

    // Store uploaded certificate
    $path = $request->file('death_certificate')->store('death_certificates', 'public');

    // Create new report
    $report = \App\Models\DeathReport::create([
        'user_id' => auth()->id(),
        'name_of_deceased' => $request->name_of_deceased,
        'date_of_death' => $request->date_of_death,
        'cause_of_death' => $request->cause_of_death === 'Other' ? $request->other_cause : $request->cause_of_death,
        'location_of_death' => $request->location_of_death,
        'notes' => $request->notes,
        'death_certificate' => $path,
    ]);

    // ✅ If duplicate found, notify the admin
    if ($existingReport) {
        $admins = \App\Models\User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\DuplicateDeathReportNotification($report));
        }
    }

    return redirect()->back()->with('success', 'Death report submitted successfully.');
}

}