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
            background: rgba(31, 41, 55, 0.92);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3), 0 0 40px rgba(220, 38, 38, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 10;
            opacity: 1;
            transform: translateY(0);
        }
        
        .auth-container.wide {
            max-width: 800px;
        }
        
        .auth-container.loading {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease-out;
        }
        
        .auth-container.loaded {
            opacity: 1;
            transform: translateY(0);
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

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .form-check {
            display: flex;
            align-items: center;
        }

        .form-check-input {
            margin-right: 0.5rem;
            accent-color: var(--stefia-primary);
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .alert {
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.3);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            color: #fca5a5;
            font-size: 0.9rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        /* Two-column layout for register form */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-grid .input-group {
            margin-bottom: 1rem;
        }

        .form-grid .full-width {
            grid-column: 1 / -1;
        }

        /* Enhanced visibility */
        .input-field {
            background: rgba(255, 255, 255, 0.12);
            border: 2px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.18);
            border-color: var(--stefia-accent);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.15), 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-red {
            background: var(--stefia-gradient);
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .btn-red:hover {
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.5);
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-options {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
            }
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
    
    <!-- Three.js 3D Background -->
    <div class="three-background" id="three-canvas" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -3; pointer-events: none;"></div>
    
    <!-- Network Animation -->
    <div class="network-animation" id="network-animation" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; pointer-events: none;"></div>
    
    <!-- Floating Particles -->
    <div class="floating-particles" id="floating-particles" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; pointer-events: none;"></div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    
    <script>
        // Show container immediately
        document.addEventListener('DOMContentLoaded', function() {
            const authContainer = document.querySelector('.auth-container');
            if (authContainer) {
                authContainer.classList.add('loaded');
            }
            
            // Initialize animations with delay for better performance
            setTimeout(() => {
                // Initialize only one heavy animation at a time
                initParticles();
                
                setTimeout(() => {
                    initThreeBackground();
                }, 500);
                
                setTimeout(() => {
                    initNetworkAnimation();
                }, 1000);
                
                // Initialize GSAP Animations
                initGSAPAnimations();
            }, 100);
            
            // Password toggle functionality
            const toggleButtons = document.querySelectorAll('.toggle-password');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');
                    
                    if (targetInput && icon) {
                        if (targetInput.type === 'password') {
                            targetInput.type = 'text';
                            icon.classList.remove('ni-eye');
                            icon.classList.add('ni-eye-off');
                        } else {
                            targetInput.type = 'password';
                            icon.classList.remove('ni-eye-off');
                            icon.classList.add('ni-eye');
                        }
                    }
                });
            });
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
            renderer.domElement.style.zIndex = '-3';
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
                new THREE.MeshBasicMaterial({ color: 0xdc2626, wireframe: true }),
                new THREE.MeshBasicMaterial({ color: 0xef4444, wireframe: true }),
                new THREE.MeshBasicMaterial({ color: 0xf87171, wireframe: true }),
                new THREE.MeshBasicMaterial({ color: 0xfca5a5, wireframe: true })
            ];
            
            const meshes = [];
            for (let i = 0; i < 12; i++) {
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
                    mesh.rotation.x += 0.008;
                    mesh.rotation.y += 0.008;
                    mesh.position.y += Math.sin(Date.now() * 0.001) * 0.008;
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
            
            // Create nodes
            for (let i = 0; i < 15; i++) {
                const node = document.createElement('div');
                node.className = 'network-node';
                node.style.position = 'absolute';
                node.style.width = '4px';
                node.style.height = '4px';
                node.style.background = '#dc2626';
                node.style.borderRadius = '50%';
                node.style.boxShadow = '0 0 8px rgba(220, 38, 38, 0.6)';
                node.style.left = Math.random() * 100 + '%';
                node.style.top = Math.random() * 100 + '%';
                networkContainer.appendChild(node);
                nodes.push({
                    element: node,
                    x: Math.random() * 100,
                    y: Math.random() * 100,
                    vx: (Math.random() - 0.5) * 0.3,
                    vy: (Math.random() - 0.5) * 0.3
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
                        
                        if (distance < 25) {
                            const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                            line.setAttribute('x1', node1.x + '%');
                            line.setAttribute('y1', node1.y + '%');
                            line.setAttribute('x2', node2.x + '%');
                            line.setAttribute('y2', node2.y + '%');
                            line.setAttribute('stroke', '#dc2626');
                            line.setAttribute('stroke-width', '0.5');
                            line.setAttribute('opacity', Math.max(0.1, 1 - distance / 25));
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
            const particlesContainer = document.getElementById('floating-particles');
            if (!particlesContainer) return;
            
            particlesJS('floating-particles', {
                particles: {
                    number: { value: 30, density: { enable: true, value_area: 800 } },
                    color: { value: '#dc2626' },
                    shape: { type: 'circle' },
                    opacity: { value: 0.3, random: false },
                    size: { value: 2, random: true },
                    line_linked: {
                        enable: true,
                        distance: 100,
                        color: '#dc2626',
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2,
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
                        grab: { distance: 200, line_linked: { opacity: 1 } },
                        bubble: { distance: 200, size: 20, duration: 2, opacity: 6, speed: 2 },
                        repulse: { distance: 100, duration: 0.3 },
                        push: { particles_nb: 2 },
                        remove: { particles_nb: 1 }
                    }
                },
                retina_detect: true
            });
        }
        
        // GSAP Animations
        function initGSAPAnimations() {
            // Auth container animation
            gsap.from('.auth-container', {
                duration: 1,
                y: 50,
                opacity: 0,
                ease: 'power3.out',
                delay: 0.3
            });
            
            // Logo animation
            gsap.from('.auth-logo img', {
                duration: 1.2,
                scale: 0.8,
                opacity: 0,
                ease: 'back.out(1.7)',
                delay: 0.5
            });
            
            // Title animation
            gsap.from('.auth-title', {
                duration: 1,
                y: 30,
                opacity: 0,
                ease: 'power2.out',
                delay: 0.7
            });
            
            // Input fields animation
            gsap.from('.input-group', {
                duration: 0.8,
                y: 20,
                opacity: 0,
                stagger: 0.1,
                ease: 'power2.out',
                delay: 0.9
            });
            
            // Button animation
            gsap.from('.btn', {
                duration: 0.8,
                scale: 0.9,
                opacity: 0,
                ease: 'back.out(1.7)',
                delay: 1.2
            });
            
            // Input focus animations
            document.querySelectorAll('.input-field').forEach(input => {
                input.addEventListener('focus', () => {
                    gsap.to(input, { duration: 0.3, scale: 1.02, ease: 'power2.out' });
                });
                
                input.addEventListener('blur', () => {
                    gsap.to(input, { duration: 0.3, scale: 1, ease: 'power2.out' });
                });
            });
            
            // Button hover animations
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('mouseenter', () => {
                    gsap.to(btn, { duration: 0.3, y: -2, ease: 'power2.out' });
                });
                
                btn.addEventListener('mouseleave', () => {
                    gsap.to(btn, { duration: 0.3, y: 0, ease: 'power2.out' });
                });
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>
