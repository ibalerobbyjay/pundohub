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

        if ($user->role === 'admin') {
            // Admin notifications: latest 5
            $notifications = Notification::latest()->take(5)->get();

            // Total donated amount (all users)
            $totalDonations = Donation::sum('amount');

            // Total number of donation records
            $totalDonationCount = Donation::count();

            // Total bereavement cases
            $totalCases = BereavementCase::count();

            // Latest 5 bereavement cases
            $recentCases = BereavementCase::with('user')
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard', compact(
                'notifications',
                'totalDonations',
                'totalDonationCount',
                'totalCases',
                'recentCases'
            ));
        } else {
            // Regular user: their own notifications
            $notifications = $user->notifications()->latest()->take(5)->get();

            // Total donations by this user
            $userTotalDonations = Donation::where('user_id', $user->id)->sum('amount');

            // Total donations from all members (for comparison)
            $totalDonations = Donation::sum('amount');

            return view('dashboard', compact(
                'notifications',
                'userTotalDonations',
                'totalDonations'
            ));
        }
    }
}
