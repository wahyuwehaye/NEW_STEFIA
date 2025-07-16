@extends('layouts.admin')

@section('title', 'Activity Log')

@section('content')
<x-page-header 
    title="Activity Log" 
    subtitle="View your account activity history"
    :breadcrumbs="[
        ['title' => 'Profile', 'url' => route('profile.edit')],
        ['title' => 'Activity Log']
    ]">
    <x-slot name="actions">
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <div class="toggle-content">
                    <ul class="nk-block-tools g-3">
                        <li><a href="{{ route('profile.edit') }}" class="btn btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Back to Profile</span></a></li>
                        <li><a href="{{ route('profile.login-history') }}" class="btn btn-outline-light"><em class="icon ni ni-signin"></em><span>Login History</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>
</x-page-header>

<div class="nk-block">
    <div class="row g-gs">
        <div class="col-12">
            <div class="card card-bordered">
                <div class="card-inner-group">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title">Recent Activity</h6>
                            </div>
                            <div class="card-tools">
                                <em class="icon ni ni-activity"></em>
                            </div>
                        </div>
                        <p class="sub-text">Your complete account activity history including logins, profile updates, and other actions.</p>
                    </div>
                    <div class="card-inner">
                        @if($activities->count() > 0)
                            <div class="timeline">
                                @foreach($activities as $activity)
                                    <div class="timeline-item">
                                        <div class="timeline-status bg-{{ $activity->action === 'login' ? 'success' : ($activity->action === 'profile_updated' ? 'info' : 'primary') }}"></div>
                                        <div class="timeline-date">{{ $activity->created_at->format('M d, Y H:i:s') }}</div>
                                        <div class="timeline-data">
                                            <h6 class="timeline-title">{{ ucfirst(str_replace('_', ' ', $activity->action)) }}</h6>
                                            <div class="timeline-des">
                                                <p>
                                                    @if($activity->resource)
                                                        {{ ucfirst($activity->resource) }} activity
                                                    @else
                                                        System activity
                                                    @endif
                                                    from {{ $activity->ip_address }}
                                                </p>
                                                @if($activity->data && is_array($activity->data))
                                                    <div class="timeline-meta">
                                                        <span class="sub-text">Additional details:</span>
                                                        @if(isset($activity->data['url']))
                                                            <br><small class="text-muted">URL: {{ $activity->data['url'] }}</small>
                                                        @endif
                                                        @if(isset($activity->data['method']))
                                                            <br><small class="text-muted">Method: {{ $activity->data['method'] }}</small>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="card-inner">
                                {{ $activities->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <em class="icon ni ni-activity text-muted" style="font-size: 3rem;"></em>
                                <h6 class="text-muted mt-2">No Activity Found</h6>
                                <p class="text-muted">Your account activity will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
