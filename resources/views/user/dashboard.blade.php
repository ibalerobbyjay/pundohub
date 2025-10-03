@extends('layouts.app')

@section('content')
<h2>Dashboard</h2>

<h4>Recent Notification</h4>
<ul class="list-group mb-3">
    @forelse($notifications as $note)
        <li class="list-group-item">
            <strong>{{ $note->title }}</strong> - {{ $note->message }}
            <span class="text-muted float-end">{{ $note->created_at->diffForHumans() }}</span>
        </li>
    @empty
        <li class="list-group-item">No notifications yet.</li>
    @endforelse
</ul>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Donations</h5>
            <p>{{ $totalDonations }}</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Bereavement Cases</h5>
            <p>{{ $totalCases }}</p>
        </div>
    </div>
</div>
@endsection

