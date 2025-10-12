@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">Add New Bereavement Case</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bereavement-cases.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">Member <span class="text-danger">*</span></label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Select Member --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="date_of_death" class="form-label">Date of Death <span class="text-danger">*</span></label>
            <input type="date" name="date_of_death" id="date_of_death" class="form-control" value="{{ old('date_of_death') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Add Case</button>
        <a href="{{ route('bereavement-cases.index') }}" class="btn btn-secondary ms-2">Back to Cases</a>
    </form>
</div>
@endsection
