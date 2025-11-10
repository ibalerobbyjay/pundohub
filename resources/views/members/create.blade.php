@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 border-0 bg-dark text-light"
         style="background: rgba(20,20,20,0.85); backdrop-filter: blur(12px);">
        
        <div class="card-body p-4">
            <h2 class="mb-4 text-info text-center fw-bold">
                <i class="bi bi-person-plus-fill me-2 text-warning"></i> Add New Member
            </h2>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form id="memberForm" action="{{ route('members.store') }}" method="POST">
                @csrf

                {{-- Name --}}
                <div class="mb-3">
                    <label class="form-label text-light">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" 
                           class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                           placeholder="Enter member name" value="{{ old('name') }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label text-light">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" 
                           class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                           placeholder="Enter email address" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    {{-- Password --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-light">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" 
                               class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                               placeholder="Enter password" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-light">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" 
                               class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                               placeholder="Confirm password" required>
                    </div>
                </div>

                {{-- Household --}}
                <div class="mb-3">
                    <label class="form-label text-light">Household</label>
                    <select name="household" class="form-select bg-dark text-light border-secondary rounded-3 shadow-sm">
                        <option value="" selected disabled>Select Purok</option>
                        @for ($i = 1; $i <= 7; $i++)
                            <option value="Purok {{ $i }}" {{ old('household') == "Purok $i" ? 'selected' : '' }}>
                                Purok {{ $i }}
                            </option>
                        @endfor
                    </select>
                    @error('household')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Contact --}}
                <div class="mb-3">
                    <label class="form-label text-light">Contact Number</label>
                    <input type="text" name="contact" id="contact" 
                           class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm" 
                           placeholder="09XXXXXXXXX" maxlength="11" pattern="09\d{9}" 
                           title="Enter an 11-digit Philippine mobile number starting with 09" 
                           value="{{ old('contact') }}">
                    @error('contact')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Role & Job Type --}}
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label text-light">Role <span class="text-danger">*</span></label>
        <select name="role" id="role" class="form-select bg-dark text-light border-secondary rounded-3 shadow-sm" required>
            <option value="" selected disabled>Select Role</option>
            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
        @error('role')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mb-3" id="jobTypeDiv" style="display: none;">
        <label class="form-label text-light">Staff Job Type</label>
        <select name="job_type" class="form-select bg-dark text-light border-secondary rounded-3 shadow-sm">
            <option value="" selected disabled>Select Job Type</option>
            <option value="cook" {{ old('job_type') == 'cook' ? 'selected' : '' }}>Cook</option>
            <option value="dishwasher" {{ old('job_type') == 'dishwasher' ? 'selected' : '' }}>Dishwasher</option>
           
        </select>
        @error('job_type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

                {{-- Buttons --}}
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('members.index') }}" 
                       class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-save2 me-1"></i> Save Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    const contactInput = document.getElementById('contact');

    contactInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');
        if (!this.value.startsWith('09')) this.value = '09';
        if (this.value.length > 11) this.value = this.value.slice(0, 11);
    });

    document.getElementById('memberForm').addEventListener('submit', function(e) {
        const contactValue = contactInput.value;
        if (!/^09\d{9}$/.test(contactValue)) {
            e.preventDefault();
            alert("Please enter a valid 11-digit number starting with 09.");
            return;
        }
        contactInput.value = '+63' + contactValue.substring(1);
    });
</script>
<script>
    const roleSelect = document.getElementById('role');
    const jobTypeDiv = document.getElementById('jobTypeDiv');

    roleSelect.addEventListener('change', function() {
        if(this.value === 'staff'){
            jobTypeDiv.style.display = 'block';
        } else {
            jobTypeDiv.style.display = 'none';
        }
    });
</script>
@endsection
