@extends('layouts.app')

@section('content')
<h2>Edit Donation</h2>
<form action="{{ route('donations.update', $donation->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Member</label>
        <select name="member_id" class="form-control" required>
            @foreach ($members as $member)
                <option value="{{ $member->id }}" {{ $donation->member_id == $member->id ? 'selected' : '' }}>
                    {{ $member->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Bereavement Case</label>
        <select name="bereavement_case_id" class="form-control" required>
            @foreach ($cases as $case)
                <option value="{{ $case->id }}" {{ $donation->bereavement_case_id == $case->id ? 'selected' : '' }}>
                    {{ $case->member->name }} ({{ $case->date_of_death }})
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="cash" {{ $donation->type == 'cash' ? 'selected' : '' }}>Cash</option>
            <option value="rice" {{ $donation->type == 'rice' ? 'selected' : '' }}>Rice</option>
            <option value="firewood" {{ $donation->type == 'firewood' ? 'selected' : '' }}>Firewood</option>
            <option value="other" {{ $donation->type == 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Amount / Quantity</label>
        <input type="number" name="amount" class="form-control" value="{{ $donation->amount }}" required>
    </div>
    <button class="btn btn-primary">Update</button>
</form>
@endsection

