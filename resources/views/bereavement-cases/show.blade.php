@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-3">Bereavement Case Details</h2>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Bereavement:</strong> {{ $case->title }}</p>
            <p><strong>Member:</strong> {{ $case->user->name }}</p>
            <p><strong>Date of Death:</strong> {{ $case->date_of_death->format('F d, Y') }}</p>
            <p><strong>Description:</strong> {{ $case->description ?? 'N/A' }}</p>
        </div>
    </div>

    <form action="{{ route('bereavement-cases.updateRemarks', $case->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="remarks" class="form-label"><strong>Remarks</strong></label>
            <textarea name="remarks" id="remarks" class="form-control" rows="4">{{ old('remarks', $case->remarks) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Remarks</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Back to Dashboard</a>
    </form>
</div>
@endsection
