<?php
namespace App\Http\Controllers;

use App\Models\DeathReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DeathReportedNotification;

class DeathReportController extends Controller
{
    public function create()
    {
        return view('death_reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_of_deceased' => 'required|string|max:255',
            'date_of_death' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $report = DeathReport::create([
            'user_id' => Auth::id(),
            'name_of_deceased' => $request->name_of_deceased,
            'date_of_death' => $request->date_of_death,
            'notes' => $request->notes,
        ]);

        // Notify Admin (we can use Notification system)
        $adminUsers = \App\Models\User::where('role', 'admin')->get();
        foreach ($adminUsers as $admin) {
            $admin->notify(new DeathReportedNotification($report));
        }

        return redirect()->back()->with('success', 'Death report submitted successfully.');
    }
}

