@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card border-0 shadow-lg rounded-4 text-light"
         style="background: rgba(20, 20, 20, 0.9); backdrop-filter: blur(10px);">
        <div class="card-body p-5">
            <h2 class="mb-4 text-info text-center">
                <i class="bi bi-file-earmark-medical me-2"></i> Death Reports
            </h2>

            {{-- ✅ Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive mt-4">
                <table class="table table-dark table-hover align-middle rounded-3 overflow-hidden text-center text-light">
                    <thead>
                        <tr class="bg-info text-dark text-uppercase small">
                            <th>Name</th>
                            <th>Date of Death</th>
                            <th>Notes</th>
                            <th>Certificate</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->name_of_deceased }}</td>
                                <td>{{ \Carbon\Carbon::parse($report->date_of_death)->format('M d, Y') }}</td>
                                <td>{{ $report->notes ?? '—' }}</td>
                                <td>
                                    @if ($report->death_certificate)
                                        @php
                                            $fileExt = strtolower(pathinfo($report->death_certificate, PATHINFO_EXTENSION));
                                            $fileUrl = asset('storage/' . $report->death_certificate);
                                        @endphp
                                        <a href="{{ $fileUrl }}" target="_blank"
                                           class="btn btn-sm btn-outline-info fw-semibold">
                                            @if (in_array($fileExt, ['jpg','jpeg','png'])) View Image
                                            @elseif ($fileExt === 'pdf') <i class="bi bi-file-earmark-pdf me-1"></i> View PDF
                                            @else View File
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-light fst-italic">No File</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($report->is_verified)
                                        <span class="badge bg-success px-3 py-2">Verified</span>
                                    @else
                                        <span class="badge bg-secondary px-3 py-2">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!$report->is_verified)
                                        <form action="{{ route('admin.death-reports.approve', $report->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-outline-success btn-sm rounded-3 fw-semibold">
                                                <i class="bi bi-check-circle me-1"></i> Verify
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.death-reports.unverify', $report->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm rounded-3 fw-semibold">
                                                <i class="bi bi-x-circle me-1"></i> Unverify
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-light fst-italic py-4">
                                    No death reports yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ✨ Custom Styles --}}
<style>
.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}

.text-light.fst-italic {
    font-style: italic;
}

.badge {
    font-size: 0.85rem;
}

.btn-outline-success:hover {
    background-color: rgba(25, 135, 84, 0.2);
    box-shadow: 0 0 10px rgba(25, 135, 84, 0.4);
}

.btn-outline-danger:hover {
    background-color: rgba(220, 53, 69, 0.2);
    box-shadow: 0 0 10px rgba(220, 53, 69, 0.4);
}

.btn-outline-info:hover {
    background-color: rgba(13, 202, 240, 0.2);
    box-shadow: 0 0 10px rgba(13, 202, 240, 0.4);
}

.alert-success {
    background-color: rgba(25, 135, 84, 0.2);
    color: #a6ffcb;
    border: 1px solid rgba(25, 135, 84, 0.4);
}
</style>
@endsection
