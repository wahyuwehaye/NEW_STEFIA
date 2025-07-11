@extends('layouts.admin')

@section('title', 'Manajemen Piutang')

@section('content')
<x-page-header 
    title="Manajemen Piutang" 
    subtitle="Kelola piutang mahasiswa dan status pembayaran">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('receivables.outstanding') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-alert-circle"></em><span>Piutang Tunggakan</span></a></li>
            <li><a href="{{ route('receivables.history') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-clock"></em><span>Riwayat</span></a></li>
            <li class="nk-block-tools-opt"><a href="{{ route('receivables.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Piutang</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Piutang Statistics -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Total Piutang" 
            value="Rp 2.847.950.000" 
            change="12.38%" 
            changeType="up" 
            tooltip="Total seluruh piutang mahasiswa" />
            
        <x-stats-card 
            title="Piutang Lunas" 
            value="Rp 2.456.780.000" 
            change="8.5%" 
            changeType="up" 
            tooltip="Piutang yang sudah lunas" />
            
        <x-stats-card 
            title="Piutang Tunggakan" 
            value="Rp 391.170.000" 
            change="2.1%" 
            changeType="down" 
            tooltip="Piutang yang masih tertunggak" />
            
        <x-stats-card 
            title="Mahasiswa Menunggak" 
            value="156" 
            change="5.2%" 
            changeType="down" 
            tooltip="Jumlah mahasiswa yang menunggak" />
    </div>
</div>

<!-- Filter Section -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="row g-3 align-center">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Status Piutang</label>
                        <div class="form-control-wrap">
                            <select class="form-control">
                                <option value="">Semua Status</option>
                                <option value="lunas">Lunas</option>
                                <option value="sebagian">Sebagian</option>
                                <option value="tunggakan">Tunggakan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Jurusan</label>
                        <div class="form-control-wrap">
                            <select class="form-control">
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
                        <label class="form-label">Angkatan</label>
                        <div class="form-control-wrap">
                            <select class="form-control">
                                <option value="">Semua Angkatan</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Semester</label>
                        <div class="form-control-wrap">
                            <select class="form-control">
                                <option value="">Semua Semester</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Periode</label>
                        <div class="form-control-wrap">
                            <select class="form-control">
                                <option value="">Semua Periode</option>
                                <option value="2024/2025">2024/2025</option>
                                <option value="2023/2024">2023/2024</option>
                                <option value="2022/2023">2022/2023</option>
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

<!-- Receivables Table -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Daftar Piutang Mahasiswa</h6>
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
                            <input type="checkbox" class="custom-control-input" id="pid-all">
                            <label class="custom-control-label" for="pid-all"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col"><span>Mahasiswa</span></div>
                    <div class="nk-tb-col"><span>Jurusan</span></div>
                    <div class="nk-tb-col"><span>Semester</span></div>
                    <div class="nk-tb-col"><span>Total Piutang</span></div>
                    <div class="nk-tb-col"><span>Dibayar</span></div>
                    <div class="nk-tb-col"><span>Sisa</span></div>
                    <div class="nk-tb-col"><span>Status</span></div>
                    <div class="nk-tb-col"><span>Jatuh Tempo</span></div>
                    <div class="nk-tb-col nk-tb-col-tools"><span>&nbsp;</span></div>
                </div>
                
                <!-- Sample Data -->
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="pid1">
                            <label class="custom-control-label" for="pid1"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-danger">
                                <span>AF</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Ahmad Fauzi</span>
                                <span class="tb-sub">2019001 - Angkatan 2019</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Teknik Informatika</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">8</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount">Rp 20.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-success">Rp 5.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-danger">Rp 15.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-danger">Tunggakan</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-danger">15 Jan 2024</span>
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
                                        <li><a href="#"><em class="icon ni ni-wallet"></em><span>Tambah Pembayaran</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-clock"></em><span>Riwayat</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-mail"></em><span>Kirim Reminder</span></a></li>
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
                            <input type="checkbox" class="custom-control-input" id="pid2">
                            <label class="custom-control-label" for="pid2"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-success">
                                <span>SN</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Siti Nurhaliza</span>
                                <span class="tb-sub">2020002 - Angkatan 2020</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Sistem Informasi</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">6</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount">Rp 15.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-success">Rp 15.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-success">Rp 0</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Lunas</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">20 Feb 2024</span>
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
                                        <li><a href="#"><em class="icon ni ni-clock"></em><span>Riwayat</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-file-text"></em><span>Cetak Kwitansi</span></a></li>
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
                            <input type="checkbox" class="custom-control-input" id="pid3">
                            <label class="custom-control-label" for="pid3"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-warning">
                                <span>BS</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">Budi Santoso</span>
                                <span class="tb-sub">2018003 - Angkatan 2018</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Teknik Elektro</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">9</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount">Rp 18.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-success">Rp 10.500.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-warning">Rp 7.500.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-warning">Sebagian</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-warning">10 Mar 2024</span>
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
                                        <li><a href="#"><em class="icon ni ni-wallet"></em><span>Tambah Pembayaran</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-clock"></em><span>Riwayat</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-mail"></em><span>Kirim Reminder</span></a></li>
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
    $('#pid-all').on('change', function() {
        $('input[type="checkbox"]').not(this).prop('checked', this.checked);
    });
});
</script>
@endpush
