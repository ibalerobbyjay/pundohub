<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyFund;
use Illuminate\Support\Facades\Auth;

class MonthlyFundController extends Controller
{
    public function index()
    {
        $funds = MonthlyFund::with('user')->latest()->get();
        return view('monthly_funds.index', compact('funds'));
    }

   public function pay(Request $request)
{
    $user = Auth::user();
    $currentMonth = now()->startOfMonth();

    // ✅ Validation (image required)
    $request->validate([
        'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // ✅ Check if already paid this month
    $alreadyPaid = $user->monthlyFunds()
        ->where('month_year', $currentMonth)
        ->exists();

    if ($alreadyPaid) {
        return back()->with('error', 'You have already paid for this month.');
    }

    // ✅ Store proof of payment image
    $path = $request->file('proof_of_payment')->store('proofs', 'public');

    // ✅ Save record
    $fund = MonthlyFund::create([
        'user_id' => $user->id,
        'amount' => 50,
        'month_year' => $currentMonth,
        'proof_of_payment' => $path,
    ]);

    // ✅ Notify Admins
    $admins = \App\Models\User::where('role', 'admin')->get();
    foreach ($admins as $admin) {
        $admin->notify(new \App\Notifications\MonthlyFundPaidNotification($user, $fund));
    }

    return back()->with('success', 'Payment proof uploaded successfully. Awaiting admin verification.');
}

}

