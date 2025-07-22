@extends('layouts.admin')

@section('title', 'Detail Piutang')

@section('content')
<x-page-header 
    title="Detail Piutang" 
    subtitle="Informasi lengkap piutang mahasiswa">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('receivables.edit', $id) }}" class="btn btn-primary"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
            <li><a href="{{ route('receivables.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="row g-gs">
        <!-- Piutang Info -->
        <div class="col-lg-8">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="nk-block-head">
                        <h6 class="title">Informasi Piutang</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Jenis Piutang</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="SPP" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Semester</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="8" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Tahun Akademik</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="2024/2025" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Jumlah Piutang</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="Rp 20.000.000" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Tagihan</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="15 Januari 2024" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Jatuh Tempo</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-danger" value="15 Februari 2024" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <div class="form-control-wrap">
                                    <span class="badge badge-dot badge-danger">Tunggakan</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-label">Hari Terlambat</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-danger" value="320 hari" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-label">Keterangan</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control" rows="3" readonly>Pembayaran SPP semester 8 masih belum lunas. Sudah dikirim reminder via email dan WhatsApp.</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Summary -->
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="nk-block-head">
                        <h6 class="title">Ringkasan Pembayaran</h6>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Total Tagihan</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" value="Rp 20.000.000" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Total Dibayar</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-success" value="Rp 5.000.000" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Sisa Piutang</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control text-danger" value="Rp 15.000.000" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Persentase Terbayar</label>
                                <div class="form-control-wrap">
                                    <div class="progress progress-md">
                                        <div class="progress-bar" data-progress="25"></div>
                                    </div>
                                    <div class="progress-percent">25%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Student Information -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-block-head">
                <h6 class="title">Informasi Mahasiswa</h6>
            </div>
            <div class="row g-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">NIM</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="2019001" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="Ahmad Fauzi" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Fakultas</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="Teknik" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Program Studi</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="Teknik Informatika" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Angkatan</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="2019" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Telepon</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="081234567890" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="ahmad.fauzi@email.com" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-control-wrap">
                            <span class="badge badge-dot badge-success">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment History -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-block-head">
                <h6 class="title">Riwayat Pembayaran</h6>
            </div>
            <div class="nk-tb-list">
                <div class="nk-tb-item nk-tb-head">
                    <div class="nk-tb-col"><span>Tanggal</span></div>
                    <div class="nk-tb-col"><span>Jumlah</span></div>
                    <div class="nk-tb-col"><span>Metode</span></div>
                    <div class="nk-tb-col"><span>Status</span></div>
                    <div class="nk-tb-col"><span>Keterangan</span></div>
                </div>
                <div class="nk-tb-item">
                    <div class="nk-tb-col">
                        <span class="tb-sub">10 Maret 2024</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-amount text-success">Rp 5.000.000</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Transfer Bank</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="badge badge-dot badge-success">Verified</span>
                    </div>
                    <div class="nk-tb-col">
                        <span class="tb-sub">Pembayaran parsial SPP</span>
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
                        <a href="{{ route('payments.create', ['debt_id' => $id]) }}" class="btn btn-success">
                            <em class="icon ni ni-wallet"></em>
                            <span>Input Pembayaran</span>
                        </a>
                        <a href="#" class="btn btn-info" onclick="sendReminder()">
                            <em class="icon ni ni-mail"></em>
                            <span>Kirim Reminder</span>
                        </a>
                        <a href="#" class="btn btn-warning" onclick="printInvoice()">
                            <em class="icon ni ni-printer"></em>
                            <span>Cetak Invoice</span>
                        </a>
                        <a href="{{ route('receivables.edit', $id) }}" class="btn btn-primary">
                            <em class="icon ni ni-edit"></em>
                            <span>Edit Piutang</span>
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
    // Initialize progress bar
    $('.progress-bar').each(function() {
        var progress = $(this).data('progress');
        $(this).css('width', progress + '%');
    });
});

function sendReminder() {
    if (confirm('Apakah Anda yakin ingin mengirim reminder kepada mahasiswa?')) {
        // TODO: Implement send reminder logic
        alert('Reminder berhasil dikirim!');
    }
}

function printInvoice() {
    // TODO: Implement print invoice logic
    window.print();
}
</script>
@endpush
