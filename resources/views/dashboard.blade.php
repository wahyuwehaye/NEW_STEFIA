
@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stats-card, .modern-card {
        background: rgba(255,255,255,0.97) !important;
        color: #1e293b !important;
        border-radius: 20px !important;
        box-shadow: 0 6px 32px rgba(0,0,0,0.06) !important;
        border: 1.5px solid #f3f4f6 !important;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .stats-card:hover, .modern-card:hover {
        box-shadow: 0 16px 48px rgba(225,29,72,0.08) !important;
        transform: translateY(-2px) scale(1.01);
    }
    .stats-card .stats-icon {
        background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%) !important;
        color: #fff !important;
        font-size: 2.2rem;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(225,29,72,0.08);
    }
    .text-gradient {
        background: linear-gradient(90deg, #e11d48, #ff4d4d, #f43f5e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700;
    }
    .gradient-text { color: #e11d48; font-weight: 700; }
    .card-title .stats-icon { font-size: 2.2rem; }
    .card-title .title { font-size: 1.1rem; font-weight: 700; }
    .badge-dot.badge-danger { background: #e11d48 !important; color: #fff !important; }
    .badge-dot.badge-warning { background: #f59e0b !important; color: #fff !important; }
    .badge-dot.badge-success { background: #22c55e !important; color: #fff !important; }
    .badge-dot.badge-info { background: #06b6d4 !important; color: #fff !important; }
    .badge-dot.badge-primary { background: #f43f5e !important; color: #fff !important; }
    .badge-status { font-size: 0.92rem; border-radius: 8px; padding: 0.32rem 1.1rem; font-weight: 600; letter-spacing: 1px; background: #f3f4f6; color: #f43f5e; border: none; }
    .badge-active { background: #e8f5e9 !important; color: #43a047 !important; }
    .badge-inactive { background: #ffebee !important; color: #e53935 !important; }
    .badge-role-table { background: #f43f5e1a; color: #f43f5e; font-size: 0.92rem; border-radius: 8px; padding: 0.32rem 1.1rem; font-weight: 600; letter-spacing: 1px; }
    .filter-bar { margin-bottom: 1.5rem; }
    .filter-bar .form-select { min-width: 140px; border-radius: 8px; }
    .high-debtors-table .tb-sub.text-danger { font-weight: 700; }
    .high-debtors-table .badge-dot.badge-danger { background: #e11d48 !important; }
    .high-debtors-table .badge-dot.badge-warning { background: #f59e0b !important; }
    .high-debtors-table .badge-dot.badge-success { background: #22c55e !important; }
    .high-debtors-table .badge-dot.badge-info { background: #06b6d4 !important; }
    .high-debtors-table .badge-dot { font-size: 0.95rem; }
    .high-debtors-table .user-avatar { font-size: 1.1rem; }
    .high-debtors-table .tb-lead { font-weight: 600; }
    .high-debtors-table .tb-sub { font-size: 0.98rem; }
    .high-debtors-table .badge { font-size: 0.95rem; }
    .high-debtors-table tr:hover { background: #f43f5e0d; }
    .chart-export-btn { background: linear-gradient(90deg, #e11d48, #ff4d4d); color: #fff; border: none; border-radius: 8px; padding: 0.45rem 1.1rem; font-weight: 600; font-size: 1.1rem; box-shadow: 0 2px 8px rgba(225,29,72,0.08); transition: all 0.2s; display: flex; align-items: center; justify-content: center; }
    .chart-export-btn:hover { background: linear-gradient(90deg, #f43f5e, #e11d48); color: #fff; box-shadow: 0 4px 16px rgba(225,29,72,0.12); transform: translateY(-2px) scale(1.04); }
    .stats-card .amount, .stats-card .data-group .amount { font-size: 2.1rem; font-weight: 700; color: #1e293b; }
    .stats-card .info .change { font-size: 1.05rem; font-weight: 600; }
    .stats-card .info .sub { font-size: 0.95rem; color: #64748b; }
    .stats-card .data-group { margin-bottom: 0.5rem; }
    .stats-card .card-title .title { color: #1e293b; }
</style>
@endpush

@section('content')
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title text-gradient">STEFIA Dashboard</h3>
            <div class="nk-block-des text-soft">
                <p>Comprehensive Financial Management Overview</p>
            </div>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export Report</span></a></li>
                        <li><a href="#" class="btn btn-success"><em class="icon ni ni-user-add"></em><span>Add Student</span></a></li>
                        <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Record Payment</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="nk-block">
    <div class="row g-gs">
        <!-- Total Mahasiswa -->
        <div class="col-xxl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card glass-card stats-card modern-card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <div class="stats-icon bg-primary">
                                <em class="icon ni ni-users"></em>
                            </div>
                            <h6 class="title text-gradient">Total Mahasiswa</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total mahasiswa terdaftar dalam sistem"></em>
                        </div>
                    </div>
                    <div class="data">
                        <div class="data-group">
                            <div class="amount gradient-text">{{ number_format($stats['total_students']) }}</div>
                            <div class="nk-ecwg6-ck">
                                <canvas class="ecommerce-line-chart-s3" id="totalStudents"></canvas>
                            </div>
                        </div>
                        <div class="info">
                            <span class="change {{ $stats['students_growth'] >= 0 ? 'up text-success' : 'down text-danger' }}">
                                <em class="icon ni ni-arrow-long-{{ $stats['students_growth'] >= 0 ? 'up' : 'down' }}"></em>{{ abs($stats['students_growth']) }}%
                            </span>
                            <span class="sub">vs last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Piutang Aktif -->
        <div class="col-xxl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card glass-card stats-card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Piutang Aktif</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total piutang yang masih aktif"></em>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">Rp {{ number_format($stats['active_receivables']) }}</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="activeReceivables"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                <span class="change {{ $stats['receivables_growth'] >= 0 ? 'up text-success' : 'down text-danger' }}">
                                    <em class="icon ni ni-arrow-long-{{ $stats['receivables_growth'] >= 0 ? 'up' : 'down' }}"></em>{{ abs($stats['receivables_growth']) }}%
                                </span>
                                <span class="sub">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Piutang Lunas -->
        <div class="col-xxl-3 col-md-6">
            <div class="card glass-card stats-card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Piutang Lunas</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total piutang yang sudah lunas"></em>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">Rp 1.456.780.000</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="paidReceivables"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                <span class="change up text-success">
                                    <em class="icon ni ni-arrow-long-up"></em>8.45%
                                </span>
                                <span class="sub">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tunggakan Kritis -->
        <div class="col-xxl-3 col-md-6">
            <div class="card glass-card stats-card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Tunggakan Kritis</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Mahasiswa dengan tunggakan >10 juta"></em>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">23</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="highDebtors"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                <span class="change down text-warning">
                                    <em class="icon ni ni-arrow-long-down"></em>2.45%
                                </span>
                                <span class="sub">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pembayaran Hari Ini -->
        <div class="col-xxl-3 col-md-6">
            <div class="card glass-card stats-card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Pembayaran Hari Ini</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Pembayaran yang diterima hari ini"></em>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">Rp 89.240.000</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="todayPayments"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                <span class="change up text-success">
                                    <em class="icon ni ni-arrow-long-up"></em>7.28%
                                </span>
                                <span class="sub">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Piutang Semester Ini -->
        <div class="col-xxl-3 col-md-6">
            <div class="card glass-card stats-card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Piutang Semester Ini</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Piutang semester tahun akademik berjalan"></em>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">Rp 456.780.000</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="semesterReceivables"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                <span class="change up text-success">
                                    <em class="icon ni ni-arrow-long-up"></em>15.67%
                                </span>
                                <span class="sub">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Piutang Tahun Ini -->
        <div class="col-xxl-3 col-md-6">
            <div class="card glass-card stats-card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Piutang Tahun Ini</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total piutang tahun 2025"></em>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">Rp 1.234.567.000</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="yearlyReceivables"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                <span class="change up text-success">
                                    <em class="icon ni ni-arrow-long-up"></em>18.23%
                                </span>
                                <span class="sub">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Collection Rate -->
        <div class="col-xxl-3 col-md-6">
            <div class="card glass-card stats-card">
                <div class="nk-ecwg nk-ecwg6">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Collection Rate</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Tingkat keberhasilan penagihan"></em>
                            </div>
                        </div>
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">94.2%</div>
                                <div class="nk-ecwg6-ck">
                                    <canvas class="ecommerce-line-chart-s3" id="collectionRate"></canvas>
                                </div>
                            </div>
                            <div class="info">
                                <span class="change up text-success">
                                    <em class="icon ni ni-arrow-long-up"></em>2.1%
                                </span>
                                <span class="sub">vs last month</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-xxl-8">
            <div class="card card-bordered glass-card h-100">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title text-gradient">Monthly Revenue</h6>
                            <p>In last 12 months revenue of STEFIA.</p>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Monthly revenue overview"></em>
                        </div>
                    </div>
                    <div class="nk-ecwg nk-ecwg1">
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">$2,847,950</div>
                                <div class="info text-right">
                                    <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>12.38%</span>
                                    <span class="sub">vs last month</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-ecwg1-ck">
                            <div id="monthlyRevenue" style="height:320px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card card-bordered glass-card h-100">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title text-gradient">Status Piutang</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Distribusi status piutang mahasiswa"></em>
                        </div>
                    </div>
                    <div class="nk-ecwg nk-ecwg3">
                        <div class="nk-ecwg3-ck">
                            <div id="receivableStatus" style="height:350px"></div>
                        </div>
                        <ul class="nk-ecwg3-legends">
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#22c55e"></span>
                                    <span>Lunas</span>
                                </div>
                                <div class="amount">68.5%</div>
                            </li>
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#f59e0b"></span>
                                    <span>Aktif</span>
                                </div>
                                <div class="amount">28.8%</div>
                            </li>
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#ef4444"></span>
                                    <span>Tunggakan</span>
                                </div>
                                <div class="amount">2.7%</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- High Debtors and Payment Trends -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-xxl-6">
            <div class="card card-bordered glass-card h-100">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title text-gradient">Mahasiswa Tunggakan Kritis (>10 Juta)</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="card-tools-nav">
                                <li><a href="#"><span>View All</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-inner p-0">
                    <div class="nk-tb-list">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span>Mahasiswa</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>Tunggakan</span></div>
                            <div class="nk-tb-col tb-col-md"><span>Terakhir Bayar</span></div>
                            <div class="nk-tb-col"><span>Status</span></div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-danger">
                                        <span>AN</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Ahmad Nurdin</span>
                                        <span class="tb-sub">2019001234</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub text-danger">Rp 15.750.000</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Nov 15, 2024</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-danger">Kritis</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-warning">
                                        <span>SR</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Siti Rahayu</span>
                                        <span class="tb-sub">2019005678</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub text-warning">Rp 12.500.000</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Dec 20, 2024</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-warning">Tinggi</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-danger">
                                        <span>BH</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Budi Hartono</span>
                                        <span class="tb-sub">2020001987</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub text-danger">Rp 18.200.000</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Oct 10, 2024</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-danger">Kritis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card card-bordered glass-card h-100">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title text-gradient">Tren Pembayaran Bulanan</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Tren pembayaran 6 bulan terakhir"></em>
                        </div>
                    </div>
                    <div class="nk-ecwg nk-ecwg1">
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">Rp 89.240.000</div>
                                <div class="info text-right">
                                    <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>7.28%</span>
                                    <span class="sub">vs bulan lalu</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-ecwg1-ck">
                            <div id="paymentTrends" style="height:280px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-xxl-8">
            <div class="card card-bordered glass-card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title text-gradient">Recent Transactions</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="card-tools-nav">
                                <li><a href="#"><span>View All</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-inner p-0">
                    <div class="nk-tb-list">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span>Student</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>Amount</span></div>
                            <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                            <div class="nk-tb-col"><span>Status</span></div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-danger">
                                        <span>JS</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">John Smith</span>
                                        <span class="tb-sub">john.smith@example.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub">$2,500</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Jan 15, 2025</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-success">Paid</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-danger">
                                        <span>MA</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Maria Anderson</span>
                                        <span class="tb-sub">maria.anderson@example.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub">$1,850</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Jan 12, 2025</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-warning">Pending</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-danger">
                                        <span>DL</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">David Lee</span>
                                        <span class="tb-sub">david.lee@example.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub">$3,200</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Jan 10, 2025</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-success">Paid</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card card-bordered glass-card">
                <div class="card-inner">
                    <div class="card-title-group mb-2">
                        <div class="card-title">
                            <h6 class="title text-gradient">Recent Activities</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="card-tools-nav">
                                <li><a href="#"><span>View All</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-inner">
                    <div class="timeline">
                        <ul class="timeline-list">
                            <li class="timeline-item">
                                <div class="timeline-status bg-primary is-outline"></div>
                                <div class="timeline-date">Just now</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">New student registration</h6>
                                    <div class="timeline-des">
                                        <p>Sarah Johnson has successfully registered for the Computer Science program.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-status bg-success is-outline"></div>
                                <div class="timeline-date">2 hours ago</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Payment received</h6>
                                    <div class="timeline-des">
                                        <p>$2,500 tuition payment received from John Smith.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-status bg-warning is-outline"></div>
                                <div class="timeline-date">5 hours ago</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Scholarship application</h6>
                                    <div class="timeline-des">
                                        <p>New scholarship application submitted by Maria Anderson.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-status bg-info is-outline"></div>
                                <div class="timeline-date">1 day ago</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Report generated</h6>
                                    <div class="timeline-des">
                                        <p>Monthly financial report has been generated and is ready for review.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Insight Cards -->
<div class="nk-block mb-4">
    <div class="row g-3">
        @foreach($insights ?? [] as $insight)
            <div class="col-md-4 col-12">
                <div class="glass-card stats-card d-flex align-items-center p-3" style="min-height:90px;">
                    <div class="stats-icon me-3 bg-{{ $insight['color'] ?? 'primary' }}" style="font-size:1.7rem;"><em class="icon ni {{ $insight['icon'] }}"></em></div>
                    <div class="flex-fill">
                        <span class="fw-semibold">{{ $insight['text'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Grafik Tambahan -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-xxl-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-inner">
                    <h6 class="title text-gradient">Komposisi Metode Pembayaran</h6>
                    <div id="paymentMethodPie" style="height:320px"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-inner">
                    <h6 class="title text-gradient">Tren Mahasiswa Baru per Bulan</h6>
                    <div id="studentTrendLine" style="height:320px"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-12">
            <div class="card glass-card h-100">
                <div class="card-inner">
                    <h6 class="title text-gradient">Jumlah Transaksi Pembayaran per Bulan</h6>
                    <div id="transactionTrendBar" style="height:320px"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Outstanding Ratio & Beasiswa -->
<div class="nk-block mt-4">
    <div class="row g-gs">
        <div class="col-xxl-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-inner">
                    <h6 class="title text-gradient">Rasio Piutang Outstanding</h6>
                    <div id="outstandingRatioDonut" style="height:320px"></div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-inner">
                    <h6 class="title text-gradient">Statistik Reminder & Notifikasi</h6>
                    <ul class="list-unstyled small mb-2">
                        <li><em class="icon ni ni-send"></em> <span class="text-muted">Reminder Terkirim:</span> <span class="text-primary">{{ $reminderStats['sent'] ?? 0 }}</span></li>
                        <li><em class="icon ni ni-cross"></em> <span class="text-muted">Reminder Gagal:</span> <span class="text-danger">{{ $reminderStats['failed'] ?? 0 }}</span></li>
                        <li><em class="icon ni ni-whatsapp"></em> <span class="text-muted">WA Terkirim:</span> <span class="text-success">{{ $reminderStats['wa_sent'] ?? 0 }}</span></li>
                        <li><em class="icon ni ni-mail"></em> <span class="text-muted">Email Terkirim:</span> <span class="text-info">{{ $reminderStats['email_sent'] ?? 0 }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-12">
            <div class="card glass-card h-100">
                <div class="card-inner">
                    <h6 class="title text-gradient">Statistik Beasiswa Aktif</h6>
                    <div id="beasiswaBar" style="height:320px"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top 10 Mahasiswa Pembayar Terbesar -->
<div class="nk-block mt-4">
    <div class="card glass-card">
        <div class="card-inner">
            <h5 class="mb-4 text-gradient">Top 10 Mahasiswa Pembayar Terbesar</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Program Studi</th>
                            <th>Total Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPayers as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->nim ?? '-' }}</td>
                                <td>{{ $student->study_program ?? '-' }}</td>
                                <td>Rp {{ number_format($student->total_paid ?? 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Highcharts CDN + no-data-to-display -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>

@php
    $months = $chartData['months'] ?? ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    $paymentTrendMonths = $chartData['trend_months'] ?? ["Jul","Aug","Sep","Oct","Nov","Dec","Jan"];
@endphp
<script>
var monthlyRevenueData = @json($chartData['monthly_revenue'] ?? []);
var paymentTrendsData = @json($chartData['payment_trends'] ?? []);
var receivableStatusData = @json($chartData['receivable_status'] ?? []);
var months = @json($months);
var paymentTrendMonths = @json($paymentTrendMonths);
console.log('monthlyRevenueData', monthlyRevenueData);
console.log('paymentTrendsData', paymentTrendsData);
console.log('receivableStatusData', receivableStatusData);
console.log('months', months);
console.log('paymentTrendMonths', paymentTrendMonths);

if (monthlyRevenueData && monthlyRevenueData.length > 0 && document.getElementById('monthlyRevenue')) {
    Highcharts.chart('monthlyRevenue', {
        chart: { type: 'area', height: 320 },
        title: { text: 'Tren Pembayaran Bulanan' },
        xAxis: { categories: months },
        yAxis: { title: { text: 'Jumlah Pembayaran (Rp)' } },
        tooltip: {
            shared: true,
            valuePrefix: 'Rp ',
            valueDecimals: 0,
            valueSuffix: ''
        },
        series: [{
            name: 'Pembayaran',
            data: monthlyRevenueData,
            color: '#e11d48',
            fillColor: {
                linearGradient: [0, 0, 0, 300],
                stops: [
                    [0, 'rgba(225,29,72,0.7)'],
                    [1, 'rgba(225,29,72,0.1)']
                ]
            }
        }],
        exporting: { enabled: true },
        credits: { enabled: false }
    });
}

if (paymentTrendsData && paymentTrendsData.length > 0 && document.getElementById('paymentTrends')) {
    Highcharts.chart('paymentTrends', {
        chart: { type: 'area', height: 280 },
        title: { text: 'Tren Pembayaran 6 Bulan Terakhir' },
        xAxis: { categories: paymentTrendMonths },
        yAxis: { title: { text: 'Pembayaran (Rp)' } },
        tooltip: {
            shared: true,
            valuePrefix: 'Rp ',
            valueDecimals: 0,
            valueSuffix: ''
        },
        series: [{
            name: 'Pembayaran',
            data: paymentTrendsData,
            color: '#22c55e',
            fillColor: {
                linearGradient: [0, 0, 0, 300],
                stops: [
                    [0, 'rgba(34,197,94,0.7)'],
                    [1, 'rgba(34,197,94,0.1)']
                ]
            }
        }],
        exporting: { enabled: true },
        credits: { enabled: false }
    });
}

if (receivableStatusData && document.getElementById('receivableStatus')) {
    Highcharts.chart('receivableStatus', {
        chart: { type: 'pie', height: 350 },
        title: { text: 'Distribusi Status Piutang' },
        tooltip: { pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>' },
        accessibility: { point: { valueSuffix: '%' } },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: { enabled: false },
                showInLegend: true,
                innerSize: '50%'
            }
        },
        series: [{
            name: 'Status',
            colorByPoint: true,
            data: [
                { name: 'Lunas', y: receivableStatusData.paid ?? 0, color: '#22c55e', sliced: true, selected: true },
                { name: 'Aktif', y: receivableStatusData.active ?? 0, color: '#f59e0b' },
                { name: 'Tunggakan', y: receivableStatusData.overdue ?? 0, color: '#ef4444' }
            ]
        }],
        exporting: { enabled: true },
        credits: { enabled: false }
    });
}

// Initialize Charts when document is ready
$(document).ready(function() {
    
    // Set Highcharts global options with modern styling
    Highcharts.setOptions({
        colors: ['#e11d48', '#f43f5e', '#fb7185', '#22c55e', '#f59e0b', '#06b6d4', '#f97316', '#84cc16'],
        chart: {
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'Inter, sans-serif',
                fontSize: '13px'
            },
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            style: {
                color: '#374151',
                fontSize: '16px',
                fontWeight: '600'
            }
        },
        subtitle: {
            style: {
                color: '#6b7280',
                fontSize: '12px'
            }
        },
        legend: {
            itemStyle: {
                color: '#374151',
                fontSize: '12px',
                fontWeight: '500'
            },
            itemHoverStyle: {
                color: '#dc2626'
            }
        },
        xAxis: {
            labels: {
                style: {
                    color: '#6b7280',
                    fontSize: '11px'
                }
            },
            title: {
                style: {
                    color: '#374151',
                    fontSize: '12px',
                    fontWeight: '500'
                }
            },
            lineColor: '#e5e7eb',
            tickColor: '#e5e7eb'
        },
        yAxis: {
            labels: {
                style: {
                    color: '#6b7280',
                    fontSize: '11px'
                }
            },
            title: {
                style: {
                    color: '#374151',
                    fontSize: '12px',
                    fontWeight: '500'
                }
            },
            gridLineColor: '#f3f4f6',
            lineColor: '#e5e7eb'
        },
        tooltip: {
            backgroundColor: 'rgba(255, 255, 255, 0.98)',
            borderColor: '#e5e7eb',
            borderRadius: 8,
            borderWidth: 1,
            shadow: {
                color: 'rgba(0, 0, 0, 0.1)',
                offsetX: 0,
                offsetY: 2,
                opacity: 0.5,
                width: 3
            },
            style: {
                color: '#374151',
                fontSize: '12px'
            }
        },
        plotOptions: {
            series: {
                animation: {
                    duration: 1200
                },
                states: {
                    hover: {
                        brightness: 0.1
                    }
                }
            }
        },
        credits: {
            enabled: false
        }
    });
    
    // Modern Highcharts small sparkline charts for statistics cards
    if ($('#totalStudents').length) {
        Highcharts.chart('totalStudents', {
            chart: {
                type: 'areaspline',
                height: 60,
                margin: [2, 0, 2, 0],
                width: 120,
                backgroundColor: null,
                borderWidth: 0,
                style: {
                    overflow: 'visible'
                },
                skipClone: true
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            xAxis: {
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                startOnTick: false,
                endOnTick: false,
                tickPositions: []
            },
            yAxis: {
                endOnTick: false,
                startOnTick: false,
                labels: {
                    enabled: false
                },
                title: {
                    text: null
                },
                tickPositions: [0]
            },
            legend: {
                enabled: false
            },
            tooltip: {
                hideDelay: 0,
                outside: true,
                shared: true
            },
            plotOptions: {
                series: {
                    animation: false,
                    lineWidth: 2,
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 2
                        }
                    },
                    marker: {
                        radius: 1,
                        states: {
                            hover: {
                                radius: 2
                            }
                        }
                    },
                    fillOpacity: 0.25
                },
                column: {
                    negativeColor: '#910000',
                    borderColor: 'silver'
                }
            },
            series: [{
                data: [1100, 1150, 1200, 1180, 1220, 1245],
                color: '#e11d48',
                fillColor: {
                    linearGradient: {
                        x1: 0,
                        y1: 0,
                        x2: 0,
                        y2: 1
                    },
                    stops: [
                        [0, 'rgba(225, 29, 72, 0.4)'],
                        [1, 'rgba(225, 29, 72, 0.1)']
                    ]
                }
            }]
        });
    }
    
    if ($('#activeReceivables').length) {
        Highcharts.chart('activeReceivables', {
            chart: {
                type: 'areaspline',
                height: 60,
                margin: [2, 0, 2, 0],
                width: 120,
                backgroundColor: null,
                borderWidth: 0,
                style: {
                    overflow: 'visible'
                },
                skipClone: true
            },
            title: { text: '' },
            credits: { enabled: false },
            xAxis: {
                labels: { enabled: false },
                title: { text: null },
                startOnTick: false,
                endOnTick: false,
                tickPositions: []
            },
            yAxis: {
                endOnTick: false,
                startOnTick: false,
                labels: { enabled: false },
                title: { text: null },
                tickPositions: [0]
            },
            legend: { enabled: false },
            tooltip: {
                hideDelay: 0,
                outside: true,
                shared: true,
                formatter: function() {
                    return 'Rp ' + (this.y / 1000000).toFixed(1) + 'M';
                }
            },
            plotOptions: {
                series: {
                    animation: false,
                    lineWidth: 2,
                    shadow: false,
                    marker: {
                        radius: 1,
                        states: { hover: { radius: 2 } }
                    },
                    fillOpacity: 0.25
                }
            },
            series: [{
                data: [2500000, 2600000, 2750000, 2680000, 2800000, 2847950],
                color: '#22c55e',
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, 'rgba(34, 197, 94, 0.4)'],
                        [1, 'rgba(34, 197, 94, 0.1)']
                    ]
                }
            }]
        });
    }
    
    // Create sparkline charts for each stats card
    function createSparklineChart(elementId, data, color, fillStops) {
        if ($('#' + elementId).length) {
            Highcharts.chart(elementId, {
                chart: {
                    type: 'areaspline',
                    height: 60,
                    margin: [2, 0, 2, 0],
                    width: 120,
                    backgroundColor: null,
                    borderWidth: 0,
                    style: { overflow: 'visible' },
                    skipClone: true
                },
                title: { text: '' },
                credits: { enabled: false },
                xAxis: {
                    labels: { enabled: false },
                    title: { text: null },
                    startOnTick: false,
                    endOnTick: false,
                    tickPositions: []
                },
                yAxis: {
                    endOnTick: false,
                    startOnTick: false,
                    labels: { enabled: false },
                    title: { text: null },
                    tickPositions: [0]
                },
                legend: { enabled: false },
                tooltip: {
                    hideDelay: 0,
                    outside: true,
                    shared: true
                },
                plotOptions: {
                    series: {
                        animation: false,
                        lineWidth: 2,
                        shadow: false,
                        marker: {
                            radius: 1,
                            states: { hover: { radius: 2 } }
                        },
                        fillOpacity: 0.25
                    }
                },
                series: [{
                    data: data,
                    color: color,
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: fillStops
                    }
                }]
            });
        }
    }
    
    // Create all sparkline charts
    createSparklineChart('paidReceivables', [1400000, 1420000, 1380000, 1450000, 1440000, 1456780], '#22c55e', [[0, 'rgba(34, 197, 94, 0.4)'], [1, 'rgba(34, 197, 94, 0.1)']]);
    createSparklineChart('highDebtors', [28, 25, 30, 27, 26, 23], '#ef4444', [[0, 'rgba(239, 68, 68, 0.4)'], [1, 'rgba(239, 68, 68, 0.1)']]);
    createSparklineChart('todayPayments', [85000, 88000, 92000, 85000, 91000, 89240], '#f59e0b', [[0, 'rgba(245, 158, 11, 0.4)'], [1, 'rgba(245, 158, 11, 0.1)']]);
    createSparklineChart('semesterReceivables', [420000, 435000, 440000, 445000, 450000, 456780], '#8b5cf6', [[0, 'rgba(139, 92, 246, 0.4)'], [1, 'rgba(139, 92, 246, 0.1)']]);
    createSparklineChart('yearlyReceivables', [1100000, 1150000, 1180000, 1200000, 1220000, 1234567], '#06b6d4', [[0, 'rgba(6, 182, 212, 0.4)'], [1, 'rgba(6, 182, 212, 0.1)']]);
    createSparklineChart('collectionRate', [92.1, 93.5, 92.8, 93.2, 94.0, 94.2], '#14b8a6', [[0, 'rgba(20, 184, 166, 0.4)'], [1, 'rgba(20, 184, 166, 0.1)']]);
    
    
    // Initialize tooltips (Bootstrap 5 compatible)
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Auto-refresh data every 30 seconds (in production, this would make AJAX calls)
    setInterval(function() {
        // You can add AJAX calls here to refresh data
        console.log('Refreshing dashboard data...');
    }, 30000);
    
});
</script>
@endpush
