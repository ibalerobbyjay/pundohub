<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Donation;
use App\Models\BereavementCase;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Latest 5 notifications for all users
        $notifications = Notification::latest()->take(5)->get();

        if ($user->role === 'admin') {
            $totalDonations = Donation::count();
            $totalCases = BereavementCase::count();

            // Fetch the latest 5 bereavement cases with their user (member)
            $recentCases = BereavementCase::with('user')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact('notifications', 'totalDonations', 'totalCases', 'recentCases'));
        }

        return view('dashboard', compact('notifications'));
    }
}
