@extends('layouts.app')

@section('content')
<div class="container my-5">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-file-earmark-medical text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-light fw-bold mb-0">Death Reports</h2>
                <p class="text-light mb-0">Manage and verify death reports</p>
            </div>
        </div>
        <div class="text-end">
            <div class="badge bg-light text-dark border px-3 py-2">
                <i class="bi bi-list-check me-1"></i>
                Total Reports: {{ $reports->count() }}
            </div>
        </div>
    </div>

      {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="fw-medium">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Statistics --}}
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card border-0 bg-light rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-check-circle-fill text-success display-6 mb-2"></i>
                        <h4 class="fw-bold text-dark">{{ $reports->where('is_verified', true)->count() }}</h4>
                        <p class="text-muted mb-0">Verified Reports</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-clock-fill text-warning display-6 mb-2"></i>
                        <h4 class="fw-bold text-dark">{{ $reports->where('is_verified', false)->count() }}</h4>
                        <p class="text-muted mb-0">Pending Reports</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-medical-fill text-info display-6 mb-2"></i>
                        <h4 class="fw-bold text-dark">{{ $reports->count() }}</h4>
                        <p class="text-muted mb-0">Total Reports</p>
                    </div>
                </div>
            </div>
        </div>

        

  
    {{-- Reports Table --}}
    @if($reports->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Death Reports Found</h4>
                <p class="text-muted mb-4">No death reports have been submitted yet.</p>
                <div class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i>
                    Reports will appear here once submitted by members
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold text-dark ps-4">Deceased Name</th>
                                <th class="border-0 fw-semibold text-dark">Date of Death</th>
                                <th class="border-0 fw-semibold text-dark">Notes</th>
                                <th class="border-0 fw-semibold text-dark text-center">Certificate</th>
                                <th class="border-0 fw-semibold text-dark text-center">Status</th>
                                <th class="border-0 fw-semibold text-dark text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 rounded p-2 me-3">
                                                <i class="bi bi-person-x text-danger"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">{{ $report->name_of_deceased }}</h6>
                                                <small class="text-muted">Report #{{ $report->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-calendar-event text-warning"></i>
                                            </div>
                                            <span class="text-dark">{{ \Carbon\Carbon::parse($report->date_of_death)->format('M d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($report->notes)
                                            <div class="text-dark">
                                                {{ Str::limit($report->notes, 50) }}
                                                @if(strlen($report->notes) > 50)
                                                    <span class="text-muted small" data-bs-toggle="tooltip" data-bs-title="{{ $report->notes }}">
                                                        <i class="bi bi-three-dots"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">—</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($report->death_certificate)
                                            @php
                                                $fileExt = strtolower(pathinfo($report->death_certificate, PATHINFO_EXTENSION));
                                                $fileUrl = asset('storage/' . $report->death_certificate);
                                            @endphp
                                            <a href="{{ $fileUrl }}" target="_blank"
                                               class="btn btn-sm btn-outline-info rounded-3 px-3"
                                               data-bs-toggle="tooltip" 
                                               data-bs-title="View Certificate">
                                                @if (in_array($fileExt, ['jpg','jpeg','png']))
                                                    <i class="bi bi-image me-1"></i> View
                                                @elseif ($fileExt === 'pdf')
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                                                @else
                                                    <i class="bi bi-file-earmark me-1"></i> File
                                                @endif
                                            </a>
                                        @else
                                            <span class="badge bg-light text-muted border py-2">
                                                <i class="bi bi-x-circle me-1"></i> No File
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($report->is_verified)
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i> Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                <i class="bi bi-clock me-1"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @if (!$report->is_verified)
                                                <form action="{{ route('admin.death-reports.approve', $report->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-success rounded-3 px-3"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-title="Verify Report"
                                                            onclick="return confirm('Are you sure you want to verify this death report?')">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.death-reports.unverify', $report->id) }}"
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger rounded-3 px-3"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-title="Unverify Report"
                                                            onclick="return confirm('Are you sure you want to unverify this death report?')">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
    @endif

    {{-- Back to Dashboard --}}
    <div class="text-center mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">
            <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>
</div>

{{-- Enhanced Styling --}}
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
        background-color: transparent;
        border-bottom: 1px solid #e9ecef;
    }

    .table-hover tbody tr {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .table-hover tbody tr:hover {
        transform: translateY(-2px);
        background-color: #f8f9fa;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-outline-success:hover {
        background-color: #198754;
        border-color: #198754;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 202, 240, 0.3);
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1e7dd, #badbcc);
        border: none;
        color: #0f5132;
    }

    .badge {
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    /* Animation for table rows */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .table tbody tr {
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }

    .table tbody tr:nth-child(1) { animation-delay: 0.1s; }
    .table tbody tr:nth-child(2) { animation-delay: 0.2s; }
    .table tbody tr:nth-child(3) { animation-delay: 0.3s; }
    .table tbody tr:nth-child(4) { animation-delay: 0.4s; }
    .table tbody tr:nth-child(5) { animation-delay: 0.5s; }

    /* Statistics cards animation */
    .card.bg-light {
        animation: fadeInUp 0.6s ease-out;
    }

    .card.bg-light:nth-child(1) { animation-delay: 0.2s; }
    .card.bg-light:nth-child(2) { animation-delay: 0.3s; }
    .card.bg-light:nth-child(3) { animation-delay: 0.4s; }
</style>

{{-- JavaScript for enhanced interactivity --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add click functionality to table rows
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on action buttons
                if (!e.target.closest('a') && !e.target.closest('button') && !e.target.closest('form')) {
                    const viewLink = this.querySelector('a[href*="/storage/"]');
                    if (viewLink) {
                        window.open(viewLink.href, '_blank');
                    }
                }
            });
        });

        // Enhanced verification confirmations
        const verifyForms = document.querySelectorAll('form[action*="/death-reports/"]');
        verifyForms.forEach(form => {
            const verifyButton = form.querySelector('button[type="submit"]');
            if (verifyButton) {
                verifyButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const isVerify = form.action.includes('approve');
                    const actionText = isVerify ? 'verify' : 'unverify';
                    const reportName = form.closest('tr').querySelector('h6').textContent.trim();
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: `${actionText.charAt(0).toUpperCase() + actionText.slice(1)} Report?`,
                            html: `
                                <div class="text-center">
                                    <i class="bi bi-${isVerify ? 'check-circle' : 'x-circle'}-fill display-1 text-${isVerify ? 'success' : 'danger'} mb-3"></i>
                                    <p class="mb-3">You are about to <strong>${actionText}</strong> the death report for:</p>
                                    <p class="fw-bold text-dark">${reportName}</p>
                                </div>
                            `,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: isVerify ? '#198754' : '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: `Yes, ${actionText} it!`,
                            cancelButtonText: 'Cancel',
                            background: '#fff',
                            backdrop: 'rgba(0,0,0,0.4)'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    } else {
                        // Fallback to native confirm
                        if (confirm(`Are you sure you want to ${actionText} this death report?`)) {
                            form.submit();
                        }
                    }
                });
            }
        });
    });
</script>

{{-- Optional: Include SweetAlert2 for enhanced confirmations --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@endsection