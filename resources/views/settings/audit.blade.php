@extends('layouts.admin')
@section('title', 'Audit Log & Riwayat Aktivitas')
@section('content')
<x-page-header title="Audit Log & Riwayat Aktivitas" subtitle="Pantau seluruh aktivitas penting di sistem.">
</x-page-header>
<div class="nk-block">
    <div class="card">
        <div class="card-inner">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0">Audit Log</h6>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2" id="searchAudit" placeholder="Cari user/aksi/resource..." onkeyup="filterLogs()" style="width:200px;">
                    <input type="date" class="form-control me-2" id="filterDate" onchange="filterLogs()" style="width:auto;display:inline-block;">
                    <select class="form-select me-2" id="filterUser" onchange="filterLogs()" style="width:auto;display:inline-block;">
                        <option value="">Semua User</option>
                        <option value="Super Admin">Super Admin</option>
                        <option value="Admin Keuangan">Admin Keuangan</option>
                        <option value="Finance Staff">Finance Staff</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                    </select>
                    <select class="form-select me-2" id="filterAction" onchange="filterLogs()" style="width:auto;display:inline-block;">
                        <option value="">Semua Aksi</option>
                        <option value="login">Login</option>
                        <option value="update">Update</option>
                        <option value="create">Create</option>
                        <option value="delete">Delete</option>
                        <option value="export">Export</option>
                        <option value="backup">Backup</option>
                        <option value="restore">Restore</option>
                    </select>
                    <button class="btn btn-secondary" onclick="resetAuditFilter()">Reset</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="auditTable">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Resource</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $logs = $logs ?? [
                            [
                                'waktu' => '2025-01-12 09:15:00',
                                'user' => 'Super Admin',
                                'aksi' => 'login',
                                'resource' => 'user',
                                'detail' => 'Login berhasil dari IP 192.168.1.10',
                            ],
                            [
                                'waktu' => '2025-01-12 09:20:00',
                                'user' => 'Admin Keuangan',
                                'aksi' => 'update',
                                'resource' => 'settings',
                                'detail' => 'Ubah email pengirim menjadi finance@stefia.ac.id',
                            ],
                            [
                                'waktu' => '2025-01-12 09:30:00',
                                'user' => 'Finance Staff',
                                'aksi' => 'export',
                                'resource' => 'report',
                                'detail' => 'Export laporan piutang ke Excel',
                            ],
                            [
                                'waktu' => '2025-01-12 09:40:00',
                                'user' => 'Super Admin',
                                'aksi' => 'backup',
                                'resource' => 'database',
                                'detail' => 'Backup manual berhasil',
                            ],
                            [
                                'waktu' => '2025-01-12 09:45:00',
                                'user' => 'Mahasiswa',
                                'aksi' => 'login',
                                'resource' => 'user',
                                'detail' => 'Login gagal (password salah)',
                            ],
                        ];
                        @endphp
                        @foreach($logs as $log)
                        <tr data-user="{{ $log['user'] }}" data-aksi="{{ $log['aksi'] }}" data-date="{{ substr($log['waktu'],0,10) }}">
                            <td>{{ $log['waktu'] }}</td>
                            <td>{{ $log['user'] }}</td>
                            <td><span class="badge bg-outline-{{ $log['aksi'] == 'login' ? 'info' : ($log['aksi'] == 'update' ? 'primary' : ($log['aksi'] == 'create' ? 'success' : ($log['aksi'] == 'delete' ? 'danger' : ($log['aksi'] == 'export' ? 'warning' : ($log['aksi'] == 'backup' ? 'secondary' : 'dark'))))) }}">{{ ucfirst($log['aksi']) }}</span></td>
                            <td>{{ ucfirst($log['resource']) }}</td>
                            <td>{{ $log['detail'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function filterLogs() {
    const user = document.getElementById('filterUser').value;
    const aksi = document.getElementById('filterAction').value;
    const date = document.getElementById('filterDate').value;
    const search = document.getElementById('searchAudit').value.toLowerCase();
    document.querySelectorAll('#auditTable tbody tr').forEach(row => {
        const rowUser = row.getAttribute('data-user');
        const rowAksi = row.getAttribute('data-aksi');
        const rowDate = row.getAttribute('data-date');
        const rowText = row.innerText.toLowerCase();
        let show = true;
        if (user && rowUser !== user) show = false;
        if (aksi && rowAksi !== aksi) show = false;
        if (date && rowDate !== date) show = false;
        if (search && !rowText.includes(search)) show = false;
        row.style.display = show ? '' : 'none';
    });
}
function resetAuditFilter() {
    document.getElementById('filterUser').value = '';
    document.getElementById('filterAction').value = '';
    document.getElementById('filterDate').value = '';
    document.getElementById('searchAudit').value = '';
    filterLogs();
}
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
/* Responsive filter bar */
.filter-section, .action-buttons, .d-flex.align-items-center {
    flex-wrap: wrap;
    gap: 0.5rem;
}
@media (max-width: 600px) {
    .filter-section, .action-buttons, .d-flex.align-items-center {
        flex-direction: column;
        align-items: stretch;
    }
    .table-responsive {
        overflow-x: auto;
    }
}
/* Konsistensi badge */
.badge, .badge-status, .badge-role-table {
    font-size: 0.92rem;
    border-radius: 8px;
    padding: 0.32rem 1.1rem;
    font-weight: 600;
    letter-spacing: 1px;
}
/* Animasi hover tabel */
.table-hover tbody tr:hover, .nk-tb-list .nk-tb-item:hover {
    background: #f43f5e0d !important;
    transition: background 0.2s;
    cursor: pointer;
}
/* Animasi tombol */
.btn, .form-select, .form-control {
    transition: box-shadow 0.2s, background 0.2s, color 0.2s;
}
.btn:hover, .form-select:focus, .form-control:focus {
    box-shadow: 0 2px 8px rgba(225,29,72,0.08);
}
/* Padding tabel mobile */
@media (max-width: 600px) {
    .table, .table th, .table td {
        padding: 0.5rem !important;
        font-size: 0.95rem;
    }
}
.toast-container { pointer-events: none; }
.toast { pointer-events: auto; min-width: 260px; }
</style>
@endpush
@endsection 