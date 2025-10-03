@extends('layouts.app')

@section('content')
<h2>Notification Details</h2>
<ul class="list-group">
    <li class="list-group-item"><strong>Title:</strong> {{ $notification->title }}</li>
    <li class="list-group-item"><strong>Message:</strong> {{ $notification->message }}</li>
    <li class="list-group-item"><strong>Created:</strong> {{ $notification->created_at->format('M d, Y h:i A') }}</li>
</ul>
<a href="{{ route('notifications.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection

