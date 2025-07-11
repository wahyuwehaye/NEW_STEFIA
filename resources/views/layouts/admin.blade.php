<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="STEFIA - Student Financial Information & Administration">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') | STEFIA</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}">
    
    <!-- StyleSheets -->
    <link rel="stylesheet" href="{{ asset('css/dashlite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --stefia-primary: #dc2626;
            --stefia-secondary: #ef4444;
            --stefia-accent: #f87171;
            --stefia-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            --stefia-dark: #1f2937;
            --stefia-light: #f9fafb;
            --stefia-gray: #6b7280;
            --stefia-light-gray: #e5e7eb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--stefia-dark);
            color: white;
            overflow-x: hidden;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1f2937 0%, #374151 25%, #4b5563 50%, #6b7280 75%, #9ca3af 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            z-index: -2;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Cdefs%3E%3Cpattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"%3E%3Cpath d="M 10 0 L 0 0 0 10" fill="none" stroke="%23334155" stroke-width="0.5" opacity="0.3"/%3E%3C/pattern%3E%3C/defs%3E%3Crect width="100" height="100" fill="url(%23grid)"/%3E%3C/svg%3E');
            animation: gridMove 20s linear infinite;
            opacity: 0.3;
        }
        
        .animated-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(220, 38, 38, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 20%, rgba(220, 38, 38, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 80%, rgba(220, 38, 38, 0.1) 0%, transparent 50%);
            animation: pulse 4s ease-in-out infinite alternate;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: var(--stefia-accent);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 0 10px var(--stefia-accent);
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; top: 20%; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; top: 80%; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; top: 30%; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; top: 70%; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; top: 10%; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; top: 90%; }
        .particle:nth-child(7) { left: 70%; animation-delay: 0.5s; top: 40%; }
        .particle:nth-child(8) { left: 80%; animation-delay: 1.5s; top: 60%; }
        .particle:nth-child(9) { left: 90%; animation-delay: 2.5s; top: 15%; }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes gridMove {
            0% { transform: translateX(0) translateY(0); }
            100% { transform: translateX(10px) translateY(10px); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        @keyframes slideInUp {
            0% { opacity: 0; transform: translateY(50px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        /* Enhanced Dashboard Styles */
        .card {
            background: rgba(31, 41, 55, 0.98) !important;
            backdrop-filter: blur(15px) !important;
            border: 1px solid rgba(220, 38, 38, 0.3) !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4) !important;
        }
        
        .card:hover {
            border-color: rgba(220, 38, 38, 0.5) !important;
            transform: translateY(-5px) !important;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.2) !important;
        }
        
        .card-bordered {
            border: 1px solid rgba(220, 38, 38, 0.2) !important;
        }
        
        .card-inner {
            animation: slideInUp 0.6s ease !important;
        }
        
        .stats-card {
            background: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(220, 38, 38, 0.2) !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
        }
        
        .stats-card:hover {
            transform: translateY(-10px) !important;
            border-color: rgba(220, 38, 38, 0.5) !important;
            box-shadow: 0 20px 50px rgba(220, 38, 38, 0.2) !important;
        }
        
        .nk-header {
            background: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(220, 38, 38, 0.2) !important;
        }
        
        .nk-sidebar {
            background: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border-right: 1px solid rgba(220, 38, 38, 0.2) !important;
        }
        
        .nk-nav-menu .nk-menu-item .nk-menu-link {
            color: rgba(255, 255, 255, 0.8) !important;
            transition: all 0.3s ease !important;
        }
        
        .nk-nav-menu .nk-menu-item .nk-menu-link:hover {
            color: var(--stefia-accent) !important;
            background: rgba(220, 38, 38, 0.1) !important;
        }
        
        .nk-nav-menu .nk-menu-item.active .nk-menu-link {
            color: var(--stefia-accent) !important;
            background: rgba(220, 38, 38, 0.2) !important;
        }
        
        .logo-img {
            filter: drop-shadow(0 0 10px rgba(220, 38, 38, 0.5)) !important;
            transition: all 0.3s ease !important;
        }
        
        .logo-img:hover {
            filter: drop-shadow(0 0 20px rgba(220, 38, 38, 0.8)) !important;
            transform: scale(1.1) !important;
        }
        
        .btn-primary {
            background: var(--stefia-gradient) !important;
            border: none !important;
            color: white !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.4) !important;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
            border: none !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-success:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.4) !important;
        }
        
        .page-title {
            background: var(--stefia-gradient) !important;
            background-clip: text !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            font-weight: 700 !important;
        }
        
        .nk-tb-list .nk-tb-item:hover {
            background: rgba(220, 38, 38, 0.05) !important;
        }
        
        .timeline-status {
            background: var(--stefia-gradient) !important;
        }
        
        .badge-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
        }
        
        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }
        
        .badge-primary {
            background: var(--stefia-gradient) !important;
        }
        
        .text-gradient {
            background: var(--stefia-gradient) !important;
            background-clip: text !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }
        
        .fade-in {
            animation: slideInUp 0.8s ease !important;
        }
        
        .feature-card {
            background: rgba(31, 41, 55, 0.8) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(220, 38, 38, 0.2) !important;
            border-radius: 20px !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .feature-card::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.1), transparent) !important;
            transition: all 0.6s ease !important;
        }
        
        .feature-card:hover::before {
            left: 100% !important;
        }
        
        .feature-card:hover {
            transform: translateY(-10px) !important;
            border-color: rgba(220, 38, 38, 0.5) !important;
            box-shadow: 0 20px 50px rgba(220, 38, 38, 0.2) !important;
        }
        
        .icon-circle {
            width: 60px !important;
            height: 60px !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: var(--stefia-gradient) !important;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .icon-circle:hover {
            transform: translateY(-5px) scale(1.1) !important;
            box-shadow: 0 20px 40px rgba(220, 38, 38, 0.5) !important;
        }
        
        .nk-content {
            position: relative !important;
            z-index: 1 !important;
        }
        
        .nk-footer {
            background: rgba(31, 41, 55, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            border-top: 1px solid rgba(220, 38, 38, 0.2) !important;
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Text Visibility Improvements */
        .card-inner {
            background: rgba(31, 41, 55, 0.99) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            border-radius: 15px !important;
        }
        
        .nk-tb-list {
            background: rgba(31, 41, 55, 0.98) !important;
        }
        
        .nk-tb-item {
            color: rgba(255, 255, 255, 0.9) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        
        .tb-lead {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .tb-sub {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        .form-control {
            background: rgba(31, 41, 55, 0.98) !important;
            color: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(220, 38, 38, 0.3) !important;
        }
        
        .form-control:focus {
            background: rgba(31, 41, 55, 0.98) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            border-color: var(--stefia-accent) !important;
        }
        
        .form-label {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .timeline-title {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .timeline-des {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Additional visibility improvements */
        .card-title {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .title {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .card p {
            color: rgba(255, 255, 255, 0.85) !important;
        }
        
        .amount {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        .data-group {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .nk-ecwg3-legends li {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .nk-ecwg3-legends .title {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .nk-ecwg3-legends .amount {
            color: rgba(255, 255, 255, 0.95) !important;
        }
        
        /* Override default dark theme */
        .nk-body.bg-lighter {
            background: transparent !important;
        }
        
        .nk-content {
            background: transparent !important;
        }
        
        .container-fluid {
            background: transparent !important;
        }
        
        .nk-content-inner {
            background: transparent !important;
        }
        
        .nk-content-body {
            background: transparent !important;
        }
        
        /* Chart canvas background */
        canvas {
            background: rgba(31, 41, 55, 0.5) !important;
            border-radius: 10px !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="nk-body bg-lighter npc-general has-sidebar">
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main">
            
            <!-- sidebar @s -->
            @include('layouts.partials.sidebar')
            <!-- sidebar @e -->
            
            <!-- wrap @s -->
            <div class="nk-wrap">
                
                <!-- main header @s -->
                @include('layouts.partials.header')
                <!-- main header @e -->
                
                <!-- content @s -->
                <div class="nk-content">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                
                <!-- footer @s -->
                @include('layouts.partials.footer')
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
