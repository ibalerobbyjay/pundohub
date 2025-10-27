@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-white">Dashboard</h2>

@if(auth()->user()->role !== 'admin')
    {{-- User & Overall Donations --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 bg-dark text-light shadow">
                <h5 class="text-info">Your Total Donations</h5>
                <p class="fs-5 fw-bold">₱ {{ number_format($userTotalDonations, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-dark text-light shadow">
                <h5 class="text-info">Total Donations (All Members)</h5>
                <p class="fs-5 fw-bold">₱ {{ number_format($totalDonations, 2) }}</p>
            </div>
        </div>
    </div>

    <h4 class="text-white">Recent Notifications</h4>

    {{-- Mark all as read --}}
    @if(auth()->user()->unreadNotifications->count() > 0)
    <form method="POST" action="{{ route('notifications.markAllRead') }}" class="mb-2">
        @csrf
        <button class="btn btn-sm btn-secondary">Mark All as Read</button>
    </form>
    @endif

    <ul class="list-group mb-3">
        @forelse(auth()->user()->notifications as $notification)
            <li class="list-group-item {{ $notification->read_at ? '' : 'bg-light' }}">
                <strong>{{ $notification->data['user_name'] ?? 'N/A' }}</strong> 
                - {{ $notification->data['title'] ?? 'No title' }} <br>
                Date of Death: {{ $notification->data['date_of_death'] ?? 'N/A' }} <br>
                Description: {{ $notification->data['description'] ?? 'N/A' }}
                <a href="{{ $notification->data['link'] ?? '#' }}" class="btn btn-sm btn-primary float-end">View Case</a>
            </li>
        @empty
            <li class="list-group-item">No notifications yet.</li>
        @endforelse
    </ul>
@endif

@if(auth()->user()->role === 'admin')
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-3 bg-dark text-light shadow">
            <h5 class="text-info">Total Donations (All Members)</h5>
            <p class="fs-5 fw-bold">₱ {{ number_format($totalDonations, 2) }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 bg-dark text-light shadow">
            <h5 class="text-info">Total Number of Donations</h5>
            <p class="fs-5 fw-bold">{{ $totalDonationCount }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3 bg-dark text-light shadow">
            <h5 class="text-info">Total Bereavement Cases</h5>
            <p class="fs-5 fw-bold">{{ $totalCases }}</p>
        </div>
    </div>
</div>

{{-- Recent Bereavement Cases --}}
<div class="mt-4">
    <h4 class="text-white">Recent Bereavement Cases</h4>
    @if(isset($recentCases) && $recentCases->count() > 0)
        <ul class="list-group">
            @foreach($recentCases as $case)
                <li class="list-group-item">
                    <strong>{{ $case->title ?? 'No title' }}</strong><br>
                    Member: {{ $case->user->name ?? 'N/A' }} <br>
                    Date of Death: {{ $case->date_of_death?->format('F j, Y') ?? 'N/A' }} <br>
                    Description: {{ $case->description ?? 'N/A' }}
                    <a href="{{ route('bereavement-cases.edit', $case->id) }}" class="btn btn-sm btn-outline-primary float-end">
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
@endsection
