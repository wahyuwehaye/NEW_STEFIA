@extends('layouts.admin')

@section('title', 'Sinkronisasi Piutang iGracias')

@section('content')
<x-page-header 
    title="Sinkronisasi Piutang iGracias" 
    subtitle="Kelola dan sinkronisasi data piutang dengan sistem iGracias">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="#" class="btn btn-white btn-outline-light" onclick="testConnection()"><em class="icon ni ni-activity"></em><span>Test Koneksi</span></a></li>
            <li><a href="{{ route('receivables.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Integration Status -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Status Koneksi" 
            value="Online" 
            change="99.9%" 
            changeType="up" 
            color="success"
            tooltip="Status koneksi dengan iGracias API" />
            
        <x-stats-card 
            title="Terakhir Sync" 
            value="{{ date('H:i') }}" 
            change="2 menit lalu" 
            changeType="up" 
            tooltip="Waktu sinkronisasi terakhir" />
            
        <x-stats-card 
            title="Total Piutang" 
            value="1,847" 
            change="100%" 
            changeType="up" 
            tooltip="Total data piutang yang tersinkron" />
            
        <x-stats-card 
            title="Pending Sync" 
            value="12" 
            change="0.6%" 
            changeType="down" 
            color="warning"
            tooltip="Data piutang yang menunggu sinkronisasi" />
    </div>
</div>

<!-- Integration Settings -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-lg-8">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Pengaturan Sinkronisasi</h6>
                        </div>
                        <div class="card-tools">
                            <a href="#" class="link" data-bs-toggle="modal" data-bs-target="#modalApiDoc">
                                <em class="icon ni ni-file-docs"></em>
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
                                        <input type="url" class="form-control" value="https://api.igracias.ac.id/v1/receivables" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">API Key</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" value="***********************" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">API Secret</label>
                                    <div class="form-control-wrap">
                                        <input type="password" class="form-control" value="***********************" readonly>
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
                                        <select class="form-control">
                                            <option value="disabled">Disabled</option>
                                            <option value="hourly">Setiap Jam</option>
                                            <option value="daily" selected>Setiap Hari</option>
                                            <option value="weekly">Setiap Minggu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="enableAutoSync" checked>
                                        <label class="custom-control-label" for="enableAutoSync">Enable Auto Sync</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="enableNotifications" checked>
                                        <label class="custom-control-label" for="enableNotifications">Enable Sync Notifications</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-save"></em>
                                        <span>Simpan Pengaturan</span>
                                    </button>
                                    <button type="button" class="btn btn-light" onclick="testConnection()">
                                        <em class="icon ni ni-activity"></em>
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
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Aksi Sinkronisasi</h6>
                        </div>
                    </div>
                    
                <div class="nk-block mb-4">
                        <div class="d-grid gap-3">
                            <button class="btn btn-primary mb-3" onclick="syncAllData()">
                                <em class="icon ni ni-sync"></em>
                                <span>Sync Semua Data</span>
                            </button>
                            <button class="btn btn-outline-primary mb-3" onclick="syncReceivables()">
                                <em class="icon ni ni-coin"></em>
                                <span>Sync Piutang Saja</span>
                            </button>
                            <button class="btn btn-outline-primary mb-3" onclick="syncPayments()">
                                <em class="icon ni ni-wallet"></em>
                                <span>Sync Pembayaran</span>
                            </button>
                            <button class="btn btn-outline-primary mb-3" onclick="syncPendingOnly()">
                                <em class="icon ni ni-clock"></em>
                                <span>Sync Pending Saja</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="alert alert-pro alert-info mt-4">
                            <div class="alert-text">
                                <h6>Informasi Sinkronisasi</h6>
                                <p class="mt-2">Sinkronisasi otomatis berjalan setiap hari pada pukul 03:00 WIB. Data piutang akan disesuaikan dengan sistem iGracias.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sync History -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Riwayat Sinkronisasi Piutang</h6>
                </div>
                <div class="card-tools">
                    <ul class="card-tools-nav">
                        <li><a href="#"><span>Lihat Semua</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-inner p-0">
            <div class="nk-tb-list">
                <div class="nk-tb-item nk-tb-head">
                    <div class="nk-tb-col"><span>Waktu</span></div>
                    <div class="nk-tb-col"><span>Type</span></div>
                    <div class="nk-tb-col"><span>Status</span></div>
                    <div class="nk-tb-col"><span>Records</span></div>
                    <div class="nk-tb-col"><span>Berhasil</span></div>
                    <div class="nk-tb-col"><span>Gagal</span></div>
                    <div class="nk-tb-col"><span>Durasi</span></div>
                    <div class="nk-tb-col nk-tb-col-tools"><span>&nbsp;</span></div>
                </div>
                
                <!-- Sample Data -->
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ date('d M Y H:i') }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <em class="icon ni ni-sync text-primary"></em>
                            Full Sync
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Success</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">1,847</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">1,835</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-danger">12</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">3m 45s</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Log">
                                    <em class="icon ni ni-download"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Retry Failed">
                                    <em class="icon ni ni-reload"></em>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ date('d M Y H:i', strtotime('-2 hours')) }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <em class="icon ni ni-coin text-info"></em>
                            Receivables Only
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-warning">Partial</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">1,847</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">1,820</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-danger">27</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">2m 15s</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Log">
                                    <em class="icon ni ni-download"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Retry Failed">
                                    <em class="icon ni ni-reload"></em>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ date('d M Y H:i', strtotime('-4 hours')) }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <em class="icon ni ni-wallet text-success"></em>
                            Payments Only
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Success</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">298</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">298</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">0</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">1m 20s</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Log">
                                    <em class="icon ni ni-download"></em>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- API Documentation Modal -->
<div class="modal fade" id="modalApiDoc" tabindex="-1" aria-labelledby="modalApiDocLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalApiDocLabel">iGracias Receivables API Documentation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="nk-block">
                    <h6>Available Endpoints:</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Method</th>
                                    <th>Endpoint</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge badge-primary">GET</span></td>
                                    <td><code>/receivables</code></td>
                                    <td>Retrieve all receivables</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">GET</span></td>
                                    <td><code>/receivables/{id}</code></td>
                                    <td>Retrieve specific receivable</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-success">POST</span></td>
                                    <td><code>/receivables</code></td>
                                    <td>Create new receivable</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-warning">PUT</span></td>
                                    <td><code>/receivables/{id}</code></td>
                                    <td>Update receivable</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">GET</span></td>
                                    <td><code>/payments</code></td>
                                    <td>Retrieve all payments</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">GET</span></td>
                                    <td><code>/payments/receivable/{id}</code></td>
                                    <td>Retrieve payments for specific receivable</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="nk-block">
                    <h6>Authentication:</h6>
                    <p>All requests must include the following headers:</p>
                    <pre><code>Authorization: Bearer {api_key}
X-API-Secret: {api_secret}</code></pre>
                </div>
                
                <div class="nk-block">
                    <h6>Rate Limiting:</h6>
                    <p>API requests are limited to 1000 requests per hour per API key.</p>
                </div>
                
                <div class="nk-block">
                    <h6>Sync Schedule:</h6>
                    <p>Automatic synchronization runs daily at 03:00 WIB. Manual sync can be triggered anytime.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Auto-refresh sync history every 30 seconds
    setInterval(function() {
        // You can add AJAX call here to refresh sync history
        console.log('Refreshing sync history...');
    }, 30000);
    
    // Form submission handling
    $('form').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading
        const btn = $(this).find('button[type="submit"]');
        const originalText = btn.html();
        btn.html('<em class="icon ni ni-loader"></em><span>Menyimpan...</span>');
        btn.prop('disabled', true);
        
        // Simulate form submission
        setTimeout(function() {
            btn.html(originalText);
            btn.prop('disabled', false);
            
            // Show success message
            if (typeof NioApp !== 'undefined') {
                NioApp.Toast('Pengaturan berhasil disimpan!', 'success', {
                    position: 'top-right',
                    ui: 'is-dark'
                });
            } else {
                toastr.success('Pengaturan berhasil disimpan!');
            }
        }, 2000);
    });
});

function testConnection() {
    // Show loading state
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<em class="icon ni ni-loader"></em><span>Testing...</span>';
    btn.disabled = true;
    
    // Simulate API call
    setTimeout(function() {
        btn.innerHTML = originalText;
        btn.disabled = false;
        
        // Show success message
        if (typeof NioApp !== 'undefined') {
            NioApp.Toast('Koneksi berhasil!', 'success', {
                position: 'top-right',
                ui: 'is-dark'
            });
        } else {
            toastr.success('Koneksi berhasil!');
        }
    }, 2000);
}

function syncAllData() {
    if (confirm('Apakah Anda yakin ingin melakukan sinkronisasi semua data? Proses ini mungkin memakan waktu beberapa menit.')) {
        // Show loading state
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<em class="icon ni ni-loader"></em><span>Syncing...</span>';
        btn.disabled = true;
        
        // Simulate sync process
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            // Show success message
            if (typeof NioApp !== 'undefined') {
                NioApp.Toast('Sinkronisasi lengkap berhasil!', 'success', {
                    position: 'top-right',
                    ui: 'is-dark'
                });
            } else {
                toastr.success('Sinkronisasi lengkap berhasil!');
            }
            
            // Refresh page or update UI
            location.reload();
        }, 5000);
    }
}

function syncReceivables() {
    if (confirm('Sinkronisasi data piutang dari iGracias?')) {
        // Show loading state
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<em class="icon ni ni-loader"></em><span>Syncing...</span>';
        btn.disabled = true;
        
        // Simulate sync process
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            // Show success message
            if (typeof NioApp !== 'undefined') {
                NioApp.Toast('Sinkronisasi piutang selesai!', 'success', {
                    position: 'top-right',
                    ui: 'is-dark'
                });
            } else {
                toastr.success('Sinkronisasi piutang selesai!');
            }
        }, 3000);
    }
}

function syncPayments() {
    if (confirm('Sinkronisasi data pembayaran dari iGracias?')) {
        // Show loading state
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<em class="icon ni ni-loader"></em><span>Syncing...</span>';
        btn.disabled = true;
        
        // Simulate sync process
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            // Show success message
            if (typeof NioApp !== 'undefined') {
                NioApp.Toast('Sinkronisasi pembayaran selesai!', 'success', {
                    position: 'top-right',
                    ui: 'is-dark'
                });
            } else {
                toastr.success('Sinkronisasi pembayaran selesai!');
            }
        }, 2000);
    }
}

function syncPendingOnly() {
    if (confirm('Sinkronisasi data pending dari iGracias?')) {
        // Show loading state
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<em class="icon ni ni-loader"></em><span>Syncing...</span>';
        btn.disabled = true;
        
        // Simulate sync process
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            // Show success message
            if (typeof NioApp !== 'undefined') {
                NioApp.Toast('Sinkronisasi pending selesai!', 'success', {
                    position: 'top-right',
                    ui: 'is-dark'
                });
            } else {
                toastr.success('Sinkronisasi pending selesai!');
            }
        }, 2000);
    }
}
</script>
@endpush
