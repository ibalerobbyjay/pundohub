<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\BereavementCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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

    // ✅ Store new donation with proof upload and admin notification
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Firewood,Rice,Money',
            'amount' => 'required_if:type,Money|numeric|min:100',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
            'proof' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // ✅ proof validation
        ]);

        $user = Auth::user();

        // ✅ Upload proof to storage/app/public/proofs
        $proofPath = $request->file('proof')->store('proofs', 'public');

        // ✅ Create donation record
        $donation = Donation::create([
            'user_id' => $user->id,
            'bereavement_case_id' => $request->bereavement_case_id,
            'type' => $request->type,
            'amount' => $request->type === 'Money' ? $request->amount : null,
            'proof' => $proofPath,
        ]);

        // ✅ Notify all admins
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

    // ✅ Update donation (with optional proof reupload)
    public function update(Request $request, Donation $donation)
    {
        $request->validate([
            'type' => 'required|in:Firewood,Rice,Money',
            'amount' => 'required_if:type,Money|numeric|min:100',
            'bereavement_case_id' => 'nullable|exists:bereavement_cases,id',
            'proof' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = [
            'type' => $request->type,
            'amount' => $request->type === 'Money' ? $request->amount : null,
            'bereavement_case_id' => $request->bereavement_case_id,
        ];

        // ✅ If new proof uploaded, replace old one
        if ($request->hasFile('proof')) {
            if ($donation->proof && Storage::disk('public')->exists($donation->proof)) {
                Storage::disk('public')->delete($donation->proof);
            }
            $data['proof'] = $request->file('proof')->store('proofs', 'public');
        }

        $donation->update($data);

        return redirect()->route('donations.index')
                         ->with('success', 'Donation updated successfully!');
    }

    // ✅ Delete donation (and remove proof image)
    public function destroy(Donation $donation)
    {
        if ($donation->proof && Storage::disk('public')->exists($donation->proof)) {
            Storage::disk('public')->delete($donation->proof);
        }

        $donation->delete();

        return redirect()->route('donations.index')->with('success', 'Donation deleted successfully!');
    }
    public function history()
{
    $user = auth()->user();

    // Get all donations made by the logged-in user
    $donations = \App\Models\Donation::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $total = $donations->sum('amount');

    return view('donations.history', compact('donations', 'total'));
}

}
