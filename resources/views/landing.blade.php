@extends('layouts.landing')

@section('title', 'Welcome to STEFIA')

@section('content')
<!-- Animated Background -->
<div class="animated-bg"></div>
<div class="network-bg"></div>
<div class="particle"></div>
<div class="particle"></div>
<div class="particle"></div>
<div class="particle"></div>
<div class="particle"></div>
<div class="particle"></div>
<div class="particle"></div>
<div class="particle"></div>
<div class="particle"></div>

<!-- Hero Section -->
<section class="section section-hero bg-transparent">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-75">
            <div class="col-lg-8 text-center">
                <div class="logo-container">
                    <img class="hero-logo" src="{{ asset('images/logo-horizontal.png') }}" alt="STEFIA Logo">
                </div>
                <div class="hero-content">
                    <h1 class="hero-title mb-4">Welcome to STEFIA</h1>
                    <p class="hero-subtitle mb-5">Your Gateway to Seamless Student Financial Management</p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn btn-lg btn-white me-3">
                            <em class="icon ni ni-user"></em>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-white">
                            <em class="icon ni ni-user-add"></em>
                            <span>Register</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portal Info Section -->
<section class="section section-portals fade-in">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Access Portals</h2>
                <p class="section-subtitle">Choose your portal to access STEFIA's comprehensive features</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="portal-card h-100">
                    <div class="text-center mb-4">
                        <div class="icon-circle">
                            <em class="icon ni ni-user-list text-white"></em>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 class="feature-title text-gradient">Student Portal</h5>
                        <p class="feature-text">Access your academic and financial information, view grades, fees, scholarships, and manage your profile with our intuitive interface</p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <em class="icon ni ni-arrow-right"></em>
                                <span>Enter Portal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="portal-card h-100">
                    <div class="text-center mb-4">
                        <div class="icon-circle">
                            <em class="icon ni ni-setting text-white"></em>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 class="feature-title text-gradient">Staff Portal</h5>
                        <p class="feature-text">Manage student records and finances, handle registrations, fees, scholarships, and generate comprehensive reports</p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <em class="icon ni ni-arrow-right"></em>
                                <span>Enter Portal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="section section-feature fade-in">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Key Features</h2>
                <p class="section-subtitle">Everything you need to manage student financial information with cutting-edge technology</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-users text-white"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title text-gradient">Student Management</h5>
                        <p class="feature-text">Comprehensive student registration, profile management, and academic tracking with real-time updates</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-wallet text-white"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title text-gradient">Financial Management</h5>
                        <p class="feature-text">Advanced fee collection, payment tracking, financial reporting, and intelligent budget management</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-gift text-white"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title text-gradient">Scholarship Management</h5>
                        <p class="feature-text">Streamlined scholarship applications, automated approvals, distributions, and comprehensive tracking</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section section-about fade-in">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title mb-4">About STEFIA</h2>
                    <p class="section-subtitle mb-4">STEFIA (Student Financial Information & Administration) is a next-generation management system designed to revolutionize student financial operations and administrative processes.</p>
                    <p class="feature-text mb-4">Our platform provides institutions with AI-powered tools to manage student records, track financial transactions, handle scholarship programs, and generate intelligent reports with predictive analytics.</p>
                    <div class="about-features">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">Secure & Reliable</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">User Friendly</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">24/7 Support</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">Mobile Ready</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image text-center">
                    <div class="portal-card d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div class="text-center">
                            <div class="icon-circle mb-4" style="width: 100px; height: 100px;">
                                <em class="icon ni ni-building text-white" style="font-size: 3rem;"></em>
                            </div>
                            <h5 class="text-gradient">STEFIA Dashboard</h5>
                            <p class="feature-text mt-3">Experience the future of student financial management</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section section-contact fade-in">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Get in Touch</h2>
                <p class="section-subtitle">Need help or have questions? Our expert support team is here to assist you 24/7</p>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-mail text-white"></em>
                        </div>
                    </div>
                    <div class="contact-content">
                        <h6 class="contact-title text-gradient">Email Support</h6>
                        <p class="contact-text">support@stefia.edu</p>
                        <a href="mailto:support@stefia.edu" class="btn btn-outline-primary btn-sm mt-2">Send Email</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-call text-white"></em>
                        </div>
                    </div>
                    <div class="contact-content">
                        <h6 class="contact-title text-gradient">Phone Support</h6>
                        <p class="contact-text">+1 (555) 123-4567</p>
                        <a href="tel:+15551234567" class="btn btn-outline-primary btn-sm mt-2">Call Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Intersection Observer for fade-in animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);
        
        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.querySelector('.nk-header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(31, 41, 55, 0.95)';
                header.style.boxShadow = '0 2px 20px rgba(220, 38, 38, 0.1)';
            } else {
                header.style.background = 'rgba(31, 41, 55, 0.9)';
                header.style.boxShadow = 'none';
            }
        });
    });
</script>
@endpush
