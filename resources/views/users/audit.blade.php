@extends('layouts.admin')

@section('title', 'Audit Log User')

@section('content')
<x-page-header title="Audit Log User" subtitle="Riwayat aktivitas seluruh user dalam sistem, lengkap dengan detail perubahan data, device, dan resource">
    <x-slot name="actions">
        <a href="{{ route('users.index') }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="card glass-card animate-fadeInUp">
        <div class="card-inner">
            <form method="GET" action="{{ route('users.audit') }}" class="mb-3">
                <div class="row g-2 align-center">
                    <div class="col-md-3">
                        <input type="text" name="user" class="form-control" placeholder="Cari nama/email user..." value="{{ request('user') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="role" class="form-control" placeholder="Cari role..." value="{{ request('role') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary"><em class="icon ni ni-search"></em> Filter</button>
                        <a href="{{ route('users.audit') }}" class="btn btn-light">Reset</a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 audit-table">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Aksi</th>
                            <th>Resource</th>
                            <th>ID</th>
                            <th>Deskripsi</th>
                            <th>Perubahan Data</th>
                            <th>IP</th>
                            <th>Device</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityLogs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $log->user->name ?? '-' }}</td>
                                <td><span class="badge badge-role-table">{{ $log->user->role_name ?? '-' }}</span></td>
                                <td>
                                    <span class="badge badge-action badge-{{ $log->action }}">{{ ucfirst($log->action) }}</span>
                                </td>
                                <td>{{ $log->resource ?? '-' }}</td>
                                <td>{{ $log->resource_id ?? '-' }}</td>
                                <td>{{ $log->description ?? '-' }}</td>
                                <td>
                                    @if($log->old_data || $log->new_data)
                                        <button class="btn btn-xs btn-light btn-toggle-data" type="button" data-bs-toggle="collapse" data-bs-target="#log-data-{{ $log->id }}" aria-expanded="false" aria-controls="log-data-{{ $log->id }}">
                                            Detail
                                        </button>
                                        <div class="collapse mt-2" id="log-data-{{ $log->id }}">
                                            <div class="card card-body bg-light p-2 small">
                                                @if($log->old_data)
                                                    <div><strong>Sebelum:</strong>
                                                        <pre class="bg-white p-2 rounded border mt-1">{{ json_encode($log->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                    </div>
                                                @endif
                                                @if($log->new_data)
                                                    <div class="mt-2"><strong>Sesudah:</strong>
                                                        <pre class="bg-white p-2 rounded border mt-1">{{ json_encode($log->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td>{{ $log->ip_address }}</td>
                                <td>
                                    <span class="d-inline-flex align-items-center">
                                        <em class="icon ni ni-monitor"></em>
                                        <span class="ms-1 small" style="max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: inline-block; vertical-align: middle;">{{ Str::limit($log->user_agent, 30) }}</span>
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .audit-table {
        border-radius: 16px;
        overflow: hidden;
        background: rgba(255,255,255,0.97);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .audit-table thead th {
        background: linear-gradient(90deg, #ff4d4d, #f43f5e) !important;
        color: #fff !important;
        font-size: 1.05rem;
        font-weight: 700;
        border: none;
    }
    .badge-action {
        font-size: 0.92rem;
        border-radius: 8px;
        padding: 0.32rem 1.1rem;
        font-weight: 600;
        letter-spacing: 1px;
        background: #f3f4f6;
        color: #f43f5e;
        border: none;
    }
    .badge-action.badge-create { background: #e0f7fa; color: #009688; }
    .badge-action.badge-update { background: #fff3e0; color: #ff9800; }
    .badge-action.badge-delete { background: #ffebee; color: #e53935; }
    .badge-action.badge-login { background: #e3f2fd; color: #1976d2; }
    .badge-action.badge-approve { background: #e8f5e9; color: #43a047; }
    .badge-action.badge-reject { background: #fbe9e7; color: #d84315; }
    .badge-action.badge-view { background: #ede7f6; color: #5e35b1; }
    .badge-action.badge-unauthorized_access { background: #fffde7; color: #fbc02d; }
    .badge-action.badge-locked { background: #f3e5f5; color: #8e24aa; }
    .badge-action.badge-activated { background: #e0f2f1; color: #00897b; }
    .badge-action.badge-suspended { background: #fbe9e7; color: #d84315; }
    .badge-action.badge-other { background: #f3f4f6; color: #607d8b; }
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