@extends('layouts.admin')

@section('title', 'Tambah Mahasiswa')

@section('content')
<x-page-header 
    title="Tambah Mahasiswa" 
    subtitle="Tambah data mahasiswa baru ke sistem">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <form action="{{ route('students.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <!-- Data Mahasiswa -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Data Mahasiswa</label>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="nim">NIM <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="fakultas">Fakultas <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="fakultas" name="fakultas" required>
                                    <option value="">Pilih Fakultas</option>
                                    <option value="Teknik">Fakultas Teknik</option>
                                    <option value="Ekonomi">Fakultas Ekonomi</option>
                                    <option value="Hukum">Fakultas Hukum</option>
                                    <option value="MIPA">Fakultas MIPA</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="program_studi">Program Studi <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="program_studi" name="program_studi" required>
                                    <option value="">Pilih Program Studi</option>
                                    <option value="Teknik Informatika">Teknik Informatika</option>
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                    <option value="Teknik Elektro">Teknik Elektro</option>
                                    <option value="Teknik Mesin">Teknik Mesin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="angkatan">Angkatan <span class="text-danger">*</span></label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="angkatan" name="angkatan" required>
                                    <option value="">Pilih Angkatan</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="status_registrasi">Status Registrasi</label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="status_registrasi" name="status_registrasi">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non-Aktif">Non-Aktif</option>
                                    <option value="Cuti">Cuti</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="status_mahasiswa">Status Mahasiswa</label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="status_mahasiswa" name="status_mahasiswa">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="DO">DO</option>
                                    <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="semester_saat_ini">Semester Saat Ini</label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="semester_saat_ini" name="semester_saat_ini">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Kontak -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Informasi Kontak</label>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="telepon">Telepon</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Masukkan nomor telepon">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                            <div class="form-control-wrap">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="gender">Jenis Kelamin</label>
                            <div class="form-control-wrap">
                                <select class="form-control js-select2" id="gender" name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="class">Kelas (Opsional)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="class" name="class" placeholder="Masukkan kelas">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label" for="alamat">Alamat</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Data Orang Tua -->
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-label">Data Orang Tua</label>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="nama_ayah">Nama Ayah</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" placeholder="Masukkan nama ayah">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="nama_ibu">Nama Ibu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" placeholder="Masukkan nama ibu">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="pekerjaan_ayah">Pekerjaan Ayah</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" placeholder="Masukkan pekerjaan ayah">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="pekerjaan_ibu">Pekerjaan Ibu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" placeholder="Masukkan pekerjaan ibu">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="telepon_ayah">Telepon Ayah</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="telepon_ayah" name="telepon_ayah" placeholder="Masukkan nomor telepon ayah">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="telepon_ibu">Telepon Ibu</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="telepon_ibu" name="telepon_ibu" placeholder="Masukkan nomor telepon ibu">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="alamat_ayah">Alamat Ayah</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3" placeholder="Masukkan alamat ayah"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-label" for="alamat_ibu">Alamat Ibu</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" rows="3" placeholder="Masukkan alamat ibu"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <em class="icon ni ni-save"></em>
                                <span>Simpan Data</span>
                            </button>
                            <a href="{{ route('students.index') }}" class="btn btn-outline-light">
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
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                title: 'Form Tidak Lengkap',
                text: 'Mohon lengkapi semua field yang wajib diisi!',
                icon: 'warning',
                confirmButtonText: 'OK, Mengerti',
                customClass: {
                    popup: 'modern-swal-popup',
                    confirmButton: 'modern-swal-confirm'
                },
                buttonsStyling: false
            });
        }
    });
});
</script>
@endpush
