@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-primary mb-4">Edit Bereavement Case</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-3 shadow-sm">
        <form action="{{ route('bereavement-cases.update', $case->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <label for="title" class="col-sm-3 col-form-label">Title <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $case->title) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="user_id" class="col-sm-3 col-form-label">Member <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select name="user_id" id="user_id" class="form-select" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $case->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="date_of_death" class="col-sm-3 col-form-label">Date of Death <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="date" name="date_of_death" id="date_of_death" class="form-control" value="{{ old('date_of_death', $case->date_of_death->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $case->description) }}</textarea>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Update Case</button>
                <a href="{{ route('bereavement-cases.index') }}" class="btn btn-secondary ms-2">Back to Cases</a>
            </div>
        </form>
    </div>
</div>
@endsection
