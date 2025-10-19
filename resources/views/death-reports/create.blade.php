@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-white">Report a Death</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card bg-dark text-white border-secondary shadow-lg rounded-4">
        <div class="card-body">
            <form action="{{ route('report.death.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name of Deceased -->
                <div class="mb-3">
                    <label for="name_of_deceased" class="form-label">Name of Deceased <span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        id="name_of_deceased" 
                        name="name_of_deceased" 
                        value="{{ old('name_of_deceased') }}"
                        class="form-control bg-dark text-white border-secondary" 
                        placeholder="Enter the full name"
                        required
                    >
                </div>

                <!-- Date of Death -->
                <div class="mb-3">
                    <label for="date_of_death" class="form-label">Date of Death <span class="text-danger">*</span></label>
                    <input 
                        type="date" 
                        id="date_of_death" 
                        name="date_of_death" 
                        value="{{ old('date_of_death') }}"
                        class="form-control bg-dark text-white border-secondary"
                        required
                    >
                </div>

                <!-- Notes -->
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="4" 
                        class="form-control bg-dark text-white border-secondary"
                        placeholder="Optional: add any relevant details...">{{ old('notes') }}</textarea>
                </div>

                <!-- Death Certificate Upload -->
                <div class="mb-4">
                    <label for="death_certificate" class="form-label">Upload Death Certificate <span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        id="death_certificate" 
                        name="death_certificate" 
                        class="form-control bg-dark text-white border-secondary" 
                        accept=".jpg,.jpeg,.png,.pdf" 
                        required
                        onchange="previewFile(event)"
                    >
                    <small class="text-muted">Accepted formats: JPG, PNG, or PDF (max 2MB)</small>

                    <!-- Preview Area -->
                    <div id="filePreview" class="mt-3"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-send me-1"></i> Submit Report
                </button>
            </form>
        </div>
    </div>
</div>

<!-- File Preview Script -->
<script>
    function previewFile(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('filePreview');
        preview.innerHTML = ''; // clear previous

        if (!file) return;

        if (file.type.includes('image')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.classList.add('img-thumbnail', 'mt-2');
            img.style.maxWidth = '200px';
            preview.appendChild(img);
        } else if (file.type === 'application/pdf') {
            preview.innerHTML = '<p class="text-info mt-2"><i class="bi bi-file-earmark-pdf"></i> PDF file selected: ' + file.name + '</p>';
        } else {
            preview.innerHTML = '<p class="text-warning mt-2">Unsupported file type selected.</p>';
        }
    }
</script>
@endsection
