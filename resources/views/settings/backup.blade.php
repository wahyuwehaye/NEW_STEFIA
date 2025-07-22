@extends('layouts.admin')
@section('title', 'Backup & Restore')
@section('content')
<x-page-header title="Backup & Restore" subtitle="Kelola backup otomatis, manual, dan recovery data.">
    <x-slot name="actions">
        <a href="{{ route('settings.general') }}" class="btn btn-light btn-modern"><em class="icon ni ni-arrow-left"></em> Kembali</a>
    </x-slot>
</x-page-header>
<div class="nk-block">
    <div class="row g-4 mb-4">
        <div class="col-lg-6 col-12">
            <div class="glass-card backup-card animate-fadeInUp">
                <h5 class="mb-2">Backup Otomatis</h5>
                <ul class="list-unstyled small mb-2">
                    <li><em class="icon ni ni-clock"></em> <span class="text-muted">Jadwal:</span> <span class="text-primary">{{ ucfirst($backups['automatic']['frequency']) }} - {{ $backups['automatic']['time'] }}</span></li>
                    <li><em class="icon ni ni-save"></em> <span class="text-muted">Retensi:</span> <span class="text-primary">{{ $backups['automatic']['retention_days'] }} hari</span></li>
                    <li><em class="icon ni ni-database"></em> <span class="text-muted">Backup Terakhir:</span> <span class="text-primary">{{ $backups['automatic']['last_backup'] }}</span></li>
                    <li><em class="icon ni ni-pie"></em> <span class="text-muted">Ukuran:</span> <span class="text-primary">{{ $backups['automatic']['backup_size'] }}</span></li>
                </ul>
                <span class="badge badge-status {{ $backups['automatic']['enabled'] ? 'badge-active' : 'badge-inactive' }}">{{ $backups['automatic']['enabled'] ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="glass-card backup-card animate-fadeInUp">
                <h5 class="mb-2">Storage</h5>
                <ul class="list-unstyled small mb-2">
                    <li><em class="icon ni ni-database"></em> <span class="text-muted">Total:</span> <span class="text-primary">{{ $backups['storage']['total_space'] }}</span></li>
                    <li><em class="icon ni ni-pie"></em> <span class="text-muted">Terpakai:</span> <span class="text-primary">{{ $backups['storage']['used_space'] }}</span></li>
                    <li><em class="icon ni ni-pie"></em> <span class="text-muted">Tersedia:</span> <span class="text-primary">{{ $backups['storage']['available_space'] }}</span></li>
                    <li><em class="icon ni ni-folder"></em> <span class="text-muted">Lokasi:</span> <span class="text-primary">{{ $backups['storage']['backup_location'] }}</span></li>
                </ul>
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
    <div class="card glass-card mt-4 animate-fadeInUp">
        <div class="card-inner">
            <h5 class="mb-4 text-gradient">Daftar Backup Terakhir</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 backup-table">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups['recent_backups'] as $backup)
                            <tr>
                                <td><em class="icon ni ni-save"></em> {{ $backup['filename'] }}</td>
                                <td>{{ $backup['size'] }}</td>
                                <td><span class="badge badge-role-table">{{ ucfirst($backup['type']) }}</span></td>
                                <td>{{ $backup['created_at'] }}</td>
                                <td><span class="badge badge-status {{ $backup['status'] === 'completed' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($backup['status']) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .backup-card {
        min-height: 210px;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        border-radius: 20px !important;
        box-shadow: 0 6px 32px rgba(0,0,0,0.07) !important;
        background: rgba(255,255,255,0.85) !important;
        border: none !important;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .backup-card:hover {
        box-shadow: 0 16px 48px rgba(255,0,0,0.10) !important;
        transform: translateY(-3px) scale(1.01);
    }
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
    .backup-table {
        border-radius: 16px;
        overflow: hidden;
        background: rgba(255,255,255,0.97);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .backup-table thead th {
        background: linear-gradient(90deg, #ff4d4d, #f43f5e) !important;
        color: #fff !important;
        font-size: 1.05rem;
        font-weight: 700;
        border: none;
    }
</style>
@endpush 