<?php

namespace App\Http\Controllers;

use App\Models\BereavementCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\NewBereavementCaseNotification;
use App\Notifications\JobAssignmentNotification;
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
        // Get all members (no more staff role)
        $assignableUsers = User::where('role', 'member')->get();

        return view('bereavement-cases.create', compact('assignableUsers'));
    }

    // Store new bereavement case
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'title'             => 'required|string|max:255',
            'date_of_death'     => 'required|date',
            'description'       => 'required|string',
        ]);

        $case = BereavementCase::create($validated);

        // Notify ALL members about the new case, but with DIFFERENT notifications
        $allMembers = User::where('role', 'member')->get();
        
        foreach ($allMembers as $member) {
            if ($member->job_type === 'none' || is_null($member->job_type)) {
                // Members with no specific job get GENERAL notification
                $member->notify(new NewBereavementCaseNotification($case));
            } else {
                // Members with specific jobs get JOB ASSIGNMENT notification
                // Use their existing job_type for the assignment
                $member->notify(new JobAssignmentNotification($case, $member->job_type));
            }
        }

        return redirect()->route('bereavement-cases.index')
                         ->with('success', 'Bereavement case added successfully! All members notified.');
    } // ← Added missing closing brace here

    // Simple method to assign job to one specific member
    public function assignJob(Request $request, $id)
    {
        $case = BereavementCase::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_type' => 'required|in:cook,dishwasher,cleaner,setup_crew,logistics,coordinator,finance'
        ]);

        $user = User::findOrFail($request->user_id);

        if ($user->role === 'member' && $user->job_type !== 'none') {
            $user->notify(new JobAssignmentNotification($case, $request->job_type));
            return redirect()->back()->with('success', "Job assigned to {$user->name}!");
        }

        return redirect()->back()->with('error', 'Can only assign jobs to members with specific job roles.');
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
        // Get all members
        $users = User::where('role', 'member')->get(); 

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

    // New method to assign specific jobs to members
    public function assignJobs(Request $request, $id)
    {
        $case = BereavementCase::findOrFail($id);
        
        $request->validate([
            'assignments' => 'required|array',
            'assignments.*.user_id' => 'required|exists:users,id',
            'assignments.*.job_type' => 'required|in:cook,dishwasher,cleaner,setup_crew,logistics,coordinator,finance'
        ]);

        foreach ($request->assignments as $assignment) {
            $user = User::find($assignment['user_id']);
            
            if ($user && $user->role === 'member' && $user->job_type !== 'none') {
                // Send job assignment notification to specialized members
                $user->notify(new JobAssignmentNotification($case, $assignment['job_type']));
            }
        }

        return redirect()->route('bereavement-cases.show', $case->id)
                         ->with('success', 'Jobs assigned successfully!');
    }
}