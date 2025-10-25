<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PundoHub</title>

    <!-- ✅ Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #1c1f26, #2a2f38);
        color: #fff;
        overflow-x: hidden;
    }

    header {
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
    }

    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        background: url("{{ asset('images/background.jpg') }}") no-repeat center center/cover;
        position: relative;
    }

    .hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
    }

    .hero-content {
        position: relative;
        z-index: 1;
        max-width: 700px;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
    }

    .hero p {
        font-size: 1.2rem;
        color: #dcdcdc;
        margin: 20px 0;
    }

    /* ✅ White Button */
    .btn-login {
        background-color: #fff;
        color: black;
        font-weight: 600;
        border: none;
        padding: 12px 28px;
        border-radius: 30px;
        transition: 0.3s ease;
        position: relative;
        box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
    }

    .btn-login:hover {
        background-color: #e6e6e6;
        box-shadow: 0 6px 15px rgba(255, 255, 255, 0.4);
    }

    footer {
        text-align: center;
        padding: 20px 0;
        background-color: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(10px);
    }

    .spinner-border {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }

    .loading {
        pointer-events: none;
        opacity: 0.8;
    }

    a {
        cursor: pointer;
    }

    /* ✅ Modal Styling - switched orange to white */
    .modal-content {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: #fff;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .modal-content:hover {
        box-shadow: 0 0 30px rgba(255, 255, 255, 0.35);
    }

    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.4);
    }

    .modal-title {
        font-weight: 700;
        color: #fff;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        border-radius: 10px;
        transition: border-color 0.2s ease, background 0.2s ease;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: white;
        box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
    }

    .form-label {
        color: #fff;
        font-weight: 500;
    }

    .form-check-label {
        color: #ddd;
    }

    .btn-close {
        filter: invert(1);
    }

    .modal-body a {
        color: #fff;
        transition: color 0.2s ease;
    }

    .modal-body a:hover {
        color: #ccc;
        text-decoration: underline;
    }

    .modal.fade .modal-dialog {
        transform: translateY(-20px);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: translateY(0);
    }

    .modal-body p {
        color: #fff !important;
        font-weight: 400;
    }

</style>

</head>
<body>

    <!-- ✅ Navbar -->
    <header class="py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="me-2" style="width: 50px; height: 50px; border-radius: 50%;">
                <h4 class="mb-0 fw-bold">
                    Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 4px;">Hub</span>
                </h4>
            </div>
            <div>
                <button class="btn btn-login" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Log In
                </button>
            </div>
        </div>
    </header>

    <!-- ✅ Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>
                Welcome to Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 6px;">Hub</span>
            </h1>

            <p>PundoHub is a compassionate platform designed to support families in times of loss. 
               We connect communities, manage bereavement cases, and streamline donations with transparency and care.</p>
            <button class="btn btn-login mt-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                Get Started
            </button>
        </div>
    </section>

    <!-- ✅ Footer -->
    <footer>
        <p class="mb-0">
            &copy; {{ date('Y') }} Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 4px;">Hub</span>. 
            All rights reserved.
        </p>
    </footer>

    <!-- ✅ Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-dark rounded-4">
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">
                Log In to Pundo<span style="background-color: white; color: black; padding: 2px 6px; border-radius: 4px;">Hub</span>
            </h5>

            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Remember me</label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a class="small text-decoration-none" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">
                        Forgot password?
                    </a>
                    <button type="submit" id="loginBtn" class="btn btn-login d-flex align-items-center justify-content-center">
                        <span class="btn-text">Log In</span>
                        <span class="spinner-border spinner-border-sm text-dark ms-2 d-none" role="status"></span>
                    </button>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-dark rounded-4">
          <div class="modal-header">
            <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="text-muted mb-3">Enter your email address and we'll send you a password reset link.</p>
            
            <form id="forgotForm" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="forgot_email" class="form-label">Email</label>
                    <input id="forgot_email" class="form-control" type="email" name="email" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a class="small text-decoration-none" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#loginModal">
                        Back to login
                    </a>
                    <button type="submit" id="forgotBtn" class="btn btn-login d-flex align-items-center justify-content-center">
                        <span class="btn-text">Send Reset Link</span>
                        <span class="spinner-border spinner-border-sm text-dark ms-2 d-none" role="status"></span>
                    </button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Loading Spinner Script -->
    <script>
        function handleLoading(formId, btnId) {
            const form = document.getElementById(formId);
            const btn = document.getElementById(btnId);
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.btn-text');

            form.addEventListener('submit', function() {
                btn.classList.add('loading');
                spinner.classList.remove('d-none');
                text.textContent = 'Please wait...';
            });
        }

        handleLoading('loginForm', 'loginBtn');
        handleLoading('forgotForm', 'forgotBtn');
    </script>
</body>
</html>
