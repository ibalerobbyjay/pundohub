@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-info">Notifications ({{ $unread->count() }} unread)</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($notifications->isEmpty())
        <div class="text-center text-muted py-5">
            No notifications found.
        </div>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-start
           {{ is_null($notification->read_at) ? 'bg-primary text-white fw-bold' : 'bg-dark text-light' }}
           border-secondary rounded-3 mb-2 shadow-sm notification-item">
    
    <div>
        {{ $notification->data['message'] ?? 'No message' }}<br>
        <small class="{{ is_null($notification->read_at) ? 'text-light-50' : 'text-muted' }}">
            {{ $notification->created_at->diffForHumans() }}
        </small>
    </div>

    <div class="ms-3 text-nowrap">
        @if(is_null($notification->read_at))
            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success mb-1 rounded-pill">✓</button>
            </form>
        @endif
    </div>
</li>

            @endforeach
        </ul>
    @endif
</div>

<style>
/* Hover effect for notifications */
.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

.notification-item.bg-dark:hover {
    background-color: #c5c7ca !important; /* slightly lighter dark */
}

.notification-item.bg-primary:hover {
    background-color: #0d6efd !important; /* slightly brighter primary */
}
</style>
@endsection
