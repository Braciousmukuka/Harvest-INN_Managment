<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="HarvestInn is a comprehensive farm management platform designed to optimize agricultural operations, track crops and livestock, and increase farm productivity.">
        <meta name="keywords" content="farm management, agriculture software, crop tracking, livestock management, harvest planning, farming technology, HarvestInn">

        <title>HarvestInn - Farm Management System</title>

        <!-- PWA Meta Tags -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#087112">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="HarvestInn">
        <link rel="apple-touch-icon" href="{{ asset('pwa-icons/apple-touch-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Custom CSS -->
        <style>
            :root {
                --primary: #087112;
                --secondary: #fab200;
            }
            
            body {
                font-family: 'Figtree', sans-serif;
                color: #333;
            }
            
            .bg-primary-custom {
                background-color: var(--primary);
            }
            
            .bg-secondary-custom {
                background-color: var(--secondary);
            }
            
            .text-primary-custom {
                color: var(--primary);
            }
            
            .text-secondary-custom {
                color: var(--secondary);
            }
            
            .btn-primary-custom {
                background-color: var(--primary);
                border-color: var(--primary);
                color: white;
            }
            
            .btn-primary-custom:hover {
                background-color: #065d0e;
                border-color: #065d0e;
                color: white;
            }
            
            .btn-secondary-custom {
                background-color: var(--secondary);
                border-color: var(--secondary);
                color: white;
            }
            
            .btn-secondary-custom:hover {
                background-color: #e59e00;
                border-color: #e59e00;
                color: white;
            }
            
            .hero {
                background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), url('{{ asset("assets/images/landing/img-header-bg.png") }}');
                background-size: cover;
                background-position: center;
                padding: 120px 0;
            }
            
            .feature-icon {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background-color: rgba(8, 113, 18, 0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
            }
            
            .feature-icon i {
                font-size: 32px;
                color: var(--primary);
            }
            
            .testimonial {
                background-color: #f8f9fa;
                padding: 30px;
                border-radius: 10px;
                margin-bottom: 30px;
            }
            
            .footer {
                background-color: #333;
                color: white;
                padding: 60px 0 30px;
            }
            
            .footer a {
                color: rgba(255,255,255,0.8);
                text-decoration: none;
            }
            
            .footer a:hover {
                color: var(--secondary);
            }
            
            /* PWA Section Styles */
            #pwa-install-hero {
                animation: pulseGreen 2s infinite;
            }
            
            @keyframes pulseGreen {
                0% { box-shadow: 0 0 0 0 rgba(8, 113, 18, 0.7); }
                70% { box-shadow: 0 0 0 10px rgba(8, 113, 18, 0); }
                100% { box-shadow: 0 0 0 0 rgba(8, 113, 18, 0); }
            }
            
            .pwa-feature-icon {
                font-size: 24px;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: rgba(8, 113, 18, 0.1);
            }
            
            /* PWA Install Popup Styles */
            .pwa-install-popup {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: linear-gradient(135deg, #087112, #0a8f1a);
                color: white;
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                max-width: 350px;
                z-index: 1050;
                transform: translateY(100px);
                opacity: 0;
                transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                border: 2px solid rgba(255,255,255,0.2);
            }
            
            .pwa-install-popup.show {
                transform: translateY(0);
                opacity: 1;
            }
            
            .pwa-install-popup .close-btn {
                position: absolute;
                top: 10px;
                right: 15px;
                background: none;
                border: none;
                color: white;
                font-size: 20px;
                cursor: pointer;
                opacity: 0.7;
                transition: opacity 0.3s;
            }
            
            .pwa-install-popup .close-btn:hover {
                opacity: 1;
            }
            
            .pwa-popup-icon {
                font-size: 40px;
                margin-bottom: 10px;
                display: block;
                text-align: center;
                animation: bounce 2s infinite;
            }
            
            /* Enhanced Modern Styles */
            .brand-gradient {
                background: linear-gradient(135deg, #28a745, #20c997);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .btn-modern {
                border-radius: 25px;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            }
            
            .btn-modern:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            }
            
            .hero-section {
                background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
                padding-top: 120px; /* Add top padding to account for fixed navbar */
            }
            
            .hero-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(40,167,69,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
                opacity: 0.5;
            }
            
            .hero-content {
                position: relative;
                z-index: 2;
            }
            
            .hero-pattern {
                position: absolute;
                top: 50%;
                right: -10%;
                width: 500px;
                height: 500px;
                background: linear-gradient(45deg, rgba(40,167,69,0.1) 0%, rgba(32,201,151,0.1) 100%);
                border-radius: 50%;
                transform: translateY(-50%);
                z-index: 1;
            }
            
            .hero-pattern::before {
                content: '';
                position: absolute;
                top: 20%;
                left: 20%;
                width: 60%;
                height: 60%;
                background: linear-gradient(45deg, rgba(40,167,69,0.05) 0%, rgba(32,201,151,0.05) 100%);
                border-radius: 50%;
            }
            
            .hero-badge {
                background: linear-gradient(135deg, rgba(40,167,69,0.1) 0%, rgba(32,201,151,0.1) 100%);
                border: 1px solid rgba(40,167,69,0.2);
            }
            
            .floating-stats {
                animation: float 6s ease-in-out infinite;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            
            .trust-indicator {
                padding: 12px 20px;
                background: rgba(40,167,69,0.05);
                border-radius: 50px;
                border: 1px solid rgba(40,167,69,0.1);
            }
            
            .feature-card {
                background: white;
                border-radius: 20px;
                padding: 2.5rem;
                height: 100%;
                transition: all 0.3s ease;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            }
            
            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            }
            
            .feature-icon-modern {
                background: linear-gradient(135deg, #28a745, #20c997);
                color: white;
                width: 80px;
                height: 80px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                margin: 0 auto 1.5rem;
            }
            
            .pulse-animation {
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
                70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
                100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
            }
            
            .section-title {
                position: relative;
                display: inline-block;
                margin-bottom: 3rem;
            }
            
            .section-title::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 4px;
                background: linear-gradient(135deg, #28a745, #20c997);
                border-radius: 2px;
            }
            
            .stats-card {
                background: white;
                border-radius: 15px;
                padding: 2rem;
                text-align: center;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }
            
            .stats-card:hover {
                transform: translateY(-5px);
            }
            
            .stats-number {
                font-size: 3rem;
                font-weight: bold;
                background: linear-gradient(135deg, #28a745, #20c997);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .pwa-section-modern {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                border-radius: 20px;
                padding: 3rem;
                margin: 3rem 0;
                text-align: center;
            }
            
            .install-popup {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.8);
                z-index: 9999;
                display: none;
                justify-content: center;
                align-items: center;
            }
            
            .install-popup-content {
                background: white;
                padding: 2rem;
                border-radius: 20px;
                max-width: 500px;
                margin: 20px;
                text-align: center;
                animation: popupSlide 0.3s ease;
            }
            
            @keyframes popupSlide {
                from { transform: translateY(-50px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            
            .help-modal .modal-content {
                border-radius: 20px;
                border: none;
            }
            
            .help-modal .modal-header {
                background: linear-gradient(135deg, #28a745, #20c997);
                color: white;
                border-radius: 20px 20px 0 0;
            }
            
            .btn-close-white {
                filter: brightness(0) invert(1);
            }
            
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
            
            .pwa-popup-buttons {
                display: flex;
                gap: 10px;
                margin-top: 15px;
            }
            
            .pwa-popup-btn {
                flex: 1;
                padding: 10px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-weight: 600;
                transition: all 0.3s;
            }
            
            .pwa-popup-btn.primary {
                background: #fab200;
                color: #333;
            }
            
            .pwa-popup-btn.primary:hover {
                background: #e59e00;
                transform: translateY(-2px);
            }
            
            .pwa-popup-btn.secondary {
                background: rgba(255,255,255,0.2);
                color: white;
                border: 1px solid rgba(255,255,255,0.3);
            }
            
            .pwa-popup-btn.secondary:hover {
                background: rgba(255,255,255,0.3);
            }
            
            @media (max-width: 768px) {
                .pwa-install-popup {
                    bottom: 10px;
                    right: 10px;
                    left: 10px;
                    max-width: none;
                }
            }
        </style>
    </head>
    <body>
        <!-- Navigation -->
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="#" style="font-size: 1.6rem;">
                <img src="{{ asset('Harvest.svg') }}" alt="Harvest INN" style="height: 45px; width: 45px;" class="me-2">
                <span class="brand-gradient">Harvest INN</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item me-3">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-modern px-4 py-2">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                        @else
                            <li class="nav-item me-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-modern px-4 py-2">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item me-3">
                                    <a href="{{ route('register') }}" class="btn btn-success btn-modern px-4 py-2">
                                        <i class="fas fa-user-plus me-2"></i>Get Started
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                    
                    <li class="nav-item me-2">
                        <button class="btn btn-outline-success btn-sm install-help-btn" onclick="showInstallHelp()" id="helpInstallBtn" style="display: none;">
                            <i class="fas fa-question-circle"></i> Install Help
                        </button>
                    </li>
                    
                    <li class="nav-item">
                        <button class="btn btn-success btn-sm pwa-install-btn pulse-animation" id="installBtn" onclick="installPWA()" style="display: none;">
                            <i class="fas fa-download me-1"></i>
                            <span class="install-text">Install App</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-pattern"></div>
            <div class="container hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="hero-text">
                            <div class="mb-3">
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">
                                    <i class="fas fa-leaf me-2"></i>Modern Farm Management
                                </span>
                            </div>
                            <h1 class="display-3 fw-bold mb-4 text-dark">
                                <span class="d-block">Transform Your</span>
                                <span class="text-success">Farm Operations</span>
                            </h1>
                            <p class="lead mb-5 text-muted fs-5">
                                HarvestInn empowers modern farmers with intelligent tools to optimize operations, 
                                track livestock, monitor crops, and maximize productivity through data-driven insights.
                            </p>
                            <div class="d-flex flex-wrap gap-3 mb-5">
                                @if (Route::has('login'))
                                    @auth
                                        <a href="{{ url('/dashboard') }}" class="btn btn-success btn-modern btn-lg px-5 py-3">
                                            <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                                        </a>
                                    @else
                                        <a href="{{ route('register') }}" class="btn btn-success btn-modern btn-lg px-5 py-3">
                                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                                        </a>
                                        <a href="{{ route('login') }}" class="btn btn-outline-success btn-modern btn-lg px-5 py-3">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login
                                        </a>
                                    @endauth
                                @endif
                            </div>
                            
                            <!-- Trust Indicators -->
                            <div class="d-flex flex-wrap gap-3">
                                <div class="trust-indicator">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span class="text-dark">Free 30-day trial</span>
                                </div>
                                <div class="trust-indicator">
                                    <i class="fas fa-shield-alt text-success me-2"></i>
                                    <span class="text-dark">Secure & reliable</span>
                                </div>
                                <div class="trust-indicator">
                                    <i class="fas fa-users text-success me-2"></i>
                                    <span class="text-dark">50,000+ farmers</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image text-center position-relative">
                            <!-- Stats Cards Floating -->
                            <div class="position-absolute top-0 end-0 d-none d-lg-block floating-stats" style="z-index: 10; animation-delay: 0s;">
                                <div class="stats-card" style="width: 140px;">
                                    <div class="stats-number" style="font-size: 2rem;">50K+</div>
                                    <small class="text-muted">Happy Farmers</small>
                                </div>
                            </div>
                            
                            <div class="position-absolute floating-stats" style="bottom: 20%; left: 0; z-index: 10; animation-delay: 2s;">
                                <div class="stats-card" style="width: 140px;">
                                    <div class="stats-number" style="font-size: 2rem;">1M+</div>
                                    <small class="text-muted">Acres Managed</small>
                                </div>
                            </div>
                            
                            <div class="position-absolute floating-stats" style="top: 50%; right: -20px; z-index: 10; animation-delay: 4s;">
                                <div class="stats-card" style="width: 120px;">
                                    <div class="stats-number" style="font-size: 1.8rem;">99%</div>
                                    <small class="text-muted">Uptime</small>
                                </div>
                            </div>
                            
                            <img src="{{ asset('Harvest.svg') }}" alt="Farm Management" class="img-fluid" style="max-height: 450px; filter: drop-shadow(0 20px 40px rgba(40,167,69,0.2));">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5 bg-light" id="features">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold section-title">Powerful Features</h2>
                    <p class="lead text-muted fs-5">Everything you need to modernize your farm operations</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card text-center h-100">
                            <div class="feature-icon-modern mx-auto">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Crop Management</h4>
                            <p class="text-muted">Track planting schedules, monitor crop health, and optimize harvesting times with intelligent insights.</p>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card text-center h-100">
                            <div class="feature-icon-modern mx-auto">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Analytics Dashboard</h4>
                            <p class="text-muted">Get real-time insights with comprehensive analytics and reporting tools for data-driven decisions.</p>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card text-center h-100">
                            <div class="feature-icon-modern mx-auto">
                                <i class="fas fa-egg"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Incubation Tracking</h4>
                            <p class="text-muted">Monitor egg batches, track hatching progress, and manage incubation cycles with precision.</p>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card text-center h-100">
                            <div class="feature-icon-modern mx-auto">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Inventory Management</h4>
                            <p class="text-muted">Keep track of products, supplies, and equipment with automated inventory tracking systems.</p>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card text-center h-100">
                            <div class="feature-icon-modern mx-auto">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Mobile Ready</h4>
                            <p class="text-muted">Access your farm data anywhere with our progressive web app that works offline.</p>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="feature-card text-center h-100">
                            <div class="feature-icon-modern mx-auto">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Secure & Reliable</h4>
                            <p class="text-muted">Your data is protected with enterprise-grade security and 99.9% uptime guarantee.</p>
                            <div class="mt-auto">
                                <a href="#" class="btn btn-outline-success btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-5 bg-light" id="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="{{ asset('assets/images/landing/img-feature-1.svg') }}" alt="About HarvestInn" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-lg-6">
                        <h2 class="display-5 fw-bold mb-4">Why Choose HarvestInn?</h2>
                        <p class="mb-4">Our farm management system is designed with farmers in mind, providing intuitive tools that make agricultural management easier and more efficient.</p>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 text-primary-custom">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <p class="mb-0">Easy-to-use interface designed for farmers</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 text-primary-custom">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <p class="mb-0">Accessible from any device - desktop, tablet, or mobile</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 text-primary-custom">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <p class="mb-0">Comprehensive reporting and analytics</p>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3 text-primary-custom">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <p class="mb-0">Regular updates with new features based on farmer feedback</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PWA Section -->
        <section class="py-5">
            <div class="container">
                <div class="pwa-section-modern">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <i class="fas fa-mobile-alt text-primary" style="font-size: 150px; opacity: 0.9;"></i>
                                    <div class="position-absolute top-50 start-50 translate-middle">
                                        <i class="fas fa-seedling text-success" style="font-size: 40px;"></i>
                                    </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-center gap-3">
                                    <div class="pwa-feature-icon text-success">
                                        <i class="fas fa-download"></i>
                                    </div>
                                    <div class="pwa-feature-icon text-warning">
                                        <i class="fas fa-sync-alt"></i>
                                    </div>
                                    <div class="pwa-feature-icon text-info">
                                        <i class="fas fa-wifi"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h2 class="display-6 fw-bold mb-4 section-title">Take Your Farm Mobile</h2>
                            <p class="lead mb-4 text-muted">Install HarvestInn as a Progressive Web App (PWA) and get native app performance with offline capabilities.</p>
                            
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-icon-modern me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            <i class="fas fa-wifi-slash text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Works Offline</h6>
                                            <small class="text-muted">Access your data without internet</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-icon-modern me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            <i class="fas fa-rocket text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Lightning Fast</h6>
                                            <small class="text-muted">Native app performance</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-icon-modern me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            <i class="fas fa-home text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Home Screen</h6>
                                            <small class="text-muted">Add to device home screen</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-icon-modern me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            <i class="fas fa-bell text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-1">Push Notifications</h6>
                                            <small class="text-muted">Stay updated with alerts</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex flex-wrap gap-3">
                                <button class="btn btn-success btn-modern btn-lg px-4" id="pwa-install-hero" onclick="installPWA()">
                                    <i class="fas fa-download me-2"></i>Install App Now
                                </button>
                                <button class="btn btn-outline-primary btn-modern btn-lg px-4" onclick="showInstallHelp()">
                                    <i class="fas fa-question-circle me-2"></i>How to Install
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        </section>

        <!-- CTA Section -->
        <section class="py-5 bg-dark text-white text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="display-5 fw-bold mb-4">Ready to Transform Your Farm?</h2>
                        <p class="lead mb-5 text-white-50">Join thousands of farmers who are already optimizing their operations with HarvestInn's intelligent platform.</p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="{{ route('register') }}" class="btn btn-success btn-modern btn-lg px-5">
                                <i class="fas fa-rocket me-2"></i>Start Free Trial
                            </a>
                            <a href="#features" class="btn btn-outline-light btn-modern btn-lg px-5">
                                <i class="fas fa-play me-2"></i>Watch Demo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-dark text-white py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="mb-3">
                            <img src="{{ asset('Harvest.svg') }}" alt="HarvestInn Logo" height="50" class="mb-3" style="filter: brightness(0) invert(1);">
                            <h5 class="brand-gradient">HarvestInn</h5>
                        </div>
                        <p class="text-white-50 mb-4">Empowering farmers with intelligent tools for modern agriculture management and sustainable growth.</p>
                        <div class="d-flex gap-3">
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle" style="width: 40px; height: 40px;">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h6 class="fw-bold mb-3">Product</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#features" class="text-white-50 text-decoration-none">Features</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Pricing</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Mobile App</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">API</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h6 class="fw-bold mb-3">Company</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">About Us</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Blog</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Careers</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Press</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                        <h6 class="fw-bold mb-3">Support</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Help Center</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Documentation</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Community</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <h6 class="fw-bold mb-3">Legal</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Terms of Service</a></li>
                            <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Cookie Policy</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="my-4 border-secondary">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-white-50 mb-0">&copy; 2025 HarvestInn. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>


        <!-- PWA Install Popup -->
        <div id="pwa-install-popup" class="pwa-install-popup">
            <button class="close-btn" onclick="closePWAPopup()">&times;</button>
            <div class="text-center">
                <i class="fas fa-mobile-alt pwa-popup-icon"></i>
                <h5 class="mb-2">📱 Install HarvestInn App</h5>
                <p class="mb-0 small">Get faster access, work offline, and enjoy a native app experience!</p>
            </div>
            <div class="pwa-popup-buttons">
                <button id="popup-install-btn" class="pwa-popup-btn primary" style="display: none;">
                    <i class="fas fa-download me-1"></i>Install Now
                </button>
                <button class="pwa-popup-btn primary" onclick="showInstallHelp()" id="popup-help-btn">
                    <i class="fas fa-info-circle me-1"></i>How to Install
                </button>
                <button class="pwa-popup-btn secondary" onclick="closePWAPopup()">
                    <i class="fas fa-times me-1"></i>Later
                </button>
            </div>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- PWA Functionality -->
        <script>
            let deferredPrompt;
            const installButton = document.getElementById('pwa-install-hero');
            const popupInstallBtn = document.getElementById('popup-install-btn');
            const installPopup = document.getElementById('pwa-install-popup');

            // Register service worker first
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            }

            // Show install button when PWA can be installed
            window.addEventListener('beforeinstallprompt', (e) => {
                console.log('beforeinstallprompt event fired');
                e.preventDefault();
                deferredPrompt = e;
                
                // Show install buttons
                installButton.style.display = 'inline-flex';
                popupInstallBtn.style.display = 'inline-block';
                
                // Hide the help button in popup when install is available
                document.getElementById('popup-help-btn').style.display = 'none';
            });

            // Handle install button clicks (both main and popup)
            function handleInstallClick() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('PWA was installed');
                            closePWAPopup();
                        }
                        deferredPrompt = null;
                        installButton.style.display = 'none';
                        popupInstallBtn.style.display = 'none';
                    });
                }
            }

            // Attach click handlers
            installButton.addEventListener('click', handleInstallClick);
            popupInstallBtn.addEventListener('click', handleInstallClick);

            // Hide install button if already installed
            window.addEventListener('appinstalled', () => {
                console.log('PWA was installed');
                installButton.style.display = 'none';
                popupInstallBtn.style.display = 'none';
                closePWAPopup();
                deferredPrompt = null;
            });

            // PWA Popup Management
            function showPWAPopup() {
                // Check if user has dismissed popup recently
                const dismissed = localStorage.getItem('pwa-popup-dismissed');
                const dismissedTime = dismissed ? parseInt(dismissed) : 0;
                const oneDayAgo = Date.now() - (24 * 60 * 60 * 1000); // 24 hours
                
                // Check if already installed
                const isInstalled = window.matchMedia('(display-mode: standalone)').matches;
                
                if (!dismissed || dismissedTime < oneDayAgo) {
                    if (!isInstalled) {
                        setTimeout(() => {
                            installPopup.classList.add('show');
                        }, 3000); // Show after 3 seconds
                    }
                }
            }

            function closePWAPopup() {
                installPopup.classList.remove('show');
                // Remember dismissal for 24 hours
                localStorage.setItem('pwa-popup-dismissed', Date.now().toString());
            }

            // Check if app is already installed
            window.addEventListener('DOMContentLoaded', () => {
                if (window.matchMedia('(display-mode: standalone)').matches) {
                    console.log('App is running in standalone mode');
                    installButton.style.display = 'none';
                } else {
                    // Show popup for new visitors
                    showPWAPopup();
                }
                
                // For development - show some debug info
                if (location.hostname === '127.0.0.1' || location.hostname === 'localhost') {
                    console.log('PWA Debug Info:');
                    console.log('- ServiceWorker supported:', 'serviceWorker' in navigator);
                    console.log('- Running standalone:', window.matchMedia('(display-mode: standalone)').matches);
                    console.log('- HTTPS/localhost:', location.protocol === 'https:' || location.hostname === 'localhost' || location.hostname === '127.0.0.1');
                }
            });

            // Auto-hide popup after 30 seconds if no interaction
            setTimeout(() => {
                if (installPopup.classList.contains('show')) {
                    closePWAPopup();
                }
            }, 30000);

            // PWA Help Modal Function
            function showPWAHelp() {
                showInstallHelp();
            }
            
            function showInstallHelp() {
                const userAgent = navigator.userAgent.toLowerCase();
                let instructions = '';
                
                if (userAgent.includes('chrome') && !userAgent.includes('edg')) {
                    instructions = `
                        <h6><i class="fab fa-chrome me-2"></i>Chrome Installation:</h6>
                        <ol class="small">
                            <li>Look for the install button in the address bar</li>
                            <li>Or use the menu → "Install HarvestInn..."</li>
                            <li>Click "Install" in the popup</li>
                        </ol>
                    `;
                } else if (userAgent.includes('safari') && !userAgent.includes('chrome')) {
                    instructions = `
                        <h6><i class="fab fa-safari me-2"></i>Safari Installation:</h6>
                        <ol class="small">
                            <li>Tap the Share button (square with arrow)</li>
                            <li>Scroll down and tap "Add to Home Screen"</li>
                            <li>Tap "Add" to confirm</li>
                        </ol>
                    `;
                } else if (userAgent.includes('edg')) {
                    instructions = `
                        <h6><i class="fab fa-edge me-2"></i>Edge Installation:</h6>
                        <ol class="small">
                            <li>Look for the install button in the address bar</li>
                            <li>Or use Settings → "Apps" → "Install this site as an app"</li>
                            <li>Click "Install" in the popup</li>
                        </ol>
                    `;
                } else {
                    instructions = `
                        <h6><i class="fas fa-mobile-alt me-2"></i>General Installation:</h6>
                        <ol class="small">
                            <li>Look for an install or "Add to Home Screen" option in your browser menu</li>
                            <li>Follow the prompts to install the app</li>
                            <li>The app will appear on your home screen</li>
                        </ol>
                    `;
                }

                const modalHtml = `
                    <div class="modal fade" id="pwaHelpModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        <i class="fas fa-download me-2 text-primary"></i>
                                        Install HarvestInn App
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center mb-3">
                                        <i class="fas fa-mobile-alt text-success" style="font-size: 48px;"></i>
                                    </div>
                                    <p class="text-muted mb-3">Get the native app experience for HarvestInn:</p>
                                    ${instructions}
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Benefits:</strong> Offline access, faster loading, home screen icon, and push notifications.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="{{ route('register') }}" class="btn btn-primary">Try Online Instead</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                // Remove existing modal if any
                const existingModal = document.getElementById('pwaHelpModal');
                if (existingModal) {
                    existingModal.remove();
                }

                // Add modal to body
                document.body.insertAdjacentHTML('beforeend', modalHtml);
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('pwaHelpModal'));
                modal.show();
            }
        </script>
    </body>
</html>
