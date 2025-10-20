@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Notifications ({{ $unread->count() }} unread)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($notifications->isEmpty())
        <div class="text-center text-muted py-5">
            No notifications found.
        </div>
    @else
        <ul class="list-group">
            @foreach($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-start 
                           {{ is_null($notification->read_at) ? 'list-group-item-primary fw-bold' : '' }}">
                    
                    <div>
                        {{ $notification->data['message'] ?? 'No message' }}<br>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="ms-3 text-nowrap">
                        {{-- Mark as read --}}
                        @if(is_null($notification->read_at))
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success mb-1">✓</button>
                            </form>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
