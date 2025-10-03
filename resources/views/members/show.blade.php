@extends('layouts.app')

@section('content')
<h2>Member Details</h2>
<ul class="list-group">
    <li class="list-group-item"><strong>Name:</strong> {{ $member->name }}</li>
    <li class="list-group-item"><strong>Household:</strong> {{ $member->household }}</li>
    <li class="list-group-item"><strong>Contact:</strong> {{ $member->contact }}</li>
    <li class="list-group-item"><strong>Verified:</strong> {{ $member->is_verified ? 'Yes' : 'No' }}</li>
</ul>
<a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection

