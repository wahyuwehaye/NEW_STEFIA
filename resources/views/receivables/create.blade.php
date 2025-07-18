@extends('layouts.admin')

@section('title', 'Tambah Piutang')

@section('content')
<x-page-header 
    title="Tambah Piutang Mahasiswa" 
    subtitle="Formulir untuk menambah piutang mahasiswa">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('receivables.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <form action="{{ route('receivables.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label" for="student_id">Mahasiswa <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="student_id" name="student_id" required>
                                    <option value="">Pilih Mahasiswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }} [{{ $student->nim }}] - {{ $student->program ?? 'N/A' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="fee_id">Jenis Biaya <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="fee_id" name="fee_id" required>
                                    <option value="">Pilih Jenis Biaya</option>
                                    @foreach($fees as $fee)
                                        <option value="{{ $fee->id }}">{{ $fee->name }} - Rp {{ number_format($fee->amount, 0, ',', '.') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="semester">Semester</label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="semester" name="semester">
                                    <option value="">Pilih Semester</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="tahun_akademik">Tahun Akademik</label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="tahun_akademik" name="tahun_akademik">
                                    <option value="">Pilih Tahun Akademik</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2023/2024">2023/2024</option>
                                    <option value="2022/2023">2022/2023</option>
                                    <option value="2021/2022">2021/2022</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="amount">Jumlah Piutang <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Masukkan jumlah" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="tanggal_tagihan">Tanggal Tagihan <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" id="tanggal_tagihan" name="tanggal_tagihan" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="due_date">Tanggal Jatuh Tempo <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" id="due_date" name="due_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label" for="description">Keterangan</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan keterangan tambahan"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden status field -->
                    <input type="hidden" name="status" value="pending">
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <em class="icon ni ni-save"></em>
                                <span>Simpan Piutang</span>
                            </button>
                            <a href="{{ route('receivables.index') }}" class="btn btn-outline-light">
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.js-select2').select2({
        minimumResultsForSearch: Infinity
    });
    
    // Auto set due date 30 days from today
    var dueDate = new Date();
    dueDate.setDate(dueDate.getDate() + 30);
    $('#due_date').val(dueDate.toISOString().split('T')[0]);
});
</script>
@endpush

