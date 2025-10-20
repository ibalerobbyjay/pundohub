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
            'type' => 'required|in:Firewood,Rice,Money',
            'amount' => 'required_if:type,Money|numeric|min:100',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
        ]);

        $user = Auth::user();

        $donation = Donation::create([
            'user_id' => $user->id,
            'bereavement_case_id' => $request->bereavement_case_id,
            'type' => $request->type,
            'amount' => $request->type === 'Money' ? $request->amount : null,
        ]);

        // Notify all admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new DonationReceived(
                "{$user->name} donated " .
                ($donation->type === 'Money' ? "₱{$donation->amount}" : $donation->type)
            ));
        }

        return redirect()->route('donations.create')
                         ->with('success', 'Donation recorded successfully!');
    }

    // Update existing donation
    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'type' => 'required|in:Firewood,Rice,Money',
            'amount' => 'required_if:type,Money|numeric|min:100',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
        ]);

        $donation->update([
            'type' => $request->type,
            'amount' => $request->type === 'Money' ? $request->amount : null,
            'bereavement_case_id' => $request->bereavement_case_id,
        ]);

        return redirect()->route('donations.index')
                         ->with('success', 'Donation updated successfully!');
    }

    // Delete donation
    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Donation deleted successfully!');
    }
}
