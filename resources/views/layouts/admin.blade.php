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
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    
    <!-- StyleSheets -->
    <link rel="stylesheet" href="{{ asset('css/dashlite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    
    @stack('styles')
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
    
    <!-- Scripts -->
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
