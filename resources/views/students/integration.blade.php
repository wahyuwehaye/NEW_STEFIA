@extends('layouts.admin')

@section('title', 'Integrasi iGracias')

@section('content')
<x-page-header 
    title="Integrasi iGracias" 
    subtitle="Sinkronisasi data dengan sistem iGracias">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="#" class="btn btn-white btn-outline-light" onclick="testConnection()"><em class="icon ni ni-activity"></em><span>Test Koneksi</span></a></li>
            <li><a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Integration Status -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Status Koneksi" 
            value="Online" 
            change="99.8%" 
            changeType="up" 
            color="success"
            tooltip="Status koneksi dengan iGracias" />
            
        <x-stats-card 
            title="Terakhir Sync" 
            value="{{ date('H:i') }}" 
            change="5 menit lalu" 
            changeType="up" 
            tooltip="Waktu sinkronisasi terakhir" />
            
        <x-stats-card 
            title="Data Tersinkron" 
            value="1,245" 
            change="100%" 
            changeType="up" 
            tooltip="Jumlah data mahasiswa yang tersinkron" />
            
        <x-stats-card 
            title="Pending Sync" 
            value="3" 
            change="0.2%" 
            changeType="down" 
            color="warning"
            tooltip="Data yang menunggu sinkronisasi" />
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
                            <h6 class="title">Pengaturan Integrasi</h6>
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
                                        <input type="url" class="form-control" value="https://api.igracias.ac.id/v1" readonly>
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
                                        <input type="number" class="form-control" value="30">
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
                            <h6 class="title">Sync Actions</h6>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" onclick="syncAllData()">
                                <em class="icon ni ni-sync"></em>
                                <span>Sync All Data</span>
                            </button>
                            <button class="btn btn-outline-primary" onclick="syncStudents()">
                                <em class="icon ni ni-users"></em>
                                <span>Sync Students Only</span>
                            </button>
                            <button class="btn btn-outline-primary" onclick="syncPayments()">
                                <em class="icon ni ni-wallet"></em>
                                <span>Sync Payments Only</span>
                            </button>
                            <button class="btn btn-outline-primary" onclick="syncReceivables()">
                                <em class="icon ni ni-coin"></em>
                                <span>Sync Receivables Only</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="alert alert-pro alert-info">
                            <div class="alert-text">
                                <h6>Informasi Sync</h6>
                                <p>Sync otomatis berjalan setiap hari pada pukul 02:00 WIB. Anda dapat melakukan sync manual kapan saja.</p>
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
                    <h6 class="title">Riwayat Sinkronisasi</h6>
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
                        <span class="tb-sub">1,245</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">1,242</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-danger">3</span>
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
                        <span class="tb-lead">{{ date('d M Y H:i', strtotime('-1 hour')) }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">
                            <em class="icon ni ni-users text-info"></em>
                            Students Only
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-warning">Partial</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">1,245</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">1,200</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-danger">45</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">1m 45s</span>
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
                            <em class="icon ni ni-wallet text-success"></em>
                            Payments Only
                        </span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Success</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">156</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">156</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">0</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">45s</span>
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
                <h5 class="modal-title" id="modalApiDocLabel">iGracias API Documentation</h5>
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
                                    <td><code>/students</code></td>
                                    <td>Retrieve all students</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">GET</span></td>
                                    <td><code>/students/{id}</code></td>
                                    <td>Retrieve specific student</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-success">POST</span></td>
                                    <td><code>/students</code></td>
                                    <td>Create new student</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-warning">PUT</span></td>
                                    <td><code>/students/{id}</code></td>
                                    <td>Update student</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">GET</span></td>
                                    <td><code>/payments</code></td>
                                    <td>Retrieve all payments</td>
                                </tr>
                                <tr>
                                    <td><span class="badge badge-primary">GET</span></td>
                                    <td><code>/receivables</code></td>
                                    <td>Retrieve all receivables</td>
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
                    <p>API requests are limited to 100 requests per minute per API key.</p>
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
        NioApp.Toast('Connection test successful!', 'success', {
            position: 'top-right',
            ui: 'is-dark'
        });
    }, 2000);
}

function syncAllData() {
    if (confirm('Are you sure you want to sync all data? This may take several minutes.')) {
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
            NioApp.Toast('Full sync completed successfully!', 'success', {
                position: 'top-right',
                ui: 'is-dark'
            });
            
            // Refresh page or update UI
            location.reload();
        }, 5000);
    }
}

function syncStudents() {
    if (confirm('Sync student data from iGracias?')) {
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
            NioApp.Toast('Student sync completed!', 'success', {
                position: 'top-right',
                ui: 'is-dark'
            });
        }, 3000);
    }
}

function syncPayments() {
    if (confirm('Sync payment data from iGracias?')) {
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
            NioApp.Toast('Payment sync completed!', 'success', {
                position: 'top-right',
                ui: 'is-dark'
            });
        }, 2000);
    }
}

function syncReceivables() {
    if (confirm('Sync receivables data from iGracias?')) {
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
            NioApp.Toast('Receivables sync completed!', 'success', {
                position: 'top-right',
                ui: 'is-dark'
            });
        }, 2000);
    }
}
</script>
@endpush
