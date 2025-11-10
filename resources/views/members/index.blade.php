@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-info">
            <i class="bi bi-people-fill me-2 text-warning"></i>Users
        </h2>
        <a href="{{ route('members.create') }}" class="btn btn-success shadow-sm rounded-pill px-4">
            <i class="bi bi-person-plus-fill me-1"></i> Add User
        </a>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Users card --}}
    <div class="card shadow-lg rounded-4 border-0"
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table table-hover table-dark align-middle mb-0 text-center text-light">
                    <thead style="background-color: #1a1a1a; color: #f8f9fa;" class="text-uppercase small">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Job Type</th>
                            <th>Household</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            <tr>
                                <td class="fw-semibold">{{ $member->name }}</td>
                                <td class="text-capitalize">{{ $member->role }}</td>
                                <td class="text-capitalize">{{ $member->role === 'staff' ? $member->job_type ?? '—' : '—' }}</td>
                                <td>{{ $member->household ?? '—' }}</td>
                                <td>{{ $member->contact ?? '—' }}</td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    <a href="{{ route('members.edit', $member->id) }}" 
                                       class="btn btn-warning btn-sm me-1 rounded-pill shadow-sm px-3">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('members.destroy', $member->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-pill shadow-sm px-3"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="bi bi-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-people fs-3 d-block mb-2"></i>
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

<style>
.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}
</style>
