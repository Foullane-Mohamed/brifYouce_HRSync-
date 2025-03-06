<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particlesjs/2.2.2/particles.min.js"></script>
    <style>
        /* Base styles */
        *, ::after, ::before {box-sizing: border-box; margin: 0; padding: 0;}
        html {line-height: 1.5; -webkit-text-size-adjust: 100%;}
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow-x: hidden;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f1f5f9;
        }

        /* Particle canvas */
        canvas {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
        }

        /* Container */
        .container {
            position: relative;
            min-height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(8px);
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 2.5rem;
            width: auto;
        }

        .logo-text {
            margin-left: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.875rem;
            color: #e2e8f0;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #f97316;
        }

        .nav-link.primary {
            background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);
            color: white;
        }

        .nav-link.primary:hover {
            opacity: 0.9;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
        }

        /* Main content */
        .main-content {
            max-width: 80rem;
            width: 90%;
            padding: 6rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            background: linear-gradient(90deg, #f1f5f9 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            max-width: 36rem;
            margin: 0 auto 3rem;
            color: #cbd5e1;
            font-weight: 300;
        }

        .btn-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 4rem;
        }

        .btn {
            display: inline-block;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #e2e8f0;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Features */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            width: 100%;
            margin-bottom: 4rem;
        }

        .feature-card {
            background: rgba(30, 41, 59, 0.7);
            border-radius: 1rem;
            padding: 2rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            background: rgba(30, 41, 59, 0.8);
        }

        .feature-icon {
            background: linear-gradient(90deg, #ef4444 0%, #f97316 100%);
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #f1f5f9;
        }

        .feature-description {
            color: #cbd5e1;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            width: 100%;
            padding: 2rem;
            text-align: center;
            color: #94a3b8;
            font-size: 0.875rem;
            backdrop-filter: blur(12px);
            background: rgba(15, 23, 42, 0.7);
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Mobile adaptations */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .logo-text {
                display: none;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .features {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<canvas id="particles"></canvas>

<div class="container">
    <nav class="navbar">
        <div class="logo">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="logo-img">
                <path d="M20 40C31.0457 40 40 31.0457 40 20C40 8.9543 31.0457 0 20 0C8.9543 0 0 8.9543 0 20C0 31.0457 8.9543 40 20 40Z" fill="url(#paint0_linear)"/>
                <path d="M30 12L20 30L10 12L30 12Z" fill="white"/>
                <circle cx="20" cy="18" r="4" fill="white"/>
                <defs>
                    <linearGradient id="paint0_linear" x1="0" y1="0" x2="40" y2="40" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#EF4444"/>
                        <stop offset="1" stop-color="#F97316"/>
                    </linearGradient>
                </defs>
            </svg>
            <span class="logo-text">HRSync</span>
        </div>


    </nav>

    <main class="main-content">
        <h1 class="hero-title"> Plateforme intelligente pour la gestion des entreprises et des employés</h1>
        <p class="hero-subtitle">Gestion des congés et des jours de récupération

            Gestion des congés annuels</p>

        <div class="btn-container">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Get Started</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">Create Account</a>
                    @endif
                @endauth
            @endif
        </div>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="white" viewBox="0 0 24 24">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Gestion des utilisateurs</h3>
                <p class="feature-description">Créez des comptes entreprise, gérez les employés et attribuez des rôles spécifiques.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="white" viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Sécurité avancée</h3>
                <p class="feature-description">Authentification sécurisée et gestion des accès grâce à des rôles et permissions.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="white" viewBox="0 0 24 24">
                        <path d="M9 11.75c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zm6 0c-.69 0-1.25.56-1.25 1.25s.56 1.25 1.25 1.25 1.25-.56 1.25-1.25-.56-1.25-1.25-1.25zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8 0-.29.02-.58.05-.86 2.36-1.05 4.23-2.98 5.21-5.37C11.07 8.33 14.05 10 17.42 10c.78 0 1.53-.09 2.25-.26.21.71.33 1.47.33 2.26 0 4.41-3.59 8-8 8z"></path>
                    </svg>
                </div>
                <h3 class="feature-title">Gestion des départements</h3>
                <p class="feature-description">Organisez vos employés en départements et définissez une hiérarchie claire.</p>
            </div>
        </div>




</div>
<script>
    window.onload = function() {
        Particles.init({
            selector: '#particles',
            color: ['#f1f5f9', '#94a3b8', '#64748b'],
            connectParticles: true,
            maxParticles: 100,
            responsive: [
                {
                    breakpoint: 768,
                    options: {
                        maxParticles: 50
                    }
                }
            ]
        });
    };
</script>
</body>
</html>
