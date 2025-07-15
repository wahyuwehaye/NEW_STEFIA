@extends('layouts.landing')

@section('title', 'Welcome to STEFIA')

@section('content')
<!-- Futuristic 3D Background -->
<div class="three-background" id="three-canvas"></div>
<div class="network-animation" id="network-animation"></div>
<div class="geometric-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
    <div class="shape shape-5"></div>
    <div class="shape shape-6"></div>
    <div class="shape shape-7"></div>
    <div class="shape shape-8"></div>
</div>

<!-- Floating Particles -->
<div class="floating-particles" id="floating-particles">
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
</div>

<!-- Hero Section -->
<section class="section section-hero bg-transparent">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-75">
            <div class="col-lg-8 text-center">
                <div class="logo-container">
                    <img class="hero-logo" src="{{ asset('images/logo.png') }}" alt="STEFIA Logo">
                </div>
                <div class="hero-content">
                    <h1 class="hero-title mb-4">STEFIA</h1>
                    <p class="hero-subtitle mb-3">Student Financial Information & Administration</p>
                    <p class="feature-text mb-5">Sistem manajemen piutang mahasiswa yang terintegrasi dengan iGracias untuk mempermudah pengelolaan dan pelaporan keuangan mahasiswa serta pemantauan status penagihan secara sistematis.</p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn btn-lg btn-white me-3">
                            <em class="icon ni ni-user"></em>
                            <span>Masuk</span>
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-lg btn-outline-white">
                            <em class="icon ni ni-user-add"></em>
                            <span>Daftar</span>
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
                <h2 class="section-title">Portal Akses</h2>
                <p class="section-subtitle">Pilih portal sesuai dengan peran Anda untuk mengakses fitur STEFIA</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="portal-card h-100">
                    <div class="text-center mb-4">
                        <div class="icon-circle">
                            <em class="icon ni ni-wallet text-white"></em>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 class="feature-title text-gradient">Admin Keuangan</h5>
                        <p class="feature-text">Kelola data piutang mahasiswa, input pembayaran, verifikasi transaksi, dan generate laporan keuangan dengan integrasi iGracias</p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <em class="icon ni ni-arrow-right"></em>
                                <span>Masuk Portal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="portal-card h-100">
                    <div class="text-center mb-4">
                        <div class="icon-circle">
                            <em class="icon ni ni-shield-check text-white"></em>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 class="feature-title text-gradient">Super Admin</h5>
                        <p class="feature-text">Manajemen user, approval registrasi, audit log aktivitas, dan pengaturan sistem secara menyeluruh</p>
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <em class="icon ni ni-arrow-right"></em>
                                <span>Masuk Portal</span>
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
                <h2 class="section-title">Fitur Unggulan STEFIA</h2>
                <p class="section-subtitle">Solusi lengkap untuk manajemen piutang mahasiswa dengan teknologi terintegrasi</p>
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
                        <h5 class="feature-title text-gradient">Manajemen Mahasiswa</h5>
                        <p class="feature-text">Kelola data mahasiswa lengkap dengan import Excel/CSV dan integrasi iGracias. Pencarian berdasarkan nama, NIM, jurusan, angkatan</p>
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
                        <h5 class="feature-title text-gradient">Manajemen Piutang</h5>
                        <p class="feature-text">Input dan update status piutang dengan integrasi otomatis API iGracias. Riwayat piutang per mahasiswa tersedia lengkap</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-credit-card text-white"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title text-gradient">Manajemen Pembayaran</h5>
                        <p class="feature-text">Input pembayaran manual dan integrasi iGracias. Auto-update status piutang dengan sinkronisasi real-time</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-bar-chart text-white"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title text-gradient">Dashboard & Statistik</h5>
                        <p class="feature-text">Statistik piutang aktif, lunas, tunggakan. Daftar mahasiswa dengan tunggakan >10 juta dan grafik tren pembayaran</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-file-text text-white"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title text-gradient">Laporan & Ekspor</h5>
                        <p class="feature-text">Laporan bulanan dengan filter lengkap. Ekspor PDF/Excel berdasarkan tanggal, jurusan, angkatan, status</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card text-center">
                    <div class="feature-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-bell text-white"></em>
                        </div>
                    </div>
                    <div class="feature-content">
                        <h5 class="feature-title text-gradient">Reminder Otomatis</h5>
                        <p class="feature-text">Reminder email/WhatsApp otomatis untuk tagihan mendekati jatuh tempo dan tracking tindakan penagihan</p>
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
                    <h2 class="section-title mb-4">Tentang STEFIA</h2>
                    <p class="section-subtitle mb-4">STEFIA (Student Financial Information & Administration) adalah sistem manajemen piutang mahasiswa yang terintegrasi dengan iGracias untuk mempermudah pengelolaan dan pelaporan keuangan mahasiswa.</p>
                    <p class="feature-text mb-4">Platform kami dirancang khusus untuk Telkom University dalam mengelola piutang mahasiswa secara sistematis, mulai dari input data, pemantauan pembayaran, hingga laporan penagihan tunggakan >10 juta rupiah.</p>
                    <div class="about-features">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">Integrasi iGracias</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">Real-time Sync</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">Laporan Tunggakan</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="feature-item">
                                    <em class="icon ni ni-check-circle text-gradient"></em>
                                    <span class="ms-2 text-white">Tracking Penagihan</span>
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
                            <p class="feature-text mt-3">Kelola piutang mahasiswa dengan mudah dan efisien</p>
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
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="section-subtitle">Ada pertanyaan tentang STEFIA? Tim kami siap membantu Anda</p>
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
                        <h6 class="contact-title text-gradient">Email</h6>
                        <p class="contact-text">finance@telkomuniversity.ac.id</p>
                        <a href="mailto:finance@telkomuniversity.ac.id" class="btn btn-outline-primary btn-sm mt-2">Kirim Email</a>
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
                        <h6 class="contact-title text-gradient">Telepon</h6>
                        <p class="contact-text">+62 22 7566456</p>
                        <a href="tel:+62227566456" class="btn btn-outline-primary btn-sm mt-2">Hubungi</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="contact-card text-center">
                    <div class="contact-icon mb-3">
                        <div class="icon-circle">
                            <em class="icon ni ni-map-pin text-white"></em>
                        </div>
                    </div>
                    <div class="contact-content">
                        <h6 class="contact-title text-gradient">Alamat</h6>
                        <p class="contact-text">Jl. Telekomunikasi No. 1, Terusan Buah Batu, Bandung 40257</p>
                        <a href="https://maps.google.com/?q=Telkom+University" class="btn btn-outline-primary btn-sm mt-2">Lihat Peta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Register GSAP plugins
        gsap.registerPlugin(ScrollTrigger);
        
        // Initialize Three.js background
        initThreeBackground();
        
        // Initialize Network Animation
        initNetworkAnimation();
        
        // Initialize Particles
        initParticles();
        
        // Initialize GSAP Animations
        initGSAPAnimations();
        
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
        
        // Mouse interaction effects
        initMouseInteractions();
        
        // Parallax scrolling
        initParallaxEffect();
    });
    
    // Three.js 3D Background
    function initThreeBackground() {
        const canvas = document.getElementById('three-canvas');
        if (!canvas) return;
        
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ alpha: true });
        
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.domElement.style.position = 'fixed';
        renderer.domElement.style.top = '0';
        renderer.domElement.style.left = '0';
        renderer.domElement.style.zIndex = '-1';
        renderer.domElement.style.pointerEvents = 'none';
        canvas.appendChild(renderer.domElement);
        
        // Create geometric shapes
        const geometries = [
            new THREE.BoxGeometry(1, 1, 1),
            new THREE.ConeGeometry(0.5, 1, 8),
            new THREE.SphereGeometry(0.5, 32, 32),
            new THREE.OctahedronGeometry(0.5)
        ];
        
        const materials = [
            new THREE.MeshBasicMaterial({ color: 0xff0000, wireframe: true }),
            new THREE.MeshBasicMaterial({ color: 0x00ff00, wireframe: true }),
            new THREE.MeshBasicMaterial({ color: 0x0000ff, wireframe: true }),
            new THREE.MeshBasicMaterial({ color: 0xffff00, wireframe: true })
        ];
        
        const meshes = [];
        for (let i = 0; i < 15; i++) {
            const geometry = geometries[Math.floor(Math.random() * geometries.length)];
            const material = materials[Math.floor(Math.random() * materials.length)];
            const mesh = new THREE.Mesh(geometry, material);
            
            mesh.position.x = (Math.random() - 0.5) * 20;
            mesh.position.y = (Math.random() - 0.5) * 20;
            mesh.position.z = (Math.random() - 0.5) * 20;
            
            mesh.rotation.x = Math.random() * Math.PI;
            mesh.rotation.y = Math.random() * Math.PI;
            
            scene.add(mesh);
            meshes.push(mesh);
        }
        
        camera.position.z = 5;
        
        function animate() {
            requestAnimationFrame(animate);
            
            meshes.forEach(mesh => {
                mesh.rotation.x += 0.01;
                mesh.rotation.y += 0.01;
                mesh.position.y += Math.sin(Date.now() * 0.001) * 0.01;
            });
            
            renderer.render(scene, camera);
        }
        
        animate();
        
        // Resize handler
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    }
    
    // Network Animation
    function initNetworkAnimation() {
        const networkContainer = document.getElementById('network-animation');
        if (!networkContainer) return;
        
        const nodes = [];
        const connections = [];
        
        // Create nodes
        for (let i = 0; i < 20; i++) {
            const node = document.createElement('div');
            node.className = 'network-node';
            node.style.left = Math.random() * 100 + '%';
            node.style.top = Math.random() * 100 + '%';
            networkContainer.appendChild(node);
            nodes.push({
                element: node,
                x: Math.random() * 100,
                y: Math.random() * 100,
                vx: (Math.random() - 0.5) * 0.5,
                vy: (Math.random() - 0.5) * 0.5
            });
        }
        
        // Create connections (SVG lines)
        const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.style.position = 'absolute';
        svg.style.top = '0';
        svg.style.left = '0';
        svg.style.width = '100%';
        svg.style.height = '100%';
        svg.style.pointerEvents = 'none';
        networkContainer.appendChild(svg);
        
        function animateNetwork() {
            // Clear existing connections
            svg.innerHTML = '';
            
            // Update node positions
            nodes.forEach(node => {
                node.x += node.vx;
                node.y += node.vy;
                
                // Bounce off edges
                if (node.x <= 0 || node.x >= 100) node.vx *= -1;
                if (node.y <= 0 || node.y >= 100) node.vy *= -1;
                
                node.element.style.left = node.x + '%';
                node.element.style.top = node.y + '%';
            });
            
            // Draw connections
            nodes.forEach((node1, i) => {
                nodes.slice(i + 1).forEach(node2 => {
                    const distance = Math.sqrt(
                        Math.pow(node1.x - node2.x, 2) + Math.pow(node1.y - node2.y, 2)
                    );
                    
                    if (distance < 30) {
                        const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                        line.setAttribute('x1', node1.x + '%');
                        line.setAttribute('y1', node1.y + '%');
                        line.setAttribute('x2', node2.x + '%');
                        line.setAttribute('y2', node2.y + '%');
                        line.setAttribute('stroke', '#ff0000');
                        line.setAttribute('stroke-width', '1');
                        line.setAttribute('opacity', Math.max(0.1, 1 - distance / 30));
                        svg.appendChild(line);
                    }
                });
            });
            
            requestAnimationFrame(animateNetwork);
        }
        
        animateNetwork();
    }
    
    // Particles.js initialization
    function initParticles() {
        const particlesContainer = document.querySelector('.floating-particles');
        if (!particlesContainer) return;
        
        particlesJS('floating-particles', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: '#ff0000' },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ff0000',
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: true, mode: 'repulse' },
                    onclick: { enable: true, mode: 'push' },
                    resize: true
                },
                modes: {
                    grab: { distance: 400, line_linked: { opacity: 1 } },
                    bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 },
                    repulse: { distance: 200, duration: 0.4 },
                    push: { particles_nb: 4 },
                    remove: { particles_nb: 2 }
                }
            },
            retina_detect: true
        });
    }
    
    // GSAP Animations
    function initGSAPAnimations() {
        // Hero section animation
        gsap.timeline()
            .from('.hero-logo', { duration: 1, y: -50, opacity: 0, ease: 'bounce.out' })
            .from('.hero-title', { duration: 1, y: 30, opacity: 0, ease: 'power2.out' }, '-=0.5')
            .from('.hero-subtitle', { duration: 1, y: 20, opacity: 0, ease: 'power2.out' }, '-=0.3')
            .from('.hero-actions .btn', { duration: 0.8, scale: 0, opacity: 0, stagger: 0.2, ease: 'back.out(1.7)' }, '-=0.2');
        
        // Geometric shapes animation
        gsap.to('.shape', {
            duration: 20,
            rotation: 360,
            repeat: -1,
            ease: 'none',
            stagger: {
                amount: 5,
                from: 'random'
            }
        });
        
        // Portal cards hover animation
        document.querySelectorAll('.portal-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, { duration: 0.3, y: -10, scale: 1.05, ease: 'power2.out' });
            });
            
            card.addEventListener('mouseleave', () => {
                gsap.to(card, { duration: 0.3, y: 0, scale: 1, ease: 'power2.out' });
            });
        });
        
        // Feature cards stagger animation
        gsap.fromTo('.feature-card', 
            { y: 50, opacity: 0 },
            { 
                y: 0, 
                opacity: 1, 
                duration: 0.8, 
                stagger: 0.2, 
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: '.section-feature',
                    start: 'top 80%',
                    end: 'bottom 20%',
                    toggleActions: 'play none none reverse'
                }
            }
        );
    }
    
    // Mouse interaction effects
    function initMouseInteractions() {
        const cursor = document.createElement('div');
        cursor.className = 'custom-cursor';
        document.body.appendChild(cursor);
        
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
        });
        
        // Interactive elements
        document.querySelectorAll('.btn, .portal-card, .feature-card').forEach(element => {
            element.addEventListener('mouseenter', () => {
                cursor.classList.add('cursor-hover');
            });
            
            element.addEventListener('mouseleave', () => {
                cursor.classList.remove('cursor-hover');
            });
        });
    }
    
    // Parallax scrolling effect
    function initParallaxEffect() {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.geometric-shapes');
            
            parallaxElements.forEach(element => {
                const speed = element.dataset.speed || 0.5;
                const yPos = -(scrolled * speed);
                element.style.transform = `translateY(${yPos}px)`;
            });
        });
    }
</script>
@endpush
