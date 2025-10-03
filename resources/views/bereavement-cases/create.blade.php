@extends('layouts.app')

@section('content')
<h2>Add New Bereavement Case</h2>

<!-- Display Validation Errors -->
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('bereavement-cases.store') }}" method="POST">
    @csrf

    <!-- Title -->
    <div class="mb-3">
        <label for="title">Title <span style="color:red;">*</span></label>
        <input type="text" name="title" id="title" class="form-control"
               value="{{ old('title') }}" required>
        @error('title')
            <small style="color:red;">{{ $message }}</small>
        @enderror
    </div>

    <!-- Member -->
    <div class="mb-3">
        <label for="member_id">Member <span style="color:red;">*</span></label>
        <select name="member_id" id="member_id" class="form-control" required>
            <option value="">-- Select Member --</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                    {{ $member->name }}
                </option>
            @endforeach
        </select>
        @error('member_id')
            <small style="color:red;">{{ $message }}</small>
        @enderror
    </div>

    <!-- Date of Death -->
    <div class="mb-3">
        <label for="date_of_death">Date of Death <span style="color:red;">*</span></label>
        <input type="date" name="date_of_death" id="date_of_death" class="form-control"
               value="{{ old('date_of_death') }}" required>
        @error('date_of_death')
            <small style="color:red;">{{ $message }}</small>
        @enderror
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        @error('description')
            <small style="color:red;">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Add Bereavement Case</button>
</form>
@endsection
