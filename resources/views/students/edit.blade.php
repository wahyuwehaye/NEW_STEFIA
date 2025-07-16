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
                                    <label class="form-label" for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $student->name ?? 'John Doe') }}" required>
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
                                    <label class="form-label" for="telepon">Nomor Telepon</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon', $student->phone ?? '081234567890') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $student->birth_place ?? '') }}" placeholder="Masukkan tempat lahir">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                                    <div class="form-control-wrap">
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $student->birth_date ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="gender">Jenis Kelamin</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="male" {{ old('gender', $student->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="female" {{ old('gender', $student->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                            <option value="other" {{ old('gender', $student->gender ?? '') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="class">Kelas (Opsional)</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="class" name="class" value="{{ old('class', $student->class ?? '') }}" placeholder="Masukkan kelas">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="fakultas">Fakultas <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-search="on" id="fakultas" name="fakultas" required>
                                            <option value="">Pilih Fakultas</option>
                                            <option value="Fakultas Teknik" {{ old('fakultas', $student->faculty ?? 'Fakultas Teknik') == 'Fakultas Teknik' ? 'selected' : '' }}>Fakultas Teknik</option>
                                            <option value="Fakultas Ekonomi" {{ old('fakultas', $student->faculty ?? '') == 'Fakultas Ekonomi' ? 'selected' : '' }}>Fakultas Ekonomi</option>
                                            <option value="Fakultas Ilmu Komputer" {{ old('fakultas', $student->faculty ?? '') == 'Fakultas Ilmu Komputer' ? 'selected' : '' }}>Fakultas Ilmu Komputer</option>
                                            <option value="Fakultas Sains" {{ old('fakultas', $student->faculty ?? '') == 'Fakultas Sains' ? 'selected' : '' }}>Fakultas Sains</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="program_studi">Program Studi <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select js-select2" data-search="on" id="program_studi" name="program_studi" required>
                                            <option value="">Pilih Program Studi</option>
                                            <option value="Teknik Informatika" {{ old('program_studi', $student->department ?? 'Teknik Informatika') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                            <option value="Sistem Informasi" {{ old('program_studi', $student->department ?? '') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                            <option value="Manajemen" {{ old('program_studi', $student->department ?? '') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                                            <option value="Akuntansi" {{ old('program_studi', $student->department ?? '') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                                            <option value="Teknik Mesin" {{ old('program_studi', $student->department ?? '') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                            <option value="Teknik Elektro" {{ old('program_studi', $student->department ?? '') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
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
                                    <label class="form-label" for="angkatan">Angkatan <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="angkatan" name="angkatan" required>
                                            <option value="">Pilih Angkatan</option>
                                            @for($year = 2015; $year <= date('Y'); $year++)
                                                <option value="{{ $year }}" {{ old('angkatan', $student->cohort_year ?? '2024') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="semester_saat_ini">Semester Saat Ini</label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="semester_saat_ini" name="semester_saat_ini">
                                            <option value="">Pilih Semester</option>
                                            @for($sem = 1; $sem <= 14; $sem++)
                                                <option value="{{ $sem }}" {{ old('semester_saat_ini', $student->current_semester ?? 1) == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="status_mahasiswa">Status <span class="text-danger">*</span></label>
                                    <div class="form-control-wrap">
                                        <select class="form-select" id="status_mahasiswa" name="status_mahasiswa" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Aktif" {{ old('status_mahasiswa', $student->status == 'active' ? 'Aktif' : '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Cuti" {{ old('status_mahasiswa', $student->status == 'inactive' ? 'Cuti' : '') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                            <option value="Lulus" {{ old('status_mahasiswa', $student->status == 'graduated' ? 'Lulus' : '') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                            <option value="DO" {{ old('status_mahasiswa', $student->status == 'dropped_out' ? 'DO' : '') == 'DO' ? 'selected' : '' }}>Drop Out</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="alamat">Alamat</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ old('alamat', $student->address ?? 'Jl. Contoh No. 123, Jakarta') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Data Orang Tua -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Data Orang Tua</label>
                                    <hr class="mt-2">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="nama_ayah">Nama Ayah</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $student->father_name ?? '') }}" placeholder="Masukkan nama ayah">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="nama_ibu">Nama Ibu</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $student->mother_name ?? '') }}" placeholder="Masukkan nama ibu">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $student->father_occupation ?? '') }}" placeholder="Masukkan pekerjaan ayah">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $student->mother_occupation ?? '') }}" placeholder="Masukkan pekerjaan ibu">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="telepon_ayah">Telepon Ayah</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="telepon_ayah" name="telepon_ayah" value="{{ old('telepon_ayah', $student->father_phone ?? '') }}" placeholder="Masukkan nomor telepon ayah">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="telepon_ibu">Telepon Ibu</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="telepon_ibu" name="telepon_ibu" value="{{ old('telepon_ibu', $student->mother_phone ?? '') }}" placeholder="Masukkan nomor telepon ibu">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="alamat_ayah">Alamat Ayah</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3" placeholder="Masukkan alamat ayah">{{ old('alamat_ayah', $student->father_address ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="alamat_ibu">Alamat Ibu</label>
                                    <div class="form-control-wrap">
                                        <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" rows="3" placeholder="Masukkan alamat ibu">{{ old('alamat_ibu', $student->mother_address ?? '') }}</textarea>
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
