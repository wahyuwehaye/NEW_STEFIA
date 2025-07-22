@extends('layouts.admin')

@section('title', 'Daftar Mahasiswa dengan Piutang')

@section('content')
<x-page-header title="Daftar Mahasiswa dengan Piutang" subtitle="Pilih mahasiswa untuk melihat detail piutang dan status pembayaran.">
    <x-slot name="actions">
        <a href="{{ route('receivables.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Piutang</span></a>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="row g-3">
        @forelse($students as $student)
        <div class="col-md-4 col-lg-3">
            <div class="card card-bordered card-hover h-100">
                <div class="card-inner text-center py-4">
                    <div class="user-avatar xl bg-primary mb-3 mx-auto">
                        <span>{{ strtoupper(substr($student->name, 0, 2)) }}</span>
                    </div>
                    <h5 class="title mb-1">{{ $student->name }}</h5>
                    <span class="sub-text">{{ $student->nim }}</span>
                    <div class="mt-3">
                        <span class="badge bg-info">Total Piutang: {{ $student->total_debts }}</span>
                    </div>
                    <div class="mt-1">
                        <span class="badge bg-danger">Outstanding: Rp {{ number_format($student->total_outstanding, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('receivables.by-student', $student->id) }}" class="btn btn-outline-primary btn-block mt-3">Lihat Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <em class="icon ni ni-users" style="font-size: 48px;"></em>
                <h5 class="mt-3">Belum ada mahasiswa dengan piutang aktif</h5>
                <p class="text-muted">Semua mahasiswa sudah melunasi piutangnya atau belum ada data piutang.</p>
                <a href="{{ route('receivables.create') }}" class="btn btn-primary mt-3"><em class="icon ni ni-plus"></em> Tambah Piutang</a>
            </div>
        </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
@endsection 