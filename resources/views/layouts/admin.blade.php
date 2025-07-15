<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="WEDIGITAL INDONESIA">
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
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            min-height: 100vh;
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
    
    @stack('scripts')
</body>
</html>
