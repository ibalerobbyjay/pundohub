<?php



namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeathReport; // Make sure you have a DeathReport model
use Illuminate\Http\Request;

class DeathReportController extends Controller
{
    // Show all death reports to admin
    public function index()
    {
        $reports = DeathReport::latest()->get();
        return view('admin.death-reports.index', compact('reports'));
    }

    // Optional: approve and convert to bereavement case
    public function approve($id)
    {
        $report = DeathReport::findOrFail($id);

        // Example: convert to BereavementCase
        \App\Models\BereavementCase::create([
            'name_of_deceased' => $report->name_of_deceased,
            'date_of_death' => $report->date_of_death,
            'notes' => $report->notes,
        ]);

        // Delete or mark report as approved
        $report->delete();

        return redirect()->back()->with('success', 'Report approved and added as a bereavement case.');
    }
}

