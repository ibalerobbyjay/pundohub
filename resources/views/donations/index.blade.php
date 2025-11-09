@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card border-0 shadow-lg rounded-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-body p-4">
            <h2 class="mb-4 fw-bold text-info text-center">
                <i class="bi bi-heart-fill me-2 text-danger"></i> All Donations
            </h2>

            <!-- Table -->
           
            <div class="table-responsive">
    <table class="table table-hover table-dark align-middle text-center text-light">
        <thead style="background-color: #1a1a1a; color: #f8f9fa;" class="text-uppercase small">
            <tr>
                <th>Donor Name</th>
                <th>Bereavement Case</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Proof</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $donation)
            <tr>
                <td>{{ $donation->user->name ?? 'N/A' }}</td>
                <td>{{ $donation->bereavementCase->title ?? 'N/A' }}</td>
                <td>
                    @if($donation->type === 'Money')
                        <span class="fw-semibold text-success">₱{{ number_format($donation->amount, 2) }}</span>
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
                <td>
                    <span class="badge 
                        {{ $donation->type === 'Money' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $donation->type }}
                    </span>
                </td>
                <td>
                    @if($donation->proof)
                        <a href="{{ asset('storage/' . $donation->proof) }}" target="_blank">
                            <img src="{{ asset('storage/' . $donation->proof) }}" 
                                 alt="Proof" 
                                 class="img-thumbnail shadow-sm"
                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        </a>
                    @else
                        <span class="text-muted fst-italic">No proof</span>
                    @endif
                </td>
                <td>
                     @if(auth()->user()->role === 'admin')
                    <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                onclick="return confirm('Are you sure you want to delete this donation?')">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                     
                                    @endif
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        No donations found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


            <div class=" mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-info rounded-pill px-4">
                    ← Back to Dashboard
                </a>
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