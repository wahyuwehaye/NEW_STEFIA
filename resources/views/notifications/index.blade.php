@extends('layouts.admin')

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Notifications</h3>
                <div class="nk-block-des text-soft">
                    <p>Manage your notifications and reminders</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <button class="btn btn-outline-primary" onclick="markAllAsRead()">
                                    <em class="icon ni ni-check-round"></em><span>Mark All Read</span>
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-outline-danger" onclick="bulkDelete()" disabled id="bulkDeleteBtn">
                                    <em class="icon ni ni-trash"></em><span>Delete Selected</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-md-2">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-2">
                            <div class="card-title">
                                <h6 class="title">Total</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total notifications"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ number_format($stats['total']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-2">
                            <div class="card-title">
                                <h6 class="title">Unread</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Unread notifications"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ number_format($stats['unread']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-2">
                            <div class="card-title">
                                <h6 class="title">Pending</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Pending notifications"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ number_format($stats['pending']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-2">
                            <div class="card-title">
                                <h6 class="title">Sent</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Sent notifications"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ number_format($stats['sent']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-2">
                            <div class="card-title">
                                <h6 class="title">Failed</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Failed notifications"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ number_format($stats['failed']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                <form method="GET" action="{{ route('notifications.index') }}">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Type</label>
                                <select class="form-select" name="type">
                                    <option value="">All Types</option>
                                    <option value="email" {{ request('type') === 'email' ? 'selected' : '' }}>Email</option>
                                    <option value="whatsapp" {{ request('type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                    <option value="system" {{ request('type') === 'system' ? 'selected' : '' }}>System</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select class="form-select" name="category">
                                    <option value="">All Categories</option>
                                    <option value="payment_reminder" {{ request('category') === 'payment_reminder' ? 'selected' : '' }}>Payment Reminder</option>
                                    <option value="overdue_notice" {{ request('category') === 'overdue_notice' ? 'selected' : '' }}>Overdue Notice</option>
                                    <option value="system_alert" {{ request('category') === 'system_alert' ? 'selected' : '' }}>System Alert</option>
                                    <option value="collection_action" {{ request('category') === 'collection_action' ? 'selected' : '' }}>Collection Action</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Priority</label>
                                <select class="form-select" name="priority">
                                    <option value="">All Priorities</option>
                                    <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Date From</label>
                                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label">Date To</label>
                                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search notifications...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">&nbsp;</label>
                                <div class="btn-group d-flex">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                @if($notifications->count() > 0)
                    <div class="nk-tb-list nk-tb-ulist">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="selectAll">
                                    <label class="custom-control-label" for="selectAll"></label>
                                </div>
                            </div>
                            <div class="nk-tb-col"><span>Title</span></div>
                            <div class="nk-tb-col"><span>Type</span></div>
                            <div class="nk-tb-col"><span>Category</span></div>
                            <div class="nk-tb-col"><span>Priority</span></div>
                            <div class="nk-tb-col"><span>Status</span></div>
                            <div class="nk-tb-col"><span>Created</span></div>
                            <div class="nk-tb-col nk-tb-col-tools text-end">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                        <em class="icon ni ni-plus"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="#" onclick="markAllAsRead()"><em class="icon ni ni-check"></em><span>Mark All Read</span></a></li>
                                            <li><a href="#" onclick="bulkDelete()"><em class="icon ni ni-trash"></em><span>Delete Selected</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach($notifications as $notification)
                            <div class="nk-tb-item {{ $notification->read_at ? '' : 'bg-light' }}">
                                <div class="nk-tb-col nk-tb-col-check">
                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                        <input type="checkbox" class="custom-control-input notification-checkbox" id="notification_{{ $notification->id }}" value="{{ $notification->id }}">
                                        <label class="custom-control-label" for="notification_{{ $notification->id }}"></label>
                                    </div>
                                </div>
                                <div class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-avatar bg-{{ $notification->priority_color }}-dim">
                                            <em class="icon ni {{ $notification->category_icon }}"></em>
                                        </div>
                                        <div class="user-info">
                                            <span class="tb-lead">{{ $notification->title }}</span>
                                            <span class="tb-sub">{{ Str::limit($notification->message, 60) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="badge badge-dim bg-outline-{{ $notification->type === 'email' ? 'info' : ($notification->type === 'whatsapp' ? 'success' : 'secondary') }}">
                                        <em class="icon ni {{ $notification->type_icon }}"></em>
                                        {{ ucfirst($notification->type) }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-sub">{{ $notification->category ? ucfirst(str_replace('_', ' ', $notification->category)) : '-' }}</span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="badge badge-dim bg-outline-{{ $notification->priority_color }}">
                                        {{ ucfirst($notification->priority) }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="badge badge-dim bg-outline-{{ $notification->status === 'sent' ? 'success' : ($notification->status === 'failed' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($notification->status) }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-sub">{{ $notification->created_at->format('M j, Y') }}</span>
                                    <span class="tb-sub">{{ $notification->created_at->format('g:i A') }}</span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">
                                        <li>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="{{ route('notifications.show', $notification) }}"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                        @if(!$notification->read_at)
                                                            <li><a href="#" onclick="markAsRead({{ $notification->id }})"><em class="icon ni ni-check"></em><span>Mark as Read</span></a></li>
                                                        @endif
                                                        <li><a href="#" onclick="deleteNotification({{ $notification->id }})" class="text-danger"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="card-inner">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <em class="icon ni ni-bell-off" style="font-size: 3rem; opacity: 0.3;"></em>
                        <h5 class="mt-3">No Notifications Found</h5>
                        <p class="text-muted">No notifications match your current filters.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Select all checkbox functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.notification-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    toggleBulkDeleteBtn();
});

// Individual checkbox functionality
document.querySelectorAll('.notification-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const allCheckboxes = document.querySelectorAll('.notification-checkbox');
        const checkedCheckboxes = document.querySelectorAll('.notification-checkbox:checked');
        
        document.getElementById('selectAll').checked = allCheckboxes.length === checkedCheckboxes.length;
        toggleBulkDeleteBtn();
    });
});

function toggleBulkDeleteBtn() {
    const checkedCheckboxes = document.querySelectorAll('.notification-checkbox:checked');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    bulkDeleteBtn.disabled = checkedCheckboxes.length === 0;
}

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

function markAllAsRead() {
    if (confirm('Are you sure you want to mark all notifications as read?')) {
        fetch('/notifications/mark-all-read', {
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
                location.reload();
            }
        });
    }
}

function bulkDelete() {
    const checkedCheckboxes = document.querySelectorAll('.notification-checkbox:checked');
    const ids = Array.from(checkedCheckboxes).map(checkbox => checkbox.value);
    
    if (ids.length === 0) {
        alert('Please select notifications to delete');
        return;
    }
    
    if (confirm(`Are you sure you want to delete ${ids.length} selected notifications?`)) {
        fetch('/notifications/bulk-delete', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ids: ids})
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
