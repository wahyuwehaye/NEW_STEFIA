@extends('layouts.admin')

@section('title', 'Input Pembayaran')

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Input Pembayaran</h3>
                <div class="nk-block-des text-soft">
                    <p>Formulir untuk menginput pembayaran mahasiswa</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li><a href="{{ route('payments.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <!-- Mahasiswa Selection -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label" for="student_id">Mahasiswa <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="student_id" name="student_id" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    <option value="1">Ahmad Fauzi [2019001] - Teknik Informatika</option>
                                    <option value="2">Siti Nurhaliza [2020002] - Sistem Informasi</option>
                                    <option value="3">Budi Santoso [2018003] - Teknik Elektro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Outstanding Receivables -->
                    <div class="col-lg-12" id="outstanding-receivables" style="display: none;">
                        <div class="card">
                            <div class="card-inner">
                                <div class="card-title">
                                    <h6 class="title">Piutang Belum Lunas</h6>
                                </div>
                                <div class="nk-tb-list nk-tb-list-s1">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span>Jenis</span></div>
                                        <div class="nk-tb-col"><span>Semester</span></div>
                                        <div class="nk-tb-col"><span>Jumlah</span></div>
                                        <div class="nk-tb-col"><span>Jatuh Tempo</span></div>
                                        <div class="nk-tb-col"><span>Status</span></div>
                                        <div class="nk-tb-col"><span>Bayar</span></div>
                                    </div>
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <span>SPP</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span>8</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="text-danger">Rp 15.000.000</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="text-danger">15 Feb 2024</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <span class="badge badge-dot badge-danger">Tunggakan</span>
                                        </div>
                                        <div class="nk-tb-col">
                                            <div class="custom-control custom-control-sm custom-checkbox">
                                                <input type="checkbox" class="custom-control-input receivable-checkbox" id="receivable-1" value="1">
                                                <label class="custom-control-label" for="receivable-1"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="payment_type">Jenis Pembayaran <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="payment_type" name="payment_type" required>
                                    <option value="">Pilih Jenis Pembayaran</option>
                                    <option value="SPP">SPP</option>
                                    <option value="Praktikum">Praktikum</option>
                                    <option value="Seminar">Seminar</option>
                                    <option value="Skripsi">Skripsi</option>
                                    <option value="Wisuda">Wisuda</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="amount">Jumlah Pembayaran <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Masukkan jumlah pembayaran" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="payment_method">Metode Pembayaran <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="payment_method" name="payment_method" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Transfer Bank</option>
                                    <option value="virtual_account">Virtual Account</option>
                                    <option value="e_wallet">E-Wallet</option>
                                    <option value="credit_card">Credit Card</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="payment_date">Tanggal Pembayaran <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bank Transfer Details -->
                    <div class="col-lg-12" id="bank-transfer-details" style="display: none;">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="bank_name">Nama Bank</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Masukkan nama bank">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="account_number">Nomor Rekening</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Masukkan nomor rekening">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="reference_number">Nomor Referensi</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="reference_number" name="reference_number" placeholder="Masukkan nomor referensi">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="payment_proof">Bukti Pembayaran</label>
                            <div class="form-control-wrap">
                                <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*,application/pdf">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label" for="notes">Catatan</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Masukkan catatan tambahan"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <em class="icon ni ni-save"></em>
                                <span>Simpan Pembayaran</span>
                            </button>
                            <button type="submit" name="action" value="save_and_verify" class="btn btn-success">
                                <em class="icon ni ni-check"></em>
                                <span>Simpan & Verifikasi</span>
                            </button>
                            <a href="{{ route('payments.index') }}" class="btn btn-outline-light">
                                <em class="icon ni ni-arrow-left"></em>
                                <span>Batal</span>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.js-select2').select2({
        minimumResultsForSearch: Infinity
    });
    
    // Set today's date as default
    $('#payment_date').val(new Date().toISOString().split('T')[0]);
    
    // Show/hide bank transfer details
    $('#payment_method').on('change', function() {
        const method = $(this).val();
        if (method === 'bank_transfer') {
            $('#bank-transfer-details').show();
        } else {
            $('#bank-transfer-details').hide();
        }
    });
    
    // Load outstanding receivables when student is selected
    $('#student_id').on('change', function() {
        const studentId = $(this).val();
        if (studentId) {
            // TODO: Load outstanding receivables via AJAX
            $('#outstanding-receivables').show();
        } else {
            $('#outstanding-receivables').hide();
        }
    });
    
    // Auto-fill amount when receivable is selected
    $('.receivable-checkbox').on('change', function() {
        if ($(this).is(':checked')) {
            // TODO: Auto-fill amount based on selected receivable
            const amount = 15000000; // Example amount
            $('#amount').val(amount);
        }
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        let isValid = true;
        
        // Check required fields
        $('input[required], select[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        // Check if amount is valid
        const amount = parseFloat($('#amount').val());
        if (isNaN(amount) || amount <= 0) {
            isValid = false;
            $('#amount').addClass('is-invalid');
            alert('Jumlah pembayaran harus lebih dari 0');
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi!');
        }
    });
});
</script>
@endpush
