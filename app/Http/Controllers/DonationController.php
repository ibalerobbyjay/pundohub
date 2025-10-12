<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\BereavementCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\DonationReceived;

class DonationController extends Controller
{
    // List all donations
    public function index()
    {
        $donations = Donation::with(['user', 'bereavementCase'])->get();
        return view('donations.index', compact('donations'));
    }

    // Show form to create donation
    public function create()
    {
        $cases = BereavementCase::all();
        return view('donations.create', compact('cases'));
    }

    // Store new donation and notify admins
    public function store(Request $request)
    {
        $request->validate([
            'amount'              => 'required|numeric|min:0',
            'type'                => 'required|string|max:50',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
        ]);

        $user = Auth::user(); // currently logged-in user

        // Create donation
        $donation = Donation::create([
            'user_id'             => $user->id,
            'bereavement_case_id' => $request->bereavement_case_id,
            'amount'              => $request->amount,
            'type'                => $request->type,
        ]);

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DonationReceived(
                "{$user->name} donated {$donation->amount} ({$donation->type})"
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

    // Edit donation (optional for admins)
    public function edit(Donation $donation)
    {
        $cases = BereavementCase::all();
        return view('donations.edit', compact('donation', 'cases'));
    }

    // Update donation
    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'amount'              => 'required|numeric|min:0',
            'type'                => 'required|string|max:50',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
        ]);

        $donation->update($request->only(['amount', 'type', 'bereavement_case_id']));

        return redirect()->route('donations.index')->with('success', 'Donation updated successfully!');
    }

    // Delete donation
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Donation deleted successfully!');
    }
}
