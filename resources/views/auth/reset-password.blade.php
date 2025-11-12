<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PundoHub | Forgot Password</title>

    <!-- ✅ Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background: radial-gradient(circle at center, #0b0b0b, #1b1b1b);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .forgot-card {
            background: rgba(25, 25, 25, 0.9);
            backdrop-filter: blur(14px);
            border-radius: 1rem;
            box-shadow: 0 0 25px rgba(255, 255, 255, 0.1);
            padding: 2.8rem;
            width: 100%;
            max-width: 420px;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.96);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-label {
            color: #f8f9fa;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ffffff;
            box-shadow: 0 0 10px #ffffff, 0 0 20px rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.12);
        }

        .btn-send {
            background-color: #ffffff;
            border: none;
            color: #000;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .btn-send:hover {
            background-color: #f8f9fa;
            box-shadow: 0 0 18px rgba(255, 255, 255, 0.6);
            transform: scale(1.04);
        }

        .logo {
            text-align: center;
            margin-bottom: 1.8rem;
        }

        .logo i {
            text-shadow: 0 0 12px rgba(255, 255, 255, 0.8);
        }

        .logo h3 {
            font-weight: 700;
            color: #fff;
            text-shadow: 0 0 12px rgba(255, 255, 255, 0.7);
        }

        .text-muted a {
            color: #ffffff;
            text-decoration: none;
            text-shadow: 0 0 6px rgba(255, 255, 255, 0.7);
            transition: 0.3s ease;
        }

        .text-muted a:hover {
            color: #dcdcdc;
            text-shadow: 0 0 10px rgba(255, 255, 255, 1);
        }

        .text-light-50 {
            color: rgba(255, 255, 255, 0.6);
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>
<body>

    <div class="forgot-card shadow-lg">
        <div class="logo">
            <i class="bi bi-key-fill fs-1 text-warning"></i>
            <h3>PundoHub</h3>
            <p class="text-light-50 mb-3">Forgot Your Password?</p>
        </div>

        <!-- ✅ Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autofocus placeholder="Enter your email">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-send w-100">
                <i class="bi bi-envelope-fill me-2"></i> Send Forgot Password Link
            </button>
        </form>

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <p class="text-center text-muted mt-4 mb-0">
            Remembered your password? <a href="{{ route('login') }}">Back to Login</a>
        </p>
    </div>

</body>
</html>
