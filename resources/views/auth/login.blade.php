<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>

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
            background: url('https://source.unsplash.com/random/1200x800/?gradient,purple') center center/cover no-repeat;
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
            margin-bottom: 2.5rem;
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
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
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

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .remember {
            display: flex;
            align-items: center;
        }

        .remember input {
            width: auto;
            margin-right: 0.5rem;
        }

        .remember label {
            margin-bottom: 0;
            font-size: 0.875rem;
            color: #64748b;
        }

        .forgot {
            font-size: 0.875rem;
            color: #8b5cf6;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot:hover {
            color: #6366f1;
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
            margin: 2rem 0;
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

        .social-login {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-btn:hover {
            background-color: #f8fafc;
            transform: translateY(-2px);
        }

        .social-btn img {
            width: 24px;
            height: 24px;
        }

        .signup-prompt {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }

        .signup-link {
            color: #8b5cf6;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .signup-link:hover {
            color: #6366f1;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .status-message {
            background-color: #ecfdf5;
            border-radius: 0.5rem;
            padding: 1rem;
            color: #065f46;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
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
            <!-- New Modern Logo -->
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

        <h1>Welcome Back</h1>
        <p class="subtitle">Sign in to your account to continue</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
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
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                @error('password')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="remember-forgot">
                <div class="remember">
                    <input id="remember_me" type="checkbox" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>

                @if (Route::has('password.request'))
                    <a class="forgot" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                Sign in
            </button>
        </form>

        <div class="divider">OR CONTINUE WITH</div>

        <div class="social-login">
            <button class="social-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#4285F4" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.8055 10.0415H21V10H12V14H17.6515C16.827 16.3285 14.6115 18 12 18C8.6865 18 6 15.3135 6 12C6 8.6865 8.6865 6 12 6C13.5295 6 14.921 6.577 15.9805 7.5195L18.809 4.691C17.023 3.0265 14.634 2 12 2C6.4775 2 2 6.4775 2 12C2 17.5225 6.4775 22 12 22C17.5225 22 22 17.5225 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z"/>
                    <path d="M3.15302 7.3455L6.43851 9.755C7.32752 7.554 9.48052 6 12 6C13.5295 6 14.921 6.577 15.9805 7.5195L18.809 4.691C17.023 3.0265 14.634 2 12 2C8.15902 2 4.82802 4.1685 3.15302 7.3455Z" fill="#EA4335"/>
                    <path d="M12 22C14.583 22 16.93 21.0115 18.7045 19.404L15.6095 16.785C14.6095 17.5455 13.3575 18 12 18C9.39947 18 7.19047 16.3415 6.35847 14.027L3.09747 16.5395C4.75247 19.778 8.11347 22 12 22Z" fill="#34A853"/>
                    <path d="M21.8055 10.0415H21V10H12V14H17.6515C17.2555 15.1185 16.536 16.083 15.608 16.7855C15.6085 16.785 15.609 16.785 15.6095 16.7845L18.7045 19.4035C18.4855 19.6025 22 17 22 12C22 11.3295 21.931 10.675 21.8055 10.0415Z" fill="#4285F4"/>
                    <path d="M6.35842 14.0275C6.19442 13.4275 6.09942 12.7965 6.09942 12.001C6.09942 11.2055 6.19442 10.5745 6.35042 9.9745L6.34942 9.975L3.05742 7.4415L3.09742 7.5605C2.40442 8.9015 2.00042 10.4105 2.00042 12.001C2.00042 13.5915 2.40442 15.1005 3.09742 16.4415L6.35842 14.0275Z" fill="#FBBC05"/>
                </svg>
            </button>
            <button class="social-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#1877F2" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24 12.073C24 5.404 18.629 0 12 0C5.369 0.001 0 5.404 0 12.075C0 18.099 4.388 23.094 10.125 24V15.563H7.078V12.075H10.125V9.413C10.125 6.386 11.917 4.71 14.658 4.71C15.97 4.71 17.344 4.946 17.344 4.946V7.875H15.83C14.339 7.875 13.874 8.801 13.874 9.75V12.073H17.203L16.671 15.561H13.874V23.998C19.611 23.094 24 18.099 24 12.073Z"/>
                </svg>
            </button>
            <button class="social-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="#000000" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0099 2C6.47788 2 2 6.48 2 12.0199C2 16.4699 4.86577 20.1684 8.83766 21.489C9.33788 21.5807 9.52188 21.272 9.52188 21.007C9.52188 20.7696 9.51188 20.1407 9.50788 19.3036C6.72632 19.9109 6.13988 17.9655 6.13988 17.9655C5.68466 16.8106 5.02853 16.5032 5.02853 16.5032C4.12132 15.8874 5.09731 15.9 5.09731 15.9C6.10154 15.9677 6.63 16.9222 6.63 16.9222C7.52198 18.4537 8.97005 18.0125 9.53988 17.7559C9.63088 17.113 9.88866 16.6718 10.175 16.4176C7.95498 16.1572 5.61922 15.3023 5.61922 11.4773C5.61922 10.3857 6.00977 9.49262 6.64920 8.79506C6.54387 8.54177 6.20277 7.5236 6.74631 6.14744C6.74631 6.14744 7.58622 5.87806 9.49632 7.17105C10.2943 6.95044 11.1499 6.83844 12.0002 6.83444C12.8489 6.83844 13.7045 6.94967 14.5041 7.17029C16.4126 5.87806 17.2509 6.14667 17.2509 6.14667C17.7961 7.52437 17.4548 8.54177 17.3497 8.79429C17.9907 9.49186 18.3797 10.385 18.3797 11.4765C18.3797 15.3115 16.0401 16.1548 13.8139 16.4092C14.1722 16.7299 14.4918 17.3648 14.4918 18.3349C14.4918 19.7371 14.4794 20.6789 14.4794 21.0055C14.4794 21.2728 14.6587 21.5844 15.1659 21.488C19.1362 20.1666 22 16.4694 22 12.0199C22 6.48 17.5221 2 12.0099 2Z"/>
                </svg>
            </button>
        </div>

        <p class="signup-prompt">
            Don't have an account? <a href="{{ route('register') }}" class="signup-link">Sign up</a>
        </p>
    </div>

    <div class="image-side">
        <div class="quote">
            <h2 class="hero-title"> Plateforme intelligente pour la gestion des entreprises et des employés </h2>
            <p class="hero-subtitle">Gestion des congés et des jours de récupération

                Gestion des congés annuels</p>
        </div>
    </div>
</div>
</body>
</html>
