<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\Member;
use App\Models\BereavementCase;
use App\Models\User;
use App\Notifications\DonationReceived;

class DonationController extends Controller
{
    // List all donations
    public function index()
    {
        $donations = Donation::with(['member', 'bereavementCase'])->get();
        return view('donations.index', compact('donations'));
    }

    // Show form to create donation
    public function create()
    {
        $members = Member::all();
        $cases   = BereavementCase::all();
        return view('donations.create', compact('members', 'cases'));
    }

    // Store new donation and notify admins
    public function store(Request $request)
    {
        $request->validate([
            'member_id'           => 'required|exists:members,id',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
            'amount'              => 'required|numeric|min:0',
            'type'                => 'required|string|max:50',
        ]);

        // Create donation
        $donation = Donation::create([
            'member_id'           => $request->member_id,
            'bereavement_case_id' => $request->bereavement_case_id,
            'amount'              => $request->amount,
            'type'                => $request->type,
        ]);

        // Notify admins
        $donorName = $donation->member->name;
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DonationReceived(
                "{$donorName} donated {$donation->amount} ({$donation->type})"
            ));
        }

        return redirect()->route('donations.index')
                         ->with('success', 'Donation recorded successfully!');
    }

    // Show single donation
    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    // Show edit form
    public function edit(Donation $donation)
    {
        $members = Member::all();
        $cases   = BereavementCase::all();
        return view('donations.edit', compact('donation', 'members', 'cases'));
    }

    // Update donation
    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'member_id'           => 'required|exists:members,id',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
            'amount'              => 'required|numeric|min:0',
            'type'                => 'required|string|max:50',
        ]);

        $donation->update($request->all());

        return redirect()->route('donations.index')
                         ->with('success', 'Donation updated successfully!');
    }

    // Delete donation
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index')
                         ->with('success', 'Donation deleted successfully!');
    }
}
