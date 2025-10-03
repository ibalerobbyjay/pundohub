@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Bereavement Cases</h2>
        <a href="{{ route('bereavement-cases.create') }}" class="btn btn-primary">Add New Case</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($cases->isEmpty())
        <p>No bereavement cases found.</p>
    @else
        <div class="row">
            @foreach($cases as $case)
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $case->title }}</h5>
                            <p class="card-text"><strong>Member:</strong> {{ $case->member->name ?? 'N/A' }}</p>
                            <p class="card-text"><strong>Date of Death:</strong> {{ $case->date_of_death }}</p>
                            <p class="card-text"><strong>Description:</strong> {{ $case->description ?? 'N/A' }}</p>
                            <a href="{{ route('bereavement-cases.edit', $case->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                            <form action="{{ route('bereavement-cases.destroy', $case->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
