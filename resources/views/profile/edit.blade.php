@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 bg-dark text-light"
         style="background: rgba(25,25,25,0.9); backdrop-filter: blur(12px);">
        <div class="card-body p-4">
            <h2 class="mb-4 fw-bold text-info text-center">
                <i class="bi bi-person-circle me-2 text-warning"></i> Edit Profile
            </h2>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
                    <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Profile Picture Section -->
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        <!-- Current Profile Picture -->
                        <div class="mb-3">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                     alt="Profile Picture" 
                                     class="img-thumbnail rounded-circle shadow-sm"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 150px; height: 150px;">
                                    <i class="bi bi-person-fill text-light" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Upload Button -->
                        <div class="mb-3">
                            <input type="file" 
                                   name="profile_picture" 
                                   id="profile_picture" 
                                   class="form-control bg-dark text-light border-secondary d-none"
                                   accept="image/*"
                                   onchange="previewImage(event)">
                            <label for="profile_picture" class="btn btn-outline-info btn-sm rounded-pill w-100">
                                <i class="bi bi-camera me-1"></i> Change Photo
                            </label>
                            @error('profile_picture')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Remove Picture Button (only show if user has a profile picture) -->
                        @if($user->profile_picture)
                            <button type="button" 
                                    class="btn btn-outline-danger btn-sm rounded-pill w-100"
                                    onclick="removeProfilePicture()">
                                <i class="bi bi-trash me-1"></i> Remove
                            </button>
                        @endif
                    </div>

                    <div class="col-md-9">
                        <!-- Image Preview -->
                        <div id="imagePreview" class="mb-3 text-center" style="display: none;">
                            <p class="text-info small mb-2">New Profile Picture Preview:</p>
                            <img id="preview" class="img-thumbnail rounded-circle shadow-sm"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        </div>

                        <!-- Profile Information -->
                        <div class="mb-3">
                            <label class="form-label text-light">Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light">Contact Number</label>
                            <input type="text" 
                                   name="contact" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   value="{{ old('contact', $user->contact) }}"
                                   placeholder="09XXXXXXXXX">
                            @error('contact')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light">Household</label>
                            <select name="household" class="form-select bg-dark text-light border-secondary rounded-3">
                                <option value="">Select Purok</option>
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="Purok {{ $i }}" 
                                            {{ old('household', $user->household) == "Purok $i" ? 'selected' : '' }}>
                                        Purok {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('household')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="card bg-dark border-secondary rounded-3 mb-4">
                    <div class="card-body">
                        <h5 class="text-info mb-3">
                            <i class="bi bi-shield-lock me-2"></i> Change Password
                        </h5>
                        <div class="mb-3">
                            <label class="form-label text-light">Current Password</label>
                            <input type="password" 
                                   name="current_password" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   placeholder="Enter current password">
                            @error('current_password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light">New Password (leave blank to keep current)</label>
                            <input type="password" 
                                   name="password" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   placeholder="Enter new password">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-light">Confirm New Password</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control bg-dark text-light border-secondary rounded-3"
                                   placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save2 me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Preview image before upload
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Remove profile picture
function removeProfilePicture() {
    if (confirm('Are you sure you want to remove your profile picture?')) {
        // You can implement AJAX call to remove the picture
        // or add a hidden field to indicate removal
        const form = document.getElementById('profileForm');
        const removeInput = document.createElement('input');
        removeInput.type = 'hidden';
        removeInput.name = 'remove_profile_picture';
        removeInput.value = '1';
        form.appendChild(removeInput);
        
        // Submit the form
        form.submit();
    }
}

// Optional: Add form validation
document.getElementById('profileForm').addEventListener('submit', function(e) {
    const password = document.querySelector('input[name="password"]').value;
    const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
    
    if (password && password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
        return false;
    }
});
</script>

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