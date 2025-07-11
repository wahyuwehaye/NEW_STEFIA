<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="STEFIA - Student Financial Information & Administration">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Authentication') | STEFIA</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    
    <!-- StyleSheets -->
    <link rel="stylesheet" href="{{ asset('css/dashlite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    
    @stack('styles')
</head>
<body class="nk-body bg-white npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content">
                    <div class="nk-split nk-split-page nk-split-lg">
                        <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                            <div class="absolute-top-right d-lg-none p-3 p-sm-5">
                                <a href="#" class="toggle btn-white btn btn-icon btn-light" data-target="athPromo">
                                    <em class="icon ni ni-info"></em>
                                </a>
                            </div>
                            <div class="nk-block nk-block-middle nk-auth-body">
                                <div class="brand-logo pb-5">
                                    <a href="{{ url('/') }}" class="logo-link">
                                        <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo">
                                        <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo-dark">
                                    </a>
                                </div>
                                
                                @yield('content')
                                
                                <div class="form-note-s2 pt-4">
                                    <a href="{{ url('/') }}"><strong>Return to Home</strong></a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="nk-split-content nk-split-stretch bg-abstract"></div>
                    </div>
                </div>
                <!-- content @e -->
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
