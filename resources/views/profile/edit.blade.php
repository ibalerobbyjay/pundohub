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

            <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label class="form-label text-light">Name</label>
                    <input type="text" name="name" class="form-control bg-dark text-light border-secondary"
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-light">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-light border-secondary"
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-light">Password (leave blank to keep current)</label>
                    <input type="password" name="password" class="form-control bg-dark text-light border-secondary">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-light">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control bg-dark text-light border-secondary">
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
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    const form = this;
    const formData = new FormData(form);

    // Optional: you can add Ajax submission if desired
});
</script>
@endsection
