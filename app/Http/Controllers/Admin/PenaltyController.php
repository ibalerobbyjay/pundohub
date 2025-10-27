<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penalty;
use Illuminate\Support\Facades\Auth;

class PenaltyController extends Controller
{
    // Ensure user is logged in and is admin
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->checkAdmin(); // manual role check

        $penalties = Penalty::with('user')
            ->orderBy('applied_at', 'desc')
            ->paginate(10);

        return view('admin.penalties', compact('penalties'));
    }

    public function markPaid(Penalty $penalty)
    {
        $this->checkAdmin(); // manual role check

        $penalty->paid = true;
        $penalty->save();

        return redirect()->back()->with('success', 'Penalty marked as paid.');
    }
}
