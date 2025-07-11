<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="STEFIA - Student Financial Information & Administration">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Welcome') | STEFIA</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    
    <!-- StyleSheets -->
    <link rel="stylesheet" href="{{ asset('css/dashlite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    
    <style>
        .min-vh-75 { min-height: 75vh; }
        .hero-title { font-size: 3.5rem; font-weight: 700; }
        .hero-subtitle { font-size: 1.25rem; }
        .section-title { font-size: 2.5rem; font-weight: 600; }
        .section-subtitle { font-size: 1.1rem; }
        .icon-circle { width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; }
        .feature-card, .contact-card { padding: 2rem; border-radius: 10px; transition: transform 0.3s ease; }
        .feature-card:hover, .contact-card:hover { transform: translateY(-5px); }
        .feature-title, .contact-title { font-size: 1.25rem; font-weight: 600; }
        .feature-text, .contact-text { font-size: 0.95rem; }
        .feature-item { display: flex; align-items: center; margin-bottom: 0.75rem; }
        .about-features { margin-top: 2rem; }
        .bg-primary-soft { background-color: rgba(98, 127, 234, 0.1); }
        .bg-success-soft { background-color: rgba(34, 197, 94, 0.1); }
        .bg-info-soft { background-color: rgba(14, 165, 233, 0.1); }
        .section { padding: 4rem 0; }
        .btn-white { background-color: white; color: #1a1a1a; border: 1px solid white; }
        .btn-white:hover { background-color: rgba(255,255,255,0.9); color: #1a1a1a; }
        .btn-outline-white { border: 1px solid white; color: white; background-color: transparent; }
        .btn-outline-white:hover { background-color: white; color: #1a1a1a; }
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .section-title { font-size: 2rem; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="nk-body bg-white npc-general">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                
                <!-- header @s -->
                <div class="nk-header nk-header-landing">
                    <div class="container">
                        <div class="nk-header-wrap">
                            <div class="nk-header-brand">
                                <a href="{{ url('/') }}" class="logo-link">
                                    <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}" alt="logo">
                                    <img class="logo-dark logo-img" src="{{ asset('images/logo.png') }}" alt="logo-dark">
                                </a>
                            </div>
                            <div class="nk-header-nav">
                                <nav class="nk-nav">
                                    <ul class="nk-nav-list">
                                        <li class="nk-nav-item">
                                            <a href="{{ url('/') }}" class="nk-nav-link">Home</a>
                                        </li>
                                        <li class="nk-nav-item">
                                            <a href="#features" class="nk-nav-link">Features</a>
                                        </li>
                                        <li class="nk-nav-item">
                                            <a href="#about" class="nk-nav-link">About</a>
                                        </li>
                                        <li class="nk-nav-item">
                                            <a href="#contact" class="nk-nav-link">Contact</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="nk-header-tools">
                                <ul class="nk-header-toolbar">
                                    <li><a href="{{ route('login') }}" class="btn btn-primary">Login</a></li>
                                    <li><a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- header @e -->
                
                <!-- content @s -->
                <div class="nk-content">
                    @yield('content')
                </div>
                <!-- content @e -->
                
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright">
                                <p>&copy; {{ date('Y') }} STEFIA. All rights reserved.</p>
                            </div>
                            <div class="nk-footer-links">
                                <ul class="nav nav-sm">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Terms</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Privacy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Support</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
                
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
