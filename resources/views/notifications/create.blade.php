@extends('layouts.app')

@section('content')
<h2>New Notification</h2>
<form action="{{ route('notifications.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Message</label>
        <textarea name="message" class="form-control" rows="4" required></textarea>
    </div>
    <button class="btn btn-success">Send</button>
</form>
@endsection

