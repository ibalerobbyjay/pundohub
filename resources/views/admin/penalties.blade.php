@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-exclamation-triangle-fill text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-light fw-bold mb-0">Penalties Dashboard</h2>
                <p class="text-light mb-0">Manage member penalties and compliance</p>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-danger rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addPenaltyModal">
                <i class="bi bi-plus-circle me-1"></i> Add Penalty
            </button>
            <button class="btn btn-outline-info rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#penaltyStatsModal">
                <i class="bi bi-graph-up me-1"></i> Statistics
            </button>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">Total Penalties</h5>
                    <h2 class="fw-bold text-dark mb-0">{{ $penalties->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-clock text-warning fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">Unpaid</h5>
                    <h2 class="fw-bold text-dark mb-0">{{ $penalties->where('paid', false)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-check-circle text-success fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">Paid</h5>
                    <h2 class="fw-bold text-dark mb-0">{{ $penalties->where('paid', true)->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 bg-light shadow-sm rounded-4">
                <div class="card-body text-center py-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-currency-dollar text-info fs-4"></i>
                    </div>
                    <h5 class="text-muted mb-1">Total Amount</h5>
                    <h2 class="fw-bold text-dark mb-0">₱{{ number_format($penalties->sum('amount'), 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Penalties Table --}}
    @if($penalties->count() > 0)
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 fw-semibold text-dark ps-4">Member</th>
                                <th class="border-0 fw-semibold text-dark">Amount</th>
                                <th class="border-0 fw-semibold text-dark">Reason</th>
                                <th class="border-0 fw-semibold text-dark">Date Applied</th>
                                <th class="border-0 fw-semibold text-dark">Due Date</th>
                                <th class="border-0 fw-semibold text-dark text-center">Status</th>
                                <th class="border-0 fw-semibold text-dark text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penalties as $penalty)
                                <tr class="border-top {{ $penalty->is_overdue ? 'bg-danger bg-opacity-10' : '' }}">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($penalty->user->profile_picture ?? false)
                                                <img src="{{ asset('storage/' . $penalty->user->profile_picture) }}" 
                                                     alt="{{ $penalty->user->name }}" 
                                                     class="rounded-circle me-3"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">{{ $penalty->user->name ?? 'Unknown' }}</h6>
                                                <small class="text-muted">{{ $penalty->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-currency-dollar text-danger"></i>
                                            </div>
                                            <span class="fw-bold text-dark">₱{{ number_format($penalty->amount, 2) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-inline-block text-truncate" style="max-width: 200px;" 
                                              data-bs-toggle="tooltip" data-bs-title="{{ $penalty->reason }}">
                                            {{ $penalty->reason }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-dark">
                                            {{ \Carbon\Carbon::parse($penalty->applied_at)->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($penalty->due_date)
                                            @if($penalty->is_overdue)
                                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                                    <i class="bi bi-clock-history me-1"></i>
                                                    {{ \Carbon\Carbon::parse($penalty->due_date)->format('M d, Y') }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                    {{ \Carbon\Carbon::parse($penalty->due_date)->format('M d, Y') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-muted">No due date</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($penalty->paid)
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i> Paid
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                <i class="bi bi-clock me-1"></i> Unpaid
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @if(!$penalty->paid)
                                                <form action="{{ route('penalties.markPaid', $penalty->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-3 px-3"
                                                            data-bs-toggle="tooltip" data-bs-title="Mark as Paid">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button class="btn btn-sm btn-outline-info rounded-3 px-3 view-penalty" 
                                                    data-penalty-id="{{ $penalty->id }}"
                                                    data-bs-toggle="tooltip" data-bs-title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <form action="{{ route('penalties.destroy', $penalty->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-3"
                                                        data-bs-toggle="tooltip" data-bs-title="Delete Penalty"
                                                        onclick="return confirm('Are you sure you want to delete this penalty?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        @if($penalties->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    {{ $penalties->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <i class="bi bi-check-circle display-1 text-success mb-3"></i>
                <h4 class="text-muted mb-3">No Penalties Recorded</h4>
                <p class="text-muted mb-4">All members are in good standing!</p>
                <button class="btn btn-danger rounded-3 px-4" data-bs-toggle="modal" data-bs-target="#addPenaltyModal">
                    <i class="bi bi-plus-circle me-2"></i> Add First Penalty
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Add Penalty Modal -->
<div class="modal fade" id="addPenaltyModal" tabindex="-1" aria-labelledby="addPenaltyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-danger rounded p-2 me-3">
                        <i class="bi bi-plus-circle text-white"></i>
                    </div>
                    <h5 class="modal-title text-dark fw-bold" id="addPenaltyModalLabel">Add New Penalty</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penalties.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="user_id" class="form-label fw-semibold text-secondary">
                            <i class="bi bi-person me-2 text-primary"></i>Select Member
                        </label>
                        <select name="user_id" id="user_id" class="form-select border-0 rounded-3 bg-light" required>
                            <option value="">Choose a member...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="amount" class="form-label fw-semibold text-secondary">
                            <i class="bi bi-currency-dollar me-2 text-success"></i>Amount (₱)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 text-secondary">₱</span>
                            <input type="number" name="amount" id="amount" class="form-control border-0 rounded-3 bg-light text-dark" 
                                   step="0.01" min="1" required placeholder="Enter penalty amount">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="reason" class="form-label fw-semibold text-secondary">
                            <i class="bi bi-chat-text me-2 text-info"></i>Reason
                        </label>
                        <textarea name="reason" id="reason" class="form-control border-0 rounded-3 bg-light text-dark" 
                                  rows="3" required placeholder="Enter penalty reason"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="due_date" class="form-label fw-semibold text-secondary">
                            <i class="bi bi-calendar me-2 text-warning"></i>Due Date (Optional)
                        </label>
                        <input type="date" name="due_date" id="due_date" class="form-control border-0 rounded-3 bg-light text-dark">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-3 px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-3 px-4">Add Penalty</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Penalty Statistics Modal -->
<div class="modal fade" id="penaltyStatsModal" tabindex="-1" aria-labelledby="penaltyStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-info rounded p-2 me-3">
                        <i class="bi bi-graph-up text-white"></i>
                    </div>
                    <h5 class="modal-title text-dark fw-bold" id="penaltyStatsModalLabel">Penalty Statistics</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-success bg-opacity-10 rounded-4">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-wallet2 text-success display-6 mb-3"></i>
                                <h5 class="text-muted mb-1">Total Collection</h5>
                                <h2 class="fw-bold text-success mb-0">₱{{ number_format($penalties->where('paid', true)->sum('amount'), 2) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-warning bg-opacity-10 rounded-4">
                            <div class="card-body text-center py-4">
                                <i class="bi bi-clock text-warning display-6 mb-3"></i>
                                <h5 class="text-muted mb-1">Pending Collection</h5>
                                <h2 class="fw-bold text-warning mb-0">₱{{ number_format($penalties->where('paid', false)->sum('amount'), 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(isset($topPenalizedUsers) && $topPenalizedUsers->count() > 0)
                    <div class="card border-0 bg-light rounded-4">
                        <div class="card-body">
                            <h6 class="fw-semibold text-dark mb-3">
                                <i class="bi bi-person-badge me-2 text-primary"></i>Top Penalized Members
                            </h6>
                            <div class="list-group list-group-flush">
                                @foreach($topPenalizedUsers as $user)
                                    <div class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                        </div>
                                        <span class="badge bg-danger rounded-pill px-3 py-2">
                                            {{ $user->penalties_count }} penalties
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        transform: translateY(-2px);
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        transform: translateY(-2px);
    }

    .btn-outline-success:hover {
        background-color: #198754;
        border-color: #198754;
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
                    const viewButton = this.querySelector('.view-penalty');
                    if (viewButton) {
                        viewButton.click();
                    }
                }
            });
        });

        // Enhanced delete confirmations
        const deleteForms = document.querySelectorAll('form[action*="/penalties/"]');
        deleteForms.forEach(form => {
            const deleteButton = form.querySelector('button[type="submit"]');
            if (deleteButton && form.action.includes('destroy')) {
                deleteButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Delete Penalty?',
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
                        if (confirm('Are you sure you want to delete this penalty?')) {
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