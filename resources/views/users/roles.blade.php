@extends('layouts.admin')

@section('title', 'Manajemen Role & Hak Akses')

@section('content')
<x-page-header title="Manajemen Role & Hak Akses" subtitle="Kelola role dan hak akses user dengan tampilan modern, calm, dan futuristik">
    <x-slot name="actions">
        <a href="{{ route('users.index') }}" class="btn btn-light btn-modern"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="row g-4 mb-4">
        @foreach($roles as $key => $role)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="glass-card role-card animate-fadeInUp">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon role-icon me-3">
                            @if($key === 'super_admin')
                                <em class="icon ni ni-shield-star"></em>
                            @elseif($key === 'admin')
                                <em class="icon ni ni-user-c"></em>
                            @elseif($key === 'finance')
                                <em class="icon ni ni-coins"></em>
                            @elseif($key === 'staff')
                                <em class="icon ni ni-users"></em>
                            @elseif($key === 'student')
                                <em class="icon ni ni-hat"></em>
                            @else
                                <em class="icon ni ni-user"></em>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-0 role-title">{{ $role }}</h5>
                            <span class="text-muted small">{{ $users->where('role', $key)->count() }} user</span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <span class="badge badge-role">{{ strtoupper($key) }}</span>
                    </div>
                    <div class="progress role-progress mb-3">
                        <div class="progress-bar role-progress-bar" role="progressbar" style="width: {{ max(8, min(100, $users->where('role', $key)->count() * 10)) }}%;" aria-valuenow="{{ $users->where('role', $key)->count() }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="text-soft small">User dengan role ini</span>
                        <span class="fw-bold text-dark">{{ $users->where('role', $key)->count() }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card glass-card mt-4 animate-fadeInUp">
        <div class="card-inner">
            <h5 class="mb-4 text-gradient">User per Role</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 role-table">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar user-avatar-sm bg-gradient-primary me-2">
                                            <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        </div>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td>
                                    <span class="badge badge-role-table">{{ $roles[$user->role] ?? $user->role }}</span>
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="#" class="d-inline-flex align-items-center justify-content-center">
                                        @csrf
                                        <select name="role" class="form-select form-select-sm d-inline w-auto glass-card select-role">
                                            @foreach($roles as $key => $role)
                                                <option value="{{ $key }}" {{ $user->role == $key ? 'selected' : '' }}>{{ $role }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-update ms-2"><em class="icon ni ni-save"></em></button>
                                    </form>
                                </td>
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
    .role-card {
        min-height: 210px;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        border-radius: 20px !important;
        box-shadow: 0 6px 32px rgba(0,0,0,0.07) !important;
        background: rgba(255,255,255,0.85) !important;
        border: none !important;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .role-card:hover {
        box-shadow: 0 16px 48px rgba(255,0,0,0.10) !important;
        transform: translateY(-3px) scale(1.01);
    }
    .role-icon {
        width: 54px;
        height: 54px;
        font-size: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff4d4d 0%, #f43f5e 100%) !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(255,0,0,0.08);
    }
    .role-title {
        font-size: 1.18rem;
        font-weight: 700;
        color: #f43f5e;
        margin-bottom: 0.1rem;
    }
    .badge-role {
        background: #f43f5e1a;
        color: #f43f5e;
        font-size: 0.85rem;
        border-radius: 8px;
        padding: 0.35rem 0.9rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
    .role-progress {
        height: 7px;
        background: #f3f4f6;
        border-radius: 6px;
        overflow: hidden;
    }
    .role-progress-bar {
        background: linear-gradient(90deg, #ff4d4d, #f43f5e);
        border-radius: 6px;
        transition: width 0.7s cubic-bezier(.4,2,.6,1);
    }
    .badge-role-table {
        background: #f43f5e1a;
        color: #f43f5e;
        font-size: 0.92rem;
        border-radius: 8px;
        padding: 0.32rem 1.1rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
    .btn-update {
        background: linear-gradient(90deg, #ff4d4d, #f43f5e);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0.45rem 1.1rem;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(255,0,0,0.08);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-update:hover {
        background: linear-gradient(90deg, #f43f5e, #ff4d4d);
        color: #fff;
        box-shadow: 0 4px 16px rgba(255,0,0,0.12);
        transform: translateY(-2px) scale(1.04);
    }
    .role-table {
        border-radius: 16px;
        overflow: hidden;
        background: rgba(255,255,255,0.95);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .role-table thead th {
        background: linear-gradient(90deg, #ff4d4d, #f43f5e) !important;
        color: #fff !important;
        font-size: 1.05rem;
        font-weight: 700;
        border: none;
    }
    .role-table tbody tr {
        transition: background 0.18s;
    }
    .role-table tbody tr:hover {
        background: #f43f5e0d;
    }
    .select-role {
        min-width: 120px;
        border-radius: 8px !important;
        background: #fff !important;
        border: 1px solid #f3f4f6 !important;
        font-size: 0.98rem;
        color: #374151;
        font-weight: 500;
        box-shadow: none !important;
        transition: border 0.2s;
    }
    .select-role:focus {
        border: 1.5px solid #f43f5e !important;
        outline: none !important;
    }
</style>
@endpush 