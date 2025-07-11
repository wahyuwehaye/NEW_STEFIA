@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<x-page-header 
    title="Manajemen Pembayaran" 
    subtitle="Kelola pembayaran mahasiswa dan verifikasi">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('payments.pending') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-clock"></em><span>Pending Verification</span></a></li>
            <li><a href="{{ route('payments.history') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-file-text"></em><span>Riwayat</span></a></li>
            <li class="nk-block-tools-opt"><a href="{{ route('payments.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Input Pembayaran</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Payment Statistics -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Total Pembayaran Hari Ini" 
            value="Rp 89.240.000" 
            change="15.2%" 
            changeType="up" 
            tooltip="Pembayaran yang diterima hari ini" />
            
        <x-stats-card 
            title="Pembayaran Bulan Ini" 
            value="Rp 1.456.780.000" 
            change="8.5%" 
            changeType="up" 
            tooltip="Total pembayaran bulan ini" />
            
        <x-stats-card 
            title="Pending Verification" 
            value="23" 
            change="3.1%" 
            changeType="down" 
            tooltip="Pembayaran yang belum diverifikasi" />
            
        <x-stats-card 
            title="Pembayaran Verified" 
            value="156" 
            change="12.8%" 
            changeType="up" 
            tooltip="Pembayaran yang sudah diverifikasi" />
    </div>
</div>

<!-- Filter Section -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="row g-3 align-center">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-control-wrap">
                            <select class="form-control js-select2">
                                <option value="">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="verified">Verified</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran</label>
                        <div class="form-control-wrap">
                            <select class="form-control js-select2">
                                <option value="">Semua Metode</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="cash">Cash</option>
                                <option value="virtual_account">Virtual Account</option>
                                <option value="e_wallet">E-Wallet</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Tanggal Dari</label>
                        <div class="form-control-wrap">
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Tanggal Sampai</label>
                        <div class="form-control-wrap">
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Jurusan</label>
                        <div class="form-control-wrap">
                            <select class="form-control js-select2">
                                <option value="">Semua Jurusan</option>
                                <option value="TI">Teknik Informatika</option>
                                <option value="SI">Sistem Informasi</option>
                                <option value="TE">Teknik Elektro</option>
                                <option value="TM">Teknik Mesin</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
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

<!-- Payments Table -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Daftar Pembayaran</h6>
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
                            <input type="checkbox" class="custom-control-input" id="payment-all">
                            <label class="custom-control-label" for="payment-all"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col"><span>Tanggal</span></div>
                    <div class="nk-tb-col"><span>Mahasiswa</span></div>
                    <div class="nk-tb-col"><span>Jenis Pembayaran</span></div>
                    <div class="nk-tb-col"><span>Jumlah</span></div>
                    <div class="nk-tb-col"><span>Metode</span></div>
                    <div class="nk-tb-col"><span>Status</span></div>
                    <div class="nk-tb-col"><span>Verifikasi</span></div>
                    <div class="nk-tb-col nk-tb-col-tools"><span>&nbsp;</span></div>
                </div>
                
                <!-- Sample Payment Data -->
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="payment1">
                            <label class="custom-control-label" for="payment1"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">15 Jan 2025</span>
                        <span class="tb-sub">10:30 AM</span>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-primary">
                                <span>AF</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Ahmad Fauzi</span>
                                <span class="tb-sub">2019001 - TI</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">SPP Semester 8</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount">Rp 5.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Transfer Bank</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-warning">Pending</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">-</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    <em class="icon ni ni-eye"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Verifikasi">
                                    <em class="icon ni ni-check"></em>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#"><em class="icon ni ni-check"></em><span>Verifikasi</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-cross"></em><span>Reject</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" class="text-danger"><em class="icon ni ni-trash"></em><span>Hapus</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="payment2">
                            <label class="custom-control-label" for="payment2"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">14 Jan 2025</span>
                        <span class="tb-sub">02:15 PM</span>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-success">
                                <span>SN</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Siti Nurhaliza</span>
                                <span class="tb-sub">2020002 - SI</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">SPP Semester 6</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount">Rp 4.500.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Virtual Account</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Verified</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Admin Keuangan</span>
                        <span class="tb-sub">14 Jan 2025</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    <em class="icon ni ni-eye"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Cetak Receipt">
                                    <em class="icon ni ni-printer"></em>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#"><em class="icon ni ni-printer"></em><span>Cetak Receipt</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-mail"></em><span>Email Receipt</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" class="text-danger"><em class="icon ni ni-trash"></em><span>Hapus</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="payment3">
                            <label class="custom-control-label" for="payment3"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">13 Jan 2025</span>
                        <span class="tb-sub">09:45 AM</span>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-danger">
                                <span>BS</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Budi Santoso</span>
                                <span class="tb-sub">2018003 - TE</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Praktikum</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount">Rp 1.200.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Cash</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-danger">Rejected</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Admin Keuangan</span>
                        <span class="tb-sub">13 Jan 2025</span>
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
                                        <li><a href="#"><em class="icon ni ni-repeat"></em><span>Reprocess</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" class="text-danger"><em class="icon ni ni-trash"></em><span>Hapus</span></a></li>
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
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
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
    $('#payment-all').on('change', function() {
        $('input[type="checkbox"]').not(this).prop('checked', this.checked);
    });
    
    // Auto-refresh every 30 seconds for pending payments
    setInterval(function() {
        if ($('.badge-warning').length > 0) {
            // TODO: Implement auto-refresh logic
            console.log('Auto-refreshing pending payments...');
        }
    }, 30000);
});
</script>
@endpush
