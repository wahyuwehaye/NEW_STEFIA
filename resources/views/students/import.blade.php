@extends('layouts.admin')

@section('title', 'Import Data Mahasiswa')

@section('content')
<x-page-header 
    title="Import Data Mahasiswa" 
    subtitle="Import data mahasiswa dari file Excel atau CSV">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download"></em><span>Download Template</span></a></li>
            <li><a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Import Form -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-lg-8">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Upload File Data Mahasiswa</h6>
                        </div>
                        <div class="card-tools">
                            <a href="#" class="link" data-bs-toggle="modal" data-bs-target="#modalInstructions">
                                <em class="icon ni ni-question"></em>
                                <span>Panduan Import</span>
                            </a>
                        </div>
                    </div>
                    
                    <form action="{{ route('students.process-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Pilih File Excel atau CSV</label>
                                    <div class="form-control-wrap">
                                        <div class="form-file">
                                            <input type="file" class="form-file-input" id="customFile" name="import_file" accept=".xlsx,.xls,.csv" required>
                                            <label class="form-file-label" for="customFile">Pilih file...</label>
                                        </div>
                                    </div>
                                    <div class="form-note">
                                        <span>Format yang didukung: Excel (.xlsx, .xls) dan CSV (.csv). Maksimal ukuran file 10MB.</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Mode Import</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control" name="import_mode" required>
                                            <option value="new">Tambah Data Baru</option>
                                            <option value="update">Update Data Existing</option>
                                            <option value="upsert">Tambah/Update (Upsert)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Kolom Pencocokan</label>
                                    <div class="form-control-wrap">
                                        <select class="form-control" name="match_column">
                                            <option value="nim">NIM</option>
                                            <option value="email">Email</option>
                                            <option value="name">Nama Lengkap</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="skip_header" name="skip_header" checked>
                                        <label class="custom-control-label" for="skip_header">Lewati baris pertama (header)</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="validate_data" name="validate_data" checked>
                                        <label class="custom-control-label" for="validate_data">Validasi data sebelum import</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-upload"></em>
                                        <span>Mulai Import</span>
                                    </button>
                                    <button type="reset" class="btn btn-light">
                                        <em class="icon ni ni-reload"></em>
                                        <span>Reset</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Format Data yang Dibutuhkan</h6>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <h6 class="title">Kolom Wajib:</h6>
                        <ul class="list list-sm list-checked">
                            <li><em class="icon ni ni-check"></em><span>NIM (Nomor Induk Mahasiswa)</span></li>
                            <li><em class="icon ni ni-check"></em><span>Nama Lengkap</span></li>
                            <li><em class="icon ni ni-check"></em><span>Email</span></li>
                            <li><em class="icon ni ni-check"></em><span>Jurusan</span></li>
                            <li><em class="icon ni ni-check"></em><span>Angkatan</span></li>
                        </ul>
                    </div>
                    
                    <div class="nk-block">
                        <h6 class="title">Kolom Opsional:</h6>
                        <ul class="list list-sm list-checked">
                            <li><em class="icon ni ni-check-circle"></em><span>Semester</span></li>
                            <li><em class="icon ni ni-check-circle"></em><span>No. Telepon</span></li>
                            <li><em class="icon ni ni-check-circle"></em><span>Alamat</span></li>
                            <li><em class="icon ni ni-check-circle"></em><span>Status</span></li>
                        </ul>
                    </div>
                    
                    <div class="nk-block">
                        <div class="alert alert-pro alert-info">
                            <div class="alert-text">
                                <h6>Tips Import</h6>
                                <p>Pastikan format NIM dan email unik untuk setiap mahasiswa. Gunakan template yang disediakan untuk memudahkan proses import.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Import History -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Riwayat Import Terbaru</h6>
                </div>
                <div class="card-tools">
                    <ul class="card-tools-nav">
                        <li><a href="#"><span>Lihat Semua</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-inner p-0">
            <div class="nk-tb-list">
                <div class="nk-tb-item nk-tb-head">
                    <div class="nk-tb-col"><span>Tanggal</span></div>
                    <div class="nk-tb-col"><span>File</span></div>
                    <div class="nk-tb-col"><span>Status</span></div>
                    <div class="nk-tb-col"><span>Total Record</span></div>
                    <div class="nk-tb-col"><span>Berhasil</span></div>
                    <div class="nk-tb-col"><span>Gagal</span></div>
                    <div class="nk-tb-col nk-tb-col-tools"><span>&nbsp;</span></div>
                </div>
                
                <!-- Sample Data -->
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ date('d M Y H:i') }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">mahasiswa_2024.xlsx</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Selesai</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">150</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">147</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-danger">3</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Log">
                                    <em class="icon ni ni-download"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    <em class="icon ni ni-eye"></em>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-lead">{{ date('d M Y H:i', strtotime('-1 day')) }}</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">mahasiswa_baru.csv</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-warning">Proses</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">75</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-success">65</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub text-danger">10</span>
                    </div>
                    <div class="nk-tb-col nk-tb-col-tools">
                        <ul class="nk-tb-actions gx-1 my-n1">
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Download Log">
                                    <em class="icon ni ni-download"></em>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-icon btn-trigger" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Detail">
                                    <em class="icon ni ni-eye"></em>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Instructions Modal -->
<div class="modal fade" id="modalInstructions" tabindex="-1" aria-labelledby="modalInstructionsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInstructionsLabel">Panduan Import Data Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="nk-block">
                    <h6>Langkah-langkah Import:</h6>
                    <ol>
                        <li>Download template Excel/CSV yang sudah disediakan</li>
                        <li>Isi data mahasiswa sesuai dengan format yang telah ditentukan</li>
                        <li>Pastikan NIM dan email unik untuk setiap mahasiswa</li>
                        <li>Simpan file dalam format .xlsx, .xls, atau .csv</li>
                        <li>Upload file melalui form di atas</li>
                        <li>Pilih mode import yang sesuai</li>
                        <li>Klik "Mulai Import" dan tunggu proses selesai</li>
                    </ol>
                </div>
                
                <div class="nk-block">
                    <h6>Format Data yang Benar:</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jurusan</th>
                                    <th>Angkatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>2019001</td>
                                    <td>Ahmad Fauzi</td>
                                    <td>ahmad.fauzi@student.ac.id</td>
                                    <td>Teknik Informatika</td>
                                    <td>2019</td>
                                </tr>
                                <tr>
                                    <td>2020002</td>
                                    <td>Siti Nurhaliza</td>
                                    <td>siti.nurhaliza@student.ac.id</td>
                                    <td>Sistem Informasi</td>
                                    <td>2020</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // File input change handler
    $('.form-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.form-file-label').text(fileName || 'Pilih file...');
    });
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush
