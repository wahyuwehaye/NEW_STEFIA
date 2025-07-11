@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<x-page-header 
    title="Manajemen User" 
    subtitle="Kelola user dan hak akses sistem">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('users.pending') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-clock"></em><span>Pending Approval</span></a></li>
            <li><a href="{{ route('users.logs') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-file-text"></em><span>Activity Logs</span></a></li>
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
            <div class="row g-3 align-center">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-control-wrap">
                            <select class="form-control js-select2">
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div class="form-control-wrap">
                            <select class="form-control js-select2">
                                <option value="">Semua Role</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin_keuangan">Admin Keuangan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Tanggal Bergabung</label>
                        <div class="form-control-wrap">
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">&nbsp;</label>
                        <div class="form-control-wrap">
                            <button class="btn btn-primary"><em class="icon ni ni-search"></em><span>Filter</span></button>
                        </div>
                    </div>
                </div>
            </div>
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
                
                <!-- Sample User Data -->
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="user1">
                            <label class="custom-control-label" for="user1"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-primary">
                                <span>SA</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Super Admin</span>
                                <span class="tb-sub">Administrator</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-danger">Super Admin</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">admin@stefia.com</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Aktif</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">15 Jan 2025</span>
                        <span class="tb-sub">10:30 AM</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">01 Jan 2024</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    <em class="icon ni ni-eye"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <em class="icon ni ni-edit"></em>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#"><em class="icon ni ni-shield"></em><span>Reset Password</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-activity"></em><span>Activity Log</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" class="text-danger"><em class="icon ni ni-na"></em><span>Suspend</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="user2">
                            <label class="custom-control-label" for="user2"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-success">
                                <span>AK</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Admin Keuangan 1</span>
                                <span class="tb-sub">Keuangan</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Admin Keuangan</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">keuangan1@stefia.com</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Aktif</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">15 Jan 2025</span>
                        <span class="tb-sub">09:15 AM</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">15 Mar 2024</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    <em class="icon ni ni-eye"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <em class="icon ni ni-edit"></em>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#"><em class="icon ni ni-shield"></em><span>Reset Password</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-activity"></em><span>Activity Log</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" class="text-danger"><em class="icon ni ni-na"></em><span>Suspend</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="user3">
                            <label class="custom-control-label" for="user3"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-warning">
                                <span>PA</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Pending Admin</span>
                                <span class="tb-sub">Menunggu Approval</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-warning">Admin Keuangan</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">pending@stefia.com</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-warning">Pending</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">-</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">12 Jan 2025</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve">
                                    <em class="icon ni ni-check"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#"><em class="icon ni ni-check"></em><span>Approve</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-cross"></em><span>Reject</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
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
