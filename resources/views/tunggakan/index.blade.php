@extends('layouts.admin')

@section('title', 'Laporan Tunggakan > 10 Juta')

@section('content')
<x-page-header 
    title="Laporan Tunggakan > 10 Juta" 
    subtitle="Laporan mahasiswa dengan tunggakan diatas 10 juta rupiah">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('tunggakan.actions') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-activity"></em><span>Riwayat Tindakan</span></a></li>
            <li><a href="{{ route('tunggakan.export') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-download"></em><span>Export Data</span></a></li>
            <li class="nk-block-tools-opt"><a href="{{ route('tunggakan.actions.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Tindakan</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Summary Cards -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Total Tunggakan" 
            value="Rp {{ number_format(array_sum(array_column($tunggakan, 'total_tunggakan')), 0, ',', '.') }}" 
            change="2.5%" 
            changeType="down" 
            tooltip="Total keseluruhan tunggakan >10 juta" />
            
        <x-stats-card 
            title="Jumlah Mahasiswa" 
            value="{{ count($tunggakan) }}" 
            change="5%" 
            changeType="up" 
            tooltip="Jumlah mahasiswa dengan tunggakan >10 juta" />
            
        <x-stats-card 
            title="Follow-up Belum" 
            value="{{ count(array_filter($tunggakan, function($item) { return $item['status_home_visit'] == 'Belum'; })) }}" 
            change="8%" 
            changeType="down" 
            tooltip="Mahasiswa yang belum mendapat follow-up lengkap" />
            
        <x-stats-card 
            title="Follow-up Selesai" 
            value="{{ count(array_filter($tunggakan, function($item) { return $item['status_home_visit'] == 'Sudah'; })) }}" 
            change="12%" 
            changeType="up" 
            tooltip="Mahasiswa yang sudah mendapat follow-up lengkap" />
    </div>
</div>

<!-- Filter Section -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="row g-3 align-center">
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
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Status NDE</label>
                        <div class="form-control-wrap">
                            <select class="form-control">
                                <option value="">Semua Status</option>
                                <option value="Sudah">Sudah</option>
                                <option value="Belum">Belum</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Home Visit</label>
                        <div class="form-control-wrap">
                            <select class="form-control">
                                <option value="">Semua Status</option>
                                <option value="Sudah">Sudah</option>
                                <option value="Belum">Belum</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="form-label">Minimum Tunggakan</label>
                        <div class="form-control-wrap">
                            <input type="number" class="form-control" placeholder="10000000" value="10000000">
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

<!-- Tunggakan Table -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Daftar Mahasiswa dengan Tunggakan >10 Juta</h6>
                </div>
                <div class="card-tools">
                    <ul class="card-tools-nav">
                        <li><a href="#"><span>Refresh Data</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-inner p-0">
            <div class="nk-tb-list">
                <div class="nk-tb-item nk-tb-head">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="checkAll">
                            <label class="custom-control-label" for="checkAll"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col"><span>Mahasiswa</span></div>
                    <div class="nk-tb-col"><span>Jurusan</span></div>
                    <div class="nk-tb-col"><span>Semester</span></div>
                    <div class="nk-tb-col"><span>Total Tunggakan</span></div>
                    <div class="nk-tb-col"><span>Pembayaran Terakhir</span></div>
                    <div class="nk-tb-col"><span>Status Tindakan</span></div>
                    <div class="nk-tb-col nk-tb-col-tools"><span>&nbsp;</span></div>
                </div>
                @foreach($tunggakan as $item)
                <div class="nk-tb-item">
                    <div class="nk-tb-col nk-tb-col-check">
                        <div class="custom-control custom-control-sm custom-checkbox notext">
                            <input type="checkbox" class="custom-control-input" id="check{{ $item['id'] }}">
                            <label class="custom-control-label" for="check{{ $item['id'] }}"></label>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <div class="user-card">
                            <div class="user-avatar user-avatar-sm bg-{{ $item['total_tunggakan'] > 15000000 ? 'danger' : 'warning' }}">
                                <span>{{ strtoupper(substr($item['student_name'], 0, 2)) }}</span>
                            </div>
                            <div class="user-name">
                                <span class="tb-lead">{{ $item['student_name'] }}</span>
                                <span class="tb-sub">{{ $item['nim'] }} - {{ $item['angkatan'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">{{ $item['jurusan'] }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">{{ $item['semester'] }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-danger">Rp {{ number_format($item['total_tunggakan'], 0, ',', '.') }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">{{ date('d M Y', strtotime($item['last_payment'])) }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <div class="progress-list">
                            <div class="progress-wrap">
                                <div class="progress-text">
                                    <div class="progress-label">Progress Follow-up</div>
                                    <div class="progress-amount">{{ $progress = (($item['status_nde'] == 'Sudah' ? 1 : 0) + ($item['status_dosen_wali'] == 'Sudah' ? 1 : 0) + ($item['status_surat'] == 'Sudah' ? 1 : 0) + ($item['status_telepon'] == 'Sudah' ? 1 : 0) + ($item['status_home_visit'] == 'Sudah' ? 1 : 0)) * 20 }}%</div>
                                </div>
                                <div class="progress progress-md">
                                    <div class="progress-bar bg-{{ $progress >= 80 ? 'success' : ($progress >= 50 ? 'warning' : 'danger') }}" data-progress="{{ $progress }}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item['id'] }}"><em class="icon ni ni-eye"></em></a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="modal" data-bs-target="#modalUpdate{{ $item['id'] }}"><em class="icon ni ni-edit"></em></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="link-list-opt no-bdr">
                                        <li><a href="#"><em class="icon ni ni-mail"></em><span>Kirim Reminder</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-phone"></em><span>Telepon</span></a></li>
                                        <li><a href="#"><em class="icon ni ni-home"></em><span>Jadwalkan Home Visit</span></a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><em class="icon ni ni-file-text"></em><span>Buat Laporan</span></a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Detail Modal -->
                <div class="modal fade" id="modalDetail{{ $item['id'] }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $item['id'] }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDetailLabel{{ $item['id'] }}">Detail Tunggakan - {{ $item['student_name'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Nama Mahasiswa</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" value="{{ $item['student_name'] }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">NIM</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" value="{{ $item['nim'] }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Jurusan</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" value="{{ $item['jurusan'] }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">Total Tunggakan</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" value="Rp {{ number_format($item['total_tunggakan'], 0, ',', '.') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h6>Status Tindakan Follow-up</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="nde{{ $item['id'] }}" {{ $item['status_nde'] == 'Sudah' ? 'checked' : '' }} disabled>
                                            <label class="custom-control-label" for="nde{{ $item['id'] }}">NDE (Tidak Diperkenankan Evaluasi)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="dosen{{ $item['id'] }}" {{ $item['status_dosen_wali'] == 'Sudah' ? 'checked' : '' }} disabled>
                                            <label class="custom-control-label" for="dosen{{ $item['id'] }}">Pemberitahuan Dosen Wali</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="surat{{ $item['id'] }}" {{ $item['status_surat'] == 'Sudah' ? 'checked' : '' }} disabled>
                                            <label class="custom-control-label" for="surat{{ $item['id'] }}">Surat Peringatan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="telepon{{ $item['id'] }}" {{ $item['status_telepon'] == 'Sudah' ? 'checked' : '' }} disabled>
                                            <label class="custom-control-label" for="telepon{{ $item['id'] }}">Telepon</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="home{{ $item['id'] }}" {{ $item['status_home_visit'] == 'Sudah' ? 'checked' : '' }} disabled>
                                            <label class="custom-control-label" for="home{{ $item['id'] }}">Home Visit</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize progress bars
    $('.progress-bar').each(function() {
        var progress = $(this).data('progress');
        $(this).css('width', progress + '%');
    });
    
    // Check all functionality
    $('#checkAll').on('change', function() {
        $('input[type="checkbox"]').not(this).prop('checked', this.checked);
    });
});
</script>
@endpush
