@extends('layouts.admin')

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <div class="nk-block-des">
                    <a href="{{ route('notifications.index') }}" class="back-to text-primary">
                        <em class="icon ni ni-arrow-left"></em><span>Back to Notifications</span>
                    </a>
                </div>
                <h3 class="nk-block-title page-title">{{ $notification->title }}</h3>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            @if(!$notification->read_at)
                                <li>
                                    <button class="btn btn-outline-primary" onclick="markAsRead({{ $notification->id }})">
                                        <em class="icon ni ni-check"></em><span>Mark as Read</span>
                                    </button>
                                </li>
                            @endif
                            <li>
                                <button class="btn btn-outline-danger" onclick="deleteNotification({{ $notification->id }})">
                                    <em class="icon ni ni-trash"></em><span>Delete</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nk-block">
        <div class="row g-gs">
            <!-- Main Content -->
            <div class="col-xl-8">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between">
                                <div class="nk-block-head-content">
                                    <h4 class="nk-block-title">{{ $notification->title }}</h4>
                                    <div class="nk-block-des">
                                        <p class="text-soft">{{ $notification->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="nk-block-head-content">
                                    <div class="user-avatar bg-{{ $notification->priority_color }}-dim">
                                        <em class="icon ni {{ $notification->category_icon }}"></em>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="nk-block">
                            <div class="card card-bordered card-stretch">
                                <div class="card-inner">
                                    <div class="content-area">
                                        <div class="message-content">
                                            {!! nl2br(e($notification->message)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($notification->data && is_array($notification->data))
                            <div class="nk-block">
                                <h6 class="title">Additional Information</h6>
                                <div class="card card-bordered">
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            @foreach($notification->data as $key => $value)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                        <div class="form-control-wrap">
                                                            <div class="form-control-static">
                                                                @if(is_array($value) || is_object($value))
                                                                    <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                                @else
                                                                    {{ $value }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($notification->error_message)
                            <div class="nk-block">
                                <h6 class="title">Error Information</h6>
                                <div class="alert alert-danger">
                                    <div class="alert-body">
                                        <h6>Error Message</h6>
                                        <p>{{ $notification->error_message }}</p>
                                        <small class="text-muted">Retry Count: {{ $notification->retry_count }}</small>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-4">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-head-content">
                                <h6 class="nk-block-title">Notification Details</h6>
                            </div>
                        </div>
                        
                        <div class="nk-block">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Type</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-static">
                                                <span class="badge badge-dim bg-outline-{{ $notification->type === 'email' ? 'info' : ($notification->type === 'whatsapp' ? 'success' : 'secondary') }}">
                                                    <em class="icon ni {{ $notification->type_icon }}"></em>
                                                    {{ ucfirst($notification->type) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Priority</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-static">
                                                <span class="badge badge-dim bg-outline-{{ $notification->priority_color }}">
                                                    {{ ucfirst($notification->priority) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-static">
                                                <span class="badge badge-dim bg-outline-{{ $notification->status === 'sent' ? 'success' : ($notification->status === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($notification->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Category</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-static">
                                                {{ $notification->category ? ucfirst(str_replace('_', ' ', $notification->category)) : 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Created</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-static">
                                                {{ $notification->created_at->format('F j, Y \a\t g:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($notification->sent_at)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Sent</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-static">
                                                    {{ $notification->sent_at->format('F j, Y \a\t g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($notification->read_at)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Read</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-static">
                                                    {{ $notification->read_at->format('F j, Y \a\t g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($notification->scheduled_at)
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Scheduled</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-static">
                                                    {{ $notification->scheduled_at->format('F j, Y \a\t g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Actions -->
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-head-content">
                                <h6 class="nk-block-title">Actions</h6>
                            </div>
                        </div>
                        
                        <div class="nk-block">
                            <ul class="link-list-opt no-bdr">
                                @if(!$notification->read_at)
                                    <li>
                                        <a href="#" onclick="markAsRead({{ $notification->id }})">
                                            <em class="icon ni ni-check text-success"></em>
                                            <span>Mark as Read</span>
                                        </a>
                                    </li>
                                @endif
                                
                                @if($notification->status === 'failed' && $notification->retry_count < 3)
                                    <li>
                                        <a href="#" onclick="retryNotification({{ $notification->id }})">
                                            <em class="icon ni ni-repeat text-warning"></em>
                                            <span>Retry Send</span>
                                        </a>
                                    </li>
                                @endif
                                
                                <li>
                                    <a href="#" onclick="deleteNotification({{ $notification->id }})" class="text-danger">
                                        <em class="icon ni ni-trash text-danger"></em>
                                        <span>Delete Notification</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/notifications/${notificationId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/notifications';
            }
        });
    }
}

function retryNotification(notificationId) {
    if (confirm('Are you sure you want to retry sending this notification?')) {
        fetch(`/notifications/${notificationId}/retry`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection
