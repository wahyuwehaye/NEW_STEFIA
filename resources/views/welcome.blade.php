@extends('layouts.landing')

@section('title', 'Welcome')

@section('content')
<!-- Hero Section -->
<section class="section section-hero bg-primary min-vh-75" id="home">
    <div class="container">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-lg-8">
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="STEFIA Logo" class="hero-logo">
                </div>
                <h1 class="hero-title">STEFIA</h1>
                <p class="hero-subtitle">Student Financial Information & Administration</p>
                <p class="hero-text mb-4">
                    Sistem manajemen piutang mahasiswa yang terintegrasi dengan iGracias untuk mempermudah pengelolaan dan pelaporan keuangan mahasiswa serta pemantauan status penagihan secara sistematis.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn btn-lg btn-white me-3">Mulai Sekarang</a>
                    <a href="#features" class="btn btn-lg btn-outline-white">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section fade-in" id="features">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="section-title">Fitur Unggulan STEFIA</h2>
                    <p class="section-subtitle">
                        Kelola piutang mahasiswa dengan mudah dan efisien melalui integrasi sistem yang canggih
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-users text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="feature-title text-gradient">Manajemen Mahasiswa</h4>
                    <p class="feature-text">Kelola data mahasiswa lengkap dengan import dari Excel/CSV dan integrasi iGracias. Pencarian berdasarkan nama, NIM, jurusan, angkatan, dan range piutang.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-wallet text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="feature-title text-gradient">Manajemen Piutang</h4>
                    <p class="feature-text">Input dan update status piutang (lunas/sebagian/tunggakan) dengan integrasi otomatis dari API iGracias. Riwayat piutang per mahasiswa tersedia lengkap.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-credit-card text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="feature-title text-gradient">Manajemen Pembayaran</h4>
                    <p class="feature-text">Input pembayaran manual dan integrasi dengan iGracias. Auto-update status piutang setelah verifikasi pembayaran dengan sinkronisasi real-time.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-bar-chart text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="feature-title text-gradient">Dashboard & Statistik</h4>
                    <p class="feature-text">Statistik piutang aktif, lunas, dan tunggakan. Daftar mahasiswa dengan tunggakan >10 juta. Grafik tren pembayaran per semester dan tahun.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-file-text text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="feature-title text-gradient">Laporan & Ekspor</h4>
                    <p class="feature-text">Laporan bulanan dengan filter lengkap (tanggal, jurusan, angkatan, status). Ekspor ke PDF/Excel. Filter berdasarkan semester menunggak dan jumlah piutang.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-shield-check text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="feature-title text-gradient">Keamanan & Akses</h4>
                    <p class="feature-text">Role-based access untuk Admin Keuangan dan Super Admin. Log aktivitas pengguna lengkap. Approval system untuk registrasi user baru.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section fade-in">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="section-title">STEFIA dalam Angka</h2>
                    <p class="section-subtitle">
                        Sistem yang telah dipercaya untuk mengelola keuangan mahasiswa
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6">
                <div class="portal-card bg-success-soft">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-users text-white" style="font-size: 2rem;"></em>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">25,000+</h3>
                        <p class="feature-text">Data Mahasiswa</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="portal-card bg-info-soft">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-wallet text-white" style="font-size: 2rem;"></em>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">15 Milyar</h3>
                        <p class="feature-text">Total Piutang Dikelola</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="portal-card bg-primary-soft">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-bar-chart text-white" style="font-size: 2rem;"></em>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">95%</h3>
                        <p class="feature-text">Akurasi Laporan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="portal-card bg-success-soft">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-shield-check text-white" style="font-size: 2rem;"></em>
                    </div>
                    <div class="text-center">
                        <h3 class="text-gradient" style="font-size: 2.5rem; font-weight: 700;">99.9%</h3>
                        <p class="feature-text">Uptime Sistem</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="section fade-in" id="about">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-6">
                <div class="about-content">
                    <h2 class="section-title">Tentang STEFIA</h2>
                    <p class="feature-text mb-4">
                        STEFIA (Student Financial Information & Administration) adalah sistem manajemen piutang mahasiswa yang terintegrasi dengan iGracias. Dirancang khusus untuk mempermudah pengelolaan dan pelaporan keuangan mahasiswa serta pemantauan status penagihan secara sistematis.
                    </p>
                    <div class="about-features">
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle text-gradient"></em>
                            <span class="feature-text">Integrasi penuh dengan sistem iGracias</span>
                        </div>
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle text-gradient"></em>
                            <span class="feature-text">Pemantauan piutang mahasiswa real-time</span>
                        </div>
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle text-gradient"></em>
                            <span class="feature-text">Laporan penagihan tunggakan >10 juta</span>
                        </div>
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle text-gradient"></em>
                            <span class="feature-text">Reminder otomatis email/WhatsApp</span>
                        </div>
                        <div class="feature-item">
                            <em class="icon ni ni-check-circle text-gradient"></em>
                            <span class="feature-text">Tracking tindakan penagihan (NDE, Dosen Wali, Surat, Home Visit)</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="portal-card bg-primary-soft">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-building text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="feature-title text-gradient">Portal Admin Keuangan</h4>
                    <p class="feature-text">Akses lengkap untuk mengelola data piutang, input pembayaran, dan generate laporan keuangan mahasiswa.</p>
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
                    <div class="hero-actions">
                        <a href="{{ route('register') }}" class="btn btn-lg btn-white me-3">Daftar Sekarang</a>
                        <a href="{{ route('login') }}" class="btn btn-lg btn-outline-white">Masuk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section fade-in" id="contact">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="section-title">Hubungi Kami</h2>
                    <p class="section-subtitle">
                        Ada pertanyaan tentang STEFIA? Tim kami siap membantu Anda.
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="contact-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-mail text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="contact-title text-gradient">Email</h4>
                    <p class="contact-text">finance@telkomuniversity.ac.id</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-call text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="contact-title text-gradient">Telepon</h4>
                    <p class="contact-text">+62 22 7566456</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contact-card">
                    <div class="icon-circle mb-3">
                        <em class="icon ni ni-map-pin text-white" style="font-size: 2rem;"></em>
                    </div>
                    <h4 class="contact-title text-gradient">Alamat</h4>
                    <p class="contact-text">Jl. Telekomunikasi No. 1, Terusan Buah Batu, Bandung 40257</p>
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
