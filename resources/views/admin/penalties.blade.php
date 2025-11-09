@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-lg rounded-4 bg-dark text-light" 
                 style="background: rgba(20,20,20,0.85); backdrop-filter: blur(10px);">
                 
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
    <h2 class="mb-0 fw-bold text-info">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>Penalties Dashboard
    </h2>
</div>


                <div class="card-body">
                    @if($penalties->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover align-middle">
                                <thead class="table-light text-dark">
                                    <tr>
                                        <th>User</th>
                                        <th>Amount (₱)</th>
                                        <th>Reason</th>
                                        <th>Date Applied</th>
                                        <th>Status</th> <!-- New column for Paid button -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penalties as $penalty)
                                        <tr>
                                            <td>{{ $penalty->user->name ?? 'Unknown' }}</td>
                                            <td>₱{{ number_format($penalty->amount, 2) }}</td>
                                            <td>{{ $penalty->reason }}</td>
                                            <td>{{ \Carbon\Carbon::parse($penalty->applied_at)->format('F d, Y g:i A') }}</td>
                                            <td>
                                                @if($penalty->paid)
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <form action="{{ route('penalties.markPaid', $penalty->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-primary">Mark as Paid</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $penalties->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <p class="text-center text-muted">No penalties recorded yet.</p>
                    @endif
                </div>
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