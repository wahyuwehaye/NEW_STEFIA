@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<x-page-header title="Tambah User" subtitle="Form untuk menambah user baru ke sistem">
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
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input-label for="name" :value="'Nama Lengkap'" />
                        <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="col-md-6">
                        <x-input-label for="email" :value="'Email'" />
                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div class="col-md-6">
                        <x-input-label for="phone" :value="'No. HP'" />
                        <x-text-input id="phone" class="form-control" type="text" name="phone" :value="old('phone')" required />
                        <x-input-error :messages="$errors->get('phone')" />
                    </div>
                    <div class="col-md-6">
                        <x-input-label for="role" :value="'Role'" />
                        <select id="role" name="role" class="form-control js-select2" required>
                            <option value="">Pilih Role</option>
                            @foreach($roles as $key => $role)
                                <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" />
                    </div>
                    <div class="col-md-6">
                        <x-input-label for="password" :value="'Password'" />
                        <x-text-input id="password" class="form-control" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><em class="icon ni ni-save"></em> Simpan User</button>
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
    $('.js-select2').select2({
        minimumResultsForSearch: Infinity
    });
});
</script>
@endpush 