@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">Bereavement Cases</h2>
        <a href="{{ route('bereavement-cases.create') }}" class="btn btn-success">Add New Case</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cases->isEmpty())
        <div class="alert alert-info">No bereavement cases found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Member</th>
                        <th>Date of Death</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cases as $case)
                        <tr>
                            <td>{{ $case->title }}</td>
                            <td>{{ $case->user->name ?? 'N/A' }}</td>
                            <td>{{ $case->date_of_death->format('F d, Y') }}</td>
                            <td>{{ $case->description ?? 'N/A' }}</td>
                            <td class="d-flex">
                                <a href="{{ route('bereavement-cases.edit', $case->id) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="{{ route('bereavement-cases.destroy', $case->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
