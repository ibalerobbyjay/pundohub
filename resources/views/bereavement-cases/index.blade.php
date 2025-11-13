@extends('layouts.app')

@section('content')
<div class="container mt-4">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-file-earmark-text text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-light fw-bold mb-0">Bereavement Cases</h2>
                <p class="text-light mb-0">Manage all bereavement cases in the system</p>
            </div>
        </div>
        <a href="{{ route('bereavement-cases.create') }}" class="btn btn-info text-white fw-bold rounded-3 px-4">
            <i class="bi bi-plus-circle me-2"></i> Add New Case
        </a>
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

    {{-- Cases Table --}}
    @if($cases->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Bereavement Cases Found</h4>
                <p class="text-muted mb-4">Get started by creating your first bereavement case.</p>
                <a href="{{ route('bereavement-cases.create') }}" class="btn btn-info text-white rounded-3 px-4">
                    <i class="bi bi-plus-circle me-2"></i> Create First Case
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
                                <th class="border-0 fw-semibold text-dark ps-4">Title</th>
                                <th class="border-0 fw-semibold text-dark">Member</th>
                                <th class="border-0 fw-semibold text-dark">Date of Death</th>
                                <th class="border-0 fw-semibold text-dark">Deceased Name</th>
                                <th class="border-0 fw-semibold text-dark text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cases as $case)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                                <i class="bi bi-file-earmark-text text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">{{ $case->title }}</h6>
                                                <small class="text-muted">Case #{{ $case->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <span class="fw-medium text-dark">{{ $case->user->name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-calendar-event text-warning"></i>
                                            </div>
                                            <span class="text-dark">{{ $case->date_of_death->format('F d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger bg-opacity-10 rounded p-2 me-2">
                                                <i class="bi bi-person-x text-danger"></i>
                                            </div>
                                            <span class="text-dark">{{ $case->description_name ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('bereavement-cases.show', $case->id) }}" 
                                               class="btn btn-sm btn-outline-info rounded-3 px-3"
                                               data-bs-toggle="tooltip" data-bs-title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('bereavement-cases.edit', $case->id) }}" 
                                               class="btn btn-sm btn-outline-warning rounded-3 px-3"
                                               data-bs-toggle="tooltip" data-bs-title="Edit Case">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('bereavement-cases.destroy', $case->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger rounded-3 px-3"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-title="Delete Case"
                                                        onclick="return confirm('Are you sure you want to delete this case? This action cannot be undone.')">
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

        {{-- Results Count --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="text-muted">
                Showing {{ $cases->count() }} case(s)
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

    .btn-info {
        background: linear-gradient(135deg, #0dcaf0, #0ba8cc);
        border: none;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #0ba8cc, #098bac);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 202, 240, 0.3);
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

    .alert-success {
        background: linear-gradient(135deg, #d1e7dd, #badbcc);
        border: none;
        color: #0f5132;
    }

    /* Status badges */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-active {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-completed {
        background-color: #e2e3e5;
        color: #383d41;
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
                    const viewLink = this.querySelector('a[href*="/bereavement-cases/"]');
                    if (viewLink) {
                        window.location.href = viewLink.href;
                    }
                }
            });
        });

        // Enhanced delete confirmation (if SweetAlert2 is available)
        const deleteForms = document.querySelectorAll('form[action*="/bereavement-cases/"]');
        deleteForms.forEach(form => {
            const deleteButton = form.querySelector('button[type="submit"]');
            if (deleteButton) {
                deleteButton.addEventListener('click', function(e) {
                    if (typeof Swal !== 'undefined') {
                        e.preventDefault();
                        
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
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
                    }
                    // If SweetAlert2 is not available, the native confirm will work
                });
            }
        });
    });
</script>

{{-- Optional: Include SweetAlert2 for enhanced confirmations --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@endsection