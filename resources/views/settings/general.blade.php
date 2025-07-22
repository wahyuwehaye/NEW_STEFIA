@extends('layouts.admin')
@section('title', 'Pengaturan Umum')
@section('content')
<x-page-header title="Pengaturan Umum" subtitle="Atur informasi institusi, branding, preferensi, dan kontak sistem.">
    <x-slot name="actions">
        <a href="/dashboard" class="btn btn-light btn-modern"><em class="icon ni ni-arrow-left"></em> Kembali</a>
    </x-slot>
</x-page-header>
<div class="nk-block">
    <div class="row g-4 mb-4">
        <div class="col-lg-6 col-12">
            <div class="glass-card settings-card animate-fadeInUp">
                <h5 class="mb-2">Informasi Institusi</h5>
                <ul class="list-unstyled small mb-2">
                    <li><em class="icon ni ni-building"></em> <span class="text-muted">Nama Aplikasi:</span> <span class="text-primary">{{ $settings['system']['app_name'] }}</span></li>
                    <li><em class="icon ni ni-info"></em> <span class="text-muted">Versi:</span> <span class="text-primary">{{ $settings['system']['app_version'] }}</span></li>
                    <li><em class="icon ni ni-globe"></em> <span class="text-muted">Zona Waktu:</span> <span class="text-primary">{{ $settings['system']['timezone'] }}</span></li>
                    <li><em class="icon ni ni-flag"></em> <span class="text-muted">Bahasa:</span> <span class="text-primary">{{ $settings['system']['language'] }}</span></li>
                </ul>
                @if(session('success'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-success border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('success') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @if(session('error'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-danger border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('error') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @foreach ([
                    ['Informasi Institusi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Branding & Preferensi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Kontak & Email', $settings['email']['updated_by'] ?? null, $settings['email']['updated_at'] ?? null],
                    ['Pengaturan Akademik & Pembayaran', $settings['academic']['updated_by'] ?? null, $settings['academic']['updated_at'] ?? null],
                ] as $i => [$title, $by, $at])
                    @if($by && $at)
                        <div class="text-end small text-muted mt-2">Last updated by <b>{{ $by }}</b> at <b>{{ $at }}</b></div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="glass-card settings-card animate-fadeInUp">
                <h5 class="mb-2">Branding & Preferensi</h5>
                <ul class="list-unstyled small mb-2">
                    <li><em class="icon ni ni-palette"></em> <span class="text-muted">Mode Maintenance:</span> <span class="text-primary">{{ $settings['system']['maintenance_mode'] ? 'Aktif' : 'Nonaktif' }}</span></li>
                    <li><em class="icon ni ni-bug"></em> <span class="text-muted">Debug Mode:</span> <span class="text-primary">{{ $settings['system']['debug_mode'] ? 'Aktif' : 'Nonaktif' }}</span></li>
                </ul>
                @if(session('success'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-success border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('success') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @if(session('error'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-danger border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('error') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @foreach ([
                    ['Informasi Institusi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Branding & Preferensi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Kontak & Email', $settings['email']['updated_by'] ?? null, $settings['email']['updated_at'] ?? null],
                    ['Pengaturan Akademik & Pembayaran', $settings['academic']['updated_by'] ?? null, $settings['academic']['updated_at'] ?? null],
                ] as $i => [$title, $by, $at])
                    @if($by && $at)
                        <div class="text-end small text-muted mt-2">Last updated by <b>{{ $by }}</b> at <b>{{ $at }}</b></div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="glass-card settings-card animate-fadeInUp">
                <h5 class="mb-2">Kontak & Email</h5>
                <ul class="list-unstyled small mb-2">
                    <li><em class="icon ni ni-mail"></em> <span class="text-muted">Email Pengirim:</span> <span class="text-primary">{{ $settings['email']['mail_from_address'] }}</span></li>
                    <li><em class="icon ni ni-user"></em> <span class="text-muted">Nama Pengirim:</span> <span class="text-primary">{{ $settings['email']['mail_from_name'] }}</span></li>
                    <li><em class="icon ni ni-server"></em> <span class="text-muted">SMTP Host:</span> <span class="text-primary">{{ $settings['email']['mail_host'] }}</span></li>
                    <li><em class="icon ni ni-lock"></em> <span class="text-muted">Enkripsi:</span> <span class="text-primary">{{ $settings['email']['mail_encryption'] }}</span></li>
                </ul>
                @if(session('success'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-success border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('success') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @if(session('error'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-danger border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('error') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @foreach ([
                    ['Informasi Institusi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Branding & Preferensi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Kontak & Email', $settings['email']['updated_by'] ?? null, $settings['email']['updated_at'] ?? null],
                    ['Pengaturan Akademik & Pembayaran', $settings['academic']['updated_by'] ?? null, $settings['academic']['updated_at'] ?? null],
                ] as $i => [$title, $by, $at])
                    @if($by && $at)
                        <div class="text-end small text-muted mt-2">Last updated by <b>{{ $by }}</b> at <b>{{ $at }}</b></div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-lg-6 col-12">
            <div class="glass-card settings-card animate-fadeInUp">
                <h5 class="mb-2">Pengaturan Akademik & Pembayaran</h5>
                <ul class="list-unstyled small mb-2">
                    <li><em class="icon ni ni-calendar"></em> <span class="text-muted">Tahun Akademik:</span> <span class="text-primary">{{ $settings['academic']['academic_year'] }}</span></li>
                    <li><em class="icon ni ni-book"></em> <span class="text-muted">Semester:</span> <span class="text-primary">{{ $settings['academic']['semester'] }}</span></li>
                    <li><em class="icon ni ni-credit-card"></em> <span class="text-muted">Metode Pembayaran:</span> <span class="text-primary">{{ implode(', ', $settings['payment']['payment_methods']) }}</span></li>
                    <li><em class="icon ni ni-coins"></em> <span class="text-muted">Mata Uang:</span> <span class="text-primary">{{ $settings['payment']['currency'] }}</span></li>
                    <li><em class="icon ni ni-alert"></em> <span class="text-muted">Denda Keterlambatan:</span> <span class="text-primary">{{ $settings['payment']['late_fee_percentage'] }}%</span></li>
                </ul>
                @if(session('success'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-success border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('success') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @if(session('error'))
                <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                  <div class="toast align-items-center text-bg-danger border-0 show fade-in" role="alert">
                    <div class="d-flex">
                      <div class="toast-body">{{ session('error') }}</div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
                @endif
                @foreach ([
                    ['Informasi Institusi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Branding & Preferensi', $settings['system']['updated_by'] ?? null, $settings['system']['updated_at'] ?? null],
                    ['Kontak & Email', $settings['email']['updated_by'] ?? null, $settings['email']['updated_at'] ?? null],
                    ['Pengaturan Akademik & Pembayaran', $settings['academic']['updated_by'] ?? null, $settings['academic']['updated_at'] ?? null],
                ] as $i => [$title, $by, $at])
                    @if($by && $at)
                        <div class="text-end small text-muted mt-2">Last updated by <b>{{ $by }}</b> at <b>{{ $at }}</b></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .settings-card {
        min-height: 210px;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        border-radius: 20px !important;
        box-shadow: 0 6px 32px rgba(0,0,0,0.07) !important;
        background: rgba(255,255,255,0.85) !important;
        border: none !important;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .settings-card:hover {
        box-shadow: 0 16px 48px rgba(255,0,0,0.10) !important;
        transform: translateY(-3px) scale(1.01);
    }
    .toast-container { pointer-events: none; }
    .toast { pointer-events: auto; min-width: 260px; }
</style>
@endpush
