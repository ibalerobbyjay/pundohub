<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeathReport;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\DeathReportedNotification;
use App\Notifications\DuplicateDeathReportNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeathReportController extends Controller
{
    // Show the death report form
    public function create()
    {
        return view('death-reports.create');
    }

    // Handle the form submission
    public function store(Request $request)
    {
        // Enhanced validation rules
        $request->validate([
            'name_of_deceased' => [
                'required',
                'string',
                'max:255',
                // Custom validation rule to prevent duplicates
                function ($attribute, $value, $fail) {
                    $existingReport = DeathReport::where('name_of_deceased', 'like', '%' . $value . '%')
                        ->where(function($query) {
                            $query->where('is_verified', true)
                                  ->orWhere('created_at', '>', now()->subDays(30));
                        })
                        ->first();
                    
                    if ($existingReport) {
                        $fail('A death report for "' . $value . '" already exists in the system. Please contact admin if this is a different person.');
                    }
                },
            ],
            'date_of_death' => [
                'required',
                'date',
                'before_or_equal:today',
                function ($attribute, $value, $fail) use ($request) {
                    // Prevent reports with future dates
                    if (strtotime($value) > strtotime('today')) {
                        $fail('Date of death cannot be in the future.');
                    }
                    
                    // Prevent reports with dates too far in the past (optional)
                    $minDate = now()->subYears(150); // 150 years ago
                    if (strtotime($value) < strtotime($minDate)) {
                        $fail('Date of death appears to be too far in the past. Please verify the date.');
                    }
                },
            ],
            'cause_of_death' => 'required|string|max:500',
            'location_of_death' => 'required|string|max:255',
            'death_certificate' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120', // 5MB max
                function ($attribute, $value, $fail) {
                    // Check file type by content
                    $allowedMimes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    $fileMime = $value->getMimeType();
                    
                    if (!in_array($fileMime, $allowedMimes)) {
                        $fail('The death certificate must be a valid image file (JPG, JPEG, PNG, or WEBP).');
                    }
                },
            ],
            'other_cause' => 'required_if:cause_of_death,Other|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name_of_deceased.required' => 'The deceased name is required.',
            'date_of_death.required' => 'The date of death is required.',
            'date_of_death.before_or_equal' => 'Date of death cannot be in the future.',
            'cause_of_death.required' => 'The cause of death is required.',
            'location_of_death.required' => 'The location of death is required.',
            'death_certificate.required' => 'Death certificate is required.',
            'death_certificate.image' => 'The death certificate must be an image.',
            'death_certificate.mimes' => 'The death certificate must be a JPG, JPEG, PNG, or WEBP file.',
            'death_certificate.max' => 'The death certificate must not exceed 5MB.',
            'other_cause.required_if' => 'Please specify the cause of death when selecting "Other".',
        ]);

        // Additional duplicate check before storing (case-insensitive)
        $recentDuplicate = DeathReport::whereRaw('LOWER(name_of_deceased) = ?', [strtolower($request->name_of_deceased)])
            ->where('created_at', '>', now()->subDays(30))
            ->exists();

        if ($recentDuplicate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'A death report for "' . $request->name_of_deceased . '" has been submitted recently. Please wait for verification or contact support.');
        }

        try {
            // Store uploaded certificate with unique filename
            $file = $request->file('death_certificate');
            $filename = 'death_certificate_' . Str::random(20) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('death_certificates', $filename, 'public');

            // Create new report
            $report = DeathReport::create([
                'user_id' => auth()->id(),
                'name_of_deceased' => trim($request->name_of_deceased),
                'date_of_death' => $request->date_of_death,
                'cause_of_death' => $request->cause_of_death === 'Other' ? $request->other_cause : $request->cause_of_death,
                'location_of_death' => $request->location_of_death,
                'notes' => $request->notes,
                'death_certificate' => $path,
                'is_verified' => false,
                'submitted_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Notify admins about new report
            $admins = User::where('role', 'admin')->get();
            
            foreach ($admins as $admin) {
                $admin->notify(new DeathReportedNotification($report));
            }

            // Check for potential duplicates (fuzzy matching)
            $potentialDuplicates = $this->findPotentialDuplicates($report);

            if ($potentialDuplicates->count() > 0) {
                foreach ($admins as $admin) {
                    $admin->notify(new DuplicateDeathReportNotification($report, $potentialDuplicates));
                }
                
                // Log duplicate detection
                \Log::warning('Potential duplicate death report detected', [
                    'report_id' => $report->id,
                    'deceased_name' => $report->name_of_deceased,
                    'duplicate_count' => $potentialDuplicates->count(),
                    'user_id' => auth()->id(),
                ]);
            }

            return redirect()->back()->with([
                'success' => 'Death report submitted successfully and is pending verification.',
                'report_id' => $report->id,
                'has_potential_duplicates' => $potentialDuplicates->count() > 0,
            ]);

        } catch (\Exception $e) {
            \Log::error('Death report submission failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'input' => $request->except(['death_certificate']),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to submit death report. Please try again or contact support if the problem persists.');
        }
    }

    // AJAX endpoint for real-time duplicate checking
    public function checkDuplicate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $name = trim($request->name);
        
        // Exact match check
        $exactMatch = DeathReport::whereRaw('LOWER(name_of_deceased) = ?', [strtolower($name)])
            ->where(function($query) {
                $query->where('is_verified', true)
                      ->orWhere('created_at', '>', now()->subDays(30));
            })
            ->exists();

        // Similar names check (fuzzy matching)
        $similarNames = DeathReport::where('name_of_deceased', 'like', '%' . $name . '%')
            ->where('id', '!=', $request->exclude_id) // Exclude current report if editing
            ->take(5)
            ->get(['id', 'name_of_deceased', 'date_of_death', 'is_verified']);

        return response()->json([
            'exists' => $exactMatch,
            'similar_names' => $similarNames,
            'similar_count' => $similarNames->count(),
            'message' => $exactMatch ? 
                'A death report for this person already exists.' : 
                ($similarNames->count() > 0 ? 
                    'No exact match found, but similar names exist in system.' : 
                    'Name is available.'),
            'suggestions' => $similarNames->count() > 0 ? 
                'Consider verifying if this is the same person:' : ''
        ]);
    }

    // Show all death reports (for admin)
    public function index(Request $request)
    {
        $query = DeathReport::with(['user', 'verifier']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_of_deceased', 'like', '%' . $search . '%')
                  ->orWhere('cause_of_death', 'like', '%' . $search . '%')
                  ->orWhere('location_of_death', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by verification status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'verified':
                    $query->where('is_verified', true);
                    break;
                case 'pending':
                    $query->where('is_verified', false);
                    break;
            }
        }

        // Date range filter
        if ($request->has('date_from') && $request->date_from) {
            $query->where('date_of_death', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->where('date_of_death', '<=', $request->date_to);
        }

        $reports = $query->orderBy('created_at', 'desc')->get();

        return view('death-reports.index', compact('reports'));
    }

    // Show individual death report
    public function show(DeathReport $deathReport)
    {
        $similarReports = $this->findPotentialDuplicates($deathReport);
        return view('death-reports.show', compact('deathReport', 'similarReports'));
    }

    // Verify a death report (admin only)
    public function verify($id)
    {
        $report = DeathReport::findOrFail($id);
        
        $report->update([
            'is_verified' => true,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        // Log verification
        \Log::info('Death report verified', [
            'report_id' => $report->id,
            'deceased_name' => $report->name_of_deceased,
            'verified_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Death report verified successfully.');
    }

    // Unverify a death report (admin only)
    public function unverify($id)
    {
        $report = DeathReport::findOrFail($id);
        
        $report->update([
            'is_verified' => false,
            'verified_by' => null,
            'verified_at' => null,
        ]);

        \Log::info('Death report unverified', [
            'report_id' => $report->id,
            'deceased_name' => $report->name_of_deceased,
            'unverified_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Death report unverified successfully.');
    }

    // Get similar names for admin review
    public function findSimilarNames($name)
    {
        $similarReports = DeathReport::where('name_of_deceased', 'like', '%' . $name . '%')
            ->orWhereRaw('SOUNDEX(name_of_deceased) = SOUNDEX(?)', [$name]) // Soundex for phonetic matching
            ->get(['id', 'name_of_deceased', 'date_of_death', 'is_verified', 'created_at']);

        return response()->json($similarReports);
    }

    // Download death certificate
    public function downloadCertificate(DeathReport $deathReport)
    {
        if (!Storage::disk('public')->exists($deathReport->death_certificate)) {
            return redirect()->back()->with('error', 'Death certificate file not found.');
        }

        return Storage::disk('public')->download(
            $deathReport->death_certificate,
            'death_certificate_' . Str::slug($deathReport->name_of_deceased) . '.' . pathinfo($deathReport->death_certificate, PATHINFO_EXTENSION)
        );
    }

    // Delete death report (admin only)
    public function destroy($id)
    {
        $report = DeathReport::findOrFail($id);
        
        // Delete associated file
        if ($report->death_certificate && Storage::disk('public')->exists($report->death_certificate)) {
            Storage::disk('public')->delete($report->death_certificate);
        }
        
        $report->delete();

        \Log::info('Death report deleted', [
            'report_id' => $id,
            'deceased_name' => $report->name_of_deceased,
            'deleted_by' => auth()->id(),
        ]);

        return redirect()->route('admin.death-reports.index')
            ->with('success', 'Death report deleted successfully.');
    }

    /**
     * Find potential duplicates for a report
     */
    private function findPotentialDuplicates(DeathReport $report)
    {
        return DeathReport::where(function($query) use ($report) {
                // Name similarity (partial match)
                $query->where('name_of_deceased', 'like', '%' . $report->name_of_deceased . '%')
                      ->orWhere('name_of_deceased', 'like', '%' . substr($report->name_of_deceased, 0, 5) . '%');
            })
            ->where('id', '!=', $report->id) // Exclude current report
            ->where('created_at', '>', now()->subYear()) // Only check reports from last year
            ->get();
    }

    /**
     * Get death reports statistics
     */
    public function statistics()
    {
        $totalReports = DeathReport::count();
        $verifiedReports = DeathReport::where('is_verified', true)->count();
        $pendingReports = DeathReport::where('is_verified', false)->count();
        $reportsThisMonth = DeathReport::where('created_at', '>=', now()->startOfMonth())->count();

        return response()->json([
            'total' => $totalReports,
            'verified' => $verifiedReports,
            'pending' => $pendingReports,
            'this_month' => $reportsThisMonth,
        ]);
    }
}