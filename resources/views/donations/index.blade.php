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
                    <th scope="col">Proof</th> {{-- ✅ new column --}}
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                <tr class="text-center">
                    <td>{{ $donation->user->name ?? 'N/A' }}</td>
                    <td>{{ $donation->bereavementCase->title ?? 'N/A' }}</td>
                    <td>{{ $donation->type === 'Money' ? number_format($donation->amount, 2) : '—' }}</td>
                    <td>{{ $donation->type }}</td>

                    {{-- ✅ Proof column --}}
                    <td>
                        @if($donation->proof)
                            <a href="{{ asset('storage/' . $donation->proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $donation->proof) }}" 
                                     alt="Proof" 
                                     class="img-thumbnail" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </a>
                        @else
                            <span class="text-muted">No proof</span>
                        @endif
                    </td>

                    {{-- ✅ Delete button only --}}
                    <td>
                        <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this donation?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
