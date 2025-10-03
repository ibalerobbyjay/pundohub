@extends('layouts.app')

@section('content')
<h2>Bereavement Case Details</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<ul class="list-group mb-3">
    <li class="list-group-item"><strong>Member:</strong> {{ $case->member->name }}</li>
    <li class="list-group-item"><strong>Date of Death:</strong> {{ $case->date_of_death }}</li>
    <li class="list-group-item"><strong>Description:</strong> {{ $case->description }}</li>
</ul>

<!-- Editable Remarks -->
<form action="{{ route('bereavement-cases.updateRemarks', $case->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="remarks"><strong>Remarks:</strong></label>
        <textarea name="remarks" id="remarks" class="form-control" rows="4">{{ old('remarks', $case->remarks) }}</textarea>
        @error('remarks')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary mt-3">Update Remarks</button>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Back</a>
</form>
@endsection
