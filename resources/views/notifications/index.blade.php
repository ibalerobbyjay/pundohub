@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Notifications ({{ $unread->count() }} unread)</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($notifications->isEmpty())
        <div class="card">
            <div class="card-body text-center text-muted">
                No notifications found.
            </div>
        </div>
    @else
        <div class="row">
            @foreach($notifications as $notification)
                <div class="col-md-6 mb-4">
                    <div class="card @if(is_null($notification->read_at)) border-primary @endif">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            
                            <div>
                                <p class="mb-1 {{ is_null($notification->read_at) ? 'fw-bold' : '' }}">
                                    {{ $notification->data['message'] ?? 'No message' }}
                                </p>
                                <small class="text-muted">
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <div class="ms-3 text-nowrap">
                                {{-- Mark as read --}}
                                @if(is_null($notification->read_at))
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success mb-1">
                                            ✓
                                        </button>
                                    </form>
                                @endif

                                {{-- Delete --}}
                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
