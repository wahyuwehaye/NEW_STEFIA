@extends('layouts.admin')

@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Edit Pembayaran #{{ $payment->payment_code }}</h3>
                </div>
                <div class="nk-block-head-content">
                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex">
                        <em class="icon ni ni-arrow-left"></em><span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="nk-block">
            <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row gy-4">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Mahasiswa</label>
                            <div class="form-control-wrap">
                                <select class="form-control" name="student_id" required>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ $student->id === $payment->student_id ? 'selected' : '' }}>{{ $student->name }} ({{ $student->nim }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Jumlah</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" name="amount" value="{{ $payment->amount }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Tanggal Pembayaran</label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" name="payment_date" value="{{ $payment->payment_date->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="form-control-wrap">
                                <select class="form-control" name="payment_method" required>
                                    <option value="cash" {{ $payment->payment_method === 'cash' ? 'selected' : '' }}>Tunai</option>
                                    <option value="bank_transfer" {{ $payment->payment_method === 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="credit_card" {{ $payment->payment_method === 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                                    <option value="debit_card" {{ $payment->payment_method === 'debit_card' ? 'selected' : '' }}>Kartu Debit</option>
                                    <option value="e_wallet" {{ $payment->payment_method === 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                    <option value="other" {{ $payment->payment_method === 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-label">Tipe Pembayaran</label>
                            <div class="form-control-wrap">
                                <select class="form-control" name="payment_type" required>
                                    <option value="tuition" {{ $payment->payment_type === 'tuition' ? 'selected' : '' }}>SPP</option>
                                    <option value="registration" {{ $payment->payment_type === 'registration' ? 'selected' : '' }}>Registrasi</option>
                                    <option value="exam" {{ $payment->payment_type === 'exam' ? 'selected' : '' }}>Ujian</option>
                                    <option value="library" {{ $payment->payment_type === 'library' ? 'selected' : '' }}>Perpustakaan</option>
                                    <option value="laboratory" {{ $payment->payment_type === 'laboratory' ? 'selected' : '' }}>Laboratorium</option>
                                    <option value="other" {{ $payment->payment_type === 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Nomor Referensi</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" name="reference_number" value="{{ $payment->reference_number }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" name="description">{{ $payment->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Catatan</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" name="notes">{{ $payment->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

