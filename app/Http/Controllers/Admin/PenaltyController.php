<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penalty;
use App\Models\User;
use Illuminate\Http\Request;

class PenaltyController extends Controller
{
    public function index()
    {
        $penalties = Penalty::with('user')->latest()->paginate(10);
        $users = User::where('role', 'member')->get();
        $topPenalizedUsers = User::withCount('penalties')
            ->where('role', 'member')
            ->orderBy('penalties_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.penalties', compact('penalties', 'users', 'topPenalizedUsers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string|max:500',
            'due_date' => 'nullable|date|after:today',
        ]);

        Penalty::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'due_date' => $request->due_date,
            'applied_at' => now(),
            'paid' => false,
        ]);

        return redirect()->route('admin.penalties')->with('success', 'Penalty added successfully!');
    }

    public function markPaid(Penalty $penalty)
    {
        $penalty->update([
            'paid' => true,
            'paid_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Penalty marked as paid!');
    }

    public function destroy(Penalty $penalty)
    {
        $penalty->delete();

        return redirect()->back()->with('success', 'Penalty deleted successfully!');
    }
}