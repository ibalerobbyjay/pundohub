<?php

namespace App\Http\Controllers;

use App\Models\BereavementCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewBereavementCaseNotification;
use App\Notifications\StaffAssignmentNotification;
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
    // Get all users who can be assigned (members + staff)
    $assignableUsers = User::whereIn('role', ['member', 'staff'])->get();

    // Only staff for staff assignment dropdown
    $staff = User::where('role', 'staff')->get();

    return view('bereavement-cases.create', compact('assignableUsers', 'staff'));
}


    // Store new bereavement case
public function store(Request $request)
{
    $validated = $request->validate([
        'user_id'           => 'required|exists:users,id', // member assigned
        'title'             => 'required|string|max:255',
        'date_of_death'     => 'required|date',
        'description'       => 'nullable|string',
        'assigned_job_type' => 'nullable|string', // staff job type
    ]);

    $case = BereavementCase::create($validated);

    // Notify the assigned member
    $member = User::find($validated['user_id']);
    if ($member) {
        $member->notify(new NewBereavementCaseNotification($case));
    }

   $assignedJobType = $validated['assigned_job_type'] ?? null;

$staff = User::where('role', 'staff')
             ->when($assignedJobType, function($q, $jobType) {
                 $q->where('job_type', $jobType);
             })
             ->get();


    foreach ($staff as $s) {
        $s->notify(new StaffAssignmentNotification($case, $s->job_type ?? 'staff'));
    }

    return redirect()->route('bereavement-cases.index')
                     ->with('success', 'Bereavement case added successfully! Notifications sent.');
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
public function edit($id)
{
    $case = BereavementCase::findOrFail($id);
    // Get all users (or filter to members only if you want)
    $users = User::all(); 

    return view('bereavement-cases.edit', compact('case', 'users'));
}

public function update(Request $request, $id)
{
    $case = BereavementCase::findOrFail($id);

    // Update fields
    $case->title = $request->input('title');
    $case->date_of_death = $request->input('date_of_death');
    $case->description = $request->input('description');
    $case->remarks = $request->input('remarks'); // if updating remarks
    $case->save();

    // Flash success message
    return redirect()->route('bereavement-cases.edit', $case->id)
                     ->with('success', 'Bereavement case edited successfully.');
}

}
