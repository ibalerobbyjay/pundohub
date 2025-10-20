@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>

@if(auth()->user()->role !== 'admin')
    {{-- User total donations --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Donations (You)</h5>
                <p>₱ {{ number_format($totalDonations, 2) }}</p>
            </div>
        </div>
    </div>

    <h4>Recent Notifications</h4>

    {{-- Mark all as read button --}}
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
        <div class="card p-3">
            <h5>Total Donations (All Members)</h5>
            <p>₱ {{ number_format($totalDonations, 2) }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Number of Donations</h5>
            <p>{{ $totalDonationCount }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Bereavement Cases</h5>
            <p>{{ $totalCases }}</p>
        </div>
    </div>
</div>

{{-- Recent Bereavement Cases --}}
<div class="mt-4">
    <h4>Recent Bereavement Cases</h4>
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
        <p>No recent bereavement cases.</p>
    @endif
</div>
@endif
@endsection
