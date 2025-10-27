<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeathReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDeathReportController extends Controller
{
    // 🛡️ Manual admin role check
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    // 🕊️ Show all death reports to admin
    public function index()
    {
        $this->checkAdmin(); // manual role check

        $reports = DeathReport::latest()->get();
        return view('admin.death-reports.index', compact('reports'));
    }

    // ✅ Approve (mark as verified)
    public function approve($id)
    {
        $this->checkAdmin(); // manual role check

        $report = DeathReport::findOrFail($id);
        $report->is_verified = true;
        $report->save();

        return redirect()->back()->with('success', 'Death report verified successfully.');
    }

    // ❌ Unverify (mark as unverified)
    public function unverify($id)
    {
        $this->checkAdmin(); // manual role check

        $report = DeathReport::findOrFail($id);
        $report->is_verified = false;
        $report->save();

        return redirect()->back()->with('success', 'Death report unverified.');
    }
}
