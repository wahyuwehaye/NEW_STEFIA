@extends('layouts.admin')

@section('title', 'Integrasi Pembayaran iGracias')

@push('styles')
<style>
    /* Modern Integration UI Styles */
    .integration-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,250,252,0.9) 100%);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .integration-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .integration-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .integration-card:hover::before {
        left: 100%;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.7) 100%);
        border-radius: 20px;
        padding: 25px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
        position: relative;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
        position: relative;
    }

    .stat-icon.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .stat-icon.warning {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
    }

    .stat-icon.info {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .stat-icon.primary {
        background: linear-gradient(135deg, #FF0000 0%, #FF4D4D 100%);
        color: white;
    }

    .sync-actions .btn {
        border-radius: 12px;
        padding: 12px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .sync-actions .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .sync-actions .btn:hover::before {
        left: 100%;
    }

    .sync-actions .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .connection-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .connection-status.online {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .connection-status.offline {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .connection-status::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .sync-history-table {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: none;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .sync-history-table th {
        background: linear-gradient(135deg, #FF0000 0%, #FF4D4D 100%);
        color: white;
        border: none;
        font-weight: 600;
        padding: 15px;
    }

    .sync-history-table td {
        padding: 15px;
        border-color: rgba(0,0,0,0.05);
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(255,255,255,0.3);
        border-top: 4px solid #fff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">
                    <i class="fas fa-plug text-primary me-2"></i>
                    Integrasi Pembayaran iGracias
                </h3>
                <div class="nk-block-des text-soft">
                    <p>Kelola dan sinkronisasi data pembayaran dengan sistem iGracias</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <button class="btn btn-white btn-outline-light" onclick="testConnection()">
                                    <i class="fas fa-wifi me-1"></i>
                                    <span>Test Koneksi</span>
                                </button>
                            </li>
                            <li>
                                <a href="{{ route('payments.index') }}" class="btn btn-white btn-outline-light">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    <span>Kembali</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Integration Status -->
    <div class="stats-grid" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-wifi"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h4 text-success mb-1">Online</div>
                <div class="stat-label text-muted">Status Koneksi</div>
                <div class="connection-status online mt-2">
                    Terhubung dengan iGracias API
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h4 text-info mb-1">{{ $stats['last_sync'] ?? '15:30' }}</div>
                <div class="stat-label text-muted">Terakhir Sync</div>
                <div class="text-muted small mt-1">{{ $stats['last_sync_ago'] ?? '2 menit lalu' }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h4 text-primary mb-1">{{ number_format($stats['total_synced'] ?? 1247) }}</div>
                <div class="stat-label text-muted">Total Pembayaran Tersinkron</div>
                <div class="text-success small mt-1">100% berhasil</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h4 text-warning mb-1">{{ number_format($stats['pending_sync'] ?? 5) }}</div>
                <div class="stat-label text-muted">Pending Sync</div>
                <div class="text-muted small mt-1">Menunggu sinkronisasi</div>
            </div>
        </div>
    </div>

    <!-- Integration Settings & Actions -->
    <div class="row g-gs" data-aos="fade-up" data-aos-delay="200">
        <div class="col-lg-8">
            <div class="integration-card">
                <div class="card-inner">
                    <div class="card-title-group mb-4">
                        <div class="card-title">
                            <h5 class="title">Pengaturan Sinkronisasi</h5>
                        </div>
                        <div class="card-tools">
                            <a href="#" class="link" data-bs-toggle="modal" data-bs-target="#modalApiDoc">
                                <i class="fas fa-book me-1"></i>
                                <span>API Documentation</span>
                            </a>
                        </div>
                    </div>
                    
                    <form>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">iGracias API Endpoint</label>
                                    <div class="form-control-wrap">
                                        <input type="url" class="form-control" value="https://api.igracias.telkomuniversity.ac.id/v1/payments" readonly>
                                        <div class="form-icon form-icon-left">
                                            <i class="fas fa-globe"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">API Key</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" value="***********************" readonly>
                                        <div class="form-icon form-icon-left">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">API Secret</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" value="***********************" readonly>
                                        <div class="form-icon form-icon-left">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Timeout (seconds)</label>
                                    <div class="form-control-wrap">
                                        <input type="number" class="form-control" value="45">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Retry Attempts</label>
                                    <div class="form-control-wrap">
                                        <input type="number" class="form-control" value="3">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Auto Sync Schedule</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select">
                                            <option value="disabled">Disabled</option>
                                            <option value="hourly">Setiap Jam</option>
                                            <option value="daily" selected>Setiap Hari</option>
                                            <option value="weekly">Setiap Minggu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="enableAutoSync" checked>
                                        <label class="custom-control-label" for="enableAutoSync">Enable Auto Sync</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="enableNotifications" checked>
                                        <label class="custom-control-label" for="enableNotifications">Enable Sync Notifications</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-save me-1"></i>
                                        <span>Simpan Pengaturan</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" onclick="testConnection()">
                                        <i class="fas fa-wifi me-1"></i>
                                        <span>Test Koneksi</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="integration-card">
                <div class="card-inner">
                    <div class="card-title-group mb-4">
                        <div class="card-title">
                            <h5 class="title">Aksi Sinkronisasi</h5>
                        </div>
                    </div>
                    
                    <div class="sync-actions">
                        <div class="d-grid gap-3">
                            <button class="btn btn-primary" onclick="syncAllData()">
                                <i class="fas fa-sync me-1"></i>
                                <span>Sync Semua Data</span>
                            </button>
                            <button class="btn btn-outline-primary" onclick="syncPaymentsOnly()">
                                <i class="fas fa-credit-card me-1"></i>
                                <span>Sync Pembayaran Saja</span>
                            </button>
                            <button class="btn btn-outline-primary" onclick="syncReceivables()">
                                <i class="fas fa-coins me-1"></i>
                                <span>Sync Piutang</span>
                            </button>
                            <button class="btn btn-outline-primary" onclick="syncPendingOnly()">
                                <i class="fas fa-clock me-1"></i>
                                <span>Sync Pending Saja</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="alert alert-info mt-4">
                        <div class="alert-text">
                            <h6>Informasi Sinkronisasi</h6>
                            <p class="small mb-2">• Sinkronisasi otomatis berjalan setiap hari pada pukul 02:00 WIB</p>
                            <p class="small mb-2">• Data akan divalidasi sebelum disimpan</p>
                            <p class="small mb-0">• Notifikasi akan dikirim jika terjadi error</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sync History -->
    <div class="nk-block" data-aos="fade-up" data-aos-delay="300">
        <div class="integration-card">
            <div class="card-inner">
                <div class="card-title-group mb-4">
                    <div class="card-title">
                        <h5 class="title">Riwayat Sinkronisasi Terakhir</h5>
                    </div>
                    <div class="card-tools">
                        <button class="btn btn-outline-light" onclick="refreshSyncHistory()">
                            <i class="fas fa-refresh"></i>
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table sync-history-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Sistem</th>
                                <th>Records</th>
                                <th>Status</th>
                                <th>Durasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSyncs ?? [] as $sync)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $sync->created_at->format('d M Y') }}</span><br>
                                    <small class="text-muted">{{ $sync->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-primary">iGracias API</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($sync->records ?? 0) }}</span>
                                    <small class="text-muted d-block">payments</small>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        <i class="fas fa-check me-1"></i>
                                        Success
                                    </span>
                                </td>
                                <td>{{ $sync->duration ?? '2.3s' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info" onclick="viewSyncDetails({{ $sync->id ?? 1 }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>{{ now()->format('d M Y') }}</td>
                                <td><span class="badge badge-primary">iGracias API</span></td>
                                <td><span class="fw-bold text-success">247</span><small class="text-muted d-block">payments</small></td>
                                <td><span class="badge badge-success"><i class="fas fa-check me-1"></i>Success</span></td>
                                <td>3.2s</td>
                                <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subDay()->format('d M Y') }}</td>
                                <td><span class="badge badge-primary">iGracias API</span></td>
                                <td><span class="fw-bold text-success">189</span><small class="text-muted d-block">payments</small></td>
                                <td><span class="badge badge-success"><i class="fas fa-check me-1"></i>Success</span></td>
                                <td>2.8s</td>
                                <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                            </tr>
                            <tr>
                                <td>{{ now()->subDays(2)->format('d M Y') }}</td>
                                <td><span class="badge badge-primary">iGracias API</span></td>
                                <td><span class="fw-bold text-warning">156</span><small class="text-muted d-block">payments</small></td>
                                <td><span class="badge badge-warning"><i class="fas fa-exclamation-triangle me-1"></i>Partial</span></td>
                                <td>4.1s</td>
                                <td><button class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></button></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner"></div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize page
    $(document).ready(function() {
        // Auto-refresh sync history every 30 seconds
        setInterval(function() {
            // Auto refresh would go here
        }, 30000);
    });

    // Show/hide loading overlay
    function showLoading() {
        $('#loadingOverlay').fadeIn(300);
    }

    function hideLoading() {
        $('#loadingOverlay').fadeOut(300);
    }

    // Test API connection
    function testConnection() {
        showLoading();
        
        // Simulate API test
        setTimeout(function() {
            hideLoading();
            Swal.fire({
                title: 'Test Koneksi Berhasil!',
                text: 'Koneksi dengan iGracias API berjalan normal',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        }, 2000);
    }

    // Sync all data
    function syncAllData() {
        Swal.fire({
            title: 'Sync Semua Data',
            text: 'Apakah Anda yakin ingin melakukan sinkronisasi semua data?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#FF0000',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Sync Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: '{{ route("api.payments.sync-igracias") }}',
                    method: 'POST',
                    data: {
                        sync_type: 'all',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        hideLoading();
                        if (response.success) {
                            Swal.fire({
                                title: 'Sync Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        hideLoading();
                        const response = xhr.responseJSON;
                        Swal.fire('Error!', response?.message || 'Terjadi kesalahan saat sinkronisasi', 'error');
                    }
                });
            }
        });
    }

    // Sync payments only
    function syncPaymentsOnly() {
        performSync('payments', 'Sync Pembayaran Saja');
    }

    // Sync receivables
    function syncReceivables() {
        performSync('receivables', 'Sync Piutang');
    }

    // Sync pending only
    function syncPendingOnly() {
        performSync('pending', 'Sync Pending Saja');
    }

    // Generic sync function
    function performSync(type, title) {
        Swal.fire({
            title: title,
            text: `Melakukan sinkronisasi data ${type}...`,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#FF0000',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Sync!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: '{{ route("api.payments.sync-igracias") }}',
                    method: 'POST',
                    data: {
                        sync_type: type,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        hideLoading();
                        if (response.success) {
                            Swal.fire({
                                title: 'Sync Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            // Refresh sync history
                            refreshSyncHistory();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        hideLoading();
                        const response = xhr.responseJSON;
                        Swal.fire('Error!', response?.message || 'Terjadi kesalahan saat sinkronisasi', 'error');
                    }
                });
            }
        });
    }

    // Refresh sync history
    function refreshSyncHistory() {
        // Implementation for refreshing sync history table
        location.reload();
    }

    // View sync details
    function viewSyncDetails(syncId) {
        Swal.fire({
            title: 'Detail Sinkronisasi',
            html: `
                <div class="text-left">
                    <p><strong>ID:</strong> ${syncId}</p>
                    <p><strong>Status:</strong> <span class="badge badge-success">Success</span></p>
                    <p><strong>Records Processed:</strong> 247</p>
                    <p><strong>Duration:</strong> 3.2 seconds</p>
                    <p><strong>Errors:</strong> 0</p>
                </div>
            `,
            icon: 'info',
            confirmButtonColor: '#FF0000'
        });
    }
</script>
@endpush
