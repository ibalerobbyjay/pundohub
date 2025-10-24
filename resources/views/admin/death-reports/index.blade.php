@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card p-4 shadow-lg rounded-4">
        <h2 class="mb-4 text-gray-800">Death Reports</h2>

        <!-- ✅ Success Alert -->
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
                        <th>Certificate</th>
                        <th>Status</th>
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
                                @if ($report->death_certificate)
                                    @php
                                        $fileExt = strtolower(pathinfo($report->death_certificate, PATHINFO_EXTENSION));
                                        $fileUrl = asset('storage/' . $report->death_certificate);
                                    @endphp

                                    @if (in_array($fileExt, ['jpg', 'jpeg', 'png']))
                                        <a href="{{ $fileUrl }}" target="_blank">
                                            <img src="{{ $fileUrl }}" alt="Certificate" class="img-thumbnail" width="70">
                                        </a>
                                    @elseif ($fileExt === 'pdf')
                                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            View PDF
                                        </a>
                                    @else
                                        <span class="text-muted">Unsupported File</span>
                                    @endif
                                @else
                                    <span class="text-muted">No File</span>
                                @endif
                            </td>

                            <td>
                                @if ($report->is_verified)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if (!$report->is_verified)
                                    <form action="{{ route('admin.death-reports.approve', $report->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle me-1"></i> Verify
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.death-reports.unverify', $report->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle me-1"></i> Unverify
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No death reports yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
