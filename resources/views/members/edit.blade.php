@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- Header Section --}}
    <div class="text-center mb-5">
        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
             style="width: 70px; height: 70px;">
            <i class="bi bi-person-fill-gear text-white" style="font-size: 1.8rem;"></i>
        </div>
        <h2 class="text-light fw-bold mb-2">Edit Member</h2>
        <p class="text-light">Update member information and settings</p>
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

    {{-- Member Form Card --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-body p-5">
            <form id="memberForm" action="{{ route('members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Current Member Info --}}
                <div class="card bg-light border-0 rounded-4 mb-4">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i class="bi bi-info-circle text-info me-2"></i>Current Member Information
                        </h6>
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted d-block">Member ID</small>
                                <strong class="text-dark">#{{ $member->id }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Registration Date</small>
                                <strong class="text-dark">{{ $member->created_at->format('M d, Y') }}</strong>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted d-block">Last Updated</small>
                                <strong class="text-dark">{{ $member->updated_at->format('M d, Y') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Left Column --}}
                    <div class="col-lg-6">
                        {{-- Name --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-person-fill text-primary me-2"></i>Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" 
                                   class="form-control border-0 rounded-3 bg-light" 
                                   placeholder="Enter member's full name" value="{{ old('name', $member->name) }}" required>
                            @error('name')
                                <small class="text-danger mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" 
                                   class="form-control border-0 rounded-3 bg-light" 
                                   placeholder="Enter email address" value="{{ old('email', $member->email) }}" required>
                            @error('email')
                                <small class="text-danger mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Household --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-house-fill text-info me-2"></i>Household
                            </label>
                            <select name="household" class="form-select border-0 rounded-3 bg-light">
                                <option value="" disabled>Select Purok</option>
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="Purok {{ $i }}" {{ old('household', $member->household) == "Purok $i" ? 'selected' : '' }}>
                                        Purok {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            @error('household')
                                <small class="text-danger mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-lg-6">
                        {{-- Contact --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-telephone-fill text-success me-2"></i>Contact Number
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">+63</span>
                                <input type="text" name="contact" id="contact" 
                                       class="form-control border-0 rounded-3 bg-light" 
                                       placeholder="9XXXXXXXXX" maxlength="10" pattern="9\d{9}" 
                                       title="Enter a 10-digit Philippine mobile number starting with 9" 
                                       value="{{ old('contact', str_replace('+63', '', $member->contact)) }}">
                            </div>
                            @error('contact')
                                <small class="text-danger mt-1">{{ $message }}</small>
                            @enderror
                            <div class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Format: 9XXXXXXXXX (10 digits)
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-person-badge-fill text-danger me-2"></i>Role <span class="text-danger">*</span>
                            </label>
                            <select name="role" id="role" class="form-select border-0 rounded-3 bg-light" required>
                                <option value="" disabled>Select Role</option>
                                <option value="member" {{ old('role', $member->role) == 'member' ? 'selected' : '' }}>Member</option>
                                <option value="admin" {{ old('role', $member->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <small class="text-danger mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Job Type --}}
                        <div class="mb-4" id="jobTypeDiv" style="display: {{ old('role', $member->role) == 'member' ? 'block' : 'none' }};">
                            <label class="form-label fw-semibold text-dark">
                                <i class="bi bi-briefcase-fill text-warning me-2"></i>Member Job Type <span class="text-danger">*</span>
                            </label>
                            <select name="job_type" class="form-select border-0 rounded-3 bg-light" {{ old('role', $member->role) == 'member' ? 'required' : '' }}>
                                <option value="" disabled>Select Job Type</option>
                                <option value="cook" {{ old('job_type', $member->job_type) == 'cook' ? 'selected' : '' }}>Cook</option>
                                <option value="dishwasher" {{ old('job_type', $member->job_type) == 'dishwasher' ? 'selected' : '' }}>Dishwasher</option>
                                <option value="cleaner" {{ old('job_type', $member->job_type) == 'cleaner' ? 'selected' : '' }}>Cleaner</option>
                                <option value="setup_crew" {{ old('job_type', $member->job_type) == 'setup_crew' ? 'selected' : '' }}>Setup Crew</option>
                                <option value="logistics" {{ old('job_type', $member->job_type) == 'logistics' ? 'selected' : '' }}>Logistics</option>
                                <option value="coordinator" {{ old('job_type', $member->job_type) == 'coordinator' ? 'selected' : '' }}>Coordinator</option>
                                <option value="finance" {{ old('job_type', $member->job_type) == 'finance' ? 'selected' : '' }}>Finance</option>
                                <option value="none" {{ old('job_type', $member->job_type) == 'none' ? 'selected' : '' }}>No Specific Job</option>
                            </select>
                            @error('job_type')
                                <small class="text-danger mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Password Reset Section --}}
                <div class="card bg-light border-0 rounded-4 mt-3">
                    <div class="card-body">
                        <h6 class="fw-semibold text-dark mb-3">
                            <i class="bi bi-key-fill text-warning me-2"></i>Password Reset (Optional)
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-dark">New Password</label>
                                    <input type="password" name="password" 
                                           class="form-control border-0 rounded-3 bg-white" 
                                           placeholder="Leave blank to keep current password">
                                    @error('password')
                                        <small class="text-danger mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-dark">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" 
                                           class="form-control border-0 rounded-3 bg-white" 
                                           placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>
                        <div class="form-text text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            Only fill these fields if you want to change the member's password
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="d-flex justify-content-between align-items-center pt-4 border-top mt-4">
                    <div class="d-flex gap-2">
                        <a href="{{ route('members.index') }}" 
                           class="btn btn-outline-secondary rounded-3 px-4">
                            <i class="bi bi-arrow-left me-2"></i> Back to Members
                        </a>
                        <a href="{{ route('members.show', $member->id) }}" 
                           class="btn btn-outline-info rounded-3 px-4">
                            <i class="bi bi-eye me-2"></i> View Profile
                        </a>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-warning rounded-3 px-4">
                            <i class="bi bi-arrow-clockwise me-2"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-warning text-white rounded-3 px-4 py-2">
                            <i class="bi bi-save me-2"></i> Update Member
                        </button>
                    </div>
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
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.15);
        border-color: #ffc107;
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

    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border: none;
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        color: white !important;
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

    .btn-outline-warning {
        border: 2px solid #ffc107;
        color: #ffc107;
        transition: all 0.3s ease;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }

    .alert-success {
        background: linear-gradient(135deg, #d1e7dd, #badbcc);
        border: none;
        color: #0f5132;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #495057;
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
    .mb-4:nth-child(6) { animation-delay: 0.6s; }

    /* Custom scrollbar for select */
    .form-select::-webkit-scrollbar {
        width: 6px;
    }

    .form-select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .form-select::-webkit-scrollbar-thumb {
        background: #ffc107;
        border-radius: 10px;
    }

    .form-select::-webkit-scrollbar-thumb:hover {
        background: #e0a800;
    }
</style>

{{-- JavaScript for enhanced interactivity --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const jobTypeDiv = document.getElementById('jobTypeDiv');
        const jobTypeSelect = jobTypeDiv.querySelector('select');
        const contactInput = document.getElementById('contact');

        // Show/hide job type based on role selection
        function toggleJobType() {
            if (roleSelect.value === 'member') {
                jobTypeDiv.style.display = 'block';
                jobTypeSelect.setAttribute('required', 'required');
            } else {
                jobTypeDiv.style.display = 'none';
                jobTypeSelect.removeAttribute('required');
                jobTypeSelect.value = '';
            }
        }

        // Initialize on page load
        toggleJobType();

        // Add event listener for role change
        roleSelect.addEventListener('change', toggleJobType);

        // Contact number validation
        contactInput.addEventListener('input', function () {
            // Remove any non-digit characters
            this.value = this.value.replace(/\D/g, '');
            
            // Ensure it starts with 9 and is exactly 10 digits
            if (this.value.length > 0 && !this.value.startsWith('9')) {
                this.value = '9' + this.value;
            }
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });

        // Form validation
        document.getElementById('memberForm').addEventListener('submit', function(e) {
            const contactValue = contactInput.value;
            
            // Validate contact number if provided
            if (contactValue && !/^9\d{9}$/.test(contactValue)) {
                e.preventDefault();
                alert("Please enter a valid 10-digit Philippine mobile number starting with 9.");
                contactInput.focus();
                return;
            }

            // Validate password if provided
            const password = document.querySelector('input[name="password"]').value;
            const passwordConfirm = document.querySelector('input[name="password_confirmation"]').value;
            
            if (password && password.length < 8) {
                e.preventDefault();
                alert("Password must be at least 8 characters long.");
                return;
            }

            if (password !== passwordConfirm) {
                e.preventDefault();
                alert("Passwords do not match.");
                return;
            }

            // Add +63 prefix to contact number before submission
            if (contactValue) {
                contactInput.value = '+63' + contactValue;
            }
        });

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

        // Reset form confirmation
        const resetButton = document.querySelector('button[type="reset"]');
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to reset all changes?')) {
                    e.preventDefault();
                }
            });
        }

        // Password strength indicator
        const passwordInput = document.querySelector('input[name="password"]');
        if (passwordInput) {
            const passwordHelp = document.createElement('div');
            passwordHelp.className = 'form-text mt-1';
            passwordInput.parentNode.appendChild(passwordHelp);

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                if (!password) {
                    passwordHelp.innerHTML = '';
                    return;
                }

                let strength = 'Weak';
                let color = 'text-danger';

                if (password.length >= 8) {
                    if (/[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
                        strength = 'Strong';
                        color = 'text-success';
                    } else if (/[A-Z]/.test(password) || /[0-9]/.test(password)) {
                        strength = 'Medium';
                        color = 'text-warning';
                    }
                }

                passwordHelp.innerHTML = `<span class="${color}"><i class="bi bi-shield-check me-1"></i>Password strength: ${strength}</span>`;
            });
        }
    });
</script>
@endsection