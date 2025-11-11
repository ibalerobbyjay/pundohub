@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-info">Notifications ({{ $unread->count() }} unread)</h3>

        @if($unread->count() > 0)
        <form action="{{ route('notifications.markAllRead') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                Mark All as Read
            </button>
        </form>
        @endif
    </div>

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
                @php
                    $data = $notification->data;
                    $isUnread = is_null($notification->read_at);
                    $bgClass = $isUnread ? 'bg-primary text-white fw-bold' : 'bg-dark text-light';
                @endphp

                <li class="list-group-item d-flex justify-content-between align-items-start {{ $bgClass }} border-secondary rounded-3 mb-2 shadow-sm notification-item">
                    <div>
                        {{-- Handle member notification --}}
                        @if(isset($data['message']))
                            {{ $data['message'] }}

                        {{-- Handle job assignment notification (UPDATED) --}}
                        @elseif(isset($data['case_title']) && isset($data['job_type']))
                            You have a new {{ $data['job_type'] }} assignment for case: {{ $data['case_title'] }}

                        {{-- Handle bereavement case notification --}}
                        @elseif(isset($data['case_title']) && isset($data['type']))
                            New {{ $data['type'] }}: {{ $data['case_title'] }}

                        @else
                            No message
                        @endif
                        <br>
                        <small class="{{ $isUnread ? 'text-light-50' : 'text-muted' }}">
                            {{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>

                    <div class="ms-3 text-nowrap">
                        {{-- Mark as Read --}}
                        @if($isUnread)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success mb-1 rounded-pill">Mark as read</button>
                        </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

<style>
.notification-item {
    transition: all 0.2s ease-in-out;
    cursor: pointer;
}

.notification-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}

.notification-item.bg-dark:hover {
    background-color: #c5c7ca !important;
}

.notification-item.bg-primary:hover {
    background-color: #0d6efd !important;
}
</style>
@endsection