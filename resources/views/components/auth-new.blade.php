<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="STEFIA">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="STEFIA - Student Financial Information & Administration">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Authentication' }} | STEFIA</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- StyleSheets -->
    <link rel="stylesheet" href="{{ asset('css/dashlite.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    
    <style>
        :root {
            --stefia-primary: #dc2626;
            --stefia-secondary: #ef4444;
            --stefia-accent: #f87171;
            --stefia-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            --stefia-dark: #1f2937;
            --stefia-light: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1f2937 0%, #374151 25%, #4b5563 50%, #6b7280 75%, #9ca3af 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            pointer-events: none;
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

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .network-line {
            position: absolute;
            width: 1px;
            height: 100px;
            background: linear-gradient(0deg, transparent, rgba(220, 38, 38, 0.2), transparent);
            animation: networkPulse 4s ease-in-out infinite;
        }

        @keyframes networkPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }

        .auth-container {
            background: rgba(31, 41, 55, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo img {
            height: 80px;
            filter: drop-shadow(0 0 20px rgba(220, 38, 38, 0.5));
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            text-align: center;
            margin-bottom: 0.5rem;
            background: var(--stefia-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .auth-subtitle {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-description {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .input-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-field {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            padding-left: 3rem;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--stefia-accent);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            background: rgba(255, 255, 255, 0.15);
        }

        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .toggle-password:hover {
            color: var(--stefia-accent);
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-red {
            background: var(--stefia-gradient);
            color: white;
        }

        .btn-red::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }

        .btn-red:hover::before {
            left: 100%;
        }

        .btn-red:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }

        .w-full {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .text-sm {
            font-size: 0.9rem;
        }

        .text-2xl {
            font-size: 1.5rem;
        }

        .link {
            color: var(--stefia-accent);
            text-decoration: none;
            font-weight: 500;
        }

        .link:hover {
            text-decoration: underline;
        }

        .space-y-4 > * + * {
            margin-top: 1rem;
        }

        .input-error {
            color: #fca5a5;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .footer-links {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            margin: 0 1rem;
            font-size: 0.85rem;
        }

        .footer-links a:hover {
            color: var(--stefia-accent);
        }

        .copyright {
            text-align: center;
            margin-top: 1rem;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .auth-container {
                margin: 1rem;
                padding: 2rem;
            }
            
            .auth-title {
                font-size: 1.5rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="animated-bg">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        
        <div class="network-line" style="left: 15%; top: 10%; transform: rotate(45deg);"></div>
        <div class="network-line" style="right: 20%; top: 20%; transform: rotate(-30deg);"></div>
        <div class="network-line" style="left: 25%; bottom: 15%; transform: rotate(60deg);"></div>
        <div class="network-line" style="right: 30%; bottom: 25%; transform: rotate(-45deg);"></div>
    </div>

    <div class="auth-container">
        <div class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="STEFIA">
        </div>
        
        <div class="auth-header">
            <h1 class="auth-title">STEFIA</h1>
            <p class="auth-subtitle">Student Financial Information & Administration</p>
        </div>
        
        {{ $slot }}
        
        <div class="footer-links">
            <a href="#">Terms & Conditions</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Help</a>
            <a href="#">Bahasa Indonesia</a>
        </div>
        
        <div class="copyright">
            © {{ date('Y') }} STEFIA. Developed by <a href="#" style="color: var(--stefia-accent);">WEDIGITAL INDONESIA</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    
    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        icon.classList.remove('ni-eye');
                        icon.classList.add('ni-eye-off');
                    } else {
                        targetInput.type = 'password';
                        icon.classList.remove('ni-eye-off');
                        icon.classList.add('ni-eye');
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
