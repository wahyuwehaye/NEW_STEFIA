@extends('layouts.admin')

@section('title', 'Edit Piutang')

@section('content')
<x-page-header 
    title="Edit Piutang" 
    subtitle="Edit data piutang mahasiswa">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('receivables.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card card-bordered">
                <div class="card-inner">
                    <form action="{{ route('receivables.update', $receivable->id ?? 1) }}" method="POST" class="form-validate">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-gs">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="student_id">Mahasiswa <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-search="on" id="student_id" name="student_id" required>
                                            <option value="">Pilih Mahasiswa</option>
                                            <option value="1" {{ old('student_id', $receivable->student_id ?? '1') == '1' ? 'selected' : '' }}>John Doe - 123456789</option>
                                            <option value="2" {{ old('student_id', $receivable->student_id ?? '') == '2' ? 'selected' : '' }}>Jane Smith - 987654321</option>
                                            <option value="3" {{ old('student_id', $receivable->student_id ?? '') == '3' ? 'selected' : '' }}>Bob Johnson - 456789123</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="type">Jenis Piutang <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="type" name="type" required>
                                            <option value="">Pilih Jenis Piutang</option>
                                            <option value="SPP" {{ old('type', $receivable->type ?? 'SPP') == 'SPP' ? 'selected' : '' }}>SPP</option>
                                            <option value="Uang Kuliah" {{ old('type', $receivable->type ?? '') == 'Uang Kuliah' ? 'selected' : '' }}>Uang Kuliah</option>
                                            <option value="Biaya Laboratorium" {{ old('type', $receivable->type ?? '') == 'Biaya Laboratorium' ? 'selected' : '' }}>Biaya Laboratorium</option>
                                            <option value="Biaya Praktikum" {{ old('type', $receivable->type ?? '') == 'Biaya Praktikum' ? 'selected' : '' }}>Biaya Praktikum</option>
                                            <option value="Biaya Wisuda" {{ old('type', $receivable->type ?? '') == 'Biaya Wisuda' ? 'selected' : '' }}>Biaya Wisuda</option>
                                            <option value="Lain-lain" {{ old('type', $receivable->type ?? '') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="amount">Jumlah <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $receivable->amount ?? '2500000') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="due_date">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control date-picker" id="due_date" name="due_date" value="{{ old('due_date', $receivable->due_date ?? date('Y-m-d', strtotime('+30 days'))) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="semester">Semester/Periode <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="semester" name="semester" required>
                                            <option value="">Pilih Semester</option>
                                            <option value="Ganjil 2024/2025" {{ old('semester', $receivable->semester ?? 'Ganjil 2024/2025') == 'Ganjil 2024/2025' ? 'selected' : '' }}>Ganjil 2024/2025</option>
                                            <option value="Genap 2024/2025" {{ old('semester', $receivable->semester ?? '') == 'Genap 2024/2025' ? 'selected' : '' }}>Genap 2024/2025</option>
                                            <option value="Ganjil 2023/2024" {{ old('semester', $receivable->semester ?? '') == 'Ganjil 2023/2024' ? 'selected' : '' }}>Ganjil 2023/2024</option>
                                            <option value="Genap 2023/2024" {{ old('semester', $receivable->semester ?? '') == 'Genap 2023/2024' ? 'selected' : '' }}>Genap 2023/2024</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Belum Lunas" {{ old('status', $receivable->status ?? 'Belum Lunas') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                            <option value="Lunas" {{ old('status', $receivable->status ?? '') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                            <option value="Cicilan" {{ old('status', $receivable->status ?? '') == 'Cicilan' ? 'selected' : '' }}>Cicilan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="description">Deskripsi</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $receivable->description ?? 'Pembayaran SPP semester ganjil 2024/2025') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="notes">Catatan</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $receivable->notes ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-check"></em><span>Update Piutang</span>
                                    </button>
                                    <a href="{{ route('receivables.index') }}" class="btn btn-white btn-outline-light">
                                        <em class="icon ni ni-arrow-left"></em><span>Batal</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.js-select2').select2({
            width: '100%',
            placeholder: 'Pilih Mahasiswa'
        });
        
        // Format number input
        $('#amount').on('input', function() {
            var value = $(this).val();
            if (value) {
                $(this).val(value.replace(/[^0-9]/g, ''));
            }
        });
    });
</script>
@endpush
