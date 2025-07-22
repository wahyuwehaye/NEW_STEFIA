@extends('layouts.admin')

@section('title', 'Dashboard Piutang')

@section('content')
<div class="nk-content">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <!-- Clean Header -->
            <div class="dashboard-header">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="page-header">
                                <h1 class="page-title">Dashboard Piutang</h1>
                                <p class="page-subtitle">Analisis dan monitoring piutang mahasiswa</p>
                            </div>
                        </div>
                        <div class="col-lg-4 text-end">
                            <div class="page-actions">
                                <a href="{{ route('receivables.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus"></em>
                                    <span>Tambah Piutang</span>
                                </a>
                                <a href="{{ route('receivables.export') }}" class="btn btn-outline-light">
                                    <em class="icon ni ni-download"></em>
                                    <span>Export</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="nk-block">
                <div class="row g-gs">
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <em class="icon ni ni-list"></em>
                                </div>
                                <div class="stat-card-info">
                                    <h3 class="stat-card-value">{{ number_format($stats['total_receivables']) }}</h3>
                                    <p class="stat-card-label">Total Receivables</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <em class="icon ni ni-wallet"></em>
                                </div>
                                <div class="stat-card-info">
                                    <h3 class="stat-card-value">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</h3>
                                    <p class="stat-card-label">Total Value</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <em class="icon ni ni-check-circle"></em>
                                </div>
                                <div class="stat-card-info">
                                    <h3 class="stat-card-value">Rp {{ number_format($stats['total_paid'], 0, ',', '.') }}</h3>
                                    <p class="stat-card-label">Total Paid</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-card-body">
                                <div class="stat-card-icon">
                                    <em class="icon ni ni-alert-circle"></em>
                                </div>
                                <div class="stat-card-info">
                                    <h3 class="stat-card-value">Rp {{ number_format($stats['total_outstanding'], 0, ',', '.') }}</h3>
                                    <p class="stat-card-label">Outstanding</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics Dashboard -->
            <div class="nk-block">
                <div class="row g-gs">
                    <!-- Payment Status Overview -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="card card-bordered analytics-card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Payment Status Analytics</h6>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>View Details</span></a></li>
                                                    <li><a href="#"><span>Export Report</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="analytics-chart">
                                    <div id="paymentStatusChart" style="height: 200px; width: 100%;"></div>
                                </div>
                                <div class="analytics-legend">
                                    <div class="legend-item">
                                        <div class="legend-color bg-success"></div>
                                        <span>Paid ({{ number_format($stats['paid_count']) }})</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color bg-warning"></div>
                                        <span>Pending ({{ number_format($stats['pending_count']) }})</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color bg-info"></div>
                                        <span>Partial ({{ number_format($stats['partial_count']) }})</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color bg-danger"></div>
                                        <span>Overdue ({{ number_format($stats['overdue_count']) }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Performance Metrics -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="card card-bordered analytics-card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Performance Metrics</h6>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>View Details</span></a></li>
                                                    <li><a href="#"><span>Export Report</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="performanceMetricsChart" style="height: 200px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Analytics -->
            <div class="nk-block">
                <div class="row g-gs">
                    <!-- Monthly Revenue Trend -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="card card-bordered analytics-card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Monthly Revenue Trend</h6>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>View Details</span></a></li>
                                                    <li><a href="#"><span>Export Report</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="monthlyRevenueChart" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Breakdown -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="card card-bordered analytics-card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Payment Method Breakdown</h6>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>View Details</span></a></li>
                                                    <li><a href="#"><span>Export Report</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="paymentMethodChart" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue Analysis and Department Breakdown -->
            <div class="nk-block">
                <div class="row g-gs">
                    <!-- Overdue Analysis -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="card card-bordered analytics-card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Overdue Analysis</h6>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>View Details</span></a></li>
                                                    <li><a href="#"><span>Export Report</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="overdueAnalysisChart" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Department Breakdown -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="card card-bordered analytics-card">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Department Breakdown</h6>
                                    </div>
                                    <div class="card-tools">
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle btn btn-light btn-sm" data-bs-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#"><span>View Details</span></a></li>
                                                    <li><a href="#"><span>Export Report</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="departmentChart" style="height: 300px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nk-block">
                <div class="row g-gs">
                    <!-- Recent Receivables -->
                    <div class="col-xxl-8">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Piutang Terbaru</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('receivables.index') }}" class="link">Lihat Semua</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-ov">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span class="sub-text">Kode</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Mahasiswa</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Jumlah</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Jatuh Tempo</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                    </div>
                                    @forelse($recent_receivables as $receivable)
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <a href="{{ route('receivables.show', $receivable) }}">
                                                <span class="fw-medium">{{ $receivable->receivable_code }}</span>
                                            </a>
                                        </div>
                                        <div class="nk-tb-col">
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $receivable->student->name }}</span>
                                                <span class="tb-sub">{{ $receivable->student->nim }}</span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="amount">Rp {{ number_format($receivable->amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="tb-sub">{{ $receivable->due_date->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="badge badge-dot badge-{{ $receivable->status_badge_class }}">
                                                {{ $receivable->formatted_status }}
                                            </span>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col" colspan="5">
                                            <div class="text-center py-4">
                                                <div class="text-muted">Belum ada piutang</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Due This Week -->
                    <div class="col-xxl-4">
                        <div class="card card-bordered h-100">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Jatuh Tempo Minggu Ini</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('receivables.outstanding') }}" class="link">Lihat Semua</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div class="nk-tb-list nk-tb-ov">
                                    @forelse($due_this_week as $receivable)
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $receivable->student->name }}</span>
                                                <span class="tb-sub">{{ $receivable->receivable_code }}</span>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col nk-tb-col-tools">
                                            <div class="amount-wrap">
                                                <span class="amount sm">Rp {{ number_format($receivable->outstanding_amount, 0, ',', '.') }}</span>
                                                <span class="currency currency-sm">{{ $receivable->due_date->format('d/m') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <div class="text-center py-4">
                                                <div class="text-muted">Tidak ada yang jatuh tempo</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse
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

@push('styles')
<style>
/* Modern Professional Dashboard */
.dashboard-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    margin: -1.5rem -1.5rem 1.5rem -1.5rem;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.page-header {
    margin: 0;
}

.page-title {
    font-size: 1.875rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.page-subtitle {
    color: #6b7280;
    font-size: 1rem;
    margin-bottom: 0;
}

.page-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid transparent;
    transition: all 0.2s ease;
}

.btn-primary {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.btn-primary:hover {
    background: #2563eb;
    color: white;
    transform: translateY(-1px);
}

.btn-outline-light {
    background: white;
    color: #6b7280;
    border-color: #d1d5db;
}

.btn-outline-light:hover {
    background: #f9fafb;
    color: #374151;
    border-color: #9ca3af;
}

/* Simple Statistics Cards */
.stat-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.2s ease;
    height: 100%;
}

.stat-card:hover {
    border-color: #d1d5db;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.stat-card-body {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-card-icon em {
    font-size: 20px;
    color: #6b7280;
}

.stat-card-info {
    flex: 1;
    min-width: 0;
}

.stat-card-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
    line-height: 1;
}

.stat-card-label {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0;
}

/* Clean Analytics Cards */
.analytics-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.2s ease;
}

.analytics-card:hover {
    border-color: #d1d5db;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.analytics-card .card-inner {
    padding: 1.5rem;
}

.card-title-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.card-title .title {
    color: #1f2937;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0;
}

.card-tools .btn {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

/* Chart Containers */
#paymentStatusChart, #performanceMetricsChart, #monthlyRevenueChart, 
#paymentMethodChart, #overdueAnalysisChart, #departmentChart {
    background: #fafafa;
    border-radius: 8px;
    padding: 1rem;
    margin: 0.5rem 0;
}

/* Legend Styling */
.analytics-legend {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #f3f4f6;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.legend-color {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

/* Table Styling */
.nk-tb-list {
    border-radius: 8px;
    overflow: hidden;
}

.nk-tb-item {
    border-bottom: 1px solid #f3f4f6;
}

.nk-tb-item:last-child {
    border-bottom: none;
}

.nk-tb-head {
    background: #f9fafb;
    font-weight: 600;
    color: #374151;
}

.nk-tb-col {
    padding: 0.75rem;
}

.sub-text {
    color: #6b7280;
    font-size: 0.875rem;
}

.fw-medium {
    font-weight: 500;
}

.tb-lead {
    color: #1f2937;
    font-weight: 500;
}

.tb-sub {
    color: #6b7280;
    font-size: 0.875rem;
}

.amount {
    font-weight: 600;
    color: #1f2937;
}

.badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.badge-dot::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

.badge-success {
    background: #dcfce7;
    color: #166534;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-info {
    background: #dbeafe;
    color: #1e40af;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-header {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .page-actions {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .stat-card-body {
        padding: 1rem;
    }
    
    .stat-card-value {
        font-size: 1.25rem;
    }
    
    .analytics-card .card-inner {
        padding: 1rem;
    }
}

/* Clean and minimal approach */
.container-fluid {
    max-width: 100%;
    padding: 0 1rem;
}

.text-center {
    text-align: center;
}

.text-muted {
    color: #6b7280;
}

.link {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
}

.link:hover {
    color: #2563eb;
    text-decoration: underline;
}

.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.h-100 {
    height: 100%;
}

.p-0 {
    padding: 0;
}

.user-info {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.amount-wrap {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.25rem;
}

.amount.sm {
    font-size: 0.875rem;
}

.currency-sm {
    font-size: 0.75rem;
    color: #6b7280;
}
</style>
@endpush

@push('scripts')
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
$(document).ready(function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Animate statistics cards on load
    $('.stat-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.2) + 's');
    });

    // Animate counters
    $('.stat-card-number').each(function() {
        const $this = $(this);
        const countTo = parseInt($this.text().replace(/[^0-9]/g, ''));
        if (countTo > 0) {
            $({ countNum: 0 }).animate({ countNum: countTo }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum).toLocaleString());
                },
                complete: function() {
                    $this.text(countTo.toLocaleString());
                }
            });
        }
    });

    // Animate progress bars
    $('.progress-bar').each(function() {
        const $this = $(this);
        if ($this.attr('style') && $this.attr('style').match(/width: ([0-9.]+)%/)) {
            const width = $this.attr('style').match(/width: ([0-9.]+)%/)[1];
            $this.css('width', '0%').animate({ width: width + '%' }, 1500);
        }
    });

    // Real-time updates simulation
    setInterval(function() {
        $('.dashboard-stats-mini .stat-item').each(function() {
            $(this).addClass('pulse');
            setTimeout(() => {
                $(this).removeClass('pulse');
            }, 500);
        });
    }, 30000);

    // Initialize Highcharts after DOM is ready
    if (typeof Highcharts !== 'undefined') {
        // Payment Status Chart
        Highcharts.chart('paymentStatusChart', {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                height: 200
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    innerSize: '60%',
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}: {point.percentage:.1f}%',
                        style: {
                            fontSize: '12px',
                            color: '#333'
                        }
                    }
                }
            },
            series: [{
                name: 'Payments',
                data: [
                    { name: 'Paid', y: {{ $stats['paid_count'] }}, color: '#10b981' },
                    { name: 'Pending', y: {{ $stats['pending_count'] }}, color: '#f59e0b' },
                    { name: 'Partial', y: {{ $stats['partial_count'] }}, color: '#06b6d4' },
                    { name: 'Overdue', y: {{ $stats['overdue_count'] }}, color: '#ef4444' }
                ]
            }]
        });

        // Performance Metrics Chart
        Highcharts.chart('performanceMetricsChart', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent',
                height: 200
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['Success Rate', 'Overdue Rate', 'Collection Rate'],
                labels: {
                    style: {
                        color: '#333'
                    }
                }
            },
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: 'Percentage (%)',
                    style: {
                        color: '#333'
                    }
                },
                labels: {
                    style: {
                        color: '#333'
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Performance',
                data: [
                    { y: {{ round(($stats['paid_count'] / max($stats['total_receivables'], 1)) * 100, 1) }}, color: '#10b981' },
                    { y: {{ round(($stats['overdue_count'] / max($stats['total_receivables'], 1)) * 100, 1) }}, color: '#f59e0b' },
                    { y: {{ round(($stats['total_paid'] / max($stats['total_amount'], 1)) * 100, 1) }}, color: '#06b6d4' }
                ]
            }]
        });

        // Monthly Revenue Trend
        Highcharts.chart('monthlyRevenueChart', {
            chart: {
                type: 'areaspline',
                backgroundColor: 'transparent',
                height: 300
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                labels: {
                    style: {
                        color: '#333'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Revenue (IDR)',
                    style: {
                        color: '#333'
                    }
                },
                labels: {
                    style: {
                        color: '#333'
                    },
                    formatter: function() {
                        return 'Rp ' + Highcharts.numberFormat(this.value, 0);
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Revenue',
                data: [2500000, 3200000, 2800000, 3500000, 4200000, 3800000, 4500000, 5200000, 4800000, 5500000, 6200000, 5800000],
                color: '#667eea',
                fillOpacity: 0.3
            }]
        });

        // Payment Method Chart
        Highcharts.chart('paymentMethodChart', {
            chart: {
                type: 'bar',
                backgroundColor: 'transparent',
                height: 300
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['Bank Transfer', 'Credit Card', 'Cash', 'E-Wallet', 'Virtual Account'],
                labels: {
                    style: {
                        color: '#333'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Number of Transactions',
                    style: {
                        color: '#333'
                    }
                },
                labels: {
                    style: {
                        color: '#333'
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Transactions',
                data: [
                    { y: 45, color: '#10b981' },
                    { y: 32, color: '#06b6d4' },
                    { y: 18, color: '#f59e0b' },
                    { y: 28, color: '#8b5cf6' },
                    { y: 22, color: '#ef4444' }
                ]
            }]
        });

        // Overdue Analysis Chart
        Highcharts.chart('overdueAnalysisChart', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent',
                height: 300
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['0-30 Days', '31-60 Days', '61-90 Days', '91-180 Days', '180+ Days'],
                labels: {
                    style: {
                        color: '#333'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Amount (IDR)',
                    style: {
                        color: '#333'
                    }
                },
                labels: {
                    style: {
                        color: '#333'
                    },
                    formatter: function() {
                        return 'Rp ' + Highcharts.numberFormat(this.value, 0);
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Overdue Amount',
                data: [
                    { y: 1200000, color: '#f59e0b' },
                    { y: 850000, color: '#f97316' },
                    { y: 620000, color: '#ef4444' },
                    { y: 380000, color: '#dc2626' },
                    { y: 150000, color: '#991b1b' }
                ]
            }]
        });

        // Department Chart
        Highcharts.chart('departmentChart', {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                height: 300
            },
            title: {
                text: null
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f}%',
                        style: {
                            fontSize: '12px',
                            color: '#333'
                        }
                    }
                }
            },
            series: [{
                name: 'Departments',
                data: [
                    { name: 'Teknik Informatika', y: 35, color: '#667eea' },
                    { name: 'Manajemen', y: 25, color: '#10b981' },
                    { name: 'Akuntansi', y: 20, color: '#06b6d4' },
                    { name: 'Hukum', y: 15, color: '#f59e0b' },
                    { name: 'Lainnya', y: 5, color: '#ef4444' }
                ]
            }]
        });
    }
});
</script>
@endpush
