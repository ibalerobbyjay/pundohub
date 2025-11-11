@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-info mb-4 text-center">
        <i class="bi bi-pencil-square me-2 text-warning"></i> Edit Bereavement Case
    </h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-lg rounded-4 p-4 bg-dark text-light" 
         style="background: rgba(25,25,25,0.85); backdrop-filter: blur(10px);">
        <form action="{{ route('bereavement-cases.update', $case->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <label for="title" class="col-sm-3 col-form-label fw-bold">Title <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="text" name="title" id="title" class="form-control bg-dark text-light border-secondary" 
                           value="{{ old('title', $case->title) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="user_id" class="col-sm-3 col-form-label fw-bold">Member <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select name="user_id" id="user_id" class="form-select bg-dark text-light border-secondary" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $user->id == $case->user_id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="date_of_death" class="col-sm-3 col-form-label fw-bold">Date of Death <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="date" name="date_of_death" id="date_of_death" 
                           class="form-control bg-dark text-light border-secondary" 
                           value="{{ old('date_of_death', $case->date_of_death->format('Y-m-d')) }}" required>
                </div>
            </div>

            {{-- Structured Description Fields --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Case Details <span class="text-danger">*</span></label>
                <div class="card bg-dark border-secondary rounded-3">
                    <div class="card-body">
                        {{-- What --}}
                        <div class="mb-3 row">
                            <label for="description_what" class="col-sm-3 col-form-label text-light small">
                                What (Type of Service/Event) <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       name="description_what" 
                                       id="description_what" 
                                       class="form-control bg-dark text-light border-secondary rounded-3"
                                       value="{{ old('description_what', $case->description_what) }}" required
                                       placeholder="e.g., Wake Service, Funeral, Memorial Mass">
                            </div>
                        </div>

                        {{-- When --}}
                        <div class="mb-3 row">
                            <label for="description_when" class="col-sm-3 col-form-label text-light small">
                                When (Date & Time) <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="datetime-local" 
                                       name="description_when" 
                                       id="description_when" 
                                       class="form-control bg-dark text-light border-secondary rounded-3"
                                       value="{{ old('description_when', $case->description_when ? \Carbon\Carbon::parse($case->description_when)->format('Y-m-d\TH:i') : '') }}" required
                                       placeholder="Select date and time">
                            </div>
                        </div>

                        {{-- Where --}}
                        <div class="mb-3 row">
                            <label for="description_where" class="col-sm-3 col-form-label text-light small">
                                Where (Location) <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       name="description_where" 
                                       id="description_where" 
                                       class="form-control bg-dark text-light border-secondary rounded-3"
                                       value="{{ old('description_where', $case->description_where) }}" required
                                       placeholder="e.g., St. Mary's Church, Family Residence">
                            </div>
                        </div>

                        {{-- Name of Deceased --}}
                        <div class="mb-3 row">
                            <label for="description_name" class="col-sm-3 col-form-label text-light small">
                                Name of Deceased <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <input type="text" 
                                       name="description_name" 
                                       id="description_name" 
                                       class="form-control bg-dark text-light border-secondary rounded-3"
                                       value="{{ old('description_name', $case->description_name) }}" required
                                       placeholder="Full name of the deceased">
                            </div>
                        </div>

                        {{-- Additional Notes --}}
                        <div class="mb-3 row">
                            <label for="description_notes" class="col-sm-3 col-form-label text-light small">
                                Additional Notes
                            </label>
                            <div class="col-sm-9">
                                <textarea name="description_notes" 
                                          id="description_notes" 
                                          class="form-control bg-dark text-light border-secondary rounded-3" 
                                          rows="3"
                                          placeholder="Any additional information about the case...">{{ old('description_notes', $case->description_notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Remarks Section --}}
            <div class="mb-3 row">
                <label for="remarks" class="col-sm-3 col-form-label fw-bold">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="remarks" id="remarks" rows="4" 
                              class="form-control bg-dark text-light border-secondary" 
                              placeholder="Any additional remarks or updates...">{{ old('remarks', $case->remarks) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success rounded-pill px-4 me-2">
                    <i class="bi bi-check-circle me-1"></i> Update Case
                </button>
                <a href="{{ route('bereavement-cases.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Cases
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Optional Hover Effects --}}
<style>
    .form-control:focus, .form-select:focus {
        border-color: #0dcaf0;
        box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
    }
    .btn:hover {
        transform: translateY(-2px);
        transition: 0.2s;
    }
</style>
@endsection