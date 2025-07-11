@extends('layouts.landing')

@section('title', 'Welcome')

@section('content')
<!-- Hero Section -->
<section class="section section-hero bg-primary" id="home">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="hero-title">
                        Welcome to <span class="text-primary">STEFIA</span>
                    </h1>
                    <p class="hero-text">
                        Student Financial Information & Administration System - Your complete solution for managing student finances, scholarships, and administrative tasks.
                    </p>
                    <div class="hero-action">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-primary">Get Started</a>
                        <a href="#features" class="btn btn-lg btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="hero-image">
                    <img src="{{ asset('assets/images/slides/slide-a.jpg') }}" alt="STEFIA Dashboard" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section section-features" id="features">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-head text-center">
                    <h2 class="title">Why Choose STEFIA?</h2>
                    <p class="text">
                        Discover the powerful features that make STEFIA the perfect choice for managing student financial information.
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <em class="icon ni ni-user-list"></em>
                    </div>
                    <div class="feature-content">
                        <h4>Student Management</h4>
                        <p>Comprehensive student database with detailed profiles, enrollment tracking, and academic progress monitoring.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <em class="icon ni ni-wallet"></em>
                    </div>
                    <div class="feature-content">
                        <h4>Financial Management</h4>
                        <p>Complete financial tracking with payment processing, invoice generation, and comprehensive reporting.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <em class="icon ni ni-award"></em>
                    </div>
                    <div class="feature-content">
                        <h4>Scholarship Management</h4>
                        <p>Streamlined scholarship application process with automated eligibility checking and disbursement tracking.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <em class="icon ni ni-coin"></em>
                    </div>
                    <div class="feature-content">
                        <h4>Fee Management</h4>
                        <p>Automated fee calculation, payment reminders, and flexible payment plans for all student fees.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <em class="icon ni ni-bar-chart"></em>
                    </div>
                    <div class="feature-content">
                        <h4>Advanced Reporting</h4>
                        <p>Detailed analytics and reports for financial insights, student performance, and institutional metrics.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <em class="icon ni ni-shield-check"></em>
                    </div>
                    <div class="feature-content">
                        <h4>Secure & Reliable</h4>
                        <p>Enterprise-grade security with data encryption, backup systems, and role-based access control.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section section-stats bg-light">
    <div class="container">
        <div class="row g-gs">
            <div class="col-lg-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <em class="icon ni ni-user"></em>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">2,568</h3>
                        <p class="stat-text">Active Students</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <em class="icon ni ni-building"></em>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">150</h3>
                        <p class="stat-text">Institutions</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <em class="icon ni ni-award"></em>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">486</h3>
                        <p class="stat-text">Scholarships</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon">
                        <em class="icon ni ni-wallet"></em>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">$2.5M</h3>
                        <p class="stat-text">Managed Funds</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section section-about" id="about">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="title">About STEFIA</h2>
                    <p>
                        STEFIA is a comprehensive Student Financial Information & Administration System designed to streamline educational financial management. Our platform brings together all aspects of student finance management into one unified solution.
                    </p>
                    <div class="about-features">
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle"></em>
                            <span>Complete student financial tracking</span>
                        </div>
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle"></em>
                            <span>Automated scholarship management</span>
                        </div>
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle"></em>
                            <span>Real-time financial reporting</span>
                        </div>
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle"></em>
                            <span>Secure payment processing</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="about-image">
                    <img src="{{ asset('assets/images/slides/slide-b.jpg') }}" alt="About STEFIA" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section section-cta bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="cta-content text-center">
                    <h2 class="title text-white">Ready to Get Started?</h2>
                    <p class="text text-white">
                        Join thousands of institutions already using STEFIA to manage their student financial operations efficiently.
                    </p>
                    <div class="cta-action">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-white">Start Your Journey</a>
                        <a href="{{ route('login') }}" class="btn btn-lg btn-outline-white">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section section-contact" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-head text-center">
                    <h2 class="title">Get in Touch</h2>
                    <p class="text">
                        Have questions about STEFIA? We're here to help you get started with our platform.
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-gs">
            <div class="col-lg-4">
                <div class="contact-item">
                    <div class="contact-icon">
                        <em class="icon ni ni-mail"></em>
                    </div>
                    <div class="contact-content">
                        <h4>Email Support</h4>
                        <p>support@stefia.com</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-item">
                    <div class="contact-icon">
                        <em class="icon ni ni-call"></em>
                    </div>
                    <div class="contact-content">
                        <h4>Phone Support</h4>
                        <p>+1 (555) 123-4567</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-item">
                    <div class="contact-icon">
                        <em class="icon ni ni-map-pin"></em>
                    </div>
                    <div class="contact-content">
                        <h4>Office Location</h4>
                        <p>123 Education St, Learning City</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Custom styles for landing page */
.section-hero {
    padding: 100px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-title {
    font-size: 3rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
}

.hero-text {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}

.hero-action .btn {
    margin-right: 1rem;
}

.section-features {
    padding: 80px 0;
}

.feature-card {
    text-align: center;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 10px;
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.section-stats {
    padding: 60px 0;
}

.stat-card {
    text-align: center;
    padding: 2rem;
}

.stat-icon {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.section-about {
    padding: 80px 0;
}

.about-features {
    margin-top: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.feature-item .icon {
    color: #48bb78;
    margin-right: 1rem;
}

.section-cta {
    padding: 80px 0;
}

.cta-action .btn {
    margin: 0 0.5rem;
}

.section-contact {
    padding: 80px 0;
}

.contact-item {
    text-align: center;
    padding: 2rem;
}

.contact-icon {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
}
</style>
@endpush
