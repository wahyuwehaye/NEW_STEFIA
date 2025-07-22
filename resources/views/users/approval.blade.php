@extends('layouts.admin')

@section('title', 'Approval User Baru')

@section('content')
<x-page-header title="Approval User Baru" subtitle="Daftar user yang menunggu persetujuan Super Admin">
    <x-slot name="actions">
        <a href="{{ route('users.index') }}" class="btn btn-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            @if(session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif
            @if(session('error'))
                <x-notification type="danger" :message="session('error')" />
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Role</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingRequests as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role_name }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('users.approve', $user) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm"><em class="icon ni ni-check"></em> Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('users.reject', $user) }}" class="d-inline ms-1">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><em class="icon ni ni-na"></em> Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Tidak ada user yang menunggu approval</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 