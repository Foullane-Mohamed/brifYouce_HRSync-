<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            padding: 2rem 1rem;
        }

        .container {
            max-width: 900px;
            width: 100%;
            display: flex;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            overflow: hidden;
            background-color: white;
            position: relative;
        }

        .form-side {
            width: 55%;
            padding: 3rem;
            position: relative;
            z-index: 2;
        }

        .image-side {
            width: 45%;
            background: url('https://source.unsplash.com/random/1200x800/?purple,tech') center center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.8) 0%, rgba(139, 92, 246, 0.8) 100%);
        }

        .logo-container {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
        }

        .logo {
            width: 48px;
            height: 48px;
            margin-right: 16px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            font-size: 1rem;
            color: #1e293b;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }

        input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            margin-top: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(139, 92, 246, 0.2);
        }

        .btn-primary:hover {
            box-shadow: 0 10px 15px -3px rgba(139, 92, 246, 0.3);
            transform: translateY(-2px);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #94a3b8;
            font-size: 0.875rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: #e2e8f0;
        }

        .divider::before {
            margin-right: 1rem;
        }

        .divider::after {
            margin-left: 1rem;
        }

        .login-prompt {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 1.5rem;
        }

        .login-link {
            color: #8b5cf6;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .login-link:hover {
            color: #6366f1;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }

        .password-requirements {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            padding: 1rem;
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        .password-requirements ul {
            padding-left: 1.5rem;
            margin-top: 0.5rem;
        }

        .password-requirements li {
            margin-bottom: 0.25rem;
        }

        .quote {
            position: relative;
            z-index: 1;
            color: white;
            max-width: 80%;
            text-align: center;
        }

        .quote-text {
            font-size: 1.25rem;
            font-weight: 300;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .quote-author {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .terms {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 1rem;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .form-side {
                width: 100%;
                padding: 2rem;
            }

            .image-side {
                width: 100%;
                height: 200px;
                order: -1;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-side">
        <div class="logo-container">
            <!-- Modern Logo -->
            <svg class="logo" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M30 60C46.5685 60 60 46.5685 60 30C60 13.4315 46.5685 0 30 0C13.4315 0 0 13.4315 0 30C0 46.5685 13.4315 60 30 60Z" fill="url(#paint0_linear)"/>
                <path d="M41.25 18.75H18.75C17.3693 18.75 16.25 19.8693 16.25 21.25V38.75C16.25 40.1307 17.3693 41.25 18.75 41.25H41.25C42.6307 41.25 43.75 40.1307 43.75 38.75V21.25C43.75 19.8693 42.6307 18.75 41.25 18.75Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16.25 25L30 33.75L43.75 25" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <defs>
                    <linearGradient id="paint0_linear" x1="0" y1="0" x2="60" y2="60" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#6366F1"/>
                        <stop offset="1" stop-color="#8B5CF6"/>
                    </linearGradient>
                </defs>
            </svg>
            <span class="logo-text">HRSync</span>
        </div>

        <h1>Create Account</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                />
                @error('name')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    placeholder="your@email.com"
                />
                @error('email')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                @error('password')
                <p class="error-message">{{ $message }}</p>
                @enderror

            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
            </div>

            <button type="submit" class="btn btn-primary">
                Create Account
            </button>

            <p class="terms">
                By clicking "Create Account", you agree to our <a href="#" class="login-link">Terms of Service</a> and <a href="#" class="login-link">Privacy Policy</a>.
            </p>
        </form>

        <div class="divider">OR</div>

        <p class="login-prompt">
            Already have an account? <a href="{{ route('login') }}" class="login-link">Sign in</a>
        </p>
    </div>

    <div class="image-side">
        <div class="quote">
            <h2 class="hero-title"> Plateforme intelligente pour la gestion des entreprises et des employés</h2>
            <p class="hero-subtitle">Gestion des congés et des jours de récupération

                Gestion des congés annuels</p>
        </div>
    </div>
</div>
</body>
</html>
