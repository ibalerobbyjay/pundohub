@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Add New Member</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Member Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter member name" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="household" class="form-label">Household</label>
            <input type="text" name="household" id="household" class="form-control" placeholder="Enter household" required>
        </div>

        <div class="mb-3">
            <label for="contact" class="form-label">Contact Number</label>
            <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter contact number" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Member</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary ms-2">Back to Members</a>
    </form>
</div>
@endsection
