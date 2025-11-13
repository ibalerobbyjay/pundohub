@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- Header Section --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                 style="width: 50px; height: 50px;">
                <i class="bi bi-people-fill text-white fs-5"></i>
            </div>
            <div>
                <h2 class="text-light fw-bold mb-0">Users & Members</h2>
                <p class="text-light mb-0">Manage system users and member accounts</p>
            </div>
        </div>
        <a href="{{ route('members.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-person-plus-fill me-2"></i> Add User
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

    {{-- Users Table --}}
    @if($members->isEmpty())
        <div class="card border-0 shadow-sm rounded-4 bg-light">
            <div class="card-body text-center py-5">
                <i class="bi bi-people display-1 text-muted mb-3"></i>
                <h4 class="text-muted mb-3">No Users Found</h4>
                <p class="text-muted mb-4">Start by adding your first user to the system.</p>
                <a href="{{ route('members.create') }}" class="btn btn-primary rounded-3 px-4">
                    <i class="bi bi-person-plus-fill me-2"></i> Add First User
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
                                <th class="border-0 fw-semibold text-dark ps-4">Name</th>
                                <th class="border-0 fw-semibold text-dark">Role</th>
                                <th class="border-0 fw-semibold text-dark">Job Type</th>
                                <th class="border-0 fw-semibold text-dark">Household</th>
                                <th class="border-0 fw-semibold text-dark">Contact</th>
                                <th class="border-0 fw-semibold text-dark">Email</th>
                                <th class="border-0 fw-semibold text-dark text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr class="border-top">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($member->profile_picture)
                                                <img src="{{ asset('storage/' . $member->profile_picture) }}" 
                                                     alt="{{ $member->name }}" 
                                                     class="rounded-circle me-3"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-person text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-semibold text-dark mb-0">{{ $member->name }}</h6>
                                                <small class="text-muted">ID: #{{ $member->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill fw-semibold px-3 py-2 
                                            {{ $member->role === 'admin' ? 'bg-danger' : 'bg-info' }}">
                                            <i class="bi 
                                                {{ $member->role === 'admin' ? 'bi-shield-check' : 'bi-person-check' }} 
                                                me-1">
                                            </i>
                                            {{ ucfirst($member->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($member->role === 'member' && $member->job_type)
                                            @php
                                                $jobTypeColors = [
                                                    'cook' => 'bg-orange text-white',
                                                    'dishwasher' => 'bg-indigo text-white',
                                                    'cleaner' => 'bg-teal text-white',
                                                    'setup_crew' => 'bg-purple text-white',
                                                    'logistics' => 'bg-cyan text-dark',
                                                    'coordinator' => 'bg-pink text-white',
                                                    'finance' => 'bg-success text-white',
                                                    'none' => 'bg-light text-muted border'
                                                ];
                                                $jobTypeClass = $jobTypeColors[$member->job_type] ?? 'bg-secondary text-white';
                                            @endphp
                                            <span class="badge rounded-pill px-3 py-2 {{ $jobTypeClass }}">
                                                <i class="bi 
                                                    {{ $member->job_type === 'cook' ? 'bi-egg-fried' : 
                                                       ($member->job_type === 'dishwasher' ? 'bi-droplet' : 
                                                       ($member->job_type === 'cleaner' ? 'bi-broom' : 
                                                       ($member->job_type === 'setup_crew' ? 'bi-wrench' : 
                                                       ($member->job_type === 'logistics' ? 'bi-truck' : 
                                                       ($member->job_type === 'coordinator' ? 'bi-diagram-3' : 
                                                       ($member->job_type === 'finance' ? 'bi-cash-coin' : 'bi-dash-circle')))))) }} 
                                                    me-1">
                                                </i>
                                                {{ $member->job_type === 'none' ? 'No Job' : ucfirst(str_replace('_', ' ', $member->job_type)) }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border py-2">
                                                <i class="bi bi-dash-circle me-1"></i> Not Applicable
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($member->household)
                                            <div class="d-flex align-items-center">
                                                <div class="bg-warning bg-opacity-10 rounded p-2 me-2">
                                                    <i class="bi bi-house text-warning"></i>
                                                </div>
                                                <span class="text-dark">{{ $member->household }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($member->contact)
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 rounded p-2 me-2">
                                                    <i class="bi bi-telephone text-success"></i>
                                                </div>
                                                <span class="text-dark">{{ $member->contact }}</span>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-dark">
                                            {{ $member->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('members.edit', $member->id) }}" 
                                               class="btn btn-sm btn-outline-warning rounded-3 px-3"
                                               data-bs-toggle="tooltip" data-bs-title="Edit User">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="{{ route('members.show', $member->id) }}" 
                                               class="btn btn-sm btn-outline-info rounded-3 px-3"
                                               data-bs-toggle="tooltip" data-bs-title="View Profile">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('members.destroy', $member->id) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger rounded-3 px-3"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-title="Delete User"
                                                        onclick="return confirm('Are you sure you want to delete this user?')">
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
                Showing {{ $members->count() }} user(s)
            </div>
            <div class="text-muted">
                <i class="bi bi-info-circle me-1"></i>
                Total Users: {{ $members->count() }}
            </div>
        </div>
    @endif
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

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0b5ed7, #0a58ca);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000 !important;
        transform: translateY(-2px);
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        transform: translateY(-2px);
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
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

    .badge {
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    /* Custom colors for job types */
    .bg-orange { background-color: #fd7e14 !important; }
    .bg-indigo { background-color: #6610f2 !important; }
    .bg-teal { background-color: #20c997 !important; }
    .bg-purple { background-color: #6f42c1 !important; }
    .bg-cyan { background-color: #0dcaf0 !important; }
    .bg-pink { background-color: #d63384 !important; }

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
                    const viewLink = this.querySelector('a[href*="/members/"]');
                    if (viewLink) {
                        window.location.href = viewLink.href;
                    }
                }
            });
        });

        // Enhanced delete confirmations
        const deleteForms = document.querySelectorAll('form[action*="/members/"]');
        deleteForms.forEach(form => {
            const deleteButton = form.querySelector('button[type="submit"]');
            if (deleteButton) {
                deleteButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const userName = form.closest('tr').querySelector('h6').textContent.trim();
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Delete User?',
                            html: `
                                <div class="text-center">
                                    <i class="bi bi-exclamation-triangle display-1 text-danger mb-3"></i>
                                    <p class="mb-3">You are about to delete the user:</p>
                                    <p class="fw-bold text-dark">${userName}</p>
                                    <p class="text-danger">This action cannot be undone!</p>
                                </div>
                            `,
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
                        if (confirm(`Are you sure you want to delete ${userName}? This action cannot be undone!`)) {
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