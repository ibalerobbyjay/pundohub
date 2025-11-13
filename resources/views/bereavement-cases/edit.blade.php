@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4" 
                 style="background: rgba(161, 161, 161, 0.98); backdrop-filter: blur(10px);">
                <div class="card-body p-5">
                    {{-- Header Section --}}
                    <div class="text-center mb-5">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 70px; height: 70px;">
                            <i class="bi bi-pencil-square text-white" style="font-size: 1.8rem;"></i>
                        </div>
                        <h2 class="text-dark fw-bold mb-2">Edit Bereavement Case</h2>
                        <p class="text-muted">Update the bereavement case details</p>
                    </div>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                <div class="fw-medium">{{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('bereavement-cases.update', $case->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Basic Information Section --}}
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-tag-fill text-warning me-2"></i>Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="title" 
                                           id="title" 
                                           class="form-control border-0 rounded-3 bg-light"
                                           value="{{ old('title', $case->title) }}" required
                                           placeholder="Enter case title">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="user_id" class="form-label fw-semibold text-dark">
                                        <i class="bi bi-person-fill text-warning me-2"></i>Select Member <span class="text-danger">*</span>
                                    </label>
                                    <select name="user_id" id="user_id" 
                                            class="form-select border-0 rounded-3 bg-light" required>
                                        <option value="">-- Select Member --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $case->user_id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ ucfirst($user->role) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Date of Death --}}
                        <div class="mb-4">
                            <label for="date_of_death" class="form-label fw-semibold text-dark">
                                <i class="bi bi-calendar-event-fill text-warning me-2"></i>Date of Death <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="date_of_death" 
                                   id="date_of_death" 
                                   class="form-control border-0 rounded-3 bg-light"
                                   value="{{ old('date_of_death', $case->date_of_death->format('Y-m-d')) }}" required>
                        </div>

                        {{-- Case Details Section --}}
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning rounded p-2 me-3">
                                    <i class="bi bi-file-text-fill text-white"></i>
                                </div>
                                <h5 class="text-dark fw-bold mb-0">Case Details</h5>
                            </div>
                            
                            <div class="card border-0 rounded-4 bg-light">
                                <div class="card-body p-4">
                                    <div class="row">
                                        {{-- What --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="description_what" class="form-label text-dark fw-medium">
                                                Type of Service/Event <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="description_what" 
                                                   id="description_what" 
                                                   class="form-control border-0 rounded-3 bg-white"
                                                   value="{{ old('description_what', $case->description_what) }}" required
                                                   placeholder="e.g., Wake Service, Funeral, Memorial Mass">
                                        </div>

                                        {{-- When --}}
                                        <div class="col-md-6 mb-3">
                                            <label for="description_when" class="form-label text-dark fw-medium">
                                                Date & Time <span class="text-danger">*</span>
                                            </label>
                                            <input type="datetime-local" 
                                                   name="description_when" 
                                                   id="description_when" 
                                                   class="form-control border-0 rounded-3 bg-white"
                                                   value="{{ old('description_when', $case->description_when ? \Carbon\Carbon::parse($case->description_when)->format('Y-m-d\TH:i') : '') }}" required>
                                        </div>
                                    </div>

                                    {{-- Where --}}
                                    <div class="mb-3">
                                        <label for="description_where" class="form-label text-dark fw-medium">
                                            Location <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="description_where" 
                                               id="description_where" 
                                               class="form-control border-0 rounded-3 bg-white"
                                               value="{{ old('description_where', $case->description_where) }}" required
                                               placeholder="e.g., St. Mary's Church, Family Residence">
                                    </div>

                                    {{-- Name of Deceased --}}
                                    <div class="mb-3">
                                        <label for="description_name" class="form-label text-dark fw-medium">
                                            Name of Deceased <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               name="description_name" 
                                               id="description_name" 
                                               class="form-control border-0 rounded-3 bg-white"
                                               value="{{ old('description_name', $case->description_name) }}" required
                                               placeholder="Full name of the deceased">
                                    </div>

                                    {{-- Additional Notes --}}
                                    <div class="mb-3">
                                        <label for="description_notes" class="form-label text-dark fw-medium">
                                            Additional Notes
                                        </label>
                                        <textarea name="description_notes" 
                                                  id="description_notes" 
                                                  class="form-control border-0 rounded-3 bg-white" 
                                                  rows="3"
                                                  placeholder="Any additional information about the case...">{{ old('description_notes', $case->description_notes) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Remarks Section --}}
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-info rounded p-2 me-3">
                                    <i class="bi bi-chat-left-text-fill text-white"></i>
                                </div>
                                <h5 class="text-dark fw-bold mb-0">Remarks</h5>
                            </div>
                            <textarea name="remarks" 
                                      id="remarks" 
                                      class="form-control border-0 rounded-3 bg-light" 
                                      rows="4"
                                      placeholder="Any additional remarks or updates...">{{ old('remarks', $case->remarks) }}</textarea>
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                            <a href="{{ route('bereavement-cases.index') }}" class="btn btn-outline-secondary rounded-3 px-4">
                                <i class="bi bi-arrow-left me-2"></i> Back to Cases
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('bereavement-cases.show', $case->id) }}" class="btn btn-outline-info rounded-3 px-4">
                                    <i class="bi bi-eye me-2"></i> View Case
                                </a>
                                <button type="submit" class="btn btn-warning text-white fw-bold rounded-3 px-4 py-2">
                                    <i class="bi bi-check-circle me-2"></i> Update Case
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Enhanced Styling --}}
<style>
    .form-control, .form-select {
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
        border-color: #ffc107;
        background-color: #ffffff;
        transform: translateY(-2px);
    }
    
    .form-control::placeholder {
        color: #6c757d;
        opacity: 0.7;
    }
    
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: white !important;
    }
    
    .btn-warning:active {
        transform: translateY(0);
    }
    
    .btn-outline-secondary {
        border: 2px solid #6c757d;
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }
    
    .btn-outline-info {
        border: 2px solid #0dcaf0;
        color: #0dcaf0;
        transition: all 0.3s ease;
    }
    
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(13, 202, 240, 0.3);
    }
    
    .alert-success {
        background: linear-gradient(135deg, #d1e7dd, #badbcc);
        border: none;
        color: #0f5132;
    }
    
    label {
        margin-bottom: 0.5rem;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #ffc107;
        border-radius: 10px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #e0a800;
    }
    
    /* Animation for form elements */
    .form-control, .form-select, .btn {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Staggered animation for form groups */
    .mb-4, .mb-3 {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }
    
    .mb-4:nth-child(1) { animation-delay: 0.1s; }
    .mb-4:nth-child(2) { animation-delay: 0.2s; }
    .mb-3:nth-child(1) { animation-delay: 0.3s; }
    .mb-3:nth-child(2) { animation-delay: 0.4s; }
    .mb-3:nth-child(3) { animation-delay: 0.5s; }
    .mb-3:nth-child(4) { animation-delay: 0.6s; }
    
    /* Status indicator */
    .status-indicator {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
    }
    
    .status-active {
        background-color: #198754;
    }
    
    .status-pending {
        background-color: #ffc107;
    }
    
    .status-completed {
        background-color: #6c757d;
    }
</style>

{{-- Optional: Add some JavaScript for enhanced interactivity --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add focus effects to form elements
        const formElements = document.querySelectorAll('.form-control, .form-select');
        
        formElements.forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            element.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
        
        // Character counters for textareas
        const textareas = [
            { element: 'description_notes', max: 500 },
            { element: 'remarks', max: 1000 }
        ];
        
        textareas.forEach(textareaConfig => {
            const textarea = document.getElementById(textareaConfig.element);
            if (textarea) {
                const counter = document.createElement('div');
                counter.className = 'form-text text-end text-muted small mt-1';
                counter.textContent = `0/${textareaConfig.max} characters`;
                textarea.parentNode.appendChild(counter);
                
                textarea.addEventListener('input', function() {
                    const length = this.value.length;
                    counter.textContent = `${length}/${textareaConfig.max} characters`;
                    
                    if (length > textareaConfig.max) {
                        counter.classList.add('text-danger');
                    } else {
                        counter.classList.remove('text-danger');
                    }
                });
                
                // Trigger input event to set initial count
                textarea.dispatchEvent(new Event('input'));
            }
        });
        
        // Auto-save draft functionality (optional)
        let autoSaveTimeout;
        const form = document.querySelector('form');
        
        form.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Here you could implement auto-save functionality
                console.log('Form data changed - could auto-save here');
            }, 2000);
        });
    });
</script>
@endsection