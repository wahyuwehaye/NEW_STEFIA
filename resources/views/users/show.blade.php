@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<x-page-header title="Detail User" subtitle="Informasi lengkap dan aktivitas user">
    <x-slot name="actions">
        <a href="{{ route('users.index') }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="card card-bordered mb-4">
        <div class="card-inner">
            <div class="row g-3">
                <div class="col-md-4 text-center">
                    <div class="user-avatar user-avatar-xl bg-primary mb-2">
                        <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <span class="badge badge-dot badge-{{ $user->is_active ? 'success' : 'warning' }}">{{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}</span>
                </div>
                <div class="col-md-8">
                    <dl class="row">
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $user->email }}</dd>
                        <dt class="col-sm-4">No. HP</dt>
                        <dd class="col-sm-8">{{ $user->phone }}</dd>
                        <dt class="col-sm-4">Role</dt>
                        <dd class="col-sm-8">{{ $user->role_name }}</dd>
                        <dt class="col-sm-4">Tanggal Join</dt>
                        <dd class="col-sm-8">{{ $user->created_at->format('d M Y') }}</dd>
                        <dt class="col-sm-4">Last Login</dt>
                        <dd class="col-sm-8">{{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-bordered">
        <div class="card-inner">
            <h6 class="title mb-3">Log Aktivitas Terakhir</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Aktivitas</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activityLogs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td>{{ $log->activity }}</td>
                                <td>{{ $log->ip_address }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 