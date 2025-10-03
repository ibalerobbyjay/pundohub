@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Bereavement Case</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('bereavement-cases.update', $case->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Case Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $case->title }}" required>
        </div>

        <div class="mb-3">
            <label for="member_id" class="form-label">Member</label>
            <select name="member_id" id="member_id" class="form-select" required>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ $member->id == $case->member_id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_of_death" class="form-label">Date of Death</label>
            <input type="date" name="date_of_death" id="date_of_death" class="form-control" value="{{ $case->date_of_death->format('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ $case->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Case</button>
        <a href="{{ route('bereavement-cases.index') }}" class="btn btn-secondary ms-2">Back to Cases</a>
    </form>
</div>
@endsection
