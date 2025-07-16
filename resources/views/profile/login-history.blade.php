@extends('layouts.admin')

@section('title', 'Login History')

@section('content')
<x-page-header 
    title="Login History" 
    subtitle="View your login history and security logs"
    :breadcrumbs="[
        ['title' => 'Profile', 'url' => route('profile.edit')],
        ['title' => 'Login History']
    ]">
    <x-slot name="actions">
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <div class="toggle-content">
                    <ul class="nk-block-tools g-3">
                        <li><a href="{{ route('profile.edit') }}" class="btn btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Back to Profile</span></a></li>
                        <li><a href="{{ route('profile.activity') }}" class="btn btn-outline-light"><em class="icon ni ni-activity"></em><span>All Activity</span></a></li>
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
                                <h6 class="title">Login History</h6>
                            </div>
                            <div class="card-tools">
                                <em class="icon ni ni-signin"></em>
                            </div>
                        </div>
                        <p class="sub-text">Your complete login history including IP addresses, timestamps, and device information.</p>
                    </div>
                    <div class="card-inner">
                        @if($loginHistory->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>IP Address</th>
                                            <th>Device Info</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($loginHistory as $login)
                                            <tr>
                                                <td>
                                                    <div class="user-card">
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{ $login->created_at->format('M d, Y') }}</span>
                                                            <span class="sub-text">{{ $login->created_at->format('h:i A') }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="tb-lead">{{ $login->ip_address }}</span>
                                                </td>
                                                <td>
                                                    <div class="user-info">
                                                        <span class="tb-lead">{{ $login->user_agent ? substr($login->user_agent, 0, 50) : 'Unknown' }}</span>
                                                        <span class="sub-text">{{ $login->ip_address }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-success">Successful</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            <div class="card-inner">
                                {{ $loginHistory->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <em class="icon ni ni-signin text-muted" style="font-size: 3rem;"></em>
                                <h6 class="text-muted mt-2">No Login History Found</h6>
                                <p class="text-muted">Your login history will appear here.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Function to parse user agent (basic)
function parseUserAgent(userAgent) {
    const browser = userAgent.match(/(Chrome|Firefox|Safari|Edge|Opera)\/[\d.]+/);
    const platform = userAgent.match(/(Windows|Mac|Linux|Android|iOS)/);
    
    return {
        browser: browser ? browser[1] : 'Unknown',
        platform: platform ? platform[1] : 'Unknown'
    };
}
</script>
@endpush
@endsection
