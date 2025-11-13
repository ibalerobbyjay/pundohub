@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-wallet2 text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-dark fw-bold mb-0">Monthly Fund Contributions</h2>
                <p class="text-muted mb-0">Track and manage monthly member contributions</p>
            </div>
        </div>
        @if(auth()->user()->role === 'admin' && $funds->count() > 0)
        <form action="{{ route('monthlyfunds.deleteAll') }}" method="POST" class="d-inline" 
              onsubmit="return confirmDeleteAll()">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger rounded-3 px-4">
                <i class="bi bi-arrow-clockwise me-2"></i>Reset All Records
            </button>
        </form>
        @endif
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

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div class="fw-medium">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Payment Section for Non-Admins --}}
    @if(auth()->user()->role !== 'admin')
        @php
            $hasPaidThisMonth = auth()->user()
                ->monthlyFunds()
                ->where('month_year', now()->startOfMonth())
                ->exists();
        @endphp

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="text-dark fw-bold mb-2">
                            <i class="bi bi-credit-card me-2 text-success"></i>
                            Monthly Contribution - {{ now()->format('F Y') }}
                        </h5>
                        <p class="text-muted mb-0">
                            Contribute ₱50 to support community funds and activities
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        @if($hasPaidThisMonth)
                            <div class="alert alert-success border-0 rounded-3 mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong>Paid</strong> for {{ now()->format('F Y') }}
                            </div>
                        @else
                            <button class="btn btn-success rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                <i class="bi bi-credit-card me-2"></i> Pay ₱50
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-cash-coin text-success fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">Total Collected</h5>
                    <h2 class="fw-bold text-dark mb-0">₱{{ number_format($funds->sum('amount'), 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-receipt text-info fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">Total Payments</h5>
                    <h2 class="fw-bold text-dark mb-0">{{ $funds->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-people text-warning fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">Active Members</h5>
                    <h2 class="fw-bold text-dark mb-0">{{ $funds->pluck('user_id')->unique()->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-calendar-month text-primary fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">This Month</h5>
                    <h2 class="fw-bold text-dark mb-0">
                        ₱{{ number_format($funds->where('month_year', now()->startOfMonth())->sum('amount'), 2) }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Fund Contributions Table --}}
    @if($funds->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <i class="bi bi-wallet display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Fund Contributions Yet</h4>
                <p class="text-muted mb-4">Monthly fund contributions will appear here once members start paying.</p>
                @if(auth()->user()->role !== 'admin')
                    <button class="btn btn-success rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        <i class="bi bi-credit-card me-2"></i> Make First Payment
                    </button>
                @endif
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold text-dark ps-4">Member</th>
                                <th class="border-0 fw-semibold text-dark">Amount</th>
                                <th class="border-0 fw-semibold text-dark">Month</th>
                                <th class="border-0 fw-semibold text-dark">Date Paid</th>
                                <th class="border-0 fw-semibold text-dark text-center">Proof</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($funds as $fund)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($fund->user->profile_picture)
                                                <img src="{{ asset('storage/' . $fund->user->profile_picture) }}" 
                                                     alt="{{ $fund->user->name }}" 
                                                     class="rounded-circle me-3"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">{{ $fund->user->name }}</h6>
                                                <small class="text-muted">{{ $fund->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-currency-dollar text-success"></i>
                                            </div>
                                            <span class="fw-bold text-success">₱{{ number_format($fund->amount, 2) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark">
                                            {{ \Carbon\Carbon::parse($fund->month_year)->format('F Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-dark">
                                            {{ $fund->created_at->format('M d, Y') }}
                                            <small class="text-muted d-block">{{ $fund->created_at->format('g:i A') }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($fund->proof_of_payment)
                                            <a href="{{ asset('storage/' . $fund->proof_of_payment) }}" target="_blank" 
                                               class="btn btn-sm btn-outline-info rounded-3 px-3"
                                               data-bs-toggle="tooltip" data-bs-title="View Proof of Payment">
                                                <i class="bi bi-eye me-1"></i> View
                                            </a>
                                        @else
                                            <span class="badge bg-light text-muted border py-2">
                                                <i class="bi bi-x-circle me-1"></i> No Proof
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Results Count --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $funds->count() }} contribution(s)
            </div>
            <div class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Total Records: {{ $funds->count() }}
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

<!-- Payment Modal -->
@if(auth()->user()->role !== 'admin')
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-success rounded p-2 me-3">
                        <i class="bi bi-credit-card text-white"></i>
                    </div>
                    <h5 class="modal-title text-dark fw-bold" id="paymentModalLabel">Monthly Contribution Payment</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('monthlyfunds.pay') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info border-0 rounded-3 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>
                                <strong>Monthly Contribution:</strong> ₱50.00<br>
                                <small class="text-muted">For {{ now()->format('F Y') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">
                            <i class="bi bi-camera me-2 text-primary"></i>Proof of Payment <span class="text-danger">*</span>
                        </label>
                        <input type="file" name="proof_of_payment" class="form-control border-0 rounded-3 bg-light" 
                               accept="image/*" required>
                        <div class="form-text text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Upload a clear photo of your payment receipt (JPG, PNG, max 2MB)
                        </div>
                    </div>

                    <div class="card bg-light border-0 rounded-3">
                        <div class="card-body">
                            <h6 class="fw-semibold text-dark mb-3">Payment Instructions</h6>
                            <ul class="list-unstyled text-muted small mb-0">
                                <li><i class="bi bi-check-circle text-success me-2"></i>Amount: ₱50.00</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Monthly contribution</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Due by end of month</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-3 px-4">
                        <i class="bi bi-credit-card me-2"></i> Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

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

    .btn-success {
        background: linear-gradient(135deg, #198754, #157347);
        border: none;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #157347, #13653f);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(25, 135, 84, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        transform: translateY(-2px);
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

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        border: none;
        color: #721c24;
    }

    .alert-info {
        background: linear-gradient(135deg, #cff4fc, #b6effb);
        border: none;
        color: #055160;
    }

    .badge {
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    /* Animation for cards */
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

    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
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

        // File input validation
        const fileInput = document.querySelector('input[type="file"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please select only image files (JPG or PNG)');
                        this.value = '';
                        return;
                    }

                    // Validate file size (2MB)
                    const maxSize = 2 * 1024 * 1024;
                    if (file.size > maxSize) {
                        alert('File size must be less than 2MB');
                        this.value = '';
                        return;
                    }
                }
            });
        }
    });

    function confirmDeleteAll() {
        const recordCount = {{ $funds->count() }};
        
        if (typeof Swal !== 'undefined') {
            return new Promise((resolve) => {
                Swal.fire({
                    title: 'Reset All Records?',
                    html: `
                        <div class="text-center">
                            <i class="bi bi-exclamation-triangle display-1 text-danger mb-3"></i>
                            <p class="mb-3">You are about to reset <strong>all ${recordCount} monthly fund records</strong>.</p>
                            <p class="text-danger fw-bold">This action cannot be undone!</p>
                            <p class="text-muted small">All payment history will be permanently deleted.</p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, reset all!',
                    cancelButtonText: 'Cancel',
                    background: '#fff',
                    backdrop: 'rgba(0,0,0,0.4)'
                }).then((result) => {
                    if (result.isConfirmed) {
                        resolve(true);
                    } else {
                        resolve(false);
                    }
                });
            });
        } else {
            // Fallback to native confirm
            return confirm(`⚠️ WARNING: Are you sure you want to delete ALL ${recordCount} monthly fund records?\n\nThis action will permanently remove all payment history and cannot be undone!`);
        }
    }
</script>

{{-- Optional: Include SweetAlert2 for enhanced confirmations --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@endsection