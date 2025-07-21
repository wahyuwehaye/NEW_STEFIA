@extends('layouts.admin')
@section('title', 'Email Reminders')
@section('content')
<x-page-header title="Email Reminders" subtitle="Manage automated email reminders for overdue payments">
</x-page-header>

<style>
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    text-align: center;
}
.stats-card h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: bold;
}
.stats-card p {
    margin: 5px 0 0 0;
    opacity: 0.9;
}
.filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}
.action-buttons {
    margin-bottom: 20px;
}
.table-responsive {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
.btn-send {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    margin-right: 10px;
}
.btn-schedule {
    background: #17a2b8;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    margin-right: 10px;
}
.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}
.status-pending { background: #ffc107; color: #000; }
.status-sent { background: #28a745; color: #fff; }
.status-failed { background: #dc3545; color: #fff; }
.status-scheduled { background: #17a2b8; color: #fff; }
</style>

<div class="nk-block">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h3>{{ $stats['total'] ?? 0 }}</h3>
                <p>Total Email Reminders</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $stats['sent'] ?? 0 }}</h3>
                <p>Emails Sent</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $stats['scheduled'] ?? 0 }}</h3>
                <p>Scheduled</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ $stats['failed'] ?? 0 }}</h3>
                <p>Failed</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5>Filter Email Reminders</h5>
        <form method="GET" action="{{ route('reminders.email') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Student Name/NIM</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search student...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Template</label>
                    <select class="form-select" name="template">
                        <option value="">All Templates</option>
                        <option value="overdue" {{ request('template') == 'overdue' ? 'selected' : '' }}>Overdue Notice</option>
                        <option value="warning" {{ request('template') == 'warning' ? 'selected' : '' }}>Payment Warning</option>
                        <option value="reminder" {{ request('template') == 'reminder' ? 'selected' : '' }}>Payment Reminder</option>
                        <option value="final" {{ request('template') == 'final' ? 'selected' : '' }}>Final Notice</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date Range</label>
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-12 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('reminders.email') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn-send" onclick="sendBulkReminder()">Send Bulk Reminders</button>
        <button class="btn-schedule" onclick="scheduleReminder()">Schedule Reminder</button>
        <button class="btn btn-info" onclick="createTemplate()">Create Template</button>
        <button class="btn btn-secondary" onclick="viewAnalytics()">View Analytics</button>
    </div>

    <!-- Email Reminders Table -->
    <div class="card">
        <div class="card-inner">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Student</th>
                            <th>Email</th>
                            <th>Outstanding Amount</th>
                            <th>Due Date</th>
                            <th>Template</th>
                            <th>Status</th>
                            <th>Scheduled At</th>
                            <th>Sent At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emailReminders ?? [] as $reminder)
                        <tr>
                            <td><input type="checkbox" name="reminder_ids[]" value="{{ $reminder->id }}"></td>
                            <td>
                                <strong>{{ $reminder->student_name }}</strong><br>
                                <small class="text-muted">{{ $reminder->student_nim }}</small>
                            </td>
                            <td>{{ $reminder->email }}</td>
                            <td class="text-danger fw-bold">Rp {{ number_format($reminder->outstanding_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="{{ $reminder->is_overdue ? 'text-danger' : 'text-warning' }}">
                                    {{ $reminder->due_date ? $reminder->due_date->format('d/m/Y') : 'N/A' }}
                                </span>
                            </td>
                            <td>{{ ucfirst($reminder->template_type ?? 'default') }}</td>
                            <td>
                                <span class="status-badge status-{{ $reminder->status }}">
                                    {{ ucfirst($reminder->status) }}
                                </span>
                            </td>
                            <td>{{ $reminder->scheduled_at ? $reminder->scheduled_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $reminder->sent_at ? $reminder->sent_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($reminder->status == 'pending' || $reminder->status == 'failed')
                                            <li><a class="dropdown-item" href="#" onclick="sendNow({{ $reminder->id }})">Send Now</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="reschedule({{ $reminder->id }})">Reschedule</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="#" onclick="previewEmail({{ $reminder->id }})">Preview</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="viewHistory({{ $reminder->id }})">View History</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="cancelReminder({{ $reminder->id }})">Cancel</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No email reminders found</p>
                                <button class="btn btn-primary" onclick="createFirstReminder()">Create First Reminder</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($emailReminders) && $emailReminders->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $emailReminders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Send Reminder Modal -->
<div class="modal fade" id="sendReminderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Email Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="sendReminderForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Template</label>
                        <select class="form-select" name="template_id" required>
                            <option value="">Choose template...</option>
                            <option value="overdue">Overdue Payment Notice</option>
                            <option value="warning">Payment Warning</option>
                            <option value="reminder">Payment Reminder</option>
                            <option value="final">Final Notice</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Send Mode</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="send_mode" value="now" checked>
                            <label class="form-check-label">Send Now</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="send_mode" value="schedule">
                            <label class="form-check-label">Schedule for Later</label>
                        </div>
                    </div>
                    <div id="scheduleDateTime" class="mb-3" style="display: none;">
                        <label class="form-label">Schedule Date & Time</label>
                        <input type="datetime-local" class="form-control" name="scheduled_at">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Filter Recipients</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Minimum Outstanding</label>
                                <input type="number" class="form-control" name="min_outstanding" placeholder="e.g., 1000000">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Days Overdue</label>
                                <input type="number" class="form-control" name="days_overdue" placeholder="e.g., 30">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Reminders</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Preview Modal -->
<div class="modal fade" id="emailPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="emailPreviewContent">
                    <!-- Email preview will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendPreviewedEmail">Send This Email</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle schedule datetime input
document.querySelectorAll('input[name="send_mode"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const scheduleDiv = document.getElementById('scheduleDateTime');
        if (this.value === 'schedule') {
            scheduleDiv.style.display = 'block';
        } else {
            scheduleDiv.style.display = 'none';
        }
    });
});

// Select all checkbox
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('input[name="reminder_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});

// Functions
function sendBulkReminder() {
    const checkedBoxes = document.querySelectorAll('input[name="reminder_ids[]"]:checked');
    if (checkedBoxes.length === 0) {
        alert('Please select at least one reminder to send.');
        return;
    }
    new bootstrap.Modal(document.getElementById('sendReminderModal')).show();
}

function scheduleReminder() {
    // Set radio to schedule mode
    document.querySelector('input[name="send_mode"][value="schedule"]').checked = true;
    document.getElementById('scheduleDateTime').style.display = 'block';
    new bootstrap.Modal(document.getElementById('sendReminderModal')).show();
}

function sendNow(reminderId) {
    if (confirm('Send email reminder now?')) {
        fetch(`/reminders/email/${reminderId}/send`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email sent successfully!');
                location.reload();
            } else {
                alert('Failed to send email: ' + data.message);
            }
        });
    }
}

function previewEmail(reminderId) {
    fetch(`/reminders/email/${reminderId}/preview`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('emailPreviewContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('emailPreviewModal')).show();
        });
}

function reschedule(reminderId) {
    const newDate = prompt('Enter new schedule date (YYYY-MM-DD HH:MM):');
    if (newDate) {
        fetch(`/reminders/email/${reminderId}/reschedule`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ scheduled_at: newDate })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Reminder rescheduled successfully!');
                location.reload();
            } else {
                alert('Failed to reschedule: ' + data.message);
            }
        });
    }
}

function cancelReminder(reminderId) {
    if (confirm('Cancel this reminder?')) {
        fetch(`/reminders/email/${reminderId}/cancel`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Reminder cancelled successfully!');
                location.reload();
            } else {
                alert('Failed to cancel reminder: ' + data.message);
            }
        });
    }
}

function viewHistory(reminderId) {
    window.location.href = `/reminders/email/${reminderId}/history`;
}

function createTemplate() {
    window.location.href = '{{ route("reminders.templates") }}';
}

function viewAnalytics() {
    window.location.href = '/reminders/email/analytics';
}

function createFirstReminder() {
    sendBulkReminder();
}

// Handle send reminder form
document.getElementById('sendReminderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const checkedBoxes = document.querySelectorAll('input[name="reminder_ids[]"]:checked');
    const reminderIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    formData.append('reminder_ids', JSON.stringify(reminderIds));
    
    fetch('/reminders/email/send-bulk', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Reminders processed successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('An error occurred while processing reminders.');
        console.error(error);
    });
});
</script>
@endpush
@endsection
