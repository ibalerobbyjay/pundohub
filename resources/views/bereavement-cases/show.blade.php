@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-info text-center">
        <i class="bi bi-file-earmark-text-fill me-2 text-warning"></i> Bereavement Case Details
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Case Information Card --}}
    <div class="card shadow-lg rounded-4 mb-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-header bg-secondary">
            <h5 class="mb-0 text-white">
                <i class="bi bi-info-circle me-2"></i>Case Information
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong class="text-info">Case Title:</strong> {{ $case->title }}</p>
                    <p><strong class="text-info">Member:</strong> {{ $case->user->name }}</p>
                    <p><strong class="text-info">Date of Death:</strong> {{ $case->date_of_death->format('F d, Y') }}</p>
                    <p><strong class="text-info">Case Created:</strong> {{ $case->created_at->format('F d, Y g:i A') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong class="text-info">Name of Deceased:</strong> {{ $case->description_name ?? 'N/A' }}</p>
                    <p><strong class="text-info">Service Type:</strong> {{ $case->description_what ?? 'N/A' }}</p>
                    <p><strong class="text-info">Service Date & Time:</strong> 
                        @if($case->description_when)
                            {{ \Carbon\Carbon::parse($case->description_when)->format('F d, Y g:i A') }}
                        @else
                            N/A
                        @endif
                    </p>
                    <p><strong class="text-info">Location:</strong> {{ $case->description_where ?? 'N/A' }}</p>
                </div>
            </div>
            
            @if($case->description_notes)
                <div class="mt-3 pt-3 border-top border-secondary">
                    <p><strong class="text-info">Additional Notes:</strong></p>
                    <p class="mb-0 text-light">{{ $case->description_notes }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Remarks Section --}}
    <div class="card shadow-lg rounded-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-header bg-secondary">
            <h5 class="mb-0 text-white">
                <i class="bi bi-chat-text me-2"></i>Case Remarks & Updates
            </h5>
        </div>
        <div class="card-body">
            {{-- Current Remarks Display --}}
            @if($case->remarks)
                <div class="mb-4 p-3 bg-dark border border-secondary rounded-3">
                    <h6 class="text-warning">Current Remarks:</h6>
                    <p class="mb-0 text-light">{{ $case->remarks }}</p>
                    <small class="text-muted">Last updated: {{ $case->updated_at->diffForHumans() }}</small>
                </div>
            @else
                <div class="mb-4 p-3 bg-dark border border-secondary rounded-3">
                    <p class="text-muted mb-0"><i>No remarks added yet.</i></p>
                </div>
            @endif

            {{-- Update Remarks Form --}}
            <form action="{{ route('bereavement-cases.updateRemarks', $case->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="remarks" class="form-label text-light"><strong>Update Remarks</strong></label>
                    <textarea name="remarks" id="remarks" class="form-control bg-dark text-light border-secondary" 
                              rows="4" placeholder="Add any remarks or updates about this case...">{{ old('remarks', $case->remarks) }}</textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <a href="{{ route('bereavement-cases.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-list-ul me-1"></i> All Cases
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light rounded-pill px-4 ms-2">
                            <i class="bi bi-arrow-left-circle me-1"></i> Dashboard
                        </a>
                    </div>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Remarks
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid #444;
}
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 255, 255, 0.15);
}
.form-control:focus {
    border-color: #0dcaf0;
    box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
}
</style>
@endsection