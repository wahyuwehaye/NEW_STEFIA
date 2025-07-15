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
        
        .network-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/images/network-pattern.svg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.6;
            z-index: -1;
            animation: networkFloat 30s ease-in-out infinite;
        }
        
        @keyframes networkFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23334155" stroke-width="0.5" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
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

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; animation-delay: 1s; }
        .particle:nth-child(3) { left: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 40%; animation-delay: 3s; }
        .particle:nth-child(5) { left: 50%; animation-delay: 4s; }
        .particle:nth-child(6) { left: 60%; animation-delay: 5s; }
        .particle:nth-child(7) { left: 70%; animation-delay: 0.5s; }
        .particle:nth-child(8) { left: 80%; animation-delay: 1.5s; }
        .particle:nth-child(9) { left: 90%; animation-delay: 2.5s; }

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

        .nk-header {
            background: rgba(31, 41, 55, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(220, 38, 38, 0.2);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .logo-img {
            height: 40px;
            filter: drop-shadow(0 0 10px rgba(220, 38, 38, 0.5));
            transition: all 0.3s ease;
        }

        .logo-img:hover {
            filter: drop-shadow(0 0 20px rgba(220, 38, 38, 0.8));
            transform: scale(1.1);
        }

        .min-vh-75 { min-height: 100vh; }
        
        .logo-container {
            margin-bottom: 3rem;
            animation: slideInUp 1s ease 0.2s both;
        }
        
        .hero-logo {
            height: 200px;
            width: auto;
            max-width: 100%;
            filter: drop-shadow(0 0 30px rgba(220, 38, 38, 0.6));
            transition: all 0.3s ease;
            animation: logoFloat 6s ease-in-out infinite;
        }
        
        .hero-logo:hover {
            filter: drop-shadow(0 0 40px rgba(220, 38, 38, 0.8));
            transform: scale(1.05);
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            background: var(--stefia-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slideInUp 1s ease 0.5s both;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            animation: slideInUp 1s ease 0.7s both;
        }
        
        /* Futuristic 3D Background */
        .three-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -5;
            overflow: hidden;
        }
        
        /* Network Animation */
        .network-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -3;
            pointer-events: none;
            overflow: hidden;
        }
        
        .network-node {
            position: absolute;
            width: 4px;
            height: 4px;
            background: var(--stefia-accent);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--stefia-accent);
            animation: pulse 2s ease-in-out infinite;
        }
        
        /* Geometric Shapes */
        .geometric-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -4;
            pointer-events: none;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            border: 2px solid rgba(220, 38, 38, 0.3);
            background: rgba(220, 38, 38, 0.1);
            backdrop-filter: blur(5px);
            animation: shapeFloat 10s ease-in-out infinite;
        }
        
        .shape-1 {
            width: 60px;
            height: 60px;
            top: 10%;
            left: 5%;
            transform: rotate(45deg);
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 80px;
            height: 80px;
            top: 20%;
            right: 10%;
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            animation-delay: 1s;
        }
        
        .shape-3 {
            width: 50px;
            height: 50px;
            top: 60%;
            left: 10%;
            border-radius: 50%;
            animation-delay: 2s;
        }
        
        .shape-4 {
            width: 70px;
            height: 70px;
            top: 70%;
            right: 5%;
            clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);
            animation-delay: 3s;
        }
        
        .shape-5 {
            width: 40px;
            height: 40px;
            top: 30%;
            left: 50%;
            transform: rotate(60deg);
            animation-delay: 4s;
        }
        
        .shape-6 {
            width: 90px;
            height: 90px;
            top: 50%;
            right: 30%;
            clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%);
            animation-delay: 5s;
        }
        
        .shape-7 {
            width: 35px;
            height: 35px;
            top: 15%;
            left: 80%;
            border-radius: 50%;
            animation-delay: 6s;
        }
        
        .shape-8 {
            width: 65px;
            height: 65px;
            top: 80%;
            left: 70%;
            transform: rotate(30deg);
            animation-delay: 7s;
        }
        
        @keyframes shapeFloat {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            25% {
                transform: translateY(-20px) rotate(90deg);
            }
            50% {
                transform: translateY(-40px) rotate(180deg);
            }
            75% {
                transform: translateY(-20px) rotate(270deg);
            }
        }
        
        /* Floating Particles */
        .floating-particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            pointer-events: none;
        }
        
        .floating-particles .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--stefia-accent);
            border-radius: 50%;
            animation: particleFloat 8s ease-in-out infinite;
        }
        
        .floating-particles .particle:nth-child(1) { left: 10%; top: 20%; animation-delay: 0s; }
        .floating-particles .particle:nth-child(2) { left: 20%; top: 60%; animation-delay: 1s; }
        .floating-particles .particle:nth-child(3) { left: 30%; top: 10%; animation-delay: 2s; }
        .floating-particles .particle:nth-child(4) { left: 40%; top: 80%; animation-delay: 3s; }
        .floating-particles .particle:nth-child(5) { left: 50%; top: 40%; animation-delay: 4s; }
        .floating-particles .particle:nth-child(6) { left: 60%; top: 70%; animation-delay: 5s; }
        .floating-particles .particle:nth-child(7) { left: 70%; top: 30%; animation-delay: 6s; }
        .floating-particles .particle:nth-child(8) { left: 80%; top: 90%; animation-delay: 7s; }
        .floating-particles .particle:nth-child(9) { left: 90%; top: 50%; animation-delay: 8s; }
        .floating-particles .particle:nth-child(10) { left: 15%; top: 75%; animation-delay: 9s; }
        
        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(0px) translateX(0px);
                opacity: 0.3;
            }
            25% {
                transform: translateY(-30px) translateX(20px);
                opacity: 0.8;
            }
            50% {
                transform: translateY(-60px) translateX(-10px);
                opacity: 1;
            }
            75% {
                transform: translateY(-30px) translateX(-30px);
                opacity: 0.5;
            }
        }
        
        /* Hero Section */
        .hero-logo {
            max-width: 300px;
            height: auto;
            filter: drop-shadow(0 10px 20px rgba(220, 38, 38, 0.3));
            animation: logoGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes logoGlow {
            0% {
                filter: drop-shadow(0 10px 20px rgba(220, 38, 38, 0.3));
            }
            100% {
                filter: drop-shadow(0 10px 30px rgba(220, 38, 38, 0.6));
            }
        }
        
        .hero-actions {
            animation: slideInUp 1s ease 0.9s both;
        }
        
        /* Portal and Feature Cards */
        .portal-card, .feature-card, .contact-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .portal-card::before, .feature-card::before, .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.1), transparent);
            transition: left 0.6s;
        }
        
        .portal-card:hover::before, .feature-card:hover::before, .contact-card:hover::before {
            left: 100%;
        }
        
        .portal-card:hover, .feature-card:hover, .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(220, 38, 38, 0.2);
            border-color: rgba(220, 38, 38, 0.5);
        }
        
        .icon-circle {
            width: 70px;
            height: 70px;
            background: var(--stefia-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
            animation: iconPulse 2s ease-in-out infinite;
        }
        
        @keyframes iconPulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 15px 40px rgba(220, 38, 38, 0.5);
            }
        }
        
        .text-gradient {
            background: var(--stefia-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
        }
        
        /* Buttons */
        .btn-white {
            background: rgba(255, 255, 255, 0.9);
            color: var(--stefia-dark);
            border: none;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-white::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--stefia-gradient);
            transition: left 0.3s;
            z-index: -1;
        }
        
        .btn-white:hover::before {
            left: 0;
        }
        
        .btn-white:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
        }
        
        .btn-outline-white {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-outline-white::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: left 0.3s;
            z-index: -1;
        }
        
        .btn-outline-white:hover::before {
            left: 0;
        }
        
        .btn-outline-white:hover {
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.1);
        }
        
        .btn-primary {
            background: var(--stefia-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f87171 0%, #ef4444 50%, #dc2626 100%);
            transition: left 0.3s;
            z-index: -1;
        }
        
        .btn-primary:hover::before {
            left: 0;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.4);
        }
        
        /* Custom Cursor */
        .custom-cursor {
            position: fixed;
            width: 20px;
            height: 20px;
            background: rgba(220, 38, 38, 0.5);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            transition: all 0.3s ease;
            mix-blend-mode: difference;
        }
        
        .custom-cursor.cursor-hover {
            width: 40px;
            height: 40px;
            background: rgba(220, 38, 38, 0.3);
            border: 2px solid rgba(220, 38, 38, 0.8);
        }
        
        /* Fade In Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Section Styling */
        .section {
            padding: 100px 0;
            position: relative;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
        }
        
        .feature-text {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }
        
        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .contact-text {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .contact-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .geometric-shapes .shape {
                transform: scale(0.7);
            }
            
            .hero-logo {
                max-width: 250px;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .portal-card, .feature-card, .contact-card {
                padding: 1.5rem;
            }
        }
        
        .hero-actions {
            animation: slideInUp 1s ease 0.9s both;
        }
        
        .section-title {
            font-size: 3rem;
            font-weight: 700;
            background: var(--stefia-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .section-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background: var(--stefia-gradient);
            box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
            transition: all 0.3s ease;
        }
        
        .icon-circle:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 20px 40px rgba(220, 38, 38, 0.5);
        }
        
        .feature-card, .contact-card {
            padding: 2.5rem;
            border-radius: 20px;
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 38, 38, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.1), transparent);
            transition: all 0.6s ease;
        }
        
        .feature-card:hover::before {
            left: 100%;
        }
        
        .feature-card:hover, .contact-card:hover {
            transform: translateY(-10px);
            border-color: rgba(220, 38, 38, 0.5);
            box-shadow: 0 20px 50px rgba(220, 38, 38, 0.2);
        }
        
        .feature-title, .contact-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: white;
            margin-bottom: 1rem;
        }
        
        .feature-text, .contact-text {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            animation: slideInLeft 0.8s ease;
        }
        
        .about-features { margin-top: 2rem; }
        
        .bg-primary-soft {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .bg-success-soft {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        
        .bg-info-soft {
            background: rgba(6, 182, 212, 0.1);
            border: 1px solid rgba(6, 182, 212, 0.2);
        }
        
        .section {
            padding: 6rem 0;
            position: relative;
        }
        
        .section-hero {
            background: transparent;
            position: relative;
            z-index: 1;
            padding-top: 8rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }
        
        .btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .btn-white {
            background: white;
            color: var(--stefia-primary);
            border: 2px solid white;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
        }
        
        .btn-white:hover {
            background: rgba(255, 255, 255, 0.9);
            color: var(--stefia-primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }
        
        .btn-outline-white {
            border: 2px solid white;
            color: white;
            background: transparent;
        }
        
        .btn-outline-white:hover {
            background: white;
            color: var(--stefia-primary);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.3);
        }
        
        .btn-primary {
            background: var(--stefia-gradient);
            border: none;
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--stefia-secondary);
            color: var(--stefia-secondary);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: var(--stefia-secondary);
            color: white;
            transform: translateY(-2px);
        }
        
        .card {
            background: rgba(31, 41, 55, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 15px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: rgba(220, 38, 38, 0.5);
            transform: translateY(-5px);
        }
        
        .nk-footer {
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(220, 38, 38, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--stefia-accent);
            transform: translateY(-2px);
        }
        
        .nk-header-nav {
            transition: all 0.3s ease;
        }
        
        .btn-trigger {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.2rem;
            padding: 0.5rem;
            cursor: pointer;
        }
        
        .btn-trigger:hover {
            color: var(--stefia-accent);
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .text-gradient {
            background: var(--stefia-gradient);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
        }
        
        .portal-card {
            background: rgba(31, 41, 55, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(220, 38, 38, 0.2);
            border-radius: 20px;
            padding: 3rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .portal-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: var(--stefia-gradient);
            border-radius: 22px;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: -1;
        }
        
        .portal-card:hover::before {
            opacity: 1;
        }
        
        .portal-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(220, 38, 38, 0.3);
        }
        
        
        .nk-header-nav {
            position: relative;
        }
        
        .nk-nav-list {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nk-nav-item {
            position: relative;
            margin: 0 1rem;
        }
        
        .nk-nav-link {
            position: relative;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 25px;
            overflow: hidden;
        }
        
        .nk-nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.2), transparent);
            transition: all 0.5s ease;
        }
        
        .nk-nav-link:hover::before {
            left: 100%;
        }
        
        .nk-nav-link:hover {
            color: white;
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.2);
        }
        
        .nk-nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--stefia-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nk-nav-link:hover::after {
            width: 100%;
        }
        
        .nk-header-toolbar {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .header-btn {
            position: relative;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            overflow: hidden;
            border: 2px solid transparent;
        }
        
        .header-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
        }
        
        .header-btn:hover::before {
            left: 100%;
        }
        
        .btn-primary.header-btn {
            background: var(--stefia-gradient);
            color: white;
            border-color: var(--stefia-primary);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }
        
        .btn-primary.header-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
            border-color: var(--stefia-accent);
        }
        
        .btn-outline-primary.header-btn {
            color: var(--stefia-secondary);
            border-color: var(--stefia-secondary);
            background: transparent;
        }
        
        .btn-outline-primary.header-btn:hover {
            background: var(--stefia-secondary);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
        }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .section-title { font-size: 2rem; }
            .hero-subtitle { font-size: 1.2rem; }
            .feature-card, .contact-card { padding: 2rem; }
            .portal-card { padding: 2rem; }
            .icon-circle { width: 60px; height: 60px; }
            .hero-logo { height: 90px; }
        }
    </style>
    
    @stack('styles')
</head>
<body class="nk-body npc-general">
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
                            <div class="nk-header-nav" id="navbar-menu">
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
                                <div class="nk-header-toolbar">
                                    <a href="{{ route('login') }}" class="btn btn-primary header-btn">Login</a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary header-btn">Register</a>
                                </div>
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
    
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggle = document.getElementById('navbar-toggle');
            const navbarMenu = document.getElementById('navbar-menu');
            
            if (navbarToggle && navbarMenu) {
                navbarToggle.addEventListener('click', function() {
                    navbarMenu.classList.toggle('active');
                });
                
                // Close menu when clicking on a nav link
                const navLinks = navbarMenu.querySelectorAll('.nk-nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        navbarMenu.classList.remove('active');
                    });
                });
                
                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!navbarToggle.contains(event.target) && !navbarMenu.contains(event.target)) {
                        navbarMenu.classList.remove('active');
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
