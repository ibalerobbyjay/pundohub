@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white fw-bold">
            <i class="bi bi-file-earmark-text me-2"></i>Bereavement Cases
        </h2>
      
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cases->isEmpty())
        <div class="alert alert-info shadow-sm rounded-3">
            No bereavement cases found.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded-4">
            <table class="table table-hover table-dark align-middle mb-0">
                <thead class="table-secondary text-dark">
                    <tr>
                        <th>Title</th>
                        <th>Member</th>
                        <th>Date of Death</th>
                        <th>Description</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cases as $case)
                        <tr class="bg-dark text-light">
                            <td>{{ $case->title }}</td>
                            <td>{{ $case->user->name ?? 'N/A' }}</td>
                            <td>{{ $case->date_of_death->format('F d, Y') }}</td>
                            <td>{{ $case->description ?? 'N/A' }}</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('bereavement-cases.edit', $case->id) }}" 
                                   class="btn btn-sm btn-warning me-2 shadow-sm">
                                   <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('bereavement-cases.destroy', $case->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm"
                                            onclick="return confirm('Are you sure you want to delete this case?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<a href="{{ route('dashboard') }}" class="btn btn-outline-light mt-3 shadow-sm">
    ← Back to Dashboard
</a>

{{-- Optional: Hover effect for rows --}}
<style>
.table-hover tbody tr:hover {
    transform: translateY(-2px);
    transition: transform 0.15s ease;
    box-shadow: 0 4px 12px rgba(0, 255, 255, 0.2);
}
</style>
@endsection
