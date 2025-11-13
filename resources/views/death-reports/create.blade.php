@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- Header Section --}}
    <div class="text-center mb-5">
        <div class="bg-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
             style="width: 70px; height: 70px;">
            <i class="bi bi-file-earmark-medical-fill text-white" style="font-size: 1.8rem;"></i>
        </div>
        <h2 class="text-light fw-bold mb-2">Report a Death</h2>
        <p class="text-light">Submit a death report with required documentation</p>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div class="fw-medium">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <h6 class="fw-bold mb-2">Please fix the following errors:</h6>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Report Form Card --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-5">
            <form action="{{ route('report.death.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Left Column --}}
                    <div class="col-lg-6">
                        {{-- Name of Deceased --}}
                        <div class="mb-4">
                            <label for="name_of_deceased" class="form-label fw-semibold text-dark">
                                <i class="bi bi-person-fill text-danger me-2"></i>Name of Deceased <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name_of_deceased" 
                                name="name_of_deceased" 
                                value="{{ old('name_of_deceased') }}"
                                class="form-control border-0 rounded-3 bg-light" 
                                placeholder="Enter the full name of the deceased"
                                required
                            >
                        </div>

                        {{-- Date of Death --}}
                        <div class="mb-4">
                            <label for="date_of_death" class="form-label fw-semibold text-dark">
                                <i class="bi bi-calendar-event-fill text-danger me-2"></i>Date of Death <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="date_of_death" 
                                name="date_of_death" 
                                value="{{ old('date_of_death') }}"
                                class="form-control border-0 rounded-3 bg-light"
                                required
                            >
                        </div>

                        {{-- Cause of Death --}}
                        <div class="mb-4">
                            <label for="cause_of_death" class="form-label fw-semibold text-dark">
                                <i class="bi bi-heart-pulse-fill text-danger me-2"></i>Cause of Death <span class="text-danger">*</span>
                            </label>
                            <select 
                                id="cause_of_death" 
                                name="cause_of_death" 
                                class="form-select border-0 rounded-3 bg-light"
                                required
                            >
                                <option value="">Select cause of death</option>
                                <option value="Natural Causes" {{ old('cause_of_death') == 'Natural Causes' ? 'selected' : '' }}>Natural Causes</option>
                                <option value="Illness" {{ old('cause_of_death') == 'Illness' ? 'selected' : '' }}>Illness</option>
                                <option value="Accident" {{ old('cause_of_death') == 'Accident' ? 'selected' : '' }}>Accident</option>
                                <option value="Old Age" {{ old('cause_of_death') == 'Old Age' ? 'selected' : '' }}>Old Age</option>
                                <option value="Cardiac Arrest" {{ old('cause_of_death') == 'Cardiac Arrest' ? 'selected' : '' }}>Cardiac Arrest</option>
                                <option value="Respiratory Failure" {{ old('cause_of_death') == 'Respiratory Failure' ? 'selected' : '' }}>Respiratory Failure</option>
                                <option value="Other" {{ old('cause_of_death') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        {{-- Other Cause Field --}}
                        <div class="mb-4" id="other_cause_field" style="display: {{ old('cause_of_death') == 'Other' ? 'block' : 'none' }};">
                            <label for="other_cause" class="form-label fw-semibold text-dark">
                                <i class="bi bi-pencil-fill text-warning me-2"></i>Specify Cause
                            </label>
                            <input 
                                type="text" 
                                id="other_cause" 
                                name="other_cause" 
                                value="{{ old('other_cause') }}"
                                class="form-control border-0 rounded-3 bg-light" 
                                placeholder="Please specify the cause of death"
                            >
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-lg-6">
                        {{-- Location of Death --}}
                        <div class="mb-4">
                            <label for="location_of_death" class="form-label fw-semibold text-dark">
                                <i class="bi bi-geo-alt-fill text-danger me-2"></i>Location of Death <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="location_of_death" 
                                name="location_of_death" 
                                value="{{ old('location_of_death') }}"
                                class="form-control border-0 rounded-3 bg-light" 
                                placeholder="e.g., Hospital, Home, Nursing Home, etc."
                                required
                            >
                        </div>

                        {{-- Additional Notes --}}
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold text-dark">
                                <i class="bi bi-sticky-fill text-info me-2"></i>Additional Notes
                            </label>
                            <textarea 
                                id="notes" 
                                name="notes" 
                                rows="4" 
                                class="form-control border-0 rounded-3 bg-light"
                                placeholder="Optional: add any other relevant details...">{{ old('notes') }}</textarea>
                            <div class="form-text text-end text-muted small mt-1">
                                <span id="notes-counter">0</span>/500 characters
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Death Certificate Upload --}}
                <div class="mb-4">
                    <div class="card border-0 bg-light rounded-4">
                        <div class="card-body">
                            <label for="death_certificate" class="form-label fw-semibold text-dark">
                                <i class="bi bi-cloud-arrow-up-fill text-primary me-2"></i>Upload Death Certificate (Picture Only) <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="file" 
                                id="death_certificate" 
                                name="death_certificate" 
                                class="form-control border-0 rounded-3 bg-white" 
                                accept=".jpg,.jpeg,.png,.webp" 
                                required
                                onchange="previewImage(event)"
                            >
                            <div class="form-text text-muted mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Accepted formats: JPG, JPEG, PNG, WEBP (max 2MB)
                            </div>

                            {{-- Image Preview Area --}}
                            <div id="imagePreview" class="mt-3 text-center"></div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-3 px-4">
                        <i class="bi bi-arrow-left me-2"></i> Back to Dashboard
                    </a>
                    <button type="submit" class="btn btn-danger text-white fw-bold rounded-3 px-4 py-2">
                        <i class="bi bi-send-fill me-2"></i> Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Enhanced Styling --}}
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .form-control, .form-select {
        transition: all 0.3s ease;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
        border-color: #dc3545;
        background-color: #ffffff;
        transform: translateY(-2px);
    }

    .form-control::placeholder {
        color: #6c757d;
        opacity: 0.7;
    }

    .btn {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
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

    .alert-success {
        background: linear-gradient(135deg, #d1e7dd, #badbcc);
        border: none;
        color: #0f5132;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        border: none;
        color: #721c24;
    }

    .img-thumbnail {
        border: 3px solid #dc3545;
        transition: all 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
    }

    /* Animation for form elements */
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

    .form-control, .form-select, .btn {
        animation: fadeInUp 0.6s ease-out;
    }

    /* Staggered animation for form groups */
    .mb-4 {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }

    .mb-4:nth-child(1) { animation-delay: 0.1s; }
    .mb-4:nth-child(2) { animation-delay: 0.2s; }
    .mb-4:nth-child(3) { animation-delay: 0.3s; }
    .mb-4:nth-child(4) { animation-delay: 0.4s; }
    .mb-4:nth-child(5) { animation-delay: 0.5s; }

    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 6px;
    }

    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    textarea::-webkit-scrollbar-thumb {
        background: #dc3545;
        border-radius: 10px;
    }

    textarea::-webkit-scrollbar-thumb:hover {
        background: #c82333;
    }
</style>

{{-- JavaScript for enhanced interactivity --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for notes textarea
        const notesTextarea = document.getElementById('notes');
        const notesCounter = document.getElementById('notes-counter');
        
        if (notesTextarea && notesCounter) {
            notesTextarea.addEventListener('input', function() {
                const length = this.value.length;
                notesCounter.textContent = length;
                
                if (length > 500) {
                    notesCounter.classList.add('text-danger');
                } else {
                    notesCounter.classList.remove('text-danger');
                }
            });
            
            // Trigger input event to set initial count
            notesTextarea.dispatchEvent(new Event('input'));
        }

        // Show/hide other cause field
        const causeOfDeathSelect = document.getElementById('cause_of_death');
        const otherCauseField = document.getElementById('other_cause_field');
        
        if (causeOfDeathSelect && otherCauseField) {
            causeOfDeathSelect.addEventListener('change', function() {
                if (this.value === 'Other') {
                    otherCauseField.style.display = 'block';
                    // Add animation
                    otherCauseField.style.animation = 'fadeInUp 0.3s ease-out';
                } else {
                    otherCauseField.style.display = 'none';
                    document.getElementById('other_cause').value = '';
                }
            });
        }

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

        // Set maximum date for date of death to today
        const dateOfDeathInput = document.getElementById('date_of_death');
        if (dateOfDeathInput) {
            const today = new Date().toISOString().split('T')[0];
            dateOfDeathInput.max = today;
        }
    });

    // Image Preview Function
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // clear previous preview

        if (!file) return;

        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            preview.innerHTML = `
                <div class="alert alert-danger border-0 rounded-3 mt-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Please select a valid image file (JPG, PNG, or WEBP)
                </div>
            `;
            event.target.value = ''; // clear the file input
            return;
        }

        // Validate file size (2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if (file.size > maxSize) {
            preview.innerHTML = `
                <div class="alert alert-danger border-0 rounded-3 mt-2">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    File size must be less than 2MB
                </div>
            `;
            event.target.value = ''; // clear the file input
            return;
        }

        // Create and display image preview
        const imgContainer = document.createElement('div');
        imgContainer.className = 'd-flex flex-column align-items-center';
        
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.classList.add('img-thumbnail', 'mt-2', 'shadow-sm');
        img.style.maxWidth = '300px';
        img.style.maxHeight = '300px';
        img.style.borderRadius = '12px';
        img.style.objectFit = 'contain';
        
        // Add file info
        const fileInfo = document.createElement('div');
        fileInfo.className = 'mt-2 text-center';
        fileInfo.innerHTML = `
            <small class="text-muted">
                <i class="bi bi-check-circle-fill text-success me-1"></i>
                File selected: ${file.name}<br>
                Size: ${(file.size / 1024 / 1024).toFixed(2)} MB
            </small>
        `;
        
        imgContainer.appendChild(img);
        imgContainer.appendChild(fileInfo);
        preview.appendChild(imgContainer);

        // Clean up URL when image is loaded
        img.onload = function() {
            URL.revokeObjectURL(img.src);
        }
    }

    // Enhanced file validation
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('death_certificate');
        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Additional validation on change
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                    const maxSize = 2 * 1024 * 1024;
                    
                    if (!validTypes.includes(file.type)) {
                        // Show error using SweetAlert if available, otherwise use native alert
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid File Type',
                                text: 'Please select only image files (JPG, PNG, or WEBP)',
                                confirmButtonColor: '#dc3545'
                            });
                        } else {
                            alert('Please select only image files (JPG, PNG, or WEBP)');
                        }
                        event.target.value = '';
                        return;
                    }
                    
                    if (file.size > maxSize) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Too Large',
                                text: 'File size must be less than 2MB',
                                confirmButtonColor: '#dc3545'
                            });
                        } else {
                            alert('File size must be less than 2MB');
                        }
                        event.target.value = '';
                        return;
                    }
                }
            });
        }
    });
</script>

{{-- Optional: Include SweetAlert2 for enhanced notifications --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
@endsection