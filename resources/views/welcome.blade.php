@extends('layouts.landing')

@section('title', 'Welcome')

@push('styles')
<style>
/* Glassmorphism & Card Effect */
.portal-card, .feature-card, .contact-card, .demo-card, .api-doc-card, .timeline, .flow-diagram {
    background: rgba(255,255,255,0.13) !important;
    box-shadow: 0 8px 40px rgba(225,29,72,0.10) !important;
    border-radius: 24px !important;
    border: 1.5px solid #f3f4f6 !important;
    backdrop-filter: blur(8px);
    color: #1e293b;
    transition: box-shadow 0.3s, transform 0.3s;
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.8s cubic-bezier(.23,1.01,.32,1) both;
}
.portal-card:hover, .feature-card:hover, .contact-card:hover, .demo-card:hover {
    box-shadow: 0 16px 48px rgba(225,29,72,0.14) !important;
    transform: translateY(-2px) scale(1.015);
}

/* Animasi fade-in/slide */
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(40px); }
    100% { opacity: 1; transform: none; }
}
.fade-in { animation: fadeInUp 1s both; }

/* Text Gradient & Badge */
.text-gradient {
    background: linear-gradient(90deg, #f43f5e 0%, #f59e42 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-fill-color: transparent;
}
.badge-feature, .badge-stat {
    display: inline-block;
    background: linear-gradient(90deg, #f43f5e 0%, #f59e42 100%);
    color: #fff;
    border-radius: 8px;
    padding: 0.25em 1em;
    font-size: 0.95em;
    font-weight: 600;
    margin-bottom: 0.5em;
    letter-spacing: 1px;
    box-shadow: 0 2px 8px #f43f5e22;
}

/* CTA Button */
.btn-lg.btn-white, .btn-lg.btn-outline-white {
    font-size: 1.2rem;
    font-weight: 700;
    border-radius: 16px;
    padding: 0.85em 2.5em;
    box-shadow: 0 2px 12px #f43f5e22;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.2s;
}
.btn-lg.btn-white:hover, .btn-lg.btn-outline-white:hover {
    background: linear-gradient(90deg, #f43f5e 0%, #f59e42 100%) !important;
    color: #fff !important;
    transform: scale(1.04);
}

/* Icon interaktif */
.icon-circle {
    background: linear-gradient(135deg, #f43f5e 0%, #f59e42 100%);
    color: #fff;
    border-radius: 50%;
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1rem auto;
    box-shadow: 0 2px 12px #f43f5e22;
    transition: box-shadow 0.2s, transform 0.2s;
}
.icon-circle:hover {
    box-shadow: 0 4px 24px #f59e4288;
    transform: scale(1.08) rotate(-6deg);
}

/* Section Title & Subtitle */
.section-title {
    font-size: 2.2rem;
    font-weight: 800;
    letter-spacing: 1px;
    margin-bottom: 0.5em;
}
.section-subtitle {
    font-size: 1.2rem;
    font-weight: 500;
    color: #f3f4f6;
    margin-bottom: 1.5em;
}

/* Timeline & Flow */
.timeline {
    list-style: none;
    padding: 0;
    margin: 0 auto;
    max-width: 600px;
}
.timeline li {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1.5em;
}
.timeline-dot {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: linear-gradient(90deg, #f43f5e 0%, #f59e42 100%);
    margin-right: 1em;
    flex-shrink: 0;
    box-shadow: 0 2px 8px #f43f5e22;
}
.timeline-title {
    font-weight: 700;
    font-size: 1.1em;
    margin-right: 0.5em;
}
.timeline-desc {
    font-size: 0.98em;
    color: #64748b;
}

/* Responsive */
@media (max-width: 900px) {
    .portal-card, .feature-card, .contact-card, .demo-card, .api-doc-card {
        padding: 1.5rem !important;
    }
    .section-title { font-size: 1.5rem; }
}
@media (max-width: 600px) {
    .portal-card, .feature-card, .contact-card, .demo-card, .api-doc-card {
        padding: 1rem !important;
    }
    .section-title { font-size: 1.2rem; }
    .icon-circle { width: 48px; height: 48px; font-size: 1.3rem; }
}
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="section section-hero min-vh-75" id="home">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8">
                <div class="portal-card mb-4 p-4">
                    <div class="logo-container mb-3">
                        <img src="{{ asset('images/logo.png') }}" alt="STEFIA Logo" class="hero-logo">
                    </div>
                    <h1 class="hero-title text-gradient">STEFIA</h1>
                    <p class="hero-subtitle">Student Financial Information & Administration</p>
                    <p class="hero-text mb-4 text-white">
                        Sistem manajemen piutang mahasiswa yang terintegrasi dengan iGracias untuk mempermudah pengelolaan dan pelaporan keuangan mahasiswa serta pemantauan status penagihan secara sistematis.
                    </p>
                    <div class="hero-actions mb-2">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-white me-3">Mulai Sekarang</a>
                        <a href="#features" class="btn btn-lg btn-outline-white">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section fade-in" id="features">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 text-center rounded mx-auto mb-5 w-100 shadow">
                    <h2 class="section-title text-gradient text-white">Fitur Unggulan STEFIA</h2>
                    <p class="section-subtitle text-white mb-4">
                        Kelola piutang mahasiswa dengan mudah dan efisien melalui integrasi sistem yang canggih
                    </p>
                    <div class="row g-4 mt-4">
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-users text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="feature-title text-gradient text-white">Manajemen Mahasiswa</h4>
                                <p class="feature-text text-white">Kelola data mahasiswa lengkap dengan import dari Excel/CSV dan integrasi iGracias. Pencarian berdasarkan nama, NIM, jurusan, angkatan, dan range piutang.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-wallet text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="feature-title text-gradient text-white">Manajemen Piutang</h4>
                                <p class="feature-text text-white">Input dan update status piutang (lunas/sebagian/tunggakan) dengan integrasi otomatis dari API iGracias. Riwayat piutang per mahasiswa tersedia lengkap.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-credit-card text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="feature-title text-gradient text-white">Manajemen Pembayaran</h4>
                                <p class="feature-text text-white">Input pembayaran manual dan integrasi dengan iGracias. Auto-update status piutang setelah verifikasi pembayaran dengan sinkronisasi real-time.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-bar-chart text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="feature-title text-gradient text-white">Dashboard & Statistik</h4>
                                <p class="feature-text text-white">Statistik piutang aktif, lunas, dan tunggakan. Daftar mahasiswa dengan tunggakan >10 juta. Grafik tren pembayaran per semester dan tahun.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-file-text text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="feature-title text-gradient text-white">Laporan & Ekspor</h4>
                                <p class="feature-text text-white">Laporan bulanan dengan filter lengkap (tanggal, jurusan, angkatan, status). Ekspor ke PDF/Excel. Filter berdasarkan semester menunggak dan jumlah piutang.</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="feature-card bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-shield-check text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="feature-title text-gradient text-white">Keamanan & Akses</h4>
                                <p class="feature-text text-white">Role-based access untuk Admin Keuangan dan Super Admin. Log aktivitas pengguna lengkap. Approval system untuk registrasi user baru.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section fade-in">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 text-center rounded mx-auto mb-5 w-100 shadow">
                    <h2 class="section-title text-gradient text-white">STEFIA dalam Angka</h2>
                    <p class="section-subtitle text-white mb-4">
                        Sistem yang telah dipercaya untuk mengelola keuangan mahasiswa
                    </p>
                    <div class="row g-4 mt-4">
                        <div class="col-lg-3 col-sm-6">
                            <div class="portal-card bg-success-soft border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-users text-white" style="font-size: 2rem;"></em>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">25,000+</h3>
                                    <p class="feature-text text-white">Data Mahasiswa</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="portal-card bg-info-soft border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-wallet text-white" style="font-size: 2rem;"></em>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">15 Milyar</h3>
                                    <p class="feature-text text-white">Total Piutang Dikelola</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="portal-card bg-primary-soft border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-bar-chart text-white" style="font-size: 2rem;"></em>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">95%</h3>
                                    <p class="feature-text text-white">Akurasi Laporan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="portal-card bg-success-soft border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-shield-check text-white" style="font-size: 2rem;"></em>
                                </div>
                                <div class="text-center">
                                    <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">99.9%</h3>
                                    <p class="feature-text text-white">Uptime Sistem</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section fade-in" id="about">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 rounded mx-auto mb-5 w-100 shadow">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-lg-6">
                            <div class="about-content">
                                <h2 class="section-title text-gradient text-white">Tentang STEFIA</h2>
                                <p class="feature-text text-white mb-4">
                                    STEFIA (Student Financial Information & Administration) adalah sistem manajemen piutang mahasiswa yang terintegrasi dengan iGracias. Dirancang khusus untuk mempermudah pengelolaan dan pelaporan keuangan mahasiswa serta pemantauan status penagihan secara sistematis.
                                </p>
                                <div class="about-features">
                                    <div class="feature-item text-white">
                                        <em class="icon ni ni-check-circle text-gradient"></em>
                                        <span class="feature-text text-white">Integrasi penuh dengan sistem iGracias</span>
                                    </div>
                                    <div class="feature-item text-white">
                                        <em class="icon ni ni-check-circle text-gradient"></em>
                                        <span class="feature-text text-white">Pemantauan piutang mahasiswa real-time</span>
                                    </div>
                                    <div class="feature-item text-white">
                                        <em class="icon ni ni-check-circle text-gradient"></em>
                                        <span class="feature-text text-white">Laporan penagihan tunggakan >10 juta</span>
                                    </div>
                                    <div class="feature-item text-white">
                                        <em class="icon ni ni-check-circle text-gradient"></em>
                                        <span class="feature-text text-white">Reminder otomatis email/WhatsApp</span>
                                    </div>
                                    <div class="feature-item text-white">
                                        <em class="icon ni ni-check-circle text-gradient"></em>
                                        <span class="feature-text text-white">Tracking tindakan penagihan (NDE, Dosen Wali, Surat, Home Visit)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="portal-card bg-primary-soft border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-building text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="feature-title text-gradient text-white">Portal Admin Keuangan</h4>
                                <p class="feature-text text-white">Akses lengkap untuk mengelola data piutang, input pembayaran, dan generate laporan keuangan mahasiswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section section-hero bg-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center">
                    <h2 class="section-title text-white">Siap Memulai dengan STEFIA?</h2>
                    <p class="section-subtitle text-white mb-4">
                        Bergabunglah dengan Telkom University dalam mengelola piutang mahasiswa secara efisien dan terintegrasi.
                    </p>
                    <div class="hero-actions mb-4">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-white me-3">Daftar Sekarang</a>
                        <a href="{{ route('login') }}" class="btn btn-lg btn-outline-white">Masuk</a>
                    </div>
                    <div class="quick-links mt-4">
                        <a href="#roadmap" class="btn btn-outline-primary me-2">Roadmap</a>
                        <a href="#flow" class="btn btn-outline-primary me-2">Flow Sistem</a>
                        <a href="#api-docs" class="btn btn-outline-primary me-2">API Docs</a>
                        <a href="#demo" class="btn btn-outline-primary">Demo Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Roadmap Section -->
<section class="section fade-in" id="roadmap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 text-center rounded mx-auto mb-5 w-100 shadow">
                    <h2 class="section-title text-gradient text-white">Roadmap & Tahapan Implementasi</h2>
                    <p class="section-subtitle text-white">Langkah-langkah pengembangan dan implementasi STEFIA</p>
                    <ul class="timeline mt-4">
                        <li><span class="timeline-dot bg-danger"></span><span class="timeline-title text-white">Analisis Kebutuhan & Mapping Modul</span><span class="timeline-desc text-white">Identifikasi fitur, entitas, dan flow sistem</span></li>
                        <li><span class="timeline-dot bg-danger"></span><span class="timeline-title text-white">Desain Database & API Integrasi</span><span class="timeline-desc text-white">Struktur tabel, relasi, dan endpoint API igracias</span></li>
                        <li><span class="timeline-dot bg-danger"></span><span class="timeline-title text-white">Implementasi Fitur Utama</span><span class="timeline-desc text-white">Mahasiswa, Piutang, Pembayaran, User, Dashboard, Laporan, Reminder</span></li>
                        <li><span class="timeline-dot bg-danger"></span><span class="timeline-title text-white">Integrasi API & Dummy Data</span><span class="timeline-desc text-white">Testing integrasi, sinkronisasi manual/otomatis, demo data</span></li>
                        <li><span class="timeline-dot bg-danger"></span><span class="timeline-title text-white">Revamp UI/UX & Onboarding</span><span class="timeline-desc text-white">Modernisasi tampilan, animasi, dan step-by-step onboarding</span></li>
                        <li><span class="timeline-dot bg-danger"></span><span class="timeline-title text-white">Testing, Dokumentasi, & Go-Live</span><span class="timeline-desc text-white">Uji coba, dokumentasi lengkap, peluncuran sistem</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Flow Section -->
<section class="section fade-in" id="flow">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 text-center rounded mx-auto mb-5 w-100 shadow">
                    <h2 class="section-title text-gradient text-white">Visualisasi Flow Sistem</h2>
                    <p class="section-subtitle text-white">Alur data, approval, dan integrasi API pada STEFIA</p>
                    <div class="flow-diagram bg-white p-4 rounded shadow-sm mb-4 mt-4">
                        <pre class="mermaid" style="background:transparent;">
flowchart TD
    A[Mahasiswa & Orangtua] -->|Registrasi/Update| B[Admin Keuangan]
    B -->|Input/Sync Data| C[STEFIA DB]
    C -->|API Sync| D[iGracias API]
    B -->|Input Pembayaran| E[Pembayaran]
    E -->|Update Status| C
    C -->|Reminder Otomatis| F[Email/WA]
    B -->|Generate Laporan| G[Laporan & Ekspor]
    H[Super Admin] -->|Approval User| C
    H -->|Audit Log| C
</pre>
                    </div>
                    <a href="#api-docs" class="btn btn-outline-primary mt-2">Lihat Dokumentasi API</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- API Docs Section -->
<section class="section fade-in" id="api-docs">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 text-center rounded mx-auto mb-5 w-100 shadow">
                    <h2 class="section-title text-gradient text-white">API Documentation & Integrasi</h2>
                    <p class="section-subtitle text-white">Dokumentasi endpoint, request/response, dan sample data untuk integrasi iGracias</p>
                    <div class="api-doc-card bg-white p-4 rounded shadow-sm mb-4 mt-4">
                        <h5 class="mb-3 text-danger">Contoh Endpoint: GET /api/igracias/students</h5>
                        <pre class="bg-light p-3 rounded"><code>{
  "students": [
    { "nim": "123456", "name": "Budi", "faculty": "Informatika", "status": "Aktif" },
    { "nim": "654321", "name": "Sari", "faculty": "Ekonomi", "status": "Cuti" }
  ]
}</code></pre>
                        <h5 class="mb-3 text-danger">Contoh Request: POST /api/igracias/payments</h5>
                        <pre class="bg-light p-3 rounded"><code>{
  "nim": "123456",
  "amount": 1500000,
  "payment_date": "2025-01-15",
  "method": "bank_transfer"
}</code></pre>
                        <h5 class="mb-3 text-danger">Contoh Response:</h5>
                        <pre class="bg-light p-3 rounded"><code>{
  "success": true,
  "message": "Payment recorded successfully",
  "payment_id": 1001
}</code></pre>
                    </div>
                    <a href="#demo" class="btn btn-outline-primary mt-2">Coba Demo Data</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Demo Data Section -->
<section class="section fade-in" id="demo">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 text-center rounded mx-auto mb-5 w-100 shadow">
                    <h2 class="section-title text-gradient text-white">Demo Data & Onboarding</h2>
                    <p class="section-subtitle text-white">Coba fitur STEFIA dengan data dummy dan ikuti onboarding step-by-step</p>
                    <div class="demo-card bg-white p-4 rounded shadow-sm mb-4 mt-4">
                        <h5 class="mb-3 text-danger">Langkah Onboarding:</h5>
                        <ol class="mb-3 text-dark">
                            <li>Registrasi akun sebagai Admin Keuangan/Super Admin</li>
                            <li>Import data mahasiswa (Excel/CSV atau API)</li>
                            <li>Input/sinkronisasi piutang dan pembayaran</li>
                            <li>Generate laporan dan reminder otomatis</li>
                            <li>Kelola approval user dan audit log</li>
                        </ol>
                        <h5 class="mb-3 text-danger">Demo Data:</h5>
                        <pre class="bg-light p-3 rounded"><code>{
  "nim": "999999",
  "name": "Demo Mahasiswa",
  "faculty": "Teknik",
  "status": "Aktif",
  "debt": 12000000,
  "payments": [
    { "amount": 6000000, "date": "2025-01-10" },
    { "amount": 6000000, "date": "2025-02-10" }
  ]
}</code></pre>
                    </div>
                    <a href="{{ route('register') }}" class="btn btn-danger btn-lg me-3">Mulai Onboarding</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-danger btn-lg">Login Demo</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section fade-in" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="portal-card p-5 text-center rounded mx-auto mb-5 w-100 shadow">
                    <h2 class="section-title text-gradient text-white">Hubungi Kami</h2>
                    <p class="section-subtitle text-white mb-4">
                        Ada pertanyaan tentang STEFIA? Tim kami siap membantu Anda.
                    </p>
                    <div class="row g-4 mt-4">
                        <div class="col-lg-4">
                            <div class="contact-card text-center p-4 bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-mail text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="contact-title text-gradient text-white">Email</h4>
                                <p class="contact-text text-white">finance@telkomuniversity.ac.id</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-card text-center p-4 bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-call text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="contact-title text-gradient text-white">Telepon</h4>
                                <p class="contact-text text-white">+62 22 7566456</p>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="contact-card text-center p-4 bg-transparent border-0 shadow-none">
                                <div class="icon-circle mb-3">
                                    <em class="icon ni ni-map-pin text-white" style="font-size: 2rem;"></em>
                                </div>
                                <h4 class="contact-title text-gradient text-white">Alamat</h4>
                                <p class="contact-text text-white">Jl. Telekomunikasi No. 1, Terusan Buah Batu, Bandung 40257</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
