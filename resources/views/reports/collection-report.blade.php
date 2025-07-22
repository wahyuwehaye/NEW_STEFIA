@extends('layouts.admin')
@section('title', 'Laporan Penagihan Piutang')

@push('styles')
<style>
    .stat-card {
        background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.15);
    }
    .follow-up-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 500;
    }
    .action-btn {
        margin: 0 2px;
        padding: 0.35rem 0.75rem;
        font-size: 0.8rem;
    }
</style>
@endpush

@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <x-page-header 
            title="Laporan Penagihan Piutang" 
            subtitle="Daftar mahasiswa dengan piutang melebihi 10 juta rupiah dan detail tindakan penagihan"
        >
            <x-slot name="actions">
                <ul class="nk-block-tools g-3">
                    <li>
                        <a href="#" class="btn btn-primary">
                            <em class="icon ni ni-download"></em>
                            <span>Export Excel</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-outline-light">
                            <em class="icon ni ni-printer"></em>
                            <span>Print PDF</span>
                        </a>
                    </li>
                </ul>
            </x-slot>
        </x-page-header>

        <!-- Statistics Cards -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Mahasiswa</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-users text-primary"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($collectionStats['total_students']) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="text-danger">Tunggakan &gt; 10 Juta</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Tunggakan</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-coin text-warning"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">Rp {{ number_format($collectionStats['total_outstanding'], 0, ',', '.') }}</span>
                            </div>
                            <div class="card-note">
                                <span class="text-danger">Keseluruhan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Rata-rata Tunggakan</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-chart-bars text-info"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">Rp {{ number_format($collectionStats['average_outstanding'], 0, ',', '.') }}</span>
                            </div>
                            <div class="card-note">
                                <span class="text-info">Per Mahasiswa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Follow-up Terjadwal</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-calendar text-success"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ $collectionStats['performance_metrics']['pending_actions'] }}</span>
                            </div>
                            <div class="card-note">
                                <span class="text-success">Butuh Tindakan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="nk-block nk-block-lg">
            <div class="card">
                <div class="card-inner">
                    <form method="GET" action="{{ route('collection-report.index') }}">
                        <div class="row g-3 align-end">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label" for="search">Cari Mahasiswa</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" placeholder="Nama, NIM, atau ID">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="faculty">Fakultas</label>
                                    <select class="form-select" id="faculty" name="faculty">
                                        <option value="">Semua</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty }}" {{ request('faculty') == $faculty ? 'selected' : '' }}>{{ $faculty }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="program_study">Program Studi</label>
                                    <select class="form-select" id="program_study" name="program_study">
                                        <option value="">Semua</option>
                                        @foreach($programStudies as $ps)
                                            <option value="{{ $ps }}" {{ request('program_study') == $ps ? 'selected' : '' }}>{{ $ps }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="">Semua</option>
                                        @foreach($studentStatuses as $status)
                                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="semester_menunggak">Semester Menunggak</label>
                                    <input type="number" min="0" class="form-control" id="semester_menunggak" name="semester_menunggak" 
                                           value="{{ request('semester_menunggak') }}" placeholder="Min">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <em class="icon ni ni-search"></em>
                                        Filter
                                    </button>
                                    <a href="{{ route('collection-report.index') }}" class="btn btn-outline-light">
                                        <em class="icon ni ni-reload"></em>
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Data Table -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Daftar Mahasiswa Piutang &gt; 10 Juta</h6>
                        </div>
                        <div class="card-tools me-n1">
                            <ul class="btn-toolbar">
                                <li>
                                    <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search">
                                        <em class="icon ni ni-search"></em>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover nk-tb-list">
                            <thead class="nk-tb-head">
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col">Mahasiswa</th>
                                    <th class="nk-tb-col">NIM</th>
                                    <th class="nk-tb-col">Jurusan</th>
                                    <th class="nk-tb-col">Fakultas</th>
                                    <th class="nk-tb-col">TA Saat Ini</th>
                                    <th class="nk-tb-col">Semester Menunggak</th>
                                    <th class="nk-tb-col">Jumlah Tunggakan</th>
                                    <th class="nk-tb-col">Status</th>
                                    <th class="nk-tb-col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col">
                                            {{ $student->name }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ $student->nim }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ $student->major->name ?? '-' }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ $student->faculty }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ $student->academicYear->year ?? '-' }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ $student->semester_menunggak }}
                                        </td>
                                        <td class="nk-tb-col">
                                            Rp {{ number_format($student->outstanding_amount, 0, ',', '.') }}
                                        </td>
                                        <td class="nk-tb-col">
                                            {{ ucfirst($student->status) }}
                                        </td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                            <em class="icon ni ni-more-h"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <ul class="link-list-opt no-bdr">
                                                                <li><a href="{{ route('students.show', $student->id) }}"><em class="icon ni ni-eye"></em><span>Lihat Detail</span></a></li>
                                                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#followUpModal" data-student-id="{{ $student->id }}"><em class="icon ni ni-plus"></em><span>Tambah Follow Up</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-mail"></em><span>Kirim Reminder</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-printer"></em><span>Print Tagihan</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="nk-tb-item">
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-center">
                                                <em class="icon ni ni-file-docs" style="font-size: 3rem; opacity: 0.3;"></em>
                                                <p class="text-muted mt-2">Tidak ada data penagihan yang ditemukan.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($students->hasPages())
                        <div class="card-inner">
                            <div class="nk-block-between-md g-3">
                                <div class="g">
                                    <ul class="pagination justify-content-center justify-content-md-start">
                                        {{ $students->links() }}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Follow Up Modal -->
<div class="modal fade" id="followUpModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Follow Up Tindakan</h5>
                <a href="#" class="close" data-bs-dismiss="modal"><em class="icon ni ni-cross"></em></a>
            </div>
            <div class="modal-body">
                <form id="followUpForm">
                    @csrf
                    <input type="hidden" id="student_id" name="student_id">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Jenis Tindakan</label>
                                <select class="form-select" name="action_type" required>
                                    <option value="">Pilih Jenis Tindakan</option>
                                    <option value="nde_fakultas">NDE Fakultas</option>
                                    <option value="dosen_wali">Bekerjasama dengan Dosen Wali</option>
                                    <option value="surat_orangtua">Mengirimkan Surat kepada Orangtua</option>
                                    <option value="telepon">Melakukan Kontak via Telepon</option>
                                    <option value="home_visit">Home Visit</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Tindakan</label>
                                <input type="date" class="form-control" name="action_date" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Judul/Ringkasan</label>
                                <input type="text" class="form-control" name="title" placeholder="Masukkan judul tindakan">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Deskripsi Detail</label>
                                <textarea class="form-control" name="description" rows="4" placeholder="Jelaskan detail tindakan yang dilakukan atau akan dilakukan"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="completed">Selesai</option>
                                    <option value="cancelled">Dibatalkan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Hasil (Opsional)</label>
                                <input type="text" class="form-control" name="result" placeholder="Hasil dari tindakan">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Catatan atau keterangan tambahan"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="followUpForm" class="btn btn-primary">Simpan Follow Up</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 show fade-in`;
    toast.style = 'min-width:260px; margin-bottom:8px;';
    toast.innerHTML = `<div class='d-flex'><div class='toast-body'>${message}</div><button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button></div>`;
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = 9999;
        document.body.appendChild(container);
    }
    container.appendChild(toast);
    setTimeout(() => { toast.classList.remove('show'); toast.remove(); }, 3500);
}
// Loading indicator for export
function showLoadingReport() {
    let loading = document.getElementById('reportLoading');
    if (!loading) {
        loading = document.createElement('div');
        loading.id = 'reportLoading';
        loading.style = 'position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.6);z-index:9998;display:flex;align-items:center;justify-content:center;';
        loading.innerHTML = '<div class="spinner-border text-danger" style="width:3rem;height:3rem;"></div>';
        document.body.appendChild(loading);
    }
}
function hideLoadingReport() {
    let loading = document.getElementById('reportLoading');
    if (loading) loading.remove();
}
// Simulasi aksi ekspor
function exportExcel() {
    showLoadingReport();
    setTimeout(() => {
        hideLoadingReport();
        showToast('Export Excel berhasil (dummy)', 'success');
    }, 1200);
}
function exportPDF() {
    showLoadingReport();
    setTimeout(() => {
        hideLoadingReport();
        showToast('Export PDF berhasil (dummy)', 'success');
    }, 1200);
}
// Feedback notifikasi sukses/gagal setelah aksi
@if(session('success'))
    window.setTimeout(() => { showToast(@json(session('success')), 'success'); }, 500);
@endif
@if(session('error'))
    window.setTimeout(() => { showToast(@json(session('error')), 'danger'); }, 500);
@endif
$(document).ready(function() {
    // Handle follow up modal
    $('#followUpModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var studentId = button.data('student-id');
        
        var modal = $(this);
        modal.find('#student_id').val(studentId);
    });
    
    // Handle follow up form submission
    $('#followUpForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '{{ route("followups.store") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#followUpModal').modal('hide');
                showToast('Follow up berhasil disimpan!', 'success');
                location.reload();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMsg = 'Terjadi kesalahan:';
                
                if (errors) {
                    for (var field in errors) {
                        errorMsg += '\n- ' + errors[field][0];
                    }
                }
                
                showToast(errorMsg, 'danger');
            }
        });
    });
});
</script>
@endpush
@push('styles')
<style>
.toast-container { pointer-events: none; }
.toast { pointer-events: auto; min-width: 260px; }
#reportLoading { pointer-events: all; }
</style>
@endpush

