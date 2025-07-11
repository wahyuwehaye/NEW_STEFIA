@extends('layouts.landing')

@section('title', 'Welcome to STEFIA')

@section('content')
<!-- Hero Section -->
<section class="section section-hero bg-primary">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-75">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                    <h1 class="hero-title text-white mb-4">Welcome to STEFIA</h1>
                    <p class="hero-subtitle text-white-50 mb-5">Student Financial Information & Administration System</p>
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
<section class="section section-portals py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-inner">
                        <div class="text-center mb-4">
                            <div class="icon-circle bg-primary-soft">
                                <em class="icon ni ni-user-list text-primary"></em>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="card-title">Student Portal</h5>
                            <p class="card-text text-soft">Access your academic and financial information, view grades, fees, scholarships, and manage your profile</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-inner">
                        <div class="text-center mb-4">
                            <div class="icon-circle bg-success-soft">
                                <em class="icon ni ni-setting text-success"></em>
                            </div>
                        </div>
                        <div class="text-center">
                            <h5 class="card-title">Staff Portal</h5>
                            <p class="card-text text-soft">Manage student records and finances, handle registrations, fees, scholarships, and generate reports</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="section section-feature bg-light py-5">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Key Features</h2>
                <p class="section-subtitle text-soft">Everything you need to manage student financial information</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle bg-primary-soft">
                            <em class="icon ni ni-users text-primary"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title">Student Management</h5>
                        <p class="feature-text text-soft">Comprehensive student registration, profile management, and academic tracking</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle bg-success-soft">
                            <em class="icon ni ni-wallet text-success"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title">Financial Management</h5>
                        <p class="feature-text text-soft">Fee collection, payment tracking, financial reporting, and budget management</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle bg-info-soft">
                            <em class="icon ni ni-gift text-info"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title">Scholarship Management</h5>
                        <p class="feature-text text-soft">Scholarship applications, approvals, distributions, and tracking</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section section-about py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title mb-4">About STEFIA</h2>
                    <p class="text-soft mb-4">STEFIA (Student Financial Information & Administration) is a comprehensive management system designed to streamline student financial operations and administrative processes.</p>
                    <p class="text-soft mb-4">Our platform provides institutions with powerful tools to manage student records, track financial transactions, handle scholarship programs, and generate detailed reports.</p>
                    <div class="about-features">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-success"></em>
                                    <span class="ms-2">Secure & Reliable</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-success"></em>
                                    <span class="ms-2">User Friendly</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-success"></em>
                                    <span class="ms-2">24/7 Support</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-success"></em>
                                    <span class="ms-2">Mobile Ready</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-image text-center">
                    <div class="image-placeholder bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                        <div class="text-center">
                            <em class="icon ni ni-building text-primary" style="font-size: 4rem;"></em>
                            <p class="text-soft mt-3">STEFIA Dashboard Preview</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section section-contact bg-light py-5">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Get in Touch</h2>
                <p class="section-subtitle text-soft">Need help or have questions? Contact our support team</p>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-icon mb-3">
                        <div class="icon-circle bg-primary-soft">
                            <em class="icon ni ni-mail text-primary"></em>
                        </div>
                    </div>
                    <div class="contact-content">
                        <h6 class="contact-title">Email Support</h6>
                        <p class="contact-text text-soft">support@stefia.edu</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-icon mb-3">
                        <div class="icon-circle bg-success-soft">
                            <em class="icon ni ni-call text-success"></em>
                        </div>
                    </div>
                    <div class="contact-content">
                        <h6 class="contact-title">Phone Support</h6>
                        <p class="contact-text text-soft">+1 (555) 123-4567</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
