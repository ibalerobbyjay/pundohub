@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add Donation</h2>

    <form action="{{ route('donations.store') }}" method="POST">
        @csrf

        <!-- Donor (auto-filled) -->
        <div class="mb-3">
            <label for="member_id" class="form-label">Donor Name</label>
            <select name="member_id" id="member_id" class="form-control" required>
                <option value="">Select a member</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Type -->
        <div class="mb-3">
            <label for="type" class="form-label">Donation Type</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" required>
        </div>

        <!-- Optional Bereavement Case -->
        <div class="mb-3">
            <label for="bereavement_case_id" class="form-label">Bereavement Case (optional)</label>
            <select name="bereavement_case_id" id="bereavement_case_id" class="form-select">
                <option value="">None</option>
                @foreach ($cases as $case)
                <option value="{{ $case->id }}">
    {{ $case->title }} ({{ $case->member->name ?? 'Unknown Member' }})
</option>

                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Donation</button>
    </form>
</div>
@endsection
