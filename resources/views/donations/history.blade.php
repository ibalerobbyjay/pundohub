@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-clock-history text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-dark fw-bold mb-0">Your Donation History</h2>
                <p class="text-muted mb-0">Track your contributions and support</p>
            </div>
        </div>
        <a href="{{ route('donations.create') }}" class="btn btn-warning text-white fw-bold rounded-3 px-4">
            <i class="bi bi-plus-circle me-2"></i> New Donation
        </a>
    </div>

    {{-- Total Donations Card --}}
    <div class="card border-0 shadow-lg rounded-4 mb-4 bg-gradient-warning text-white">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3">
                            <i class="bi bi-wallet2 text-white"></i>
                        </div>
                        <div>
                            <h5 class="text-white mb-1">Total Donations</h5>
                            <p class="text-white-50 mb-0">Your lifetime contributions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <h2 class="fw-bold mb-0">₱ {{ number_format($total, 2) }}</h2>
                    <small class="text-white-50">Total Amount</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Donations Table --}}
    @if($donations->count() > 0)
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold text-dark ps-4">Date & Time</th>
                                <th class="border-0 fw-semibold text-dark">Bereavement Case</th>
                                <th class="border-0 fw-semibold text-dark text-end pe-4">Amount (₱)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $donation)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                                <i class="bi bi-calendar-check text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">
                                                    {{ $donation->created_at->format('M j, Y') }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $donation->created_at->format('g:i A') }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-heartbreak text-danger"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">
                                                    {{ $donation->bereavementCase->title ?? 'N/A' }}
                                                </h6>
                                                <small class="text-muted">
                                                    {{ $donation->bereavementCase->user->name ?? 'Unknown Member' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="bg-success bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-currency-dollar text-success"></i>
                                            </div>
                                            <div class="text-end">
                                                <h6 class="fw-bold text-success mb-0">
                                                    ₱ {{ number_format($donation->amount, 2) }}
                                                </h6>
                                                <small class="text-muted">Donation</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Summary Statistics --}}
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card border-0 bg-light rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-receipt text-primary display-6 mb-2"></i>
                        <h4 class="fw-bold text-dark">{{ $donations->count() }}</h4>
                        <p class="text-muted mb-0">Total Donations</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar-month text-info display-6 mb-2"></i>
                        <h4 class="fw-bold text-dark">
                            {{ $donations->groupBy(function($item) { return $item->created_at->format('Y-m'); })->count() }}
                        </h4>
                        <p class="text-muted mb-0">Active Months</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 bg-light rounded-4">
                    <div class="card-body text-center">
                        <i class="bi bi-people text-success display-6 mb-2"></i>
                        <h4 class="fw-bold text-dark">
                            {{ $donations->pluck('bereavement_case_id')->unique()->count() }}
                        </h4>
                        <p class="text-muted mb-0">Cases Supported</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <i class="bi bi-gift display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Donations Yet</h4>
                <p class="text-muted mb-4">Start making a difference by contributing to bereavement cases.</p>
                <a href="{{ route('donations.create') }}" class="btn btn-warning text-white rounded-3 px-4">
                    <i class="bi bi-plus-circle me-2"></i> Make Your First Donation
                </a>
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

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border: none;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: white !important;
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
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

    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107, #ffb300, #ffa000) !important;
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

    /* Amount emphasis */
    .text-success {
        font-weight: 700;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .card-body {
            padding: 1rem;
        }
    }
</style>

{{-- JavaScript for enhanced interactivity --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add click functionality to table rows
        const tableRows = document.querySelectorAll('.table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't trigger if clicking on links or buttons
                if (!e.target.closest('a') && !e.target.closest('button')) {
                    // You could add functionality here to view donation details
                    // For example, show a modal with donation details
                    console.log('View donation details for row:', this);
                }
            });
        });

        // Animate the total donations card on load
        const totalCard = document.querySelector('.bg-gradient-warning');
        if (totalCard) {
            totalCard.style.opacity = '0';
            totalCard.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                totalCard.style.transition = 'all 0.6s ease-out';
                totalCard.style.opacity = '1';
                totalCard.style.transform = 'translateY(0)';
            }, 200);
        }

        // Add counting animation to total amount
        const totalAmount = {{ $total }};
        const totalElement = document.querySelector('.bg-gradient-warning h2');
        
        if (totalElement && totalAmount > 0) {
            let current = 0;
            const increment = totalAmount / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= totalAmount) {
                    current = totalAmount;
                    clearInterval(timer);
                }
                totalElement.textContent = `₱ ${current.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            }, 30);
        }
    });
</script>
@endsection