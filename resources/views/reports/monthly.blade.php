@extends('layouts.admin')
@section('title', 'Laporan Bulanan')

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
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <x-page-header 
            title="Laporan Bulanan" 
            subtitle="Laporan bulanan piutang dan pembayaran mahasiswa"
        >
            <x-slot name="actions">
                <ul class="nk-block-tools g-3">
                    <li>
                        <form method="GET" action="{{ route('reports.monthly') }}" class="d-inline">
                            <input type="month" name="month" value="{{ $currentMonth }}" class="form-control" onchange="this.form.submit()">
                        </form>
                    </li>
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

        <!-- Monthly Statistics -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-2 col-md-4">
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
                                <span class="amount">{{ number_format($monthlyStats['total_students']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Mahasiswa Berpiutang</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-user-cross text-warning"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($monthlyStats['students_with_debt']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Piutang</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-coin text-danger"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">Rp {{ number_format($monthlyStats['total_outstanding'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Pembayaran Bulan Ini</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-money text-success"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">Rp {{ number_format($monthlyStats['total_paid_this_month'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Piutang Baru</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-plus-circle text-info"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($monthlyStats['new_debts_this_month']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-md-4">
                    <div class="card stat-card h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="subtitle">Follow Up</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint icon ni ni-calendar text-purple"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($monthlyStats['followups_this_month']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <form method="GET" action="{{ route('reports.monthly') }}">
                        <input type="hidden" name="month" value="{{ $currentMonth }}">
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
                                        @foreach($filterOptions['faculties'] as $faculty)
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
                                        @foreach($filterOptions['program_studies'] as $ps)
                                            <option value="{{ $ps }}" {{ request('program_study') == $ps ? 'selected' : '' }}>{{ $ps }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="min_outstanding">Min Piutang</label>
                                    <input type="number" class="form-control" id="min_outstanding" name="min_outstanding" 
                                           value="{{ request('min_outstanding') }}" placeholder="Minimal">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label" for="max_outstanding">Max Piutang</label>
                                    <input type="number" class="form-control" id="max_outstanding" name="max_outstanding" 
                                           value="{{ request('max_outstanding') }}" placeholder="Maksimal">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <em class="icon ni ni-search"></em>
                                        Filter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="nk-block">
            <div class="card">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Daftar Mahasiswa - {{ \Carbon\Carbon::parse($currentMonth)->format('F Y') }}</h6>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover nk-tb-list">
                            <thead class="nk-tb-head">
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col">Mahasiswa</th>
                                    <th class="nk-tb-col">NIM</th>
                                    <th class="nk-tb-col">Fakultas</th>
                                    <th class="nk-tb-col">Program Studi</th>
                                    <th class="nk-tb-col">Total Piutang</th>
                                    <th class="nk-tb-col">Status</th>
                                    <th class="nk-tb-col">Aksi</th>
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
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">{{ $student->nim }}</td>
                                        <td class="nk-tb-col">{{ $student->faculty }}</td>
                                        <td class="nk-tb-col">{{ $student->program_study }}</td>
                                        <td class="nk-tb-col">
                                            <span class="tb-amount text-danger">Rp {{ number_format($student->outstanding_amount, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="nk-tb-col">
                                            <span class="badge badge-dot {{ $student->status == 'active' ? 'badge-success' : 'badge-warning' }}">
                                                {{ ucfirst($student->status) }}
                                            </span>
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
                                                                <li><a href="{{ route('students.show', $student->id) }}"><em class="icon ni ni-eye"></em><span>Detail</span></a></li>
                                                                <li><a href="#"><em class="icon ni ni-download"></em><span>Export Data</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="nk-tb-item">
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-center">
                                                <em class="icon ni ni-file-docs" style="font-size: 3rem; opacity: 0.3;"></em>
                                                <p class="text-muted mt-2">Tidak ada data yang ditemukan.</p>
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
@endsection
