@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')
<x-page-header 
    title="Detail Mahasiswa" 
    subtitle="Informasi lengkap data mahasiswa">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('students.edit', $id) }}" class="btn btn-primary"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
            <li><a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="row g-gs">
        <!-- Profile Card -->
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="user-card">
                        <div class="user-avatar user-avatar-lg bg-primary">
                            <span>AF</span>
                        </div>
                        <div class="user-info">
                            <h5 class="user-name">Ahmad Fauzi</h5>
                            <span class="user-title">2019001</span>
                        </div>
                    </div>
                    <div class="user-meta">
                        <div class="user-meta-item">
                            <span class="user-meta-label">Fakultas:</span>
                            <span class="user-meta-value">Teknik</span>
                        </div>
                        <div class="user-meta-item">
                            <span class="user-meta-label">Program Studi:</span>
                            <span class="user-meta-value">Teknik Informatika</span>
                        </div>
                        <div class="user-meta-item">
                            <span class="user-meta-label">Angkatan:</span>
                            <span class="user-meta-value">2019</span>
                        </div>
                        <div class="user-meta-item">
                            <span class="user-meta-label">Semester:</span>
                            <span class="user-meta-value">8</span>
                        </div>
                        <div class="user-meta-item">
                            <span class="user-meta-label">Status:</span>
                            <span class="badge badge-dot badge-success">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Details -->
        <div class="col-lg-8">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="nk-block-head">
                        <h6 class="title">Informasi Mahasiswa</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">NIM</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="2019001" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="Ahmad Fauzi" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Fakultas</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="Teknik" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Program Studi</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="Teknik Informatika" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Angkatan</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="2019" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Semester Saat Ini</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="8" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Status Registrasi</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="Aktif" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Status Mahasiswa</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="Aktif" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Telepon</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="081234567890" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="ahmad.fauzi@email.com" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" rows="3" readonly>Jl. Sudirman No. 123, Jakarta Pusat, DKI Jakarta</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Parent Information -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-block-head">
                <h6 class="title">Informasi Orang Tua</h6>
            </div>
            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Nama Ayah</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="Budi Santoso" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Nama Ibu</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="Siti Nurhaliza" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="Pegawai Negeri Sipil" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="Ibu Rumah Tangga" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Telepon Orang Tua</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="081234567891" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="form-label">Alamat Orang Tua</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control" rows="3" readonly>Jl. Merdeka No. 456, Bandung, Jawa Barat</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-block-head">
                <h6 class="title">Ringkasan Keuangan</h6>
            </div>
            <div class="row g-gs">
                <div class="col-sm-6 col-lg-3">
                    <div class="statbox">
                        <div class="statbox-body">
                            <h6 class="statbox-title">Total Tagihan</h6>
                            <div class="statbox-text">Rp 20.000.000</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="statbox">
                        <div class="statbox-body">
                            <h6 class="statbox-title">Total Dibayar</h6>
                            <div class="statbox-text text-success">Rp 5.000.000</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="statbox">
                        <div class="statbox-body">
                            <h6 class="statbox-title">Total Piutang</h6>
                            <div class="statbox-text text-danger">Rp 15.000.000</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="statbox">
                        <div class="statbox-body">
                            <h6 class="statbox-title">Semester Menunggak</h6>
                            <div class="statbox-text text-warning">3</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-block-head">
                <h6 class="title">Tindakan</h6>
            </div>
            <div class="row g-3">
                <div class="col-lg-12">
                    <div class="btn-group" role="group">
                        <a href="{{ route('receivables.create', ['student_id' => $id]) }}" class="btn btn-primary">
                            <em class="icon ni ni-plus"></em>
                            <span>Tambah Piutang</span>
                        </a>
                        <a href="{{ route('payments.create', ['student_id' => $id]) }}" class="btn btn-success">
                            <em class="icon ni ni-wallet"></em>
                            <span>Input Pembayaran</span>
                        </a>
                        <a href="{{ route('receivables.history', ['student_id' => $id]) }}" class="btn btn-info">
                            <em class="icon ni ni-clock"></em>
                            <span>Riwayat Piutang</span>
                        </a>
                        <a href="{{ route('payments.history', ['student_id' => $id]) }}" class="btn btn-warning">
                            <em class="icon ni ni-file-text"></em>
                            <span>Riwayat Pembayaran</span>
                        </a>
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
    // Any specific functionality for the show page
    console.log('Student detail page loaded');
});
</script>
@endpush
