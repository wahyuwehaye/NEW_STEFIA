@extends('layouts.admin')

@section('title', 'Security Settings')

@section('content')
<x-page-header 
    title="Security Settings" 
    subtitle="Enhance the security of your account"
    :breadcrumbs="[
        ['title' => 'Profile', 'url' => route('profile.edit')],
        ['title' => 'Security Settings']
    ]"
    :actions="[
        ['label' => 'Back to Profile', 'icon' => 'ni-arrow-left', 'url' => route('profile.edit')]
    ]"
>
</x-page-header>

<div class="nk-block">
    <div class="row g-gs">
        <div class="col-12">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Recent Login Attempts</h6>
                            </div>
                            <div class="card-tools">
                                <em class="icon ni ni-signin"></em>
                            </div>
                        </div>
                        <p class="sub-text">Monitor your recent login attempts and secure your account.</p>
                    </div>
                    <div class="card-inner">
                        @if($recentLoginAttempts->count() > 0)
                            <div class="timeline">
                                @foreach($recentLoginAttempts as $attempt)
                                    <div class="timeline-item">
                                        <div class="timeline-status bg-{{ $attempt->action === 'login' ? 'success' : 'danger' }}"></div>
                                        <div class="timeline-date">{{ $attempt->created_at->format('M d, Y H:i:s') }}</div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">{{ ucfirst(str_replace('_', ' ', $attempt->action)) }}</h6>
                                            <div class="timeline-des">
                                                <p>Attempt from {{ $attempt->ip_address }}</p>
                                                @if($attempt->user_agent)
                                                    <div class="timeline-meta">
                                                        <small class="text-muted">{{ $attempt->user_agent }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <em class="icon ni ni-security text-muted" style="font-size: 3rem;"></em>
                                <h6 class="text-muted mt-2">No Login Attempts Found</h6>
                                <p class="text-muted">Your login activity will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

