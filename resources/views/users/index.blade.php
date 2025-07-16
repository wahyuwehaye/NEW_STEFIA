@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<x-page-header 
    title="Manajemen User" 
    subtitle="Kelola user dan hak akses sistem">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('users.approval') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-clock"></em><span>Pending Approval</span></a></li>
            <li><a href="{{ route('users.audit') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-file-text"></em><span>Activity Logs</span></a></li>
            <li class="nk-block-tools-opt"><a href="{{ route('users.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah User</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- User Statistics -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Total User" 
            value="12" 
            change="8.3%" 
            changeType="up" 
            tooltip="Total user dalam sistem" />
            
        <x-stats-card 
            title="User Aktif" 
            value="10" 
            change="5.2%" 
            changeType="up" 
            tooltip="User yang aktif" />
            
        <x-stats-card 
            title="Pending Approval" 
            value="2" 
            change="1.1%" 
            changeType="down" 
            tooltip="User menunggu approval" />
            
        <x-stats-card 
            title="Admin Keuangan" 
            value="8" 
            change="0%" 
            changeType="up" 
            tooltip="User dengan role Admin Keuangan" />
    </div>
</div>

<!-- Filter Section -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <form method="GET" action="{{ route('users.index') }}">
                <div class="row g-3 align-center">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="form-control-wrap">
                                <select name="status" class="form-control js-select2">
                                    <option value="all" {{ ($filters['status'] ?? 'all') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <div class="form-control-wrap">
                                <select name="role" class="form-control js-select2">
                                    <option value="all" {{ ($filters['role'] ?? 'all') == 'all' ? 'selected' : '' }}>Semua Role</option>
                                    @foreach($roles as $key => $role)
                                        <option value="{{ $key }}" {{ ($filters['role'] ?? '') == $key ? 'selected' : '' }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">Cari</label>
                            <div class="form-control-wrap">
                                <input type="text" name="search" class="form-control" placeholder="Nama atau email..." value="{{ $filters['search'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="form-control-wrap">
                                <button type="submit" class="btn btn-primary"><em class="icon ni ni-search"></em><span>Filter</span></button>
                                <a href="{{ route('users.index') }}" class="btn btn-light">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Daftar User</h6>
                </div>
                <div class="card-tools">
                    <ul class="card-tools-nav">
                        <li><a href="#"><span>Export Excel</span></a></li>
                        <li><a href="#"><span>Export PDF</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-inner p-0">
            <div class="nk-tb-list">
                <div class="nk-tb-item nk-tb-head">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="user-all">
                            <label class="custom-control-label" for="user-all"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col"><span>User</span></div>
                    <div class="nk-tb-col"><span>Role</span></div>
                    <div class="nk-tb-col"><span>Email</span></div>
                    <div class="nk-tb-col"><span>Status</span></div>
                    <div class="nk-tb-col"><span>Last Login</span></div>
                    <div class="nk-tb-col"><span>Bergabung</span></div>
                    <div class="nk-tb-col nk-tb-col-tools"><span>&nbsp;</span></div>
                </div>
                
                @forelse($users as $user)
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="user{{ $user->id }}">
                                <label class="custom-control-label" for="user{{ $user->id }}"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-avatar user-avatar-sm bg-{{ $user->is_active ? 'primary' : 'warning' }}">
                                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                                <div class="user-name">
                                    <span class="tb-lead">{{ $user->name }}</span>
                                    <span class="tb-sub">{{ $user->role_name }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            @php
                                $badgeColor = match($user->role) {
                                    'super_admin' => 'danger',
                                    'admin' => 'primary',
                                    'finance' => 'success',
                                    'staff' => 'info',
                                    default => 'secondary'
                                };
                            @endphp
                            <span class="badge badge-dot badge-{{ $badgeColor }}">{{ $user->role_name }}</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">{{ $user->email }}</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="badge badge-dot badge-{{ $user->is_active ? 'success' : 'warning' }}">
                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                        <div class="nk-tb-col">
                            @if($user->last_login_at)
                                <span class="tb-sub">{{ $user->last_login_at->format('d M Y') }}</span>
                                <span class="tb-sub">{{ $user->last_login_at->format('H:i') }}</span>
                            @else
                                <span class="tb-sub">-</span>
                            @endif
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1 my-n1">
                                <li>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                        <em class="icon ni ni-eye"></em>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <em class="icon ni ni-edit"></em>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-link text-{{ $user->is_active ? 'warning' : 'success' }}">
                                                        <em class="icon ni ni-{{ $user->is_active ? 'na' : 'check' }}"></em>
                                                        <span>{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                                                    </button>
                                                </form>
                                            </li>
                                            <li><a href="{{ route('users.show', $user) }}"><em class="icon ni ni-activity"></em><span>Activity Log</span></a></li>
                                            @if(auth()->user()->isSuperAdmin() && $user->id !== auth()->id())
                                                <li class="divider"></li>
                                                <li>
                                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline delete-user-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-sm btn-link text-danger delete-user-btn" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                                            <em class="icon ni ni-trash"></em><span>Hapus</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="nk-tb-item">
                        <div class="nk-tb-col" colspan="7">
                            <div class="text-center py-4">
                                <em class="icon ni ni-users" style="font-size: 3rem; opacity: 0.3;"></em>
                                <p class="text-muted">Tidak ada user yang ditemukan</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-block-between-md g-3">
                <div class="g">
                    <ul class="pagination justify-content-center justify-content-md-start">
                        <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </div>
                <div class="g">
                    <div class="pagination-goto d-flex justify-content-center justify-content-md-end">
                        <div>Page</div>
                        <div>
                            <select class="form-select js-select2" data-search="false">
                                <option value="page-1">1</option>
                                <option value="page-2">2</option>
                                <option value="page-3">3</option>
                            </select>
                        </div>
                        <div>of 3</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2 for dropdowns
    $('.js-select2').select2({
        minimumResultsForSearch: Infinity
    });
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Check all functionality
    $('#user-all').on('change', function() {
        $('input[type="checkbox"]').not(this).prop('checked', this.checked);
    });
});
</script>
@endpush
