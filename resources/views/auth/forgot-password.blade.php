@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card border-0 shadow-lg rounded-4 bg-dark text-light px-4 py-5"
         style="background: rgba(20,20,20,0.85); backdrop-filter: blur(12px); max-width: 500px; width: 100%;">

        <div class="text-center mb-4">
            <i class="bi bi-key-fill text-warning fs-1 mb-3"></i>
            <h3 class="fw-bold text-info">Forgot Password</h3>
            <p class="text-secondary small mt-2">
                No worries! Enter your registered email and we’ll send you a reset link.
            </p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="form-label text-light">Email Address <span class="text-danger">*</span></label>
                <input id="email" type="email" name="email"
                       class="form-control bg-dark text-light border-secondary rounded-3 shadow-sm"
                       placeholder="Enter your registered email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill shadow-sm py-2 fw-semibold">
                    <i class="bi bi-envelope-paper me-1"></i> Send Password Reset Link
                </button>
            </div>

            {{-- Back to Login --}}
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none text-info small">
                    <i class="bi bi-arrow-left-circle me-1"></i> Back to Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
