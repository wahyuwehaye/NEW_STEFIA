@extends('layouts.admin')
@section('title', 'Backup & Restore')
@section('content')
<x-page-header title="Backup & Restore" subtitle="Kelola backup otomatis, manual, dan recovery data.">
    <x-slot name="actions">
        <a href="{{ route('settings.general') }}" class="btn btn-light btn-modern"><em class="icon ni ni-arrow-left"></em> Kembali</a>
    </x-slot>
</x-page-header>

<!-- Summary Cards -->
<div class="nk-block">
  <div class="row g-gs">
    <div class="col-xxl-3 col-md-6">
      <div class="card card-bordered h-100">
        <div class="card-inner">
          <h6 class="subtitle">Backup Otomatis</h6>
          <div class="mb-1"><em class="icon ni ni-clock"></em> <span class="text-muted">Jadwal:</span> <span class="text-primary">{{ ucfirst($backups['automatic']['frequency']) }} - {{ $backups['automatic']['time'] }}</span></div>
          <div class="mb-1"><em class="icon ni ni-save"></em> <span class="text-muted">Retensi:</span> <span class="text-primary">{{ $backups['automatic']['retention_days'] }} hari</span></div>
          <div class="mb-1"><em class="icon ni ni-database"></em> <span class="text-muted">Backup Terakhir:</span> <span class="text-primary">{{ $backups['automatic']['last_backup'] }}</span></div>
          <div class="mb-1"><em class="icon ni ni-pie"></em> <span class="text-muted">Ukuran:</span> <span class="text-primary">{{ $backups['automatic']['backup_size'] }}</span></div>
          <span class="badge badge-status {{ $backups['automatic']['enabled'] ? 'badge-active' : 'badge-inactive' }}">{{ $backups['automatic']['enabled'] ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
      </div>
    </div>
    <div class="col-xxl-3 col-md-6">
      <div class="card card-bordered h-100">
        <div class="card-inner">
          <h6 class="subtitle">Storage</h6>
          <div class="mb-1"><em class="icon ni ni-database"></em> <span class="text-muted">Total:</span> <span class="text-primary">{{ $backups['storage']['total_space'] }}</span></div>
          <div class="mb-1"><em class="icon ni ni-pie"></em> <span class="text-muted">Terpakai:</span> <span class="text-primary">{{ $backups['storage']['used_space'] }}</span></div>
          <div class="mb-1"><em class="icon ni ni-pie"></em> <span class="text-muted">Tersedia:</span> <span class="text-primary">{{ $backups['storage']['available_space'] }}</span></div>
          <div class="mb-1"><em class="icon ni ni-folder"></em> <span class="text-muted">Lokasi:</span> <span class="text-primary">{{ $backups['storage']['backup_location'] }}</span></div>
          <div class="mt-2">
            <strong>Cloud Backup:</strong>
            <div class="small mt-1">
              <em class="icon ni ni-cloud"></em> <span class="text-muted">Provider:</span> <span class="text-primary">{{ $backups['storage']['cloud_backup']['provider'] }}</span><br>
              <em class="icon ni ni-upload-cloud"></em> <span class="text-muted">Last Upload:</span> <span class="text-primary">{{ $backups['storage']['cloud_backup']['last_upload'] }}</span>
            </div>
            <span class="badge badge-status {{ $backups['storage']['cloud_backup']['enabled'] ? 'badge-active' : 'badge-inactive' }}">{{ $backups['storage']['cloud_backup']['enabled'] ? 'Aktif' : 'Nonaktif' }}</span>
          </div>
        </div>
      </div>
    </div>
    <!-- Tambahkan 2 card kosong agar grid tetap 4 kolom -->
    <div class="col-xxl-3 col-md-6"></div>
    <div class="col-xxl-3 col-md-6"></div>
  </div>
</div>

<!-- Tabel Backup -->
<div class="nk-block">
  <div class="card card-bordered">
    <div class="card-inner">
      <div class="card-title-group">
        <div class="card-title">
          <h6 class="title">Daftar Backup Terakhir</h6>
        </div>
        <div class="card-tools">
          <ul class="card-tools-nav">
            <li><button class="btn btn-primary" onclick="backupNow()"><em class="icon ni ni-save"></em><span>Backup Sekarang</span></button></li>
            <li><button class="btn btn-info" onclick="restoreBackupPrompt()"><em class="icon ni ni-upload-cloud"></em><span>Restore</span></button></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="card-inner p-0">
      <div class="nk-tb-list">
        <div class="nk-tb-item nk-tb-head">
          <div class="nk-tb-col"><span>Nama File</span></div>
          <div class="nk-tb-col"><span>Ukuran</span></div>
          <div class="nk-tb-col"><span>Jenis</span></div>
          <div class="nk-tb-col"><span>Tanggal</span></div>
          <div class="nk-tb-col"><span>Status</span></div>
          <div class="nk-tb-col"><span>Aksi</span></div>
        </div>
        @foreach($backups['recent_backups'] as $backup)
        <div class="nk-tb-item">
          <div class="nk-tb-col"><em class="icon ni ni-save"></em> {{ $backup['filename'] }}</div>
          <div class="nk-tb-col">{{ $backup['size'] }}</div>
          <div class="nk-tb-col"><span class="badge badge-role-table">{{ ucfirst($backup['type']) }}</span></div>
          <div class="nk-tb-col">{{ $backup['created_at'] }}</div>
          <div class="nk-tb-col"><span class="badge badge-status {{ $backup['status'] === 'completed' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($backup['status']) }}</span></div>
          <div class="nk-tb-col">
            <div class="drodown">
              <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
              <div class="dropdown-menu dropdown-menu-end">
                <ul class="link-list-opt no-bdr">
                  <li><a href="#" onclick="downloadBackup('{{ $backup['filename'] }}')"><em class="icon ni ni-download"></em><span>Download</span></a></li>
                  <li><a href="#" onclick="restoreBackupPrompt('{{ $backup['filename'] }}')"><em class="icon ni ni-upload-cloud"></em><span>Restore</span></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function backupNow() {
    if(confirm('Lakukan backup sekarang?')) {
        showToast('Backup dimulai... (dummy, implementasi endpoint backup diperlukan)', 'success');
        // TODO: AJAX call ke endpoint backup
    }
}
function restoreBackupPrompt(filename) {
    let msg = filename ? `Restore backup ${filename}? Semua data saat ini akan diganti!` : 'Pilih backup untuk restore.';
    if(confirm(msg)) {
        showToast('Restore dimulai... (dummy, implementasi endpoint restore diperlukan)', 'info');
        // TODO: AJAX call ke endpoint restore
    }
}
function downloadBackup(filename) {
    showToast('Download backup: ' + filename + ' (dummy, implementasi endpoint download diperlukan)', 'info');
    // TODO: window.location = '/settings/backup/download/' + filename;
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
    .badge-status {
        font-size: 0.92rem;
        border-radius: 8px;
        padding: 0.32rem 1.1rem;
        font-weight: 600;
        letter-spacing: 1px;
        background: #f3f4f6;
        color: #f43f5e;
        border: none;
    }
    .badge-active { background: #e8f5e9 !important; color: #43a047 !important; }
    .badge-inactive { background: #ffebee !important; color: #e53935 !important; }
    .badge-role-table {
        background: #f43f5e1a;
        color: #f43f5e;
        font-size: 0.92rem;
        border-radius: 8px;
        padding: 0.32rem 1.1rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
</style>
@endpush 