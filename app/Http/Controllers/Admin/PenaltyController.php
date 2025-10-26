<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penalty;

class PenaltyController extends Controller
{
    public function index()
    {
        $penalties = Penalty::with('user')
            ->orderBy('applied_at', 'desc')
            ->paginate(10);

        return view('admin.penalties', compact('penalties'));
    }
}
