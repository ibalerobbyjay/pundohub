@extends('layouts.app')

@section('content')
<div class="container my-5">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-heart-fill text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-light fw-bold mb-0">All Donations</h2>
                <p class="text-light mb-0">Manage and view all donation records</p>
            </div>
        </div>
        <a href="{{ route('donations.create') }}" class="btn btn-warning text-white fw-bold rounded-3 px-4">
            <i class="bi bi-plus-circle me-2"></i> Add Donation
        </a>
    </div>

    {{-- Delete All Button (Admin Only) --}}
    @if(auth()->user()->role === 'admin' && $donations->count() > 0)
    <div class="mb-4">
        <div class="alert alert-warning border-0 rounded-3 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>
                        <strong>Admin Action:</strong> You can delete all donations at once
                    </div>
                </div>
                <form action="{{ route('donations.deleteAll') }}" method="POST" class="d-inline" 
                      onsubmit="return confirmDeleteAll()">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger rounded-3 px-4">
                        <i class="bi bi-trash-fill me-2"></i>Delete All Donations
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- Donations Table --}}
    @if($donations->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Donations Found</h4>
                <p class="text-muted mb-4">Start by adding your first donation to support bereavement cases.</p>
                <a href="{{ route('donations.create') }}" class="btn btn-warning text-white rounded-3 px-4">
                    <i class="bi bi-plus-circle me-2"></i> Add First Donation
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold text-dark ps-4">Donor Name</th>
                                <th class="border-0 fw-semibold text-dark">Bereavement Case</th>
                                <th class="border-0 fw-semibold text-dark text-center">Amount</th>
                                <th class="border-0 fw-semibold text-dark text-center">Type</th>
                                <th class="border-0 fw-semibold text-dark text-center">Proof</th>
                                <th class="border-0 fw-semibold text-dark text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donations as $donation)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">{{ $donation->user->name ?? 'N/A' }}</h6>
                                                <small class="text-muted">Donor</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-heartbreak text-danger"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">{{ $donation->bereavementCase->title ?? 'N/A' }}</h6>
                                                <small class="text-muted">
                                                    {{ $donation->bereavementCase->user->name ?? 'Unknown Member' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($donation->type === 'Money')
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="bg-success bg-opacity-10 rounded p-2 me-2">
                                                    <i class="bi  text-success"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-success mb-0">₱{{ number_format($donation->amount, 2) }}</h6>
                                                    <small class="text-muted">Cash Donation</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <span class="badge bg-light text-muted border py-2 px-3">
                                                    <i class="bi bi-dash-circle me-1"></i>
                                                    Not Applicable
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill fw-semibold px-3 py-2 
                                            {{ $donation->type === 'Money' ? 'bg-success' : 
                                               ($donation->type === 'Rice' ? 'bg-warning text-dark' : 
                                               ($donation->type === 'Firewood' ? 'bg-orange text-white' : 'bg-info text-white')) }}">
                                            <i class="bi 
                                                {{ $donation->type === 'Money' ? 'bi-cash' : 
                                                   ($donation->type === 'Rice' ? 'bi-basket' : 
                                                   ($donation->type === 'Firewood' ? 'bi-tree' : 'bi-gift')) }} me-1">
                                            </i>
                                            {{ $donation->type }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($donation->proof)
                                            <a href="{{ asset('storage/' . $donation->proof) }}" target="_blank" 
                                               class="btn btn-sm btn-outline-info rounded-3 px-3"
                                               data-bs-toggle="tooltip" data-bs-title="View Proof">
                                                <i class="bi bi-eye me-1"></i> View
                                            </a>
                                        @else
                                            <span class="badge bg-light text-muted border py-2">
                                                <i class="bi bi-x-circle me-1"></i> No Proof
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @if(auth()->user()->role === 'admin')
                                              
                                                <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger rounded-3 px-3"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-title="Delete Donation"
                                                            onclick="return confirm('Are you sure you want to delete this donation?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-light text-muted py-2">
                                                    <i class="bi bi-lock me-1"></i> View Only
                                                </span>
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

        {{-- Results Count --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $donations->count() }} donation(s)
            </div>
            <div class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Total Records: {{ $donations->count() }}
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
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.3);
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

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        transform: translateY(-2px);
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000 !important;
        transform: translateY(-2px);
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        transform: translateY(-2px);
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        transform: translateY(-2px);
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd, #ffeaa7);
        border: none;
        color: #856404;
    }

    /* Custom colors for badges */
    .bg-orange {
        background-color: #fd7e14 !important;
    }

    /* Status badges */
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
                    const editLink = this.querySelector('a[href*="/donations/edit/"]');
                    if (editLink && {{ auth()->user()->role === 'admin' ? 'true' : 'false' }}) {
                        window.location.href = editLink.href;
                    } else {
                        const viewLink = this.querySelector('a[href*="/donations/"]');
                        if (viewLink) {
                            window.location.href = viewLink.href;
                        }
                    }
                }
            });
        });

        // Enhanced delete confirmation for individual donations
        const deleteForms = document.querySelectorAll('form[action*="/donations/"]');
        deleteForms.forEach(form => {
            const deleteButton = form.querySelector('button[type="submit"]');
            if (deleteButton && !form.action.includes('deleteAll')) {
                deleteButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Delete Donation?',
                            text: "This action cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it!',
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
                        if (confirm('Are you sure you want to delete this donation?')) {
                            form.submit();
                        }
                    }
                });
            }
        });
    });

    function confirmDeleteAll() {
        const donationCount = {{ $donations->count() }};
        
        if (typeof Swal !== 'undefined') {
            return new Promise((resolve) => {
                Swal.fire({
                    title: 'Delete All Donations?',
                    html: `
                        <div class="text-center">
                            <i class="bi bi-exclamation-triangle display-1 text-danger mb-3"></i>
                            <p class="mb-3">You are about to delete <strong>all ${donationCount} donations</strong>.</p>
                            <p class="text-danger fw-bold">This action cannot be undone!</p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete all!',
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
            return confirm(`Are you sure you want to delete ALL ${donationCount} donations? This action cannot be undone!`);
        }
    }
</script>

{{-- Optional: Include SweetAlert2 for enhanced confirmations --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@endsection