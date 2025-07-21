<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="WEDIGITAL INDONESIA">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="STEFIA - Student Financial Information & Administration">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="session-lifetime" content="{{ config('session.lifetime') }}">
    
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
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ionicons@7.2.2/dist/css/ionicons.min.css">
    
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.min.css">
    
    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    
    <!-- Custom Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Select Dropdown Styles -->
    <link rel="stylesheet" href="{{ asset('css/custom-select.css') }}">
    
    @stack('styles')
    
    <style>
        :root {
            --stefia-primary: #FF0000;
            --stefia-secondary: #f43f5e;
            --stefia-success: #22c55e;
            --stefia-warning: #f59e0b;
            --stefia-info: #06b6d4;
            --stefia-dark: #1f2937;
            --stefia-light: #f8fafc;
            --stefia-gradient: linear-gradient(135deg, #FF0000, #FF4D4D);
            --stefia-glass: rgba(255, 255, 255, 0.1);
            --stefia-blur: blur(10px);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 25%, #e2e8f0 50%, #cbd5e1 75%, #94a3b8 100%);
            background-size: 400% 400%;
            animation: subtleGradientShift 30s ease infinite;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        @keyframes subtleGradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Advanced Dashboard Background Effects */
        .dashboard-bg-effects {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
            opacity: 0.8;
            overflow: hidden;
        }
        
        /* 3D Floating Elements */
        .dashboard-particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, rgba(255, 0, 0, 0.8) 0%, rgba(255, 77, 77, 0.6) 50%, transparent 100%);
            border-radius: 50%;
            animation: dashboardFloat3D 15s ease-in-out infinite;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.5), 0 0 40px rgba(255, 0, 0, 0.3);
            transform-style: preserve-3d;
        }
        
        .dashboard-particle:nth-child(1) { left: 5%; animation-delay: 0s; top: 10%; }
        .dashboard-particle:nth-child(2) { left: 15%; animation-delay: 2s; top: 60%; }
        .dashboard-particle:nth-child(3) { left: 25%; animation-delay: 4s; top: 20%; }
        .dashboard-particle:nth-child(4) { left: 35%; animation-delay: 6s; top: 80%; }
        .dashboard-particle:nth-child(5) { left: 45%; animation-delay: 8s; top: 30%; }
        .dashboard-particle:nth-child(6) { left: 55%; animation-delay: 10s; top: 70%; }
        .dashboard-particle:nth-child(7) { left: 65%; animation-delay: 1s; top: 40%; }
        .dashboard-particle:nth-child(8) { left: 75%; animation-delay: 3s; top: 90%; }
        .dashboard-particle:nth-child(9) { left: 85%; animation-delay: 5s; top: 15%; }
        .dashboard-particle:nth-child(10) { left: 95%; animation-delay: 7s; top: 50%; }
        
        /* Advanced 3D Floating Animation */
        @keyframes dashboardFloat3D {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) translateZ(0px) rotate(0deg) scale(1); 
                opacity: 0.6;
                box-shadow: 0 0 20px rgba(255, 0, 0, 0.5), 0 0 40px rgba(255, 0, 0, 0.3);
            }
            25% { 
                transform: translateY(-30px) translateX(15px) translateZ(20px) rotate(90deg) scale(1.3); 
                opacity: 0.9;
                box-shadow: 0 0 30px rgba(255, 0, 0, 0.7), 0 0 60px rgba(255, 0, 0, 0.4);
            }
            50% { 
                transform: translateY(-20px) translateX(-10px) translateZ(-15px) rotate(180deg) scale(0.8); 
                opacity: 0.7;
                box-shadow: 0 0 25px rgba(255, 0, 0, 0.6), 0 0 50px rgba(255, 0, 0, 0.3);
            }
            75% { 
                transform: translateY(-40px) translateX(8px) translateZ(25px) rotate(270deg) scale(1.1); 
                opacity: 0.8;
                box-shadow: 0 0 35px rgba(255, 0, 0, 0.8), 0 0 70px rgba(255, 0, 0, 0.5);
            }
        }
        
        /* Enhanced Network Lines */
        .dashboard-network-line {
            position: absolute;
            width: 2px;
            height: 100px;
            background: linear-gradient(0deg, transparent, rgba(255, 0, 0, 0.4), rgba(255, 77, 77, 0.6), transparent);
            animation: dashboardNetworkPulse3D 10s ease-in-out infinite;
            transform-origin: center;
            filter: blur(0.5px);
        }
        
        @keyframes dashboardNetworkPulse3D {
            0%, 100% { 
                opacity: 0.3; 
                transform: scaleY(0.8) scaleX(1) rotateX(0deg); 
                box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
            }
            50% { 
                opacity: 0.8; 
                transform: scaleY(1.5) scaleX(1.2) rotateX(180deg); 
                box-shadow: 0 0 20px rgba(255, 0, 0, 0.6);
            }
        }
        
        /* Advanced Geometric Shapes */
        .dashboard-geometric {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 2px solid rgba(255, 0, 0, 0.3);
            border-radius: 50%;
            animation: dashboardRotate3D 25s linear infinite;
            transform-style: preserve-3d;
        }
        
        .dashboard-geometric::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 30px;
            height: 30px;
            background: radial-gradient(circle, rgba(255, 0, 0, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: dashboardInnerPulse 8s ease-in-out infinite;
        }
        
        @keyframes dashboardRotate3D {
            0% { transform: rotate(0deg) scale(1) rotateX(0deg) rotateY(0deg); }
            25% { transform: rotate(90deg) scale(1.2) rotateX(90deg) rotateY(45deg); }
            50% { transform: rotate(180deg) scale(0.9) rotateX(180deg) rotateY(90deg); }
            75% { transform: rotate(270deg) scale(1.1) rotateX(270deg) rotateY(135deg); }
            100% { transform: rotate(360deg) scale(1) rotateX(360deg) rotateY(180deg); }
        }
        
        @keyframes dashboardInnerPulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.3; }
            50% { transform: translate(-50%, -50%) scale(1.5); opacity: 0.7; }
        }
        
        /* Holographic Grid Effect */
        .dashboard-grid {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 0, 0, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 0, 0, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: dashboardGridMove 20s linear infinite;
            opacity: 0.4;
        }
        
        @keyframes dashboardGridMove {
            0% { transform: translate(0, 0) rotateX(0deg); }
            100% { transform: translate(50px, 50px) rotateX(360deg); }
        }
        
        /* Advanced Wave Effect */
        .dashboard-wave {
            position: absolute;
            width: 200px;
            height: 200px;
            border: 1px solid rgba(255, 0, 0, 0.2);
            border-radius: 50%;
            animation: dashboardWaveExpand 12s ease-out infinite;
        }
        
        @keyframes dashboardWaveExpand {
            0% { 
                transform: scale(0.5) rotate(0deg); 
                opacity: 0.8;
                border-color: rgba(255, 0, 0, 0.6);
            }
            50% { 
                transform: scale(1.2) rotate(180deg); 
                opacity: 0.4;
                border-color: rgba(255, 0, 0, 0.3);
            }
            100% { 
                transform: scale(2) rotate(360deg); 
                opacity: 0;
                border-color: rgba(255, 0, 0, 0.1);
            }
        }
        
        /* Pulsing Orb Effects */
        .dashboard-orb {
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 0, 0, 0.4) 0%, rgba(255, 77, 77, 0.2) 50%, transparent 100%);
            animation: dashboardOrbPulse 18s ease-in-out infinite;
            filter: blur(1px);
        }
        
        @keyframes dashboardOrbPulse {
            0%, 100% { 
                transform: scale(1) rotate(0deg); 
                opacity: 0.5;
                filter: blur(1px) brightness(1);
            }
            33% { 
                transform: scale(1.4) rotate(120deg); 
                opacity: 0.8;
                filter: blur(0.5px) brightness(1.3);
            }
            66% { 
                transform: scale(0.7) rotate(240deg); 
                opacity: 0.3;
                filter: blur(2px) brightness(0.8);
            }
        }
        
        /* Ensure main content stays above background */
        .nk-main {
            position: relative;
            z-index: 1;
        }
        
        .nk-content {
            position: relative;
            z-index: 2;
        }
        
        /* Glass Morphism Effects */
        .glass-card {
            background: var(--stefia-glass);
            backdrop-filter: var(--stefia-blur);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
        }
        
        /* Gradient Backgrounds */
        .bg-gradient-primary {
            background: var(--stefia-gradient);
        }
        
        .text-gradient {
            background: var(--stefia-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
        
        /* Modern Button Styles */
        .btn-modern {
            background: var(--stefia-gradient);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-modern:hover::before {
            left: 100%;
        }
        
        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(225, 29, 72, 0.3);
        }
        
        /* Sidebar Enhancements */
        .nk-sidebar {
            background: linear-gradient(180deg, #1f2937 0%, #374151 100%);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Dark/Light Theme Support */
        [data-theme="dark"] {
            --stefia-light: #1f2937;
            --stefia-dark: #f8fafc;
        }
        
        [data-theme="dark"] body {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: #f8fafc;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .glass-card {
                border-radius: 12px;
                margin: 0.5rem;
            }
        }
        
        /* Loading Animation */
        .loading-spinner {
            border: 3px solid rgba(225, 29, 72, 0.3);
            border-top: 3px solid var(--stefia-primary);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Enhanced Chart Styles */
        .chart-container {
            position: relative;
            background: var(--stefia-glass);
            backdrop-filter: var(--stefia-blur);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        /* Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        /* Enhanced Table Styles */
        .table-responsive {
            background: var(--stefia-glass);
            backdrop-filter: var(--stefia-blur);
            border-radius: 16px;
            overflow: hidden;
        }
        
        .table thead th {
            background: var(--stefia-gradient);
            color: white;
            border: none;
            font-weight: 600;
        }
        
        /* Stats Card Enhancements */
        .stats-card {
            background: var(--stefia-glass);
            backdrop-filter: var(--stefia-blur);
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--stefia-gradient);
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        /* Modern Form Inputs */
        .form-control, .form-select {
            background: var(--stefia-glass);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            min-height: 45px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--stefia-primary);
            box-shadow: 0 0 0 0.2rem rgba(225, 29, 72, 0.25);
            background: rgba(255, 255, 255, 0.9);
        }
        
        /* Select2 Enhancements */
        .select2-container--bootstrap-5 .select2-selection--single {
            height: 45px !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            background: var(--stefia-glass) !important;
            padding: 0.75rem 1rem !important;
            display: flex !important;
            align-items: center !important;
        }
        
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 0 !important;
            line-height: 1.5 !important;
            color: #495057 !important;
        }
        
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }
        
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 43px !important;
            right: 10px !important;
        }
        
        .select2-container--bootstrap-5.select2-container--focus .select2-selection--single {
            border-color: var(--stefia-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(225, 29, 72, 0.25) !important;
        }
        
        .select2-dropdown {
            border-radius: 12px !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            background: var(--stefia-glass) !important;
            backdrop-filter: var(--stefia-blur) !important;
        }
        
        .select2-results__option {
            padding: 0.75rem 1rem !important;
            transition: all 0.3s ease !important;
        }
        
        .select2-results__option--highlighted {
            background: var(--stefia-primary) !important;
            color: white !important;
        }
    </style>
</head>
<body class="nk-body bg-lighter npc-general has-sidebar">
    <!-- Dashboard Background Effects -->
    <div class="dashboard-bg-effects">
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        <div class="dashboard-particle"></div>
        
        <div class="dashboard-network-line" style="left: 10%; top: 15%; transform: rotate(25deg);"></div>
        <div class="dashboard-network-line" style="right: 15%; top: 25%; transform: rotate(-35deg);"></div>
        <div class="dashboard-network-line" style="left: 20%; bottom: 20%; transform: rotate(50deg);"></div>
        <div class="dashboard-network-line" style="right: 25%; bottom: 30%; transform: rotate(-20deg);"></div>
        <div class="dashboard-network-line" style="left: 60%; top: 40%; transform: rotate(70deg);"></div>
        <div class="dashboard-network-line" style="right: 50%; bottom: 50%; transform: rotate(-60deg);"></div>
        
        <div class="dashboard-geometric" style="left: 8%; top: 25%;"></div>
        <div class="dashboard-geometric" style="right: 12%; top: 35%;"></div>
        <div class="dashboard-geometric" style="left: 30%; bottom: 25%;"></div>
        <div class="dashboard-geometric" style="right: 35%; bottom: 15%;"></div>
        <div class="dashboard-geometric" style="left: 70%; top: 60%;"></div>
        
        <!-- Advanced Background Elements -->
        <div class="dashboard-grid"></div>
        
        <!-- Wave Effects -->
        <div class="dashboard-wave" style="left: 20%; top: 30%; animation-delay: 0s;"></div>
        <div class="dashboard-wave" style="right: 25%; bottom: 40%; animation-delay: 4s;"></div>
        <div class="dashboard-wave" style="left: 60%; top: 15%; animation-delay: 8s;"></div>
        
        <!-- Pulsing Orbs -->
        <div class="dashboard-orb" style="left: 15%; top: 70%; animation-delay: 2s;"></div>
        <div class="dashboard-orb" style="right: 20%; top: 20%; animation-delay: 6s;"></div>
        <div class="dashboard-orb" style="left: 80%; bottom: 30%; animation-delay: 10s;"></div>
        
        <!-- Additional Particles for Depth -->
        <div class="dashboard-particle" style="left: 12%; top: 35%; animation-delay: 3s;"></div>
        <div class="dashboard-particle" style="right: 18%; top: 65%; animation-delay: 7s;"></div>
        <div class="dashboard-particle" style="left: 42%; bottom: 45%; animation-delay: 11s;"></div>
        <div class="dashboard-particle" style="right: 28%; bottom: 25%; animation-delay: 15s;"></div>
        <div class="dashboard-particle" style="left: 78%; top: 25%; animation-delay: 19s;"></div>
    </div>
    
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
    
    <!-- Load libraries in correct order -->
    <!-- jQuery first -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    
    <!-- AOS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <!-- Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    
    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <!-- Typed.js -->
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.1.0/dist/typed.min.js"></script>
    
    <!-- Toast Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    
    <!-- Original DashLite Scripts -->
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    
    <!-- Modern Dashboard Scripts -->
    @vite(['resources/js/app.js'])
    
    <!-- Custom Select JavaScript -->
    <script src="{{ asset('js/custom-select.js') }}"></script>
    
    <!-- Dashboard Background Effects Script -->
    <script>
        $(document).ready(function() {
            // Initialize AOS animations
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true,
                    offset: 100
                });
            }
            
            // Dashboard background effects initialization
            function initDashboardEffects() {
                const particles = document.querySelectorAll('.dashboard-particle');
                const networkLines = document.querySelectorAll('.dashboard-network-line');
                const geometricShapes = document.querySelectorAll('.dashboard-geometric');
                const waves = document.querySelectorAll('.dashboard-wave');
                const orbs = document.querySelectorAll('.dashboard-orb');
                
                // Add random variations to particles
                particles.forEach((particle, index) => {
                    const randomDelay = Math.random() * 5;
                    const randomDuration = 8 + Math.random() * 8;
                    particle.style.animationDelay = randomDelay + 's';
                    particle.style.animationDuration = randomDuration + 's';
                    
                    // Add random position variations
                    const currentLeft = parseInt(particle.style.left || '0');
                    const currentTop = parseInt(particle.style.top || '0');
                    const randomXOffset = (Math.random() - 0.5) * 10;
                    const randomYOffset = (Math.random() - 0.5) * 10;
                    particle.style.left = `calc(${currentLeft}% + ${randomXOffset}px)`;
                    particle.style.top = `calc(${currentTop}% + ${randomYOffset}px)`;
                });
                
                // Add random variations to network lines
                networkLines.forEach((line, index) => {
                    const randomDelay = Math.random() * 3;
                    const randomDuration = 6 + Math.random() * 6;
                    line.style.animationDelay = randomDelay + 's';
                    line.style.animationDuration = randomDuration + 's';
                    
                    // Add subtle height variations
                    const randomHeight = 80 + Math.random() * 40;
                    line.style.height = randomHeight + 'px';
                });
                
                // Add random variations to geometric shapes
                geometricShapes.forEach((shape, index) => {
                    const randomDelay = Math.random() * 10;
                    const randomDuration = 15 + Math.random() * 10;
                    shape.style.animationDelay = randomDelay + 's';
                    shape.style.animationDuration = randomDuration + 's';
                    
                    // Add random size variations
                    const randomSize = 40 + Math.random() * 40;
                    shape.style.width = randomSize + 'px';
                    shape.style.height = randomSize + 'px';
                });
                
                // Add random variations to waves
                waves.forEach((wave, index) => {
                    const randomDelay = Math.random() * 4;
                    const randomDuration = 10 + Math.random() * 8;
                    wave.style.animationDelay = randomDelay + 's';
                    wave.style.animationDuration = randomDuration + 's';
                    
                    // Add random size variations
                    const randomSize = 150 + Math.random() * 100;
                    wave.style.width = randomSize + 'px';
                    wave.style.height = randomSize + 'px';
                });
                
                // Add random variations to orbs
                orbs.forEach((orb, index) => {
                    const randomDelay = Math.random() * 6;
                    const randomDuration = 15 + Math.random() * 10;
                    orb.style.animationDelay = randomDelay + 's';
                    orb.style.animationDuration = randomDuration + 's';
                    
                    // Add random size variations
                    const randomSize = 60 + Math.random() * 40;
                    orb.style.width = randomSize + 'px';
                    orb.style.height = randomSize + 'px';
                });
            }
            
            // Add mouse interaction to background effects
            function addMouseInteraction() {
                const backgroundEffects = document.querySelector('.dashboard-bg-effects');
                if (backgroundEffects) {
                    backgroundEffects.addEventListener('mousemove', function(e) {
                        const mouseX = e.clientX / window.innerWidth;
                        const mouseY = e.clientY / window.innerHeight;
                        
                        // Subtle parallax effect for particles
                        const particles = document.querySelectorAll('.dashboard-particle');
                        particles.forEach((particle, index) => {
                            const speed = 0.5 + (index * 0.1);
                            const x = (mouseX - 0.5) * speed;
                            const y = (mouseY - 0.5) * speed;
                            particle.style.transform = `translate(${x}px, ${y}px)`;
                        });
                    });
                }
            }
            
            // Add subtle pulse effect to glass cards on hover
            function addGlassCardEffects() {
                const glassCards = document.querySelectorAll('.glass-card');
                glassCards.forEach(card => {
                    card.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-5px) scale(1.02)';
                        this.style.boxShadow = '0 20px 60px rgba(255, 0, 0, 0.1)';
                    });
                    
                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                        this.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.1)';
                    });
                });
            }
            
            // Add responsive behavior for mobile devices
            function addResponsiveBehavior() {
                const isMobile = window.innerWidth <= 768;
                const backgroundEffects = document.querySelector('.dashboard-bg-effects');
                
                if (isMobile && backgroundEffects) {
                    backgroundEffects.style.opacity = '0.3';
                    // Reduce animation complexity on mobile
                    const particles = document.querySelectorAll('.dashboard-particle');
                    particles.forEach(particle => {
                        particle.style.animationDuration = '20s';
                    });
                }
            }
            
            // Initialize all dashboard effects
            initDashboardEffects();
            addMouseInteraction();
            addGlassCardEffects();
            addResponsiveBehavior();
            
            // Add window resize handler
            window.addEventListener('resize', addResponsiveBehavior);
            
            // Add subtle loading animation for dashboard content
            $('.nk-content-body').css('opacity', '0').animate({
                opacity: 1
            }, 800);
            
            // Add staggered animation for stats cards
            $('.stats-card').each(function(index) {
                $(this).delay(index * 100).animate({
                    opacity: 1
                }, 600);
            });
            
            console.log('Dashboard background effects initialized');
        });
    </script>
    
    <!-- Toast Notification Functions -->
    <script>
        // Toast notification functions using SweetAlert2
        function showSuccessToast(message, title = 'Success!') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                customClass: {
                    popup: 'colored-toast-success'
                }
            });
            
            Toast.fire({
                icon: 'success',
                title: title,
                text: message
            });
        }
        
        function showErrorToast(message, title = 'Error!') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                customClass: {
                    popup: 'colored-toast-error'
                }
            });
            
            Toast.fire({
                icon: 'error',
                title: title,
                text: message
            });
        }
        
        function showWarningToast(message, title = 'Warning!') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                customClass: {
                    popup: 'colored-toast-warning'
                }
            });
            
            Toast.fire({
                icon: 'warning',
                title: title,
                text: message
            });
        }
        
        function showInfoToast(message, title = 'Info') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                customClass: {
                    popup: 'colored-toast-info'
                }
            });
            
            Toast.fire({
                icon: 'info',
                title: title,
                text: message
            });
        }
        
        // Check for flash messages from Laravel session
        $(document).ready(function() {
            @if(session('success'))
                showSuccessToast('{{ session('success') }}');
            @endif
            
            @if(session('error'))
                showErrorToast('{{ session('error') }}');
            @endif
            
            @if(session('warning'))
                showWarningToast('{{ session('warning') }}');
            @endif
            
            @if(session('info'))
                showInfoToast('{{ session('info') }}');
            @endif
        });
    </script>
    
    <!-- Custom Toast Styles -->
    <style>
        .colored-toast-success {
            background-color: #22c55e !important;
            color: white !important;
        }
        
        .colored-toast-error {
            background-color: #ef4444 !important;
            color: white !important;
        }
        
        .colored-toast-warning {
            background-color: #f59e0b !important;
            color: white !important;
        }
        
        .colored-toast-info {
            background-color: #06b6d4 !important;
            color: white !important;
        }
        
        .swal2-toast .swal2-title {
            color: white !important;
            font-weight: 600;
        }
        
        .swal2-toast .swal2-html-container {
            color: white !important;
        }
        
        .swal2-toast .swal2-icon {
            color: white !important;
        }
        
        .swal2-toast .swal2-timer-progress-bar {
            background: rgba(255, 255, 255, 0.4) !important;
        }
    </style>
    
    <!-- Authentication Utilities -->
    <script src="{{ asset('js/auth-utils.js') }}"></script>
    
    <!-- Session Timeout Handler -->
    <script src="{{ asset('js/session-timeout.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
