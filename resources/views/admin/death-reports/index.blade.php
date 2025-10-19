@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card p-4 shadow-lg rounded-4">
        <h2 class="mb-4 text-gray-800">Death Reports</h2>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Date of Death</th>
                        <th>Notes</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->name_of_deceased }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->date_of_death)->format('M d, Y') }}</td>
                            <td>{{ $report->notes ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.death-reports.approve', $report->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle me-1"></i> Approve
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No death reports yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
