@extends('layouts.admin')

@section('title', 'Riwayat Piutang')

@section('content')
<x-page-header 
    title="Riwayat Piutang" 
    subtitle="Riwayat semua transaksi piutang mahasiswa">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li>
                <a href="#" class="btn btn-white btn-outline-light" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <em class="icon ni ni-filter"></em><span>Filter</span>
                </a>
            </li>
            <li>
                <a href="#" class="btn btn-white btn-outline-light" onclick="exportData()">
                    <em class="icon ni ni-download-cloud"></em><span>Export Excel</span>
                </a>
            </li>
            <li>
                <a href="{{ route('receivables.index') }}" class="btn btn-primary">
                    <em class="icon ni ni-arrow-left"></em><span>Kembali</span>
                </a>
            </li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Statistics Cards -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Total Riwayat</h6>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">1,247</span>
                        <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>8.47%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Piutang Lunas</h6>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">1,089</span>
                        <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>12.38%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Piutang Dihapus</h6>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">34</span>
                        <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>2.15%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Rata-rata Nilai</h6>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">Rp 2.45M</span>
                        <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>5.26%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Receivables History Table -->
<div class="nk-block">
    <div class="card card-bordered card-stretch">
        <div class="card-inner-group">
            <div class="card-inner position-relative card-tools-toggle">
                <div class="card-title-group">
                    <div class="card-tools">
                        <div class="form-inline flex-nowrap gx-3">
                            <div class="form-wrap w-150px">
                                <select class="form-select js-select2" data-search="off">
                                    <option value="">Semua Status</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="dihapus">Dihapus</option>
                                    <option value="diubah">Diubah</option>
                                </select>
                            </div>
                            <div class="form-wrap w-150px">
                                <input type="text" class="form-control" placeholder="Cari mahasiswa...">
                            </div>
                        </div>
                    </div>
                    <div class="card-tools me-n1">
                        <ul class="btn-toolbar gx-1">
                            <li>
                                <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                            </li>
                            <li class="btn-toolbar-sep"></li>
                            <li>
                                <div class="toggle-wrap">
                                    <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                    <div class="toggle-content" data-content="cardTools">
                                        <ul class="btn-toolbar">
                                            <li class="toggle-close">
                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                            </li>
                                            <li>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                        <em class="icon ni ni-setting"></em>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                                        <ul class="link-check">
                                                            <li><span>Show</span></li>
                                                            <li class="active"><a href="#">10</a></li>
                                                            <li><a href="#">20</a></li>
                                                            <li><a href="#">50</a></li>
                                                        </ul>
                                                        <ul class="link-check">
                                                            <li><span>Order</span></li>
                                                            <li class="active"><a href="#">DESC</a></li>
                                                            <li><a href="#">ASC</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-search search-wrap" data-search="search">
                    <div class="card-body">
                        <div class="search-content">
                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                            <input type="text" class="form-control border-transparent form-focus-none" placeholder="Cari berdasarkan nama atau NIM...">
                            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-inner p-0">
                <div class="nk-tb-list nk-tb-ulist">
                    <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col"><span class="sub-text">Mahasiswa</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Jenis Piutang</span></div>
                        <div class="nk-tb-col tb-col-lg"><span class="sub-text">Jumlah</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Tanggal</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Aksi</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">User</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">
                            <span class="sub-text">Action</span>
                        </div>
                    </div>
                    
                    @php
                        $historyData = [
                            [
                                'id' => 1,
                                'student_name' => 'John Doe',
                                'student_nim' => '123456789',
                                'type' => 'SPP',
                                'amount' => 2500000,
                                'date' => '2025-01-10 14:30:00',
                                'status' => 'lunas',
                                'action' => 'Pembayaran diterima',
                                'user' => 'Admin Finance',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 2,
                                'student_name' => 'Jane Smith',
                                'student_nim' => '987654321',
                                'type' => 'Biaya Laboratorium',
                                'amount' => 1500000,
                                'date' => '2025-01-09 10:15:00',
                                'status' => 'diubah',
                                'action' => 'Jumlah piutang diubah',
                                'user' => 'Staff Keuangan',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 3,
                                'student_name' => 'Bob Johnson',
                                'student_nim' => '456789123',
                                'type' => 'Uang Kuliah',
                                'amount' => 3200000,
                                'date' => '2025-01-08 16:45:00',
                                'status' => 'lunas',
                                'action' => 'Pembayaran diterima',
                                'user' => 'Admin Finance',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 4,
                                'student_name' => 'Alice Brown',
                                'student_nim' => '789123456',
                                'type' => 'SPP',
                                'amount' => 2500000,
                                'date' => '2025-01-07 09:20:00',
                                'status' => 'dihapus',
                                'action' => 'Piutang dihapus karena kesalahan input',
                                'user' => 'Supervisor',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 5,
                                'student_name' => 'Charlie Davis',
                                'student_nim' => '321654987',
                                'type' => 'Biaya Praktikum',
                                'amount' => 800000,
                                'date' => '2025-01-06 11:30:00',
                                'status' => 'lunas',
                                'action' => 'Pembayaran diterima',
                                'user' => 'Staff Keuangan',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 6,
                                'student_name' => 'Diana Wilson',
                                'student_nim' => '654321098',
                                'type' => 'Biaya Wisuda',
                                'amount' => 1200000,
                                'date' => '2025-01-05 13:15:00',
                                'status' => 'lunas',
                                'action' => 'Pembayaran diterima',
                                'user' => 'Admin Finance',
                                'semester' => 'Ganjil 2024/2025'
                            ]
                        ];
                    @endphp
                    
                    @foreach($historyData as $item)
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-{{ $item['status'] == 'lunas' ? 'success' : ($item['status'] == 'dihapus' ? 'danger' : 'warning') }}">
                                        <span>{{ substr($item['student_name'], 0, 2) }}</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $item['student_name'] }}</span>
                                        <span class="tb-sub">{{ $item['student_nim'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-lead">{{ $item['type'] }}</span>
                                <span class="tb-sub text-primary">{{ $item['semester'] }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-lg">
                                <span class="tb-lead">Rp {{ number_format($item['amount'], 0, ',', '.') }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-lead">{{ \Carbon\Carbon::parse($item['date'])->format('d M Y') }}</span>
                                <span class="tb-sub">{{ \Carbon\Carbon::parse($item['date'])->format('H:i') }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                @if($item['status'] == 'lunas')
                                    <span class="badge badge-dot badge-success">Lunas</span>
                                @elseif($item['status'] == 'dihapus')
                                    <span class="badge badge-dot badge-danger">Dihapus</span>
                                @else
                                    <span class="badge badge-dot badge-warning">Diubah</span>
                                @endif
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-lead">{{ $item['action'] }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-lead">{{ $item['user'] }}</span>
                            </div>
                            <div class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#" onclick="viewDetail({{ $item['id'] }})"><em class="icon ni ni-eye"></em><span>Detail</span></a></li>
                                                    @if($item['status'] == 'lunas')
                                                        <li><a href="#" onclick="viewPayment({{ $item['id'] }})"><em class="icon ni ni-wallet"></em><span>Lihat Pembayaran</span></a></li>
                                                    @endif
                                                    <li><a href="#" onclick="printHistory({{ $item['id'] }})"><em class="icon ni ni-printer"></em><span>Cetak</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-inner">
                <div class="nk-block-between-md g-3">
                    <div class="g">
                        <ul class="pagination justify-content-center justify-content-md-start">
                            <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><span class="page-link">...</span></li>
                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </div>
                    <div class="g">
                        <div class="pagination-goto d-flex justify-content-center justify-content-md-end gx-3">
                            <div>Page</div>
                            <div>
                                <select class="form-select form-select-sm js-select2" data-search="off">
                                    <option value="page-1">1</option>
                                    <option value="page-2">2</option>
                                    <option value="page-4">4</option>
                                    <option value="page-5">5</option>
                                    <option value="page-6">6</option>
                                </select>
                            </div>
                            <div>OF 102</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Riwayat Piutang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="filter-status" class="form-label">Status</label>
                            <select class="form-select" id="filter-status" name="status">
                                <option value="">Semua Status</option>
                                <option value="lunas">Lunas</option>
                                <option value="dihapus">Dihapus</option>
                                <option value="diubah">Diubah</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="filter-type" class="form-label">Jenis Piutang</label>
                            <select class="form-select" id="filter-type" name="type">
                                <option value="">Semua Jenis</option>
                                <option value="SPP">SPP</option>
                                <option value="Uang Kuliah">Uang Kuliah</option>
                                <option value="Biaya Laboratorium">Biaya Laboratorium</option>
                                <option value="Biaya Praktikum">Biaya Praktikum</option>
                                <option value="Biaya Wisuda">Biaya Wisuda</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="filter-start-date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="filter-start-date" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="filter-end-date" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="filter-end-date" name="end_date">
                        </div>
                        <div class="col-md-6">
                            <label for="filter-min-amount" class="form-label">Jumlah Minimum</label>
                            <input type="number" class="form-control" id="filter-min-amount" name="min_amount" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label for="filter-max-amount" class="form-label">Jumlah Maksimum</label>
                            <input type="number" class="form-control" id="filter-max-amount" name="max_amount" placeholder="100000000">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="applyFilter()">Terapkan Filter</button>
                <button type="button" class="btn btn-white" onclick="resetFilter()">Reset</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Riwayat Piutang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.js-select2').select2();
        
        // Initialize date range picker
        $('#filter-start-date, #filter-end-date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
    
    function viewDetail(id) {
        // Show loading
        $('#detailContent').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $('#detailModal').modal('show');
        
        // Simulate loading detail data
        setTimeout(() => {
            $('#detailContent').html(`
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Mahasiswa</label>
                            <div class="form-control-wrap">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-primary">
                                        <span>JD</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text">John Doe</span>
                                        <span class="sub-text">123456789</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Jenis Piutang</label>
                            <div class="form-control-wrap">
                                <span class="lead-text">SPP</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Jumlah</label>
                            <div class="form-control-wrap">
                                <span class="lead-text">Rp 2.500.000</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <div class="form-control-wrap">
                                <span class="badge badge-dot badge-success">Lunas</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Aksi</label>
                            <div class="form-control-wrap">
                                <span class="lead-text">Pembayaran diterima</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Tanggal & Waktu</label>
                            <div class="form-control-wrap">
                                <span class="lead-text">10 Jan 2025, 14:30</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">User</label>
                            <div class="form-control-wrap">
                                <span class="lead-text">Admin Finance</span>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }, 1000);
    }
    
    function viewPayment(id) {
        // Redirect to payment detail
        window.location.href = '/payments/' + id;
    }
    
    function printHistory(id) {
        // Print history
        window.print();
    }
    
    function exportData() {
        // Export data functionality
        NioApp.Toast('Data sedang diproses untuk export...', 'info');
        
        // Simulate export process
        setTimeout(() => {
            NioApp.Toast('Export berhasil! File akan diunduh sebentar lagi.', 'success');
        }, 2000);
    }
    
    function applyFilter() {
        // Apply filter logic here
        $('#filterModal').modal('hide');
        NioApp.Toast('Filter berhasil diterapkan!', 'success');
    }
    
    function resetFilter() {
        document.getElementById('filterForm').reset();
        $('.js-select2').val(null).trigger('change');
    }
</script>
@endpush
