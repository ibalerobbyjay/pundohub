<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BereavementCase;
use App\Models\Donation;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $data = [
            'user' => $user,
            'notifications' => $user->notifications()->latest()->take(10)->get(),
            'recentCases' => BereavementCase::with('member')->latest()->take(5)->get(),
            'totalDonations' => Donation::sum('amount'),
            'totalCases' => BereavementCase::count(),
        ];

        return response()->json($data);
    }

    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'All notifications marked as read']);
    }
}
