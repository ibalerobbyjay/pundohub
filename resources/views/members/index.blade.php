@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Members</h2>

    <a href="{{ route('members.create') }}" class="btn btn-primary mb-3">Add Member</a>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Household</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->household }}</td>
                        <td>{{ $member->contact }}</td>
                        <td>
                            <a href="{{ route('members.show', $member->id) }}" class="btn btn-info btn-sm me-1">View</a>
                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
