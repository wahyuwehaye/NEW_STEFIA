@extends('layouts.admin')

@section('title', 'Piutang Tunggakan')

@section('content')
<x-page-header 
    title="Piutang Tunggakan" 
    subtitle="Daftar piutang yang belum lunas">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li>
                <a href="#" class="btn btn-white btn-outline-light" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <em class="icon ni ni-filter"></em><span>Filter</span>
                </a>
            </li>
            <li>
                <a href="{{ route('receivables.create') }}" class="btn btn-primary">
                    <em class="icon ni ni-plus"></em><span>Tambah Piutang</span>
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
                            <h6 class="title">Total Tunggakan</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total piutang yang belum lunas"></em>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">Rp 156.750.000</span>
                        <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>12.37%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Jumlah Mahasiswa</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Jumlah mahasiswa yang memiliki tunggakan"></em>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">89</span>
                        <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>4.63%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Tunggakan > 30 Hari</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Tunggakan yang sudah lewat 30 hari"></em>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">23</span>
                        <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>2.45%</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Rata-rata Tunggakan</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Rata-rata jumlah tunggakan per mahasiswa"></em>
                        </div>
                    </div>
                    <div class="card-amount">
                        <span class="amount">Rp 1.760.000</span>
                        <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>7.28%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Outstanding Receivables Table -->
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
                                    <option value="overdue">Jatuh Tempo</option>
                                    <option value="critical">Kritis (>30 hari)</option>
                                    <option value="warning">Peringatan (>7 hari)</option>
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
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="selectAll">
                                <label class="custom-control-label" for="selectAll"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col"><span class="sub-text">Mahasiswa</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Jenis Piutang</span></div>
                        <div class="nk-tb-col tb-col-lg"><span class="sub-text">Jumlah</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Jatuh Tempo</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Hari Terlambat</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">
                            <div class="dropdown">
                                <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                    <ul class="link-tidy sm">
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="action-send-reminder">
                                                <label class="custom-control-label" for="action-send-reminder">Kirim Reminder</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="action-mark-paid">
                                                <label class="custom-control-label" for="action-mark-paid">Tandai Lunas</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @php
                        $outstandingReceivables = [
                            [
                                'id' => 1,
                                'student_name' => 'John Doe',
                                'student_nim' => '123456789',
                                'student_email' => 'john@example.com',
                                'type' => 'SPP',
                                'amount' => 2500000,
                                'due_date' => '2024-12-15',
                                'overdue_days' => 27,
                                'status' => 'critical',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 2,
                                'student_name' => 'Jane Smith',
                                'student_nim' => '987654321',
                                'student_email' => 'jane@example.com',
                                'type' => 'Biaya Laboratorium',
                                'amount' => 1500000,
                                'due_date' => '2025-01-02',
                                'overdue_days' => 9,
                                'status' => 'warning',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 3,
                                'student_name' => 'Bob Johnson',
                                'student_nim' => '456789123',
                                'student_email' => 'bob@example.com',
                                'type' => 'Uang Kuliah',
                                'amount' => 3200000,
                                'due_date' => '2024-11-30',
                                'overdue_days' => 42,
                                'status' => 'critical',
                                'semester' => 'Ganjil 2024/2025'
                            ],
                            [
                                'id' => 4,
                                'student_name' => 'Alice Brown',
                                'student_nim' => '789123456',
                                'student_email' => 'alice@example.com',
                                'type' => 'SPP',
                                'amount' => 2500000,
                                'due_date' => '2025-01-05',
                                'overdue_days' => 6,
                                'status' => 'overdue',
                                'semester' => 'Ganjil 2024/2025'
                            ]
                        ];
                    @endphp
                    
                    @foreach($outstandingReceivables as $receivable)
                        <div class="nk-tb-item">
                            <div class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="receivable{{ $receivable['id'] }}">
                                    <label class="custom-control-label" for="receivable{{ $receivable['id'] }}"></label>
                                </div>
                            </div>
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-primary">
                                        <span>{{ substr($receivable['student_name'], 0, 2) }}</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="tb-lead">{{ $receivable['student_name'] }}</span>
                                        <span class="tb-sub">{{ $receivable['student_nim'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-lead">{{ $receivable['type'] }}</span>
                                <span class="tb-sub text-primary">{{ $receivable['semester'] }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-lg">
                                <span class="tb-lead">Rp {{ number_format($receivable['amount'], 0, ',', '.') }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-lead">{{ \Carbon\Carbon::parse($receivable['due_date'])->format('d M Y') }}</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-lead 
                                    @if($receivable['overdue_days'] > 30) text-danger 
                                    @elseif($receivable['overdue_days'] > 7) text-warning 
                                    @else text-info @endif">
                                    {{ $receivable['overdue_days'] }} hari
                                </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                @if($receivable['status'] == 'critical')
                                    <span class="badge badge-dot badge-danger">Kritis</span>
                                @elseif($receivable['status'] == 'warning')
                                    <span class="badge badge-dot badge-warning">Peringatan</span>
                                @else
                                    <span class="badge badge-dot badge-info">Terlambat</span>
                                @endif
                            </div>
                            <div class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="{{ route('receivables.show', $receivable['id']) }}"><em class="icon ni ni-eye"></em><span>Detail</span></a></li>
                                                    <li><a href="{{ route('receivables.edit', $receivable['id']) }}"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                    <li><a href="#" class="send-reminder" data-id="{{ $receivable['id'] }}"><em class="icon ni ni-mail"></em><span>Kirim Reminder</span></a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" class="text-danger" onclick="confirmDelete({{ $receivable['id'] }})"><em class="icon ni ni-trash"></em><span>Hapus</span></a></li>
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
                <h5 class="modal-title" id="filterModalLabel">Filter Piutang Tunggakan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="filter-program" class="form-label">Program Studi</label>
                            <select class="form-select" id="filter-program" name="program">
                                <option value="">Semua Program</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                                <option value="Manajemen">Manajemen</option>
                                <option value="Akuntansi">Akuntansi</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="filter-level" class="form-label">Jenjang</label>
                            <select class="form-select" id="filter-level" name="level">
                                <option value="">Semua Jenjang</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
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
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="filter-overdue" class="form-label">Hari Terlambat</label>
                            <select class="form-select" id="filter-overdue" name="overdue">
                                <option value="">Semua</option>
                                <option value="0-7">0-7 hari</option>
                                <option value="8-30">8-30 hari</option>
                                <option value="31-60">31-60 hari</option>
                                <option value="60+">Lebih dari 60 hari</option>
                            </select>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.js-select2').select2();
        
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Send reminder functionality
        $('.send-reminder').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            
            Swal.fire({
                title: 'Kirim Reminder?',
                text: 'Apakah Anda yakin ingin mengirim reminder pembayaran ke mahasiswa ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Kirim!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Here you would make an AJAX call to send reminder
                    Swal.fire(
                        'Berhasil!',
                        'Reminder telah dikirim ke mahasiswa.',
                        'success'
                    );
                }
            });
        });
        
        // Select all checkbox
        $('#selectAll').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('input[type="checkbox"][id^="receivable"]').prop('checked', isChecked);
        });
    });
    
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Piutang?',
            text: 'Apakah Anda yakin ingin menghapus piutang ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Here you would make an AJAX call to delete
                Swal.fire(
                    'Berhasil!',
                    'Piutang telah dihapus.',
                    'success'
                );
            }
        });
    }
    
    function applyFilter() {
        // Apply filter logic here
        $('#filterModal').modal('hide');
        
        // Show loading or refresh table
        NioApp.Toast('Filter berhasil diterapkan!', 'success');
    }
    
    function resetFilter() {
        document.getElementById('filterForm').reset();
        $('.js-select2').val(null).trigger('change');
    }
</script>
@endpush
