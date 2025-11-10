@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-white fw-bold">Dashboard</h2>

    {{-- Regular User Dashboard --}}
    @if(auth()->user()->role !== 'admin')
        <div class="row mb-4">
            {{-- Your Donations --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('donations.history') }}" class="text-decoration-none">
                    <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                        <h5 class="text-info">Total Fund</h5>
                        <p class="fs-5 fw-bold">₱ {{ number_format($userTotalDonations, 2) }}</p>
                    </div>
                </a>
            </div>

            {{-- Total Donations (All Members) --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('donations.index') }}" class="text-decoration-none">
                    <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                        <h5 class="text-info">Total Donations (All Members)</h5>
                        <p class="fs-5 fw-bold">₱ {{ number_format($totalDonations, 2) }}</p>
                    </div>
                </a>
            </div>

            {{-- 🆕 Monthly Funds --}}
            <div class="col-md-4 mb-3">
                <a href="{{ route('monthlyfunds.index') }}" class="text-decoration-none">
                    <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card position-relative">
                        <h5 class="text-info">Monthly Funds</h5>
                        <p class="fs-5 fw-bold">₱ 50 / month</p>

                        {{-- ✅ Show Paid/Unpaid Status --}}
                        @php
                            $hasPaidThisMonth = auth()->user()
                                ->monthlyFunds()
                                ->where('month_year', now()->startOfMonth())
                                ->exists();
                        @endphp

                        @if($hasPaidThisMonth)
                            <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2">Paid</span>
                        @else
                            <span class="badge bg-danger position-absolute top-0 end-0 m-3 px-3 py-2">Unpaid</span>
                        @endif
                    </div>
                </a>
            </div>
        </div>

        <h4 class="text-white mt-4">Recent Notifications</h4>

        {{-- Mark all as read --}}
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('notifications.markAllRead') }}" class="mb-3">
                @csrf
                <button class="btn btn-sm btn-secondary rounded-pill px-3">Mark All as Read</button>
            </form>
        @endif

        <ul class="list-group mb-3 shadow-sm rounded-4">
            @forelse(auth()->user()->notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-start
                           {{ $notification->read_at ? 'bg-dark text-light' : 'bg-info text-dark fw-bold' }} hover-notification">
                    <div>
                        <strong>{{ $notification->data['user_name'] ?? 'N/A' }}</strong>
                        - {{ $notification->data['title'] ?? 'No title' }} <br>
                        Date of Death: {{ $notification->data['date_of_death'] ?? 'N/A' }} <br>
                        Description: {{ $notification->data['description'] ?? 'N/A' }}
                        <br><small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                    <a href="{{ $notification->data['link'] ?? '#' }}" 
                       class="btn btn-sm btn-primary align-self-center ms-3">
                       View Case
                    </a>
                </li>
            @empty
                <li class="list-group-item bg-dark text-light text-center">No notifications yet.</li>
            @endforelse
        </ul>
    @endif

    {{-- Admin Dashboard --}}
    @if(auth()->user()->role === 'admin')
        <div class="row mt-4">
            {{-- Total Donations --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('donations.index') }}" class="text-decoration-none">
                    <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                        <h5 class="text-info">Total Donations</h5>
                        <p class="fs-5 fw-bold">₱ {{ number_format($totalDonations, 2) }}</p>
                    </div>
                </a>
            </div>

            {{-- Total Number of Donations --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('donations.index') }}" class="text-decoration-none">
                    <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                        <h5 class="text-info">Number of Donations</h5>
                        <p class="fs-5 fw-bold">{{ $totalDonationCount }}</p>
                    </div>
                </a>
            </div>

            {{-- Total Bereavement Cases --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('bereavement-cases.index') }}" class="text-decoration-none">
                    <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                        <h5 class="text-info">Bereavement Cases</h5>
                        <p class="fs-5 fw-bold">{{ $totalCases }}</p>
                    </div>
                </a>
            </div>

            {{-- 🆕 Monthly Funds (Admin View) --}}
            <div class="col-md-3 mb-3">
                <a href="{{ route('monthlyfunds.index') }}" class="text-decoration-none">
                    <div class="card p-4 bg-dark text-light shadow rounded-4 hover-card">
                        <h5 class="text-info">Monthly Fund (All Members)</h5>
                        <p class="fs-5 fw-bold">
                            ₱ {{ number_format(\App\Models\MonthlyFund::where('month_year', now()->startOfMonth())->sum('amount'), 2) }}
                        </p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Recent Bereavement Cases --}}
        <div class="mt-4">
            <h4 class="text-white">Recent Bereavement Cases</h4>
            @if(isset($recentCases) && $recentCases->count() > 0)
                <ul class="list-group shadow-sm rounded-4">
                    @foreach($recentCases as $case)
                        <li class="list-group-item d-flex justify-content-between align-items-start
                                   bg-dark text-light mb-2 rounded-3 hover-notification">
                            <div>
                                <strong>{{ $case->title ?? 'No title' }}</strong><br>
                                Member: {{ $case->user->name ?? 'N/A' }} <br>
                                Date of Death: {{ $case->date_of_death?->format('F j, Y') ?? 'N/A' }} <br>
                                Description: {{ $case->description ?? 'N/A' }}
                            </div>
                            <a href="{{ route('bereavement-cases.edit', $case->id) }}" 
                               class="btn btn-sm btn-outline-primary align-self-center">
                               View / Edit
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No recent bereavement cases.</p>
            @endif
        </div>
    @endif
</div>

{{-- Hover effects --}}
<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
}
.hover-notification {
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}
.hover-notification:hover {
    background-color: rgba(0, 255, 255, 0.1);
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
}
</style>
@endsection
