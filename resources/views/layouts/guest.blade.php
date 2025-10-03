<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline CSS only for the login page (quick & reliable) -->
    @if(request()->routeIs('login') || request()->is('login'))
    <style>
        /* page background */
        body.page-login {
            background: url('/images/background.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        /* login card glass effect */
        body.page-login .login-card {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.4);
        }

        /* make text inside the card readable */
        body.page-login .login-card,
        body.page-login .login-card .block,
        body.page-login .login-card label,
        body.page-login .login-card input,
        body.page-login .login-card a {
            color: #ffffff !important;
        }

        /* tweak inputs (if you used global glass styles) */
        body.page-login .login-card input::placeholder {
            color: rgba(255,255,255,0.7) !important;
        }

        /* make login inputs blurry */
body.page-login .login-card input {
    background: rgba(255, 255, 255, 0.15);  /* semi-transparent */
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #fff; /* text stays readable */
    border-radius: 8px;
    padding: 0.6rem 1rem;
}

/* placeholder styling */
body.page-login .login-card input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

    </style>
    @endif
</head>
<body class="font-sans text-gray-900 antialiased {{ (request()->routeIs('login') || request()->is('login')) ? 'page-login' : '' }}">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <!-- added login-card class here -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg login-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
