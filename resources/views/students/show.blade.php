@extends('layouts.admin')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="nk-content">
    <div class="nk-content-inner">
        <div class="nk-content-body">
            <div class="components-preview">
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Detail Mahasiswa</h3>
                            <div class="nk-block-des">
                                <p>Informasi lengkap data mahasiswa</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <ul class="nk-block-tools g-3">
                                <li><a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                <li><a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="row g-gs">
                        <!-- Profile Card -->
                        <div class="col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="user-card">
                                        <div class="user-avatar bg-primary">
                                            <span>{{ strtoupper(substr($student->name, 0, 2)) }}</span>
                                        </div>
                                        <div class="user-info">
                                            <span class="lead-text">{{ $student->name }}</span>
                                            <span class="sub-text">{{ $student->nim }}</span>
                                        </div>
                                        <div class="user-status">
                                            @php
                                                $statusDisplay = [
                                                    'active' => 'Aktif',
                                                    'inactive' => 'Tidak Aktif',
                                                    'graduated' => 'Lulus',
                                                    'dropped_out' => 'Drop Out'
                                                ];
                                                $statusClass = [
                                                    'active' => 'success',
                                                    'inactive' => 'warning',
                                                    'graduated' => 'success',
                                                    'dropped_out' => 'danger'
                                                ];
                                            @endphp
                                            <span class="badge badge-dot badge-{{ $statusClass[$student->status] ?? 'secondary' }}">{{ $statusDisplay[$student->status] ?? $student->status }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Details Card -->
                        <div class="col-lg-8">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="nk-block-head">
                                        <h5 class="title">Informasi Mahasiswa</h5>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">NIM</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->nim ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Nama Lengkap</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->name ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Fakultas</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->faculty ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Program Studi</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->department ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Angkatan</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->cohort_year ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Status</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->status ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->email ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Telepon</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->phone ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tempat Lahir</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->birth_place ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Tanggal Lahir</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->birth_date ? \Carbon\Carbon::parse($student->birth_date)->format('d/m/Y') : 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Jenis Kelamin</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->gender == 'male' ? 'Laki-laki' : ($student->gender == 'female' ? 'Perempuan' : ($student->gender == 'other' ? 'Lainnya' : 'N/A')) }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Kelas</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->class ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Semester Saat Ini</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->current_semester ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label">Alamat</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control" rows="3" readonly>{{ $student->address ?? 'N/A' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Parent Information Card -->
                            <div class="card card-bordered mt-3">
                                <div class="card-inner">
                                    <div class="nk-block-head">
                                        <h5 class="title">Data Orang Tua</h5>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Nama Ayah</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->father_name ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Nama Ibu</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->mother_name ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Pekerjaan Ayah</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->father_occupation ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Pekerjaan Ibu</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->mother_occupation ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Telepon Ayah</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->father_phone ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Telepon Ibu</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" value="{{ $student->mother_phone ?? 'N/A' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Alamat Ayah</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control" rows="3" readonly>{{ $student->father_address ?? 'N/A' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Alamat Ibu</label>
                                                <div class="form-control-wrap">
                                                    <textarea class="form-control" rows="3" readonly>{{ $student->mother_address ?? 'N/A' }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.user-card {
    text-align: center;
    padding: 20px;
}

.user-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 2rem;
    font-weight: bold;
    color: white;
}

.user-info .lead-text {
    display: block;
    font-size: 1.25rem;
    font-weight: 600;
    color: #364a63;
    margin-bottom: 5px;
}

.user-info .sub-text {
    display: block;
    color: #8094ae;
    font-size: 0.9rem;
}

.user-status {
    margin-top: 15px;
}

.card-bordered {
    border: 1px solid #e5e9f2;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.card-inner {
    padding: 1.5rem;
}

.nk-block-head .title {
    color: #364a63;
    font-weight: 600;
    margin-bottom: 1rem;
}
</style>
@endpush
