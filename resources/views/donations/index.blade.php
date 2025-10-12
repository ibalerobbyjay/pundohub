@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Donations</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Donor Name</th>
                    <th scope="col">Bereavement Case</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Type</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
         <tbody>
@foreach($donations as $donation)
<tr class="text-center">
    <td>{{ $donation->user->name ?? 'N/A' }}</td>
    <td>{{ $donation->bereavementCase->title ?? 'N/A' }}</td>
    <td>{{ number_format($donation->amount, 2) }}</td>
    <td>{{ $donation->type }}</td>
    <td>
        <a href="{{ route('donations.edit', $donation->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
        <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this donation?')">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>

        </table>
        
    </form>
    </div>
</div>
@endsection
