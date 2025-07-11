@extends('layouts.admin')

@section('title', 'Edit Mahasiswa')

@section('content')
<x-page-header 
    title="Edit Mahasiswa" 
    subtitle="Edit data mahasiswa yang sudah terdaftar">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="row g-gs">
        <div class="col-lg-12">
            <div class="card card-bordered">
                <div class="card-inner">
                    <form action="{{ route('students.update', $student->id ?? 1) }}" method="POST" class="form-validate">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-gs">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="nim">NIM <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $student->nim ?? '123456789') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->name ?? 'John Doe') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->email ?? 'john@example.com') }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Nomor Telepon</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $student->phone ?? '081234567890') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="program">Program Studi <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-search="on" id="program" name="program" required>
                                            <option value="">Pilih Program Studi</option>
                                            <option value="Teknik Informatika" {{ old('program', $student->program ?? 'Teknik Informatika') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                            <option value="Sistem Informasi" {{ old('program', $student->program ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                            <option value="Manajemen" {{ old('program', $student->program ?? '') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                                            <option value="Akuntansi" {{ old('program', $student->program ?? '') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                            <option value="Teknik Mesin" {{ old('program', $student->program ?? '') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                            <option value="Teknik Elektro" {{ old('program', $student->program ?? '') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="level">Jenjang <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="level" name="level" required>
                                            <option value="">Pilih Jenjang</option>
                                            <option value="D3" {{ old('level', $student->level ?? '') == 'D3' ? 'selected' : '' }}>D3</option>
                                            <option value="S1" {{ old('level', $student->level ?? 'S1') == 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('level', $student->level ?? '') == 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('level', $student->level ?? '') == 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="batch">Angkatan <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="batch" name="batch" required>
                                            <option value="">Pilih Angkatan</option>
                                            @for($year = 2015; $year <= date('Y'); $year++)
                                                <option value="{{ $year }}" {{ old('batch', $student->batch ?? '2024') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
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
                                            <option value="Aktif" {{ old('status', $student->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Cuti" {{ old('status', $student->status ?? '') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                            <option value="Lulus" {{ old('status', $student->status ?? '') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                            <option value="Drop Out" {{ old('status', $student->status ?? '') == 'Drop Out' ? 'selected' : '' }}>Drop Out</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="address">Alamat</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $student->address ?? 'Jl. Contoh No. 123, Jakarta') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="notes">Catatan</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $student->notes ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-check"></em><span>Update Mahasiswa</span>
                                    </button>
                                    <a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light">
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
            placeholder: 'Pilih Program Studi'
        });
    });
</script>
@endpush
