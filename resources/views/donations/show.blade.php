@extends('layouts.app')

@section('content')
<h2>Donation Details</h2>
<ul class="list-group">
    <li class="list-group-item"><strong>Member:</strong> {{ $donation->member->name }}</li>
    <li class="list-group-item"><strong>Bereavement Case:</strong> {{ $donation->bereavementCase->member->name }}</li>
    <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($donation->type) }}</li>
    <li class="list-group-item"><strong>Amount / Quantity:</strong> {{ $donation->amount }}</li>
</ul>
<a href="{{ route('donations.index') }}" class="btn btn-secondary mt-3">Back</a>
@endsection

