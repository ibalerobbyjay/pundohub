@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-info text-center fw-bold">
        <i class="bi bi-file-earmark-medical-fill me-2 text-danger"></i> Report a Death
    </h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-dark text-light border-secondary shadow-lg rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('report.death.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name of Deceased -->
                <div class="mb-3">
                    <label for="name_of_deceased" class="form-label fw-semibold">Name of Deceased <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="name_of_deceased" 
                        name="name_of_deceased" 
                        value="{{ old('name_of_deceased') }}"
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        placeholder="Enter the full name"
                        required
                    >
                </div>

                <!-- Date of Death -->
                <div class="mb-3">
                    <label for="date_of_death" class="form-label fw-semibold">Date of Death <span class="text-danger">*</span></label>
                    <input 
                        type="date" 
                        id="date_of_death" 
                        name="date_of_death" 
                        value="{{ old('date_of_death') }}"
                        class="form-control bg-dark text-light border-secondary rounded-3"
                        required
                    >
                </div>

                <!-- Cause of Death -->
                <div class="mb-3">
                    <label for="cause_of_death" class="form-label fw-semibold">Cause of Death <span class="text-danger">*</span></label>
                    <select 
                        id="cause_of_death" 
                        name="cause_of_death" 
                        class="form-select bg-dark text-light border-secondary rounded-3"
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

                <!-- If Other is selected, show additional field -->
                <div class="mb-3" id="other_cause_field" style="display: {{ old('cause_of_death') == 'Other' ? 'block' : 'none' }};">
                    <label for="other_cause" class="form-label fw-semibold">Specify Cause</label>
                    <input 
                        type="text" 
                        id="other_cause" 
                        name="other_cause" 
                        value="{{ old('other_cause') }}"
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        placeholder="Please specify the cause of death"
                    >
                </div>

                <!-- Location of Death -->
                <div class="mb-3">
                    <label for="location_of_death" class="form-label fw-semibold">Location of Death <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="location_of_death" 
                        name="location_of_death" 
                        value="{{ old('location_of_death') }}"
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        placeholder="e.g., Hospital, Home, Nursing Home, etc."
                        required
                    >
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label for="notes" class="form-label fw-semibold">Additional Notes</label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="4" 
                        class="form-control bg-dark text-light border-secondary rounded-3"
                        placeholder="Optional: add any other relevant details...">{{ old('notes') }}</textarea>
                </div>

                <!-- Death Certificate Upload - PICTURES ONLY -->
                <div class="mb-4">
                    <label for="death_certificate" class="form-label fw-semibold">Upload Death Certificate (Picture Only) <span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        id="death_certificate" 
                        name="death_certificate" 
                        class="form-control bg-dark text-light border-secondary rounded-3" 
                        accept=".jpg,.jpeg,.png,.webp" 
                        required
                        onchange="previewImage(event)"
                    >
                    <small class="text-muted d-block mt-1">Accepted formats: JPG, JPEG, PNG, WEBP (max 2MB)</small>

                    <!-- Image Preview Area -->
                    <div id="imagePreview" class="mt-3 text-center"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                    <i class="bi bi-send me-1"></i> Submit Report
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = ''; // clear previous preview

        if (!file) return;

        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            preview.innerHTML = '<p class="text-danger mt-2"><i class="bi bi-exclamation-triangle"></i> Please select a valid image file (JPG, PNG, or WEBP)</p>';
            event.target.value = ''; // clear the file input
            return;
        }

        // Validate file size (2MB)
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes
        if (file.size > maxSize) {
            preview.innerHTML = '<p class="text-danger mt-2"><i class="bi bi-exclamation-triangle"></i> File size must be less than 2MB</p>';
            event.target.value = ''; // clear the file input
            return;
        }

        // Create and display image preview
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.classList.add('img-thumbnail', 'mt-2', 'shadow-sm');
        img.style.maxWidth = '300px';
        img.style.maxHeight = '300px';
        img.style.borderRadius = '8px';
        img.style.objectFit = 'contain';
        
        // Add loading text
        const loadingText = document.createElement('p');
        loadingText.className = 'text-muted small mt-1';
        loadingText.innerHTML = '<i class="bi bi-image"></i> Image Preview';
        
        preview.appendChild(loadingText);
        preview.appendChild(img);

        // Clean up URL when image is loaded
        img.onload = function() {
            URL.revokeObjectURL(img.src);
        }
    }

    // Show/hide other cause field
    document.getElementById('cause_of_death').addEventListener('change', function() {
        const otherCauseField = document.getElementById('other_cause_field');
        if (this.value === 'Other') {
            otherCauseField.style.display = 'block';
        } else {
            otherCauseField.style.display = 'none';
            document.getElementById('other_cause').value = '';
        }
    });

    // Real-time file validation
    document.getElementById('death_certificate').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // Additional validation on change
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            const maxSize = 2 * 1024 * 1024;
            
            if (!validTypes.includes(file.type)) {
                alert('Please select only image files (JPG, PNG, or WEBP)');
                event.target.value = '';
                return;
            }
            
            if (file.size > maxSize) {
                alert('File size must be less than 2MB');
                event.target.value = '';
                return;
            }
        }
    });
</script>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #0dcaf0;
        box-shadow: 0 0 0 0.2rem rgba(13, 202, 240, 0.25);
    }
    .img-thumbnail {
        border: 2px solid #0dcaf0;
    }
</style>
@endsection