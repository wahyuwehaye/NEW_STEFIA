@extends('layouts.admin')
@section('title', 'Laporan Tunggakan > 10 Juta')

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
            title="Laporan Tunggakan > 10 Juta" 
            subtitle="Daftar lengkap mahasiswa dengan tunggakan melebihi 10 juta rupiah dan status tindakan keuangan">
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
                                <span class="amount">{{ number_format($stats['total_students']) }}</span>
                            </div>
                            <div class="card-note">
                                <span class="text-danger">Tunggakan > 10 Juta</span>
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
                                <span class="amount">Rp {{ number_format($stats['total_outstanding'], 0, ',', '.') }}</span>
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
                                    <h6 class="subtitle">Follow Up Pending</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-clock text-info"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ $stats['action_stats']['pending'] ?? 0 }}</span>
                            </div>
                            <div class="card-note">
                                <span class="text-warning">Butuh Tindakan</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Follow Up Selesai</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-check-circle text-success"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ $stats['action_stats']['completed'] ?? 0 }}</span>
                            </div>
                            <div class="card-note">
                                <span class="text-success">Terlaksana</span>
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
                    <form method="GET" action="{{ route('tunggakan.index') }}">
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
                                    <label class="form-label" for="class">Kelas</label>
                                    <select class="form-select" id="class" name="class">
                                        <option value="">Semua</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>{{ $class }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="academic_year">Tahun Akademik</label>
                                    <select class="form-select" id="academic_year" name="academic_year">
                                        <option value="">Semua</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <em class="icon ni ni-search"></em>
                                        Filter
                                    </button>
                                    <a href="{{ route('tunggakan.index') }}" class="btn btn-outline-light">
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
                            <h6 class="title">Daftar Mahasiswa Tunggakan > 10 Juta</h6>
                        </div>
                        <div class="card-tools me-n1">
                            <ul class="btn-toolbar">
                                <li>
                                    <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover nk-tb-list">
                            <thead class="nk-tb-head">
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col">Mahasiswa</th>
                                    <th class="nk-tb-col">Program Studi</th>
                                    <th class="nk-tb-col">Tunggakan</th>
                                    <th class="nk-tb-col">Status Tindakan Keuangan</th>
                                    <th class="nk-tb-col">Follow Up Terakhir</th>
                                    <th class="nk-tb-col nk-tb-col-tools">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-avatar xs bg-primary">
                                                    <span>{{ substr($student->name, 0, 2) }}</span>
                                                </div>
                                                <div class="user-name">
                                                    <span class="tb-lead">{{ $student->name }}</span>
                                                    <span class="tb-sub text-muted">{{ $student->nim }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div>
                                                <span class="tb-lead">{{ $student->program_study }}</span>
                                                <div class="tb-sub text-muted">{{ $student->class }}</div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div>
                                                <span class="tb-amount text-danger fw-bold">Rp {{ number_format($student->outstanding_amount, 0, ',', '.') }}</span>
                                                @if($student->debts->count() > 0)
                                                    <div class="tb-sub text-muted">{{ $student->debts->count() }} item tunggakan</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="d-flex flex-wrap gap-1">
                                                @php
                                                    $actionTypes = $student->followUps->pluck('action_type')->unique();
                                                @endphp
                                                @if($actionTypes->contains('nde_fakultas'))
                                                    <span class="follow-up-badge bg-info text-white">NDE</span>
                                                @endif
                                                @if($actionTypes->contains('dosen_wali'))
                                                    <span class="follow-up-badge bg-primary text-white">Dosen Wali</span>
                                                @endif
                                                @if($actionTypes->contains('surat_orangtua'))
                                                    <span class="follow-up-badge bg-warning text-dark">Surat</span>
                                                @endif
                                                @if($actionTypes->contains('telepon'))
                                                    <span class="follow-up-badge bg-success text-white">Telepon</span>
                                                @endif
                                                @if($actionTypes->contains('home_visit'))
                                                    <span class="follow-up-badge bg-danger text-white">Home Visit</span>
                                                @endif
                                                @if($actionTypes->isEmpty())
                                                    <span class="follow-up-badge bg-secondary text-white">Belum Ada</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            @php
                                                $lastFollowUp = $student->followUps->first();
                                            @endphp
                                            @if($lastFollowUp)
                                                <div>
                                                    <span class="tb-sub text-muted">{{ $lastFollowUp->action_date->format('d M Y') }}</span>
                                                    <div class="tb-lead">
                                                        <span class="badge badge-dot {{ $lastFollowUp->status_badge_color }}">{{ ucfirst($lastFollowUp->status) }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                <li>
                                                    <div class="drodown">
                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
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
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-center">
                                                <em class="icon ni ni-file-docs" style="font-size: 3rem; opacity: 0.3;"></em>
                                                <p class="text-muted mt-2">Tidak ada data tunggakan yang ditemukan.</p>
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
                toastr.success('Follow up berhasil disimpan!');
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
                
                toastr.error(errorMsg);
            }
        });
    });
});
</script>
@endpush
