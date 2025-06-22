<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HydroMonitor - Sistem Monitoring Hidroponik IoT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <style>
        :root {
            --primary-green: #2d8f47;
            --light-green: #4ade80;
            --accent-blue: #0ea5e9;
            --soft-blue: #e0f2fe;
            --dark-green: #1e5d32;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --gradient-bg: linear-gradient(135deg, #0ea5e9 0%, #2d8f47 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            overflow-x: hidden;
            background: linear-gradient(135deg, #f0fdfa 0%, #ecfdf5 50%, #f0f9ff 100%);
        }

        .hero-section {
            min-height: 100vh;
            background: var(--gradient-bg);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M30 30c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zm-20-18c9.941 0 18 8.059 18 18s-8.059 18-18 18S-8 39.941-8 30s8.059-18 18-18z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
            opacity: 0.1;
        }

        .floating-leaves {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .leaf {
            position: absolute;
            color: rgba(255, 255, 255, 0.2);
            font-size: 2rem;
            animation: float 6s ease-in-out infinite;
        }

        .leaf:nth-child(1) { top: 20%; left: 10%; animation-delay: 0s; }
        .leaf:nth-child(2) { top: 60%; left: 20%; animation-delay: 2s; }
        .leaf:nth-child(3) { top: 30%; right: 15%; animation-delay: 4s; }
        .leaf:nth-child(4) { bottom: 20%; right: 25%; animation-delay: 1s; }
        .leaf:nth-child(5) { top: 70%; right: 40%; animation-delay: 3s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            max-width: 600px;
            opacity: 0.9;
        }

        .section {
            padding: 80px 0;
            position: relative;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary-green);
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-bg);
            border-radius: 2px;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease;
            border: 1px solid rgba(45, 143, 71, 0.1);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-bg);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(45, 143, 71, 0.2);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 1.8rem;
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(45, 143, 71, 0.3);
        }

        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--primary-green);
        }

        .feature-description {
            color: var(--text-light);
            line-height: 1.7;
        }

        .tech-badge {
            display: inline-block;
            background: var(--soft-blue);
            color: var(--accent-blue);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            margin: 0.25rem;
            border: 2px solid rgba(14, 165, 233, 0.2);
            transition: all 0.3s ease;
        }

        .tech-badge:hover {
            background: var(--accent-blue);
            color: white;
            transform: scale(1.05);
        }

        .benefit-item {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
            border-left: 4px solid var(--primary-green);
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 30px rgba(45, 143, 71, 0.15);
        }

        .cta-section {
            background: var(--gradient-bg);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255, 255, 255, 0.05) 10px,
                rgba(255, 255, 255, 0.05) 20px
            );
            animation: slide 20s linear infinite;
        }

        @keyframes slide {
            0% { transform: translateX(-50px) translateY(-50px); }
            100% { transform: translateX(50px) translateY(50px); }
        }

        .dashboard-btn {
            background: white;
            color: var(--primary-green);
            padding: 1rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        .dashboard-btn:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            color: var(--primary-green);
            text-decoration: none;
        }

        .stats-counter {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-green);
            display: block;
        }

        .glow-effect {
            position: relative;
        }

        .glow-effect::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(45, 143, 71, 0.3) 0%, transparent 70%);
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.4s ease;
            pointer-events: none;
        }

        .glow-effect:hover::after {
            opacity: 1;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.2rem; }
            .section { padding: 60px 0; }
            .feature-card { padding: 2rem; }
        }
    </style>
</head>

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-leaves">
            <i class="fas fa-leaf leaf"></i>
            <i class="fas fa-seedling leaf"></i>
            <i class="fas fa-leaf leaf"></i>
            <i class="fas fa-seedling leaf"></i>
            <i class="fas fa-leaf leaf"></i>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title fade-in">Hydroponics</h1>
                        <p class="hero-subtitle fade-in">Sistem Monitoring Hidroponik Berbasis Web Realtime</p>
                        <p class="hero-description fade-in">
                            Revolusi pertanian modern dengan teknologi IoT dan MQTT untuk monitoring otomatis sistem hidroponik Anda. Pantau kondisi nutrisi dan tinggi air secara realtime, kapan saja dan di mana saja.
                        </p>
                        <div class="fade-in">
                            <span class="tech-badge"><i class="fas fa-wifi"></i> IoT Ready</span>
                            <span class="tech-badge"><i class="fas fa-chart-line"></i> Real-time</span>
                            <span class="tech-badge"><i class="fas fa-mobile-alt"></i> Responsive</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center fade-in">
                        <i class="fas fa-seedling" style="font-size: 15rem; color: rgba(255,255,255,0.8); filter: drop-shadow(0 10px 20px rgba(0,0,0,0.3));"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latar Belakang Section -->
    <section class="section" id="background">
        <div class="container">
            <h2 class="section-title fade-in">Latar Belakang</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="feature-card fade-in glow-effect">
                        <div class="text-center">
                            <div class="feature-icon mx-auto">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h3 class="feature-title">Tantangan Pertanian Modern</h3>
                            <p class="feature-description">
                                Dalam menghadapi tantangan pertanian modern, sistem hidroponik menjadi solusi alternatif dalam mengoptimalkan produksi tanaman di lahan terbatas. Namun, keberhasilan sistem ini sangat bergantung pada kestabilan parameter lingkungan seperti kadar nutrisi dan tinggi permukaan air. Pemantauan secara manual membutuhkan waktu, tenaga, dan berisiko terhadap keterlambatan dalam penanganan kondisi kritis.
                            </p>
                            <p class="feature-description">
                                <strong>Oleh karena itu, dibutuhkan sistem pemantauan otomatis berbasis web yang mampu menampilkan data secara realtime dan efisien.</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tujuan Section -->
    <section class="section" id="objectives" style="background: rgba(45, 143, 71, 0.05);">
        <div class="container">
            <h2 class="section-title fade-in">Tujuan Proyek</h2>
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-in glow-effect">
                        <div class="feature-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <h3 class="feature-title">Dashboard Web</h3>
                        <p class="feature-description">
                            Mengembangkan dashboard berbasis web yang menampilkan data sensor hidroponik secara realtime.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-in glow-effect">
                        <div class="feature-icon">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h3 class="feature-title">Integrasi IoT</h3>
                        <p class="feature-description">
                            Mengintegrasikan sensor fisik menggunakan protokol MQTT melalui perangkat IoT.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-in glow-effect">
                        <div class="feature-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h3 class="feature-title">Penyimpanan Data</h3>
                        <p class="feature-description">
                            Menyediakan fitur penyimpanan riwayat data lokal untuk keperluan analisis sederhana.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card fade-in glow-effect">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Efisiensi Waktu</h3>
                        <p class="feature-description">
                            Mempermudah pengguna memantau kondisi sistem tanpa perlu datang ke lokasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Manfaat Section -->
    <section class="section" id="benefits">
        <div class="container">
            <h2 class="section-title fade-in">Manfaat Sistem</h2>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="benefit-item fade-in">
                        <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-clock text-success me-2"></i>
                            Monitoring 24/7
                        </h4>
                        <p>Memberikan kemudahan monitoring sistem hidroponik kapan saja dan di mana saja.</p>
                    </div>
                    <div class="benefit-item fade-in">
                        <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-brain text-success me-2"></i>
                            Pengambilan Keputusan Cerdas
                        </h4>
                        <p>Membantu pengguna dalam pengambilan keputusan secara cepat dan tepat berdasarkan data aktual.</p>
                    </div>
                    <div class="benefit-item fade-in">
                        <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-cogs text-success me-2"></i>
                            Efisiensi Operasional
                        </h4>
                        <p>Meningkatkan efisiensi operasional dan mengurangi potensi kerusakan sistem akibat keterlambatan penanganan.</p>
                    </div>
                    <div class="benefit-item fade-in">
                        <h4 style="color: var(--primary-green); margin-bottom: 0.5rem;">
                            <i class="fas fa-leaf text-success me-2"></i>
                            Smart Farming
                        </h4>
                        <p>Mendorong penerapan teknologi IoT pada sektor pertanian sebagai solusi pertanian cerdas (smart farming).</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Teknologi Section -->
    <section class="section" id="technology" style="background: rgba(14, 165, 233, 0.05);">
        <div class="container">
            <h2 class="section-title fade-in">Teknologi yang Digunakan</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in glow-effect text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <h3 class="feature-title">Hardware</h3>
                        <div class="tech-badge">ESP8266</div>
                        <div class="tech-badge">Sensor TDS</div>
                        <div class="tech-badge">Sensor Ultrasonik</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in glow-effect text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-network-wired"></i>
                        </div>
                        <h3 class="feature-title">Protocol</h3>
                        <div class="tech-badge">MQTT</div>
                        <div class="tech-badge">WebSocket</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in glow-effect text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-code"></i>
                        </div>
                        <h3 class="feature-title">Frontend</h3>
                        <div class="tech-badge">HTML5</div>
                        <div class="tech-badge">Bootstrap</div>
                        <div class="tech-badge">JavaScript</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card fade-in glow-effect text-center">
                        <div class="feature-icon mx-auto">
                            <i class="fas fa-server"></i>
                        </div>
                        <h3 class="feature-title">Backend</h3>
                        <div class="tech-badge">Laravel</div>
                        <div class="tech-badge">localStorage</div>
                        <div class="tech-badge">Database</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="display-4 fw-bold mb-4 fade-in">
                        Siap Memulai Smart Farming?
                    </h2>
                    <p class="lead mb-5 fade-in">
                        Bergabunglah dengan revolusi pertanian digital dan rasakan kemudahan monitoring hidroponik secara realtime
                    </p>
                    <div class="fade-in">
                        <a href="{{ route('dashboard') }}" class="dashboard-btn">
                            <i class="fas fa-rocket me-2"></i>
                            Lanjut ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4 text-center fade-in">
                    <div class="stats-counter" data-target="24">0</div>
                    <p>Jam Monitoring</p>
                </div>
                <div class="col-md-4 text-center fade-in">
                    <div class="stats-counter" data-target="100">0</div>
                    <p>% Akurasi Data</p>
                </div>
                <div class="col-md-4 text-center fade-in">
                    <div class="stats-counter" data-target="0">0</div>
                    <p>Downtime (Menit)</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Register ScrollTrigger plugin
        gsap.registerPlugin(ScrollTrigger);

        // Initial animations
        gsap.set('.fade-in', { opacity: 0, y: 50 });

        // Hero animations
        gsap.timeline()
            .to('.hero-title', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' })
            .to('.hero-subtitle', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }, '-=0.7')
            .to('.hero-description', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }, '-=0.7')
            .to('.hero-content .tech-badge', { opacity: 1, y: 0, duration: 0.8, stagger: 0.1, ease: 'power3.out' }, '-=0.5')
            .to('.col-lg-6 .fade-in', { opacity: 1, y: 0, duration: 1, ease: 'power3.out' }, '-=1');

        // Scroll-triggered animations
        gsap.utils.toArray('.section .fade-in').forEach((element, index) => {
            gsap.to(element, {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: element,
                    start: 'top 85%',
                    end: 'bottom 15%',
                    toggleActions: 'play none none reverse'
                }
            });
        });

        // Feature cards hover animations
        gsap.utils.toArray('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, { scale: 1.02, duration: 0.3, ease: 'power2.out' });
            });
            
            card.addEventListener('mouseleave', () => {
                gsap.to(card, { scale: 1, duration: 0.3, ease: 'power2.out' });
            });
        });

        // Counter animation
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-target'));
            const duration = 2;
            
            gsap.to(element, {
                innerText: target,
                duration: duration,
                ease: 'power2.out',
                snap: { innerText: 1 },
                scrollTrigger: {
                    trigger: element,
                    start: 'top 80%',
                    onEnter: () => {
                        gsap.fromTo(element, 
                            { innerText: 0 },
                            { 
                                innerText: target,
                                duration: duration,
                                ease: 'power2.out',
                                snap: { innerText: 1 }
                            }
                        );
                    }
                }
            });
        }

        // Initialize counters
        document.querySelectorAll('.stats-counter').forEach(animateCounter);

        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    gsap.to(window, {
                        duration: 1,
                        scrollTo: { y: target, offsetY: 80 },
                        ease: 'power3.inOut'
                    });
                }
            });
        });

        // Floating animation for leaves
        gsap.to('.leaf', {
            y: -20,
            rotation: 10,
            duration: 3,
            ease: 'power2.inOut',
            stagger: {
                each: 0.5,
                repeat: -1,
                yoyo: true
            }
        });

        // Parallax effect for hero section
        gsap.to('.floating-leaves', {
            yPercent: -50,
            ease: 'none',
            scrollTrigger: {
                trigger: '.hero-section',
                start: 'top bottom',
                end: 'bottom top',
                scrub: true
            }
        });

        // Tech badges animation
        gsap.utils.toArray('.tech-badge').forEach((badge, index) => {
            gsap.set(badge, { scale: 0.8, opacity: 0 });
            
            ScrollTrigger.create({
                trigger: badge.closest('.feature-card'),
                start: 'top 80%',
                onEnter: () => {
                    gsap.to(badge, {
                        scale: 1,
                        opacity: 1,
                        duration: 0.6,
                        delay: index * 0.1,
                        ease: 'back.out(1.7)'
                    });
                }
            });
        });

        // Benefit items slide animation
        gsap.utils.toArray('.benefit-item').forEach((item, index) => {
            gsap.fromTo(item, 
                { x: -100, opacity: 0 },
                {
                    x: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: index * 0.2,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: item,
                        start: 'top 85%',
                        toggleActions: 'play none none reverse'
                    }
                }
            );
        });

        // Dashboard button pulse effect
        gsap.to('.dashboard-btn', {
            scale: 1.05,
            duration: 2,
            ease: 'power2.inOut',
            repeat: -1,
            yoyo: true
        });

        // Add glow effect on scroll for feature icons
        gsap.utils.toArray('.feature-icon').forEach(icon => {
            ScrollTrigger.create({
                trigger: icon,
                start: 'top 80%',
                onEnter: () => {
                    gsap.to(icon, {
                        boxShadow: '0 0 30px rgba(45, 143, 71, 0.6)',
                        duration: 0.5,
                        ease: 'power2.out'
                    });
                },
                onLeave: () => {
                    gsap.to(icon, {
                        boxShadow: '0 0 0px rgba(45, 143, 71, 0)',
                        duration: 0.5,
                        ease: 'power2.out'
                    });
                }
            });
        });

        // Section titles animation
        gsap.utils.toArray('.section-title').forEach(title => {
            gsap.fromTo(title, 
                { opacity: 0, y: 50, scale: 0.9 },
                {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 1,
                    ease: 'back.out(1.7)',
                    scrollTrigger: {
                        trigger: title,
                        start: 'top 85%',
                        toggleActions: 'play none none reverse'
                    }
                }
            );
        });

        // Add magnetic effect to cards
        gsap.utils.toArray('.feature-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                gsap.to(card, {
                    x: x * 0.1,
                    y: y * 0.1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });
            
            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    x: 0,
                    y: 0,
                    duration: 0.5,
                    ease: 'elastic.out(1, 0.3)'
                });
            });
        });

        // Background pattern animation
        gsap.to('.cta-section::before', {
            rotation: 360,
            duration: 20,
            ease: 'none',
            repeat: -1
        });

        // Stagger animation for tech badges in each card
        gsap.utils.toArray('.feature-card').forEach(card => {
            const badges = card.querySelectorAll('.tech-badge');
            
            ScrollTrigger.create({
                trigger: card,
                start: 'top 80%',
                onEnter: () => {
                    gsap.fromTo(badges,
                        { scale: 0, rotation: -180 },
                        {
                            scale: 1,
                            rotation: 0,
                            duration: 0.6,
                            stagger: 0.1,
                            ease: 'back.out(2)'
                        }
                    );
                }
            });
        });

        // Loading animation
        window.addEventListener('load', () => {
            gsap.from('body', {
                opacity: 0,
                duration: 0.5,
                ease: 'power2.out'
            });
        });

        // Smooth page transitions
        let isTransitioning = false;
        
        // document.addEventListener('click', (e) => {
        //     if (e.target.matches('.dashboard-btn') && !isTransitioning) {
        //         isTransitioning = true;
        //         e.preventDefault();
                
        //         gsap.to('.dashboard-btn', {
        //             scale: 0.95,
        //             duration: 0.1,
        //             yoyo: true,
        //             repeat: 1,
        //             onComplete: () => {
        //                 // Here you would normally navigate to dashboard
        //                 alert('Dashboard akan segera dimuat!');
        //                 isTransitioning = false;
        //             }
        //         });
        //     }
        // });

        // Add ripple effect to buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
            circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
            circle.classList.add('ripple');

            const ripple = button.getElementsByClassName('ripple')[0];
            if (ripple) {
                ripple.remove();
            }

            button.appendChild(circle);
        }

        // Add ripple CSS
        const rippleCSS = `
            .ripple {
                position: absolute;
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 600ms linear;
                background-color: rgba(255, 255, 255, 0.6);
            }
            
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        
        const style = document.createElement('style');
        style.textContent = rippleCSS;
        document.head.appendChild(style);

        // Apply ripple to dashboard button
        document.querySelector('.dashboard-btn').addEventListener('click', createRipple);

        // Performance optimization: Pause animations when not visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    gsap.set(entry.target, { animationPlayState: 'running' });
                } else {
                    gsap.set(entry.target, { animationPlayState: 'paused' });
                }
            });
        });

        document.querySelectorAll('.leaf').forEach(leaf => {
            observer.observe(leaf);
        });

    </script>
</body>
@endsection

</html>