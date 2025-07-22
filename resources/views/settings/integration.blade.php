@extends('layouts.admin')
@section('title', 'Integrasi Sistem')
@section('content')
<x-page-header title="Integrasi Sistem" subtitle="Kelola integrasi dengan sistem eksternal, payment gateway, WhatsApp, dan email.">
    <x-slot name="actions">
        <a href="{{ route('settings.general') }}" class="btn btn-light btn-modern"><em class="icon ni ni-arrow-left"></em> Kembali</a>
    </x-slot>
</x-page-header>
<div class="nk-block">
    <div class="row g-4 mb-4">
        @foreach($integrations as $key => $integration)
            <div class="col-lg-6 col-12">
                <div class="glass-card integration-card animate-fadeInUp">
                    <div class="d-flex align-items-center mb-2">
                        <div class="integration-icon me-3">
                            @if($key === 'igracias')
                                <em class="icon ni ni-hat"></em>
                            @elseif($key === 'payment_gateway')
                                <em class="icon ni ni-coins"></em>
                            @elseif($key === 'whatsapp_api')
                                <em class="icon ni ni-whatsapp"></em>
                            @elseif($key === 'email_service')
                                <em class="icon ni ni-mail"></em>
                            @else
                                <em class="icon ni ni-link"></em>
                            @endif
                        </div>
                        <div>
                            <h5 class="mb-0 integration-title">{{ $integration['name'] }}</h5>
                            <span class="text-muted small">{{ $integration['description'] }}</span>
                        </div>
                        <span class="badge badge-status ms-auto {{ $integration['status'] === 'active' ? 'badge-active' : 'badge-inactive' }}">{{ ucfirst($integration['status']) }}</span>
                    </div>
                    <div class="mb-2">
                        @if(isset($integration['endpoints']))
                            <div class="mb-1"><strong>Endpoint:</strong></div>
                            <ul class="list-unstyled small mb-2">
                                @foreach($integration['endpoints'] as $label => $url)
                                    <li><em class="icon ni ni-link"></em> <span class="text-muted">{{ ucfirst($label) }}:</span> <span class="text-primary">{{ $url }}</span></li>
                                @endforeach
                            </ul>
                        @endif
                        @if(isset($integration['providers']))
                            <div class="mb-1"><strong>Provider:</strong></div>
                            <ul class="list-unstyled small mb-2">
                                @foreach($integration['providers'] as $prov => $provdata)
                                    <li><em class="icon ni ni-server"></em> <span class="text-muted">{{ ucfirst($prov) }}:</span> <span class="text-primary">{{ ucfirst($provdata['status']) }}</span> <span class="text-muted ms-2">{{ $provdata['last_transaction'] ? 'Last: '.$provdata['last_transaction'] : '' }}</span></li>
                                @endforeach
                            </ul>
                        @endif
                        @if(isset($integration['phone_number']))
                            <div><em class="icon ni ni-phone"></em> <span class="text-muted">Nomor:</span> <span class="text-primary">{{ $integration['phone_number'] }}</span></div>
                        @endif
                        @if(isset($integration['provider']))
                            <div><em class="icon ni ni-mail"></em> <span class="text-muted">Provider:</span> <span class="text-primary">{{ $integration['provider'] }}</span></div>
                        @endif
                        @if(isset($integration['daily_quota']))
                            <div><em class="icon ni ni-pie"></em> <span class="text-muted">Quota Harian:</span> <span class="text-primary">{{ $integration['daily_quota'] }}</span></div>
                        @endif
                        @if(isset($integration['emails_sent_today']))
                            <div><em class="icon ni ni-send"></em> <span class="text-muted">Email Terkirim Hari Ini:</span> <span class="text-primary">{{ $integration['emails_sent_today'] }}</span></div>
                        @endif
                        @if(isset($integration['messages_sent_today']))
                            <div><em class="icon ni ni-send"></em> <span class="text-muted">WA Terkirim Hari Ini:</span> <span class="text-primary">{{ $integration['messages_sent_today'] }}</span></div>
                        @endif
                        @if(isset($integration['last_sync']))
                            <div><em class="icon ni ni-clock"></em> <span class="text-muted">Last Sync:</span> <span class="text-primary">{{ $integration['last_sync'] }}</span></div>
                        @endif
                        @if(isset($integration['sync_frequency']))
                            <div><em class="icon ni ni-repeat"></em> <span class="text-muted">Sync:</span> <span class="text-primary">{{ ucfirst($integration['sync_frequency']) }}</span></div>
                        @endif
                        @if(isset($integration['verified']))
                            <div><em class="icon ni ni-check-circle"></em> <span class="text-muted">Verified:</span> <span class="text-primary">{{ $integration['verified'] ? 'Ya' : 'Tidak' }}</span></div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
@push('styles')
<style>
    .integration-card {
        min-height: 210px;
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        border-radius: 20px !important;
        box-shadow: 0 6px 32px rgba(0,0,0,0.07) !important;
        background: rgba(255,255,255,0.85) !important;
        border: none !important;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .integration-card:hover {
        box-shadow: 0 16px 48px rgba(255,0,0,0.10) !important;
        transform: translateY(-3px) scale(1.01);
    }
    .integration-icon {
        width: 54px;
        height: 54px;
        font-size: 2rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ff4d4d 0%, #f43f5e 100%) !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(255,0,0,0.08);
    }
    .integration-title {
        font-size: 1.18rem;
        font-weight: 700;
        color: #f43f5e;
        margin-bottom: 0.1rem;
    }
    .badge-status {
        font-size: 0.92rem;
        border-radius: 8px;
        padding: 0.32rem 1.1rem;
        font-weight: 600;
        letter-spacing: 1px;
        background: #f3f4f6;
        color: #f43f5e;
        border: none;
    }
    .badge-active { background: #e8f5e9 !important; color: #43a047 !important; }
    .badge-inactive { background: #ffebee !important; color: #e53935 !important; }
</style>
@endpush 