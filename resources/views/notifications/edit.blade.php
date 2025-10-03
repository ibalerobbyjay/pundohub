@extends('layouts.app')

@section('content')
<h2>Edit Notification</h2>
<form action="{{ route('notifications.update', $notification->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ $notification->title }}" required>
    </div>
    <div class="mb-3">
        <label>Message</label>
        <textarea name="message" class="form-control" rows="4" required>{{ $notification->message }}</textarea>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection

