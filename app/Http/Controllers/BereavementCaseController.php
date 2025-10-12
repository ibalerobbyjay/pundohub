<?php

namespace App\Http\Controllers;

use App\Models\BereavementCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewBereavementCaseNotification;
use Illuminate\Support\Facades\Notification;

class BereavementCaseController extends Controller
{
    // Display all bereavement cases
    public function index()
    {
        $cases = BereavementCase::latest()->get();
        return view('bereavement-cases.index', compact('cases'));
    }

    // Show a specific bereavement case
    public function show(Request $request, $id)
    {
        if ($request->has('notification_id')) {
            $notification = $request->user()->notifications()->find($request->notification_id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        $case = BereavementCase::findOrFail($id);
        return view('bereavement-cases.show', compact('case'));
    }

    // Show form to create a new case
    public function create()
    {
        $users = User::where('role', 'member')->get(); // Only members
        return view('bereavement-cases.create', compact('users'));
    }

    // Store new bereavement case
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'title'         => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'description'   => 'nullable|string',
        ]);

        $case = BereavementCase::create($validated);

        // Notify all members
        $members = User::where('role', 'member')->get();
        Notification::send($members, new NewBereavementCaseNotification($case));

        return redirect()->route('bereavement-cases.index')
                         ->with('success', 'Bereavement case added successfully! All members have been notified.');
    }

    // Show form to edit a case
    public function edit($id)
    {
        $case = BereavementCase::findOrFail($id);
        $users = User::where('role', 'member')->get();
        return view('bereavement-cases.edit', compact('case', 'users'));
    }

    // Update an existing case
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'title'         => 'required|string|max:255',
            'date_of_death' => 'required|date',
            'description'   => 'nullable|string',
            'remarks'       => 'nullable|string',
        ]);

        $case = BereavementCase::findOrFail($id);
        $case->update($validated);

        return redirect()->route('bereavement-cases.index')
                         ->with('success', 'Bereavement case updated successfully!');
    }

    // Delete a case
    public function destroy($id)
    {
        $case = BereavementCase::findOrFail($id);
        $case->delete();

        return redirect()->route('bereavement-cases.index')
                         ->with('success', 'Bereavement case deleted successfully!');
    }

    // Update remarks
    public function updateRemarks(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'nullable|string',
        ]);

        $case = BereavementCase::findOrFail($id);
        $case->remarks = $request->remarks;
        $case->save();

        return redirect()->back()->with('success', 'Remarks updated successfully!');
    }
}
