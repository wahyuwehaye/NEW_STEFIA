@extends('layouts.admin')

@section('title', 'Dashboard Pembayaran')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview">
                    <div class="nk-block-head nk-block-head-lg">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title fw-normal">Dashboard Pembayaran</h2>
                            <div class="nk-block-des">
                                <p>Monitoring dan analisis pembayaran mahasiswa secara real-time</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="nk-block">
                        <div class="row g-3">
                            <div class="col-xxl-3 col-md-6">
                                <div class="card card-full bg-primary">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title text-white">Total Pembayaran Hari Ini</h6>
                                            </div>
                                        </div>
                                        <div class="card-amount">
                                            <span class="amount text-white">Rp 125,750,000</span>
                                        </div>
                                        <div class="card-note">
                                            <em class="icon ni ni-activity text-white"></em>
                                            <span class="text-white">34 transaksi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="card card-full bg-success">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title text-white">Pembayaran Terverifikasi</h6>
                                            </div>
                                        </div>
                                        <div class="card-amount">
                                            <span class="amount text-white">1,234</span>
                                        </div>
                                        <div class="card-note">
                                            <em class="icon ni ni-check-circle text-white"></em>
                                            <span class="text-white">+12% dari kemarin</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="card card-full bg-warning">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title text-white">Menunggu Verifikasi</h6>
                                            </div>
                                        </div>
                                        <div class="card-amount">
                                            <span class="amount text-white">87</span>
                                        </div>
                                        <div class="card-note">
                                            <em class="icon ni ni-clock text-white"></em>
                                            <span class="text-white">Perlu perhatian</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-6">
                                <div class="card card-full bg-danger">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title text-white">Pembayaran Gagal</h6>
                                            </div>
                                        </div>
                                        <div class="card-amount">
                                            <span class="amount text-white">23</span>
                                        </div>
                                        <div class="card-note">
                                            <em class="icon ni ni-cross-circle text-white"></em>
                                            <span class="text-white">Butuh tindakan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="nk-block">
                        <div class="card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Aksi Cepat</h6>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-3 col-md-6">
                                        <a href="{{ route('payments.create') }}" class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Input Pembayaran</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="icon ni ni-plus-circle text-primary"></em>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <span class="text-muted">Tambah pembayaran baru</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <a href="{{ route('payments.verification') }}" class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Verifikasi</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="icon ni ni-check-circle text-success"></em>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <span class="text-muted">Verifikasi pembayaran</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <a href="{{ route('payments.integration') }}" class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Integrasi</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="icon ni ni-reload text-info"></em>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <span class="text-muted">Sync dengan iGracias</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-6">
                                        <a href="{{ route('payments.export') }}" class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Export</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="icon ni ni-download text-warning"></em>
                                                    </div>
                                                </div>
                                                <div class="card-text">
                                                    <span class="text-muted">Download laporan</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Analytics -->
                    <div class="nk-block">
                        <div class="row g-3">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Trend Pembayaran</h6>
                                            </div>
                                            <div class="card-tools">
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                        30 Hari Terakhir
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><span>7 Hari</span></a></li>
                                                            <li><a href="#"><span>30 Hari</span></a></li>
                                                            <li><a href="#"><span>3 Bulan</span></a></li>
                                                            <li><a href="#"><span>1 Tahun</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-chart-wrap">
                                            <canvas id="paymentTrendChart" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Metode Pembayaran</h6>
                                            </div>
                                        </div>
                                        <div class="nk-chart-wrap">
                                            <canvas id="paymentMethodChart" width="400" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Payments -->
                    <div class="nk-block">
                        <div class="card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Pembayaran Terbaru</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('payments.index') }}" class="btn btn-light btn-sm">
                                            Lihat Semua
                                        </a>
                                    </div>
                                </div>
                                <div class="nk-tb-wrap">
                                    <div class="nk-tb">
                                        <div class="nk-tb-head">
                                            <div class="nk-tb-col"><span class="sub-text">Tanggal</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Mahasiswa</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Jumlah</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Metode</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">Aksi</span></div>
                                        </div>
                                        <div class="nk-tb-body">
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead">{{ now()->format('d M Y') }}</span>
                                                    <span class="tb-sub">{{ now()->format('H:i') }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">Ahmad Rizki</span>
                                                            <span class="tb-sub">102210001</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead">Rp 2,500,000</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dim bg-light">Transfer Bank</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dim bg-warning">Pending</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-light" data-bs-toggle="dropdown">
                                                            <em class="icon ni ni-more-h"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-check"></em><span>Verify</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead">{{ now()->subMinutes(30)->format('d M Y') }}</span>
                                                    <span class="tb-sub">{{ now()->subMinutes(30)->format('H:i') }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">Siti Nurhaliza</span>
                                                            <span class="tb-sub">102210002</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead">Rp 1,750,000</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dim bg-light">Credit Card</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dim bg-success">Verified</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-light" data-bs-toggle="dropdown">
                                                            <em class="icon ni ni-more-h"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-file-text"></em><span>Receipt</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead">{{ now()->subHours(1)->format('d M Y') }}</span>
                                                    <span class="tb-sub">{{ now()->subHours(1)->format('H:i') }}</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">Budi Santoso</span>
                                                            <span class="tb-sub">102210003</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="tb-lead">Rp 3,000,000</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dim bg-light">E-Wallet</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span class="badge badge-dim bg-danger">Failed</span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-light" data-bs-toggle="dropdown">
                                                            <em class="icon ni ni-more-h"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="#"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-reload"></em><span>Retry</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Summary -->
                    <div class="nk-block">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Ringkasan Hari Ini</h6>
                                            </div>
                                        </div>
                                        <div class="nk-block">
                                            <div class="row g-3">
                                                <div class="col-sm-6">
                                                    <div class="overview-item">
                                                        <div class="overview-tile">
                                                            <span class="overview-icon bg-primary">
                                                                <em class="icon ni ni-coins"></em>
                                                            </span>
                                                        </div>
                                                        <div class="overview-text">
                                                            <span class="overview-title">Total Pembayaran</span>
                                                            <span class="overview-amount">Rp 125,750,000</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="overview-item">
                                                        <div class="overview-tile">
                                                            <span class="overview-icon bg-success">
                                                                <em class="icon ni ni-check-circle"></em>
                                                            </span>
                                                        </div>
                                                        <div class="overview-text">
                                                            <span class="overview-title">Terverifikasi</span>
                                                            <span class="overview-amount">28 transaksi</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="overview-item">
                                                        <div class="overview-tile">
                                                            <span class="overview-icon bg-warning">
                                                                <em class="icon ni ni-clock"></em>
                                                            </span>
                                                        </div>
                                                        <div class="overview-text">
                                                            <span class="overview-title">Pending</span>
                                                            <span class="overview-amount">4 transaksi</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="overview-item">
                                                        <div class="overview-tile">
                                                            <span class="overview-icon bg-danger">
                                                                <em class="icon ni ni-cross-circle"></em>
                                                            </span>
                                                        </div>
                                                        <div class="overview-text">
                                                            <span class="overview-title">Gagal</span>
                                                            <span class="overview-amount">2 transaksi</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Top Kategori Pembayaran</h6>
                                            </div>
                                        </div>
                                        <div class="nk-tb-wrap">
                                            <div class="nk-tb">
                                                <div class="nk-tb-body">
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead">Tuition Fee</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-end">
                                                            <span class="tb-amount">Rp 89,500,000</span>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead">Lab Fee</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-end">
                                                            <span class="tb-amount">Rp 25,250,000</span>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead">Registration</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-end">
                                                            <span class="tb-amount">Rp 8,000,000</span>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead">Library</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-end">
                                                            <span class="tb-amount">Rp 2,000,000</span>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-item">
                                                        <div class="nk-tb-col">
                                                            <span class="tb-lead">Other</span>
                                                        </div>
                                                        <div class="nk-tb-col tb-col-end">
                                                            <span class="tb-amount">Rp 1,000,000</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 show fade-in`;
    toast.style = 'min-width:260px; margin-bottom:8px;';
    toast.innerHTML = `<div class='d-flex'><div class='toast-body'>${message}</div><button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button></div>`;
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = 9999;
        document.body.appendChild(container);
    }
    container.appendChild(toast);
    setTimeout(() => { toast.classList.remove('show'); toast.remove(); }, 3500);
}
// Example: feedback ekspor
function exportChart(chartId) {
    showToast('Ekspor chart ' + chartId + ' berhasil (dummy)', 'success');
    // TODO: Implement real export logic
}
// Example: feedback error
function chartError(chartId) {
    showToast('Gagal memuat chart ' + chartId, 'danger');
}
// Loading indicator for refresh
function showLoadingDashboard() {
    let loading = document.getElementById('dashboardLoading');
    if (!loading) {
        loading = document.createElement('div');
        loading.id = 'dashboardLoading';
        loading.style = 'position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.6);z-index:9998;display:flex;align-items:center;justify-content:center;';
        loading.innerHTML = '<div class="spinner-border text-danger" style="width:3rem;height:3rem;"></div>';
        document.body.appendChild(loading);
    }
}
function hideLoadingDashboard() {
    let loading = document.getElementById('dashboardLoading');
    if (loading) loading.remove();
}
// Simulasi refresh data dengan loading
function refreshDashboardData() {
    showLoadingDashboard();
    setTimeout(() => {
        hideLoadingDashboard();
        showToast('Data dashboard berhasil diperbarui', 'success');
    }, 1200);
}
// Feedback notifikasi sukses/gagal setelah aksi
@if(session('success'))
    window.setTimeout(() => { showToast(@json(session('success')), 'success'); }, 500);
@endif
@if(session('error'))
    window.setTimeout(() => { showToast(@json(session('error')), 'danger'); }, 500);
@endif
</script>
@endpush
@push('styles')
<style>
.toast-container { pointer-events: none; }
.toast { pointer-events: auto; min-width: 260px; }
#dashboardLoading { pointer-events: all; }
</style>
@endpush
