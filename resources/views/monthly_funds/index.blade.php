@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-white fw-bold">Monthly Fund Contributions</h2>

    {{-- ✅ Alerts (Success + Error) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Payment button (only for non-admins) --}}
    @if(auth()->user()->role !== 'admin')
        @php
            $hasPaidThisMonth = auth()->user()
                ->monthlyFunds()
                ->where('month_year', now()->startOfMonth())
                ->exists();
        @endphp

        @if($hasPaidThisMonth)
            <button class="btn btn-secondary mb-3" disabled>
                You have already paid ₱50 for {{ now()->format('F Y') }}
            </button>
        @else
           <form action="{{ route('monthlyfunds.pay') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label text-white">Upload Proof of Payment (JPG/PNG)</label>
        <input type="file" name="proof_of_payment" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success mb-3">
        Pay ₱50 for {{ now()->format('F Y') }}
    </button>
</form>

        @endif
    @endif

    {{-- ✅ Fund Table --}}
    <div class="card bg-dark text-light shadow-lg border-0 rounded-4">
        <div class="card-body">
            <table class="table table-dark table-hover mb-0">
               <thead>
    <tr>
        <th>Member</th>
        <th>Amount</th>
        <th>Month</th>
        <th>Date Paid</th>
        <th>Proof</th>
    </tr>
</thead>
<tbody>
    @forelse($funds as $fund)
        <tr>
            <td>{{ $fund->user->name }}</td>
            <td>₱{{ number_format($fund->amount, 2) }}</td>
            <td>{{ \Carbon\Carbon::parse($fund->month_year)->format('F Y') }}</td>
            <td>{{ $fund->created_at->format('M d, Y') }}</td>
            <td>
                @if($fund->proof_of_payment)
                    <a href="{{ asset('storage/' . $fund->proof_of_payment) }}" target="_blank" class="btn btn-sm btn-outline-info">
                        View Proof
                    </a>
                @else
                    <span class="text-muted">No proof</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center text-muted">No monthly fund records yet.</td>
        </tr>
    @endforelse
</tbody>

            </table>
        </div>
    </div>
</div>

            <div class=" mt-4">
                <a href="{{ route('dashboard') }}" class="btn btn-outline-info rounded-pill px-4">
                    ← Back to Dashboard
                </a>
            </div>
@endsection
<style>
.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}
</style>