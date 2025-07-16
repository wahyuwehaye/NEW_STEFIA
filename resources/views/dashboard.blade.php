
@extends('layouts.admin')

@section('title', 'Dashboard')

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
                            <canvas class="ecommerce-line-chart-s1" id="monthlyRevenue"></canvas>
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
                            <canvas class="ecommerce-doughnut-s1" id="receivableStatus"></canvas>
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
                            <canvas class="ecommerce-line-chart-s1" id="paymentTrends"></canvas>
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
@endsection

@push('scripts')
<!-- Charts will be initialized by the main app.js -->
<script>
// Dashboard-specific initialization
$(document).ready(function() {
    // Any dashboard-specific code can go here
    console.log('Dashboard page loaded');
});
</script>

<script>
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
        
        // Advanced Monthly Revenue Chart with Highcharts
        if ($('#monthlyRevenue').length) {
            Highcharts.chart('monthlyRevenue', {
                chart: {
                    type: 'area',
                    height: 300
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                yAxis: {
                    title: {
                        text: 'Revenue (IDR)'
                    },
                    labels: {
                        formatter: function() {
                            return 'Rp ' + (this.value / 1000000).toFixed(1) + 'M';
                        }
                    },
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + this.x + '</b>';
                        this.points.forEach(function(point) {
                            s += '<br/>' + point.series.name + ': Rp ' + 
                                 (point.y / 1000000).toFixed(1) + 'M';
                        });
                        return s;
                    }
                },
                plotOptions: {
                    area: {
                        fillOpacity: 0.5,
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 4,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Total Revenue',
                    data: [2200000000, 2350000000, 2180000000, 2450000000, 2600000000, 2750000000, 2680000000, 2800000000, 2920000000, 2850000000, 2780000000, 2847950000],
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, 'rgba(225, 29, 72, 0.8)'],
                            [1, 'rgba(225, 29, 72, 0.1)']
                        ]
                    },
                    color: '#e11d48'
                }, {
                    name: 'Target Revenue',
                    data: [2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000],
                    type: 'line',
                    color: '#22c55e',
                    dashStyle: 'dash'
                }],
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                        }
                    }
                }
            });
        }
        
        // Receivable Status Pie Chart with Highcharts
        if ($('#receivableStatus').length) {
            Highcharts.chart('receivableStatus', {
                chart: {
                    type: 'pie',
                    height: 350
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true,
                        innerSize: '50%'
                    }
                },
                series: [{
                    name: 'Status',
                    colorByPoint: true,
                    data: [{
                        name: 'Lunas',
                        y: 68.5,
                        color: '#22c55e',
                        sliced: true,
                        selected: true
                    }, {
                        name: 'Aktif',
                        y: 28.8,
                        color: '#f59e0b'
                    }, {
                        name: 'Tunggakan',
                        y: 2.7,
                        color: '#ef4444'
                    }]
                }]
            });
        }
        
        // Payment Trends Chart
        if ($('#paymentTrends').length) {
            Highcharts.chart('paymentTrends', {
                chart: {
                    type: 'area',
                    height: 280
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                yAxis: {
                    title: {
                        text: 'Pembayaran (IDR)'
                    },
                    labels: {
                        formatter: function() {
                            return 'Rp ' + (this.value / 1000000).toFixed(1) + 'M';
                        }
                    },
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + this.x + '</b>';
                        this.points.forEach(function(point) {
                            s += '<br/>' + point.series.name + ': Rp ' + 
                                 (point.y / 1000000).toFixed(1) + 'M';
                        });
                        return s;
                    }
                },
                plotOptions: {
                    area: {
                        fillOpacity: 0.5,
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 4,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Pembayaran',
                    data: [75000000, 82000000, 78000000, 85000000, 88000000, 91000000, 89240000],
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, 'rgba(34, 197, 94, 0.8)'],
                            [1, 'rgba(34, 197, 94, 0.1)']
                        ]
                    },
                    color: '#22c55e'
                }]
            });
        }
        
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
