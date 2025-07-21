@extends('layouts.admin')

@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Detail Pembayaran #{{ $payment->payment_code }}</h3>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('payments.index') }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em><span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-lg-8">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h6 class="card-title">Informasi Pembayaran</h6>
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Kode Pembayaran</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->payment_code }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="form-control-wrap">
                                            @php
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'completed' => 'success',
                                                    'failed' => 'danger',
                                                    'cancelled' => 'secondary'
                                                ][$payment->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $statusClass }}">{{ $payment->status_label }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Jumlah</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->formatted_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Tanggal Pembayaran</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->payment_date->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->payment_method_label }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label">Tipe Pembayaran</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->payment_type_label }}</span>
                                        </div>
                                    </div>
                                </div>
                                @if($payment->reference_number)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Nomor Referensi</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->reference_number }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($payment->description)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Deskripsi</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->description }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($payment->notes)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Catatan</label>
                                        <div class="form-control-wrap">
                                            <span class="form-control">{{ $payment->notes }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h6 class="card-title">Data Mahasiswa</h6>
                            @if($payment->student)
                                <div class="user-card">
                                    <div class="user-info">
                                        <span class="lead-text">{{ $payment->student->name }}</span>
                                        <span class="sub-text">{{ $payment->student->nim }}</span>
                                    </div>
                                </div>
                            @else
                                <p>Data mahasiswa tidak tersedia</p>
                            @endif
                        </div>
                    </div>

                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h6 class="card-title">Aksi</h6>
                            <div class="btn-group-vertical w-100">
                                @if($payment->status === 'pending')
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary">
                                        <em class="icon ni ni-edit"></em> Edit
                                    </a>
                                    <form action="{{ route('payments.verify', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Yakin ingin verifikasi pembayaran ini?')">
                                            <em class="icon ni ni-check"></em> Verifikasi
                                        </button>
                                    </form>
                                @endif
                                
                                @if($payment->status === 'completed')
                                    <a href="{{ route('payments.receipt', $payment->id) }}" class="btn btn-secondary" target="_blank">
                                        <em class="icon ni ni-printer"></em> Cetak Kuitansi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card card-bordered">
                        <div class="card-inner">
                            <h6 class="card-title">Informasi Sistem</h6>
                            <div class="data-list">
                                <div class="data-item">
                                    <div class="data-col">
                                        <span class="data-label">Dibuat Oleh</span>
                                        <span class="data-value">{{ $payment->user->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="data-item">
                                    <div class="data-col">
                                        <span class="data-label">Tanggal Dibuat</span>
                                        <span class="data-value">{{ $payment->created_at->format('d F Y H:i') }}</span>
                                    </div>
                                </div>
                                @if($payment->verifiedBy)
                                <div class="data-item">
                                    <div class="data-col">
                                        <span class="data-label">Diverifikasi Oleh</span>
                                        <span class="data-value">{{ $payment->verifiedBy->name }}</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
