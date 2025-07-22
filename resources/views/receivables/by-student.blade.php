@extends('layouts.admin')

@section('title', $student ? 'Piutang ' . $student->name : 'Piutang Mahasiswa')

@section('content')
<x-page-header 
    title="{{ $student ? 'Piutang ' . $student->name : 'Piutang Mahasiswa' }}" 
    subtitle="{{ $student ? 'Daftar piutang mahasiswa ' . $student->name . ' [' . $student->nim . ']' : 'Pilih mahasiswa untuk melihat daftar piutang' }}">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li>
                <div class="dropdown">
                    <a href="#" class="btn btn-white btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                        <em class="icon ni ni-users"></em><span>Pilih Mahasiswa</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <div class="dropdown-head">
                            <span class="text-title">Mahasiswa Lain</span>
                        </div>
                        <div class="dropdown-body dropdown-body-sm">
                            @if(isset($otherStudents) && $otherStudents->count() > 0)
                                @foreach($otherStudents as $otherStudent)
                                    <a href="{{ route('receivables.by-student', $otherStudent) }}" class="dropdown-item">
                                        <div class="user-card">
                                            <div class="user-avatar sm bg-primary">
                                                @if($otherStudent->avatar && file_exists(public_path($otherStudent->avatar)))
                                                    <img src="{{ asset($otherStudent->avatar) }}" alt="Avatar" class="rounded">
                                                @else
                                                    <span>{{ strtoupper(substr($otherStudent->name, 0, 2)) }}</span>
                                                @endif
                                            </div>
                                            <div class="user-info">
                                                <span class="tb-lead">{{ $otherStudent->name }}</span>
                                                <span class="sub-text">{{ $otherStudent->nim }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="text-center py-3">
                                    <span class="text-muted">Tidak ada mahasiswa lain dengan piutang</span>
                                </div>
                            @endif
                            <div class="dropdown-foot center">
                                <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-light">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li><a href="{{ route('receivables.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Piutang</span></a></li>
            <li><a href="{{ route('receivables.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

@if(!$student && $students->count() == 0)
    <!-- Empty State -->
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="text-center py-5">
                    <em class="icon ni ni-users" style="font-size: 64px; color: #c4c4c4;"></em>
                    <h5 class="mt-3">Tidak Ada Mahasiswa dengan Piutang</h5>
                    <p class="text-muted">Belum ada mahasiswa yang memiliki piutang dalam sistem.</p>
                    <div class="mt-4">
                        <a href="{{ route('receivables.create') }}" class="btn btn-primary">
                            <em class="icon ni ni-plus"></em><span>Tambah Piutang</span>
                        </a>
                        <a href="{{ route('students.index') }}" class="btn btn-outline-light ms-2">
                            <em class="icon ni ni-users"></em><span>Lihat Mahasiswa</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif(!$student)
    <!-- Student Selection -->
    <div class="nk-block nk-block-lg">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="text-center py-4">
                    <h5>Pilih Mahasiswa</h5>
                    <p class="text-muted">Pilih mahasiswa dari daftar berikut untuk melihat detail piutang:</p>
                    <div class="row g-3 mt-3">
                        @foreach($students->take(12) as $studentOption)
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('receivables.by-student', $studentOption->id) }}" class="card card-bordered card-hover">
                                    <div class="card-inner text-center py-3">
                                        <div class="user-avatar sm bg-primary mb-2 mx-auto">
                                            <span>{{ strtoupper(substr($studentOption->name, 0, 2)) }}</span>
                                        </div>
                                        <h6 class="title">{{ $studentOption->name }}</h6>
                                        <span class="sub-text">{{ $studentOption->nim }}</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@else

<!-- Student Info Card -->
<div class="nk-block nk-block-lg">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="profile-card">
                        <div class="profile-avatar">
                            @if($student->avatar && file_exists(public_path($student->avatar)))
                                <img src="{{ asset($student->avatar) }}" alt="Avatar" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-avatar.svg') }}" alt="Default Avatar" class="rounded" style="width: 80px; height: 80px;">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-info">
                        <h4>{{ $student->name }}</h4>
                        <p class="text-soft">{{ $student->nim }} • {{ $student->major->name ?? 'N/A' }}</p>
                        <div class="row g-3 mt-2">
                            <div class="col-sm-3">
                                <div class="profile-stats">
                                    <span class="amount">{{ 'Rp ' . number_format($stats['total_amount'] ?? 0) }}</span>
                                    <span class="sub-text">Total Piutang</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-stats">
                                    <span class="amount">{{ 'Rp ' . number_format($stats['total_paid'] ?? 0) }}</span>
                                    <span class="sub-text">Sudah Dibayar</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-stats">
                                    <span class="amount">{{ 'Rp ' . number_format($stats['total_outstanding'] ?? 0) }}</span>
                                    <span class="sub-text">Sisa Piutang</span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="profile-stats">
                                    <span class="amount">{{ $stats['overdue_count'] ?? 0 }}</span>
                                    <span class="sub-text">Terlambat</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Receivables Table -->
<div class="nk-block">
    <div class="card card-bordered card-stretch">
        <div class="card-inner-group">
            <div class="card-inner position-relative card-tools-toggle">
                <div class="card-title-group">
                    <div class="card-tools">
                        <div class="form-inline flex-nowrap gx-3">
                            <div class="form-wrap w-150px">
                                <select class="form-select js-select2" data-search="off" data-placeholder="Bulk Action">
                                    <option value="">Bulk Action</option>
                                    <option value="send_reminder">Kirim Reminder</option>
                                    <option value="mark_paid">Mark as Paid</option>
                                    <option value="update_priority">Update Priority</option>
                                </select>
                            </div>
                            <div class="btn-wrap">
                                <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Apply</button></span>
                                <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-tools me-n1">
                        <ul class="btn-toolbar gx-1">
                            <li><a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a></li>
                            <li class="btn-toolbar-sep"></li>
                            <li><div class="toggle-wrap"><a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a></div></li>
                        </ul>
                    </div>
                </div>
                <div class="card-search search-wrap" data-search="search">
                    <div class="card-body">
                        <div class="search-content">
                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                            <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search by transaction or amount">
                            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-inner p-0">
                <div class="nk-tb-list nk-tb-ulist">
                    <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col tb-col-mb"><span class="sub-text">Kode</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Kategori</span></div>
                        <div class="nk-tb-col tb-col-lg"><span class="sub-text">Jumlah</span></div>
                        <div class="nk-tb-col tb-col-lg"><span class="sub-text">Sisa</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Jatuh Tempo</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Prioritas</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">
                            <div class="dropdown">
                                <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-bs-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                    <ul class="link-tidy sm no-bdr">
                                        <li><a href="#" class="dropdown-item"><em class="icon ni ni-user-add"></em><span>Add User</span></a></li>
                                        <li><a href="#" class="dropdown-item"><em class="icon ni ni-setting-alt"></em><span>Tools</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @forelse($debts as $debt)
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid{{ $debt->id }}">
                                <label class="custom-control-label" for="uid{{ $debt->id }}"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col tb-col-mb">
                            <span class="tb-amount">{{ $debt->receivable_code ?? 'RC' . str_pad($debt->id, 6, '0', STR_PAD_LEFT) }}</span>
                            <span class="tb-amount-sm">{{ $debt->description ?? 'N/A' }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-amount">{{ ucfirst($debt->category) }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-lg">
                            <span class="tb-amount">{{ 'Rp ' . number_format($debt->amount) }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-lg">
                            <span class="tb-amount">{{ 'Rp ' . number_format($debt->outstanding_amount) }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            <span class="tb-date">{{ $debt->due_date ? $debt->due_date->format('d M Y') : 'N/A' }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            @php
                                $statusClass = [
                                    'pending' => 'warning',
                                    'partial' => 'info',
                                    'paid' => 'success',
                                    'overdue' => 'danger',
                                    'cancelled' => 'dark'
                                ][$debt->status] ?? 'secondary';
                            @endphp
                            <span class="tb-status text-{{ $statusClass }}">{{ ucfirst($debt->status) }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            @php
                                $priorityClass = [
                                    'low' => 'success',
                                    'medium' => 'warning',
                                    'high' => 'danger',
                                    'urgent' => 'dark'
                                ][$debt->priority] ?? 'secondary';
                            @endphp
                            <span class="badge badge-sm badge-dot has-bg bg-{{ $priorityClass }} d-none d-md-inline-flex">{{ ucfirst($debt->priority) }}</span>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li class="nk-tb-action-hidden">
                                    <a href="{{ route('receivables.show', $debt) }}" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                        <em class="icon ni ni-eye"></em>
                                    </a>
                                </li>
                                <li class="nk-tb-action-hidden">
                                    <a href="{{ route('receivables.edit', $debt) }}" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <em class="icon ni ni-edit"></em>
                                    </a>
                                </li>
                                <li>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="{{ route('receivables.show', $debt) }}"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                <li><a href="{{ route('receivables.edit', $debt) }}"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" onclick="event.preventDefault(); document.getElementById('send-reminder-{{ $debt->id }}').submit();"><em class="icon ni ni-mail"></em><span>Send Reminder</span></a></li>
                                                <li><a href="#" class="text-danger" onclick="event.preventDefault(); document.getElementById('delete-{{ $debt->id }}').submit();"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Hidden Forms -->
                    <form id="send-reminder-{{ $debt->id }}" action="{{ route('receivables.send-reminder', $debt) }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <form id="delete-{{ $debt->id }}" action="{{ route('receivables.destroy', $debt) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    @empty
                    <div class="nk-tb-item">
                        <div class="nk-tb-col" colspan="8">
                            <div class="text-center py-4">
                                <em class="icon ni ni-inbox" style="font-size: 48px; color: #c4c4c4;"></em>
                                <p class="text-muted mt-2">Tidak ada piutang untuk mahasiswa ini</p>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
            @if($debts instanceof \Illuminate\Contracts\Pagination\Paginator && $debts->hasPages())
            <div class="card-inner">
                {{ $debts->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endif
@endsection
