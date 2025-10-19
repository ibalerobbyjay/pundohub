<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeathReport;
use Illuminate\Http\Request;

class DeathReportController extends Controller
{
    // 🕊️ Show all death reports to admin
    public function index()
    {
        $reports = DeathReport::latest()->get();
        return view('admin.death-reports.index', compact('reports'));
    }

    // ✅ Approve (mark as verified)
    public function approve($id)
    {
        $report = DeathReport::findOrFail($id);
        $report->is_verified = true;
        $report->save();

        return redirect()->back()->with('success', 'Death report verified successfully.');
    }

    // ❌ Unverify (mark as unverified)
    public function unverify($id)
    {
        $report = DeathReport::findOrFail($id);
        $report->is_verified = false;
        $report->save();

        return redirect()->back()->with('success', 'Death report unverified.');
    }
}
