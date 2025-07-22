@extends('layouts.admin')

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Reminder Management</h3>
                <div class="nk-block-des text-soft">
                    <p>Manage payment reminders, overdue notices, and system alerts</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <a href="{{ route('reminders.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus"></em><span>Create Reminder</span>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <a href="#" class="btn btn-outline-light btn-icon dropdown-toggle" data-bs-toggle="dropdown">
                                        <em class="icon ni ni-setting"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="#" onclick="processScheduled()"><em class="icon ni ni-clock"></em><span>Process Scheduled</span></a></li>
                                            <li><a href="#" onclick="retryFailed()"><em class="icon ni ni-repeat"></em><span>Retry Failed</span></a></li>
                                            <li><a href="#" onclick="loadTemplates()"><em class="icon ni ni-template"></em><span>Templates</span></a></li>
                                        </ul>
                                    </div>
                                </div>
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
            <div class="col-md-3">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-2">
                            <div class="card-title">
                                <h6 class="title">Total Notifications</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Total notifications sent"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ number_format($stats['total']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group align-start mb-2">
                            <div class="card-title">
                                <h6 class="title">Sent</h6>
                            </div>
                            <div class="card-tools">
                                <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Successfully sent"></em>
                            </div>
                        </div>
                        <div class="card-amount">
                            <span class="amount">{{ number_format($stats['sent']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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

    <!-- Quick Actions -->
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-head-content">
                        <h6 class="nk-block-title">Quick Actions</h6>
                        <p class="text-soft">Send bulk reminders and notifications</p>
                    </div>
                </div>
                
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Payment Reminders</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="icon ni ni-money text-primary" style="font-size: 2rem;"></em>
                                    </div>
                                </div>
                                <p class="text-soft">Send payment reminders to students with upcoming due dates.</p>
                                <div class="card-tools mt-3">
                                    <button class="btn btn-primary" onclick="openPaymentReminderModal()">
                                        <em class="icon ni ni-send"></em><span>Send Reminders</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-3">
                                    <div class="card-title">
                                        <h6 class="title">Overdue Notices</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="icon ni ni-alert-circle text-warning" style="font-size: 2rem;"></em>
                                    </div>
                                </div>
                                <p class="text-soft">Send overdue notices to students with outstanding balances.</p>
                                <div class="card-tools mt-3">
                                    <button class="btn btn-warning" onclick="openOverdueNoticeModal()">
                                        <em class="icon ni ni-send"></em><span>Send Notices</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card card-bordered card-full">
                            <div class="card-inner">
                                <div class="card-title-group align-start mb-3">
                                    <div class="card-title">
                                        <h6 class="title">System Alerts</h6>
                                    </div>
                                    <div class="card-tools">
                                        <em class="icon ni ni-bell text-info" style="font-size: 2rem;"></em>
                                    </div>
                                </div>
                                <p class="text-soft">Send system alerts and announcements to all users.</p>
                                <div class="card-tools mt-3">
                                    <button class="btn btn-info" onclick="openSystemAlertModal()">
                                        <em class="icon ni ni-send"></em><span>Send Alert</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Statistics by Type -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-md-6">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-head-content">
                                <h6 class="nk-block-title">By Type</h6>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-static">
                                            <span class="badge badge-dim bg-outline-info">{{ number_format($stats['by_type']['email']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">WhatsApp</label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-static">
                                            <span class="badge badge-dim bg-outline-success">{{ number_format($stats['by_type']['whatsapp']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">System</label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-static">
                                            <span class="badge badge-dim bg-outline-secondary">{{ number_format($stats['by_type']['system']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-head-content">
                                <h6 class="nk-block-title">By Priority</h6>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">Urgent</label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-static">
                                            <span class="badge badge-dim bg-outline-danger">{{ number_format($stats['by_priority']['urgent']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">High</label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-static">
                                            <span class="badge badge-dim bg-outline-warning">{{ number_format($stats['by_priority']['high']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">Normal</label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-static">
                                            <span class="badge badge-dim bg-outline-info">{{ number_format($stats['by_priority']['normal']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">Low</label>
                                    <div class="form-control-wrap">
                                        <div class="form-control-static">
                                            <span class="badge badge-dim bg-outline-secondary">{{ number_format($stats['by_priority']['low']) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reminder List & Actions -->
    <div class="nk-block mt-4">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="nk-block-head nk-block-head-sm mb-3">
                    <div class="nk-block-head-content">
                        <h6 class="nk-block-title">Recent Reminders</h6>
                        <div class="form-inline mt-2">
                            <select class="form-select me-2" id="filterStatus" onchange="filterReminders()">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="sent">Sent</option>
                                <option value="failed">Failed</option>
                                <option value="overdue">Overdue</option>
                            </select>
                            <select class="form-select me-2" id="filterType" onchange="filterReminders()">
                                <option value="">All Type</option>
                                <option value="email">Email</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="system">System</option>
                            </select>
                            <input type="text" class="form-control" id="searchReminder" placeholder="Search..." onkeyup="filterReminders()" style="max-width:200px;">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="reminderTable">
                        <thead>
                            <tr>
                                <th>Recipient</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Scheduled</th>
                                <th>Sent At</th>
                                <th>Error</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            // Dummy data jika belum ada $reminders
                            $reminders = $reminders ?? [
                                [
                                    'recipient' => 'John Doe',
                                    'type' => 'email',
                                    'title' => 'Payment Reminder',
                                    'status' => 'pending',
                                    'scheduled_at' => '2025-01-15 08:00:00',
                                    'sent_at' => null,
                                    'error_message' => null
                                ],
                                [
                                    'recipient' => 'Jane Smith',
                                    'type' => 'whatsapp',
                                    'title' => 'Overdue Notice',
                                    'status' => 'failed',
                                    'scheduled_at' => '2025-01-10 08:00:00',
                                    'sent_at' => null,
                                    'error_message' => 'WhatsApp API error: number not registered.'
                                ],
                                [
                                    'recipient' => 'Bob Johnson',
                                    'type' => 'system',
                                    'title' => 'System Alert',
                                    'status' => 'sent',
                                    'scheduled_at' => '2025-01-11 09:00:00',
                                    'sent_at' => '2025-01-11 09:01:00',
                                    'error_message' => null
                                ],
                                [
                                    'recipient' => 'Maria Anderson',
                                    'type' => 'email',
                                    'title' => 'Payment Reminder',
                                    'status' => 'overdue',
                                    'scheduled_at' => '2025-01-09 08:00:00',
                                    'sent_at' => null,
                                    'error_message' => null
                                ],
                            ];
                            @endphp
                            @foreach($reminders as $reminder)
                            <tr data-status="{{ $reminder['status'] }}" data-type="{{ $reminder['type'] }}" data-title="{{ strtolower($reminder['title']) }}" data-recipient="{{ strtolower($reminder['recipient']) }}">
                                <td>{{ $reminder['recipient'] }}</td>
                                <td><span class="badge bg-outline-{{ $reminder['type'] == 'email' ? 'info' : ($reminder['type'] == 'whatsapp' ? 'success' : 'secondary') }}">{{ ucfirst($reminder['type']) }}</span></td>
                                <td>{{ $reminder['title'] }}</td>
                                <td>
                                    @php
                                        $badge = [
                                            'pending' => 'warning',
                                            'sent' => 'success',
                                            'failed' => 'danger',
                                            'overdue' => 'info',
                                        ][$reminder['status']] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ ucfirst($reminder['status']) }}</span>
                                </td>
                                <td>{{ $reminder['scheduled_at'] }}</td>
                                <td>{{ $reminder['sent_at'] ?? '-' }}</td>
                                <td>
                                    @if($reminder['error_message'])
                                        <span class="text-danger" title="{{ $reminder['error_message'] }}">{{ Str::limit($reminder['error_message'], 24) }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($reminder['status'] == 'failed' || $reminder['status'] == 'overdue')
                                        <button class="btn btn-sm btn-warning" onclick="retryReminder(this)"><em class="icon ni ni-repeat"></em> Retry</button>
                                        <button class="btn btn-sm btn-info" onclick="rescheduleReminder(this)"><em class="icon ni ni-clock"></em> Reschedule</button>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Reminder Modal -->
<div class="modal fade" tabindex="-1" id="paymentReminderModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Send Payment Reminders</h6>
                <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="paymentReminderForm">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Students & Payment Details</label>
                                <div id="studentsContainer">
                                    <div class="student-row border rounded p-3 mb-3">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <select class="form-select" name="students[0][user_id]" required>
                                                    <option value="">Select Student</option>
                                                    <!-- Will be populated via AJAX -->
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="number" class="form-control" name="students[0][amount]" placeholder="Amount" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="date" class="form-control" name="students[0][due_date]" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" name="students[0][fee_type]" placeholder="Fee Type" required>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeStudentRow(this)">
                                                    <em class="icon ni ni-cross"></em>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addStudentRow()">
                                    <em class="icon ni ni-plus"></em><span>Add Student</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sendPaymentReminders()">Send Reminders</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let studentRowIndex = 1;

function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 show fade-in`;
    toast.style = 'min-width:260px; margin-bottom:8px;';
    toast.innerHTML = `<div class='d-flex'><div class='toast-body'>${message}</div><button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button></div>`;
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = 9999;
        document.body.appendChild(container);
    }
    container.appendChild(toast);
    setTimeout(() => { toast.classList.remove('show'); toast.remove(); }, 3500);
}

function openPaymentReminderModal() {
    $('#paymentReminderModal').modal('show');
    loadUsers();
}

function openOverdueNoticeModal() {
    showToast('Overdue Notice modal - to be implemented', 'info');
}

function openSystemAlertModal() {
    showToast('System Alert modal - to be implemented', 'info');
}

function addStudentRow() {
    const container = document.getElementById('studentsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'student-row border rounded p-3 mb-3';
    newRow.innerHTML = `
        <div class="row g-3">
            <div class="col-md-3">
                <select class="form-select" name="students[${studentRowIndex}][user_id]" required>
                    <option value="">Select Student</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control" name="students[${studentRowIndex}][amount]" placeholder="Amount" required>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="students[${studentRowIndex}][due_date]" required>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" name="students[${studentRowIndex}][fee_type]" placeholder="Fee Type" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeStudentRow(this)">
                    <em class="icon ni ni-cross"></em>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newRow);
    studentRowIndex++;
    loadUsersForRow(newRow);
}

function removeStudentRow(button) {
    button.closest('.student-row').remove();
}

function loadUsers() {
    // Load users for all existing rows
    document.querySelectorAll('.student-row').forEach(row => {
        loadUsersForRow(row);
    });
}

function loadUsersForRow(row) {
    const select = row.querySelector('select');
    // In a real implementation, you would fetch users via AJAX
    // For demo purposes, we'll add some dummy options
    select.innerHTML = `
        <option value="">Select Student</option>
        <option value="1">John Doe</option>
        <option value="2">Jane Smith</option>
        <option value="3">Bob Johnson</option>
    `;
}

function sendPaymentReminders() {
    const form = document.getElementById('paymentReminderForm');
    const formData = new FormData(form);
    
    // Convert FormData to JSON
    const students = [];
    let index = 0;
    while (formData.get(`students[${index}][user_id]`)) {
        students.push({
            user_id: formData.get(`students[${index}][user_id]`),
            amount: formData.get(`students[${index}][amount]`),
            due_date: formData.get(`students[${index}][due_date]`),
            fee_type: formData.get(`students[${index}][fee_type]`)
        });
        index++;
    }
    
    fetch('/reminders/payment-reminders', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ students: students })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            $('#paymentReminderModal').modal('hide');
            setTimeout(() => location.reload(), 1200);
        } else {
            showToast(data.message || 'Failed to send reminders', 'danger');
        }
    })
    .catch(error => {
        showToast('An error occurred while sending reminders', 'danger');
    });
}

function processScheduled() {
    fetch('/reminders/process-scheduled', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, data.processed > 0 ? 'success' : 'info');
        if (data.processed > 0) setTimeout(() => location.reload(), 1200);
    });
}

function retryFailed() {
    fetch('/reminders/retry-failed', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, data.retried > 0 ? 'success' : 'danger');
        if (data.retried > 0) setTimeout(() => location.reload(), 1200);
    });
}

function loadTemplates() {
    fetch('/reminders/templates')
    .then(response => response.json())
    .then(data => {
        showToast('Templates loaded - check console for details', 'info');
        console.log('Templates:', data);
    });
}

function filterReminders() {
    const status = document.getElementById('filterStatus').value;
    const type = document.getElementById('filterType').value;
    const search = document.getElementById('searchReminder').value.toLowerCase();
    document.querySelectorAll('#reminderTable tbody tr').forEach(row => {
        const rowStatus = row.getAttribute('data-status');
        const rowType = row.getAttribute('data-type');
        const rowTitle = row.getAttribute('data-title');
        const rowRecipient = row.getAttribute('data-recipient');
        let show = true;
        if (status && rowStatus !== status) show = false;
        if (type && rowType !== type) show = false;
        if (search && !(rowTitle.includes(search) || rowRecipient.includes(search))) show = false;
        row.style.display = show ? '' : 'none';
    });
}

function retryReminder(btn) {
    showToast('Retry reminder - to be implemented (AJAX call to retry)', 'info');
}
function rescheduleReminder(btn) {
    showToast('Reschedule reminder - to be implemented (show modal for new schedule)', 'info');
}
// Feedback notifikasi sukses/gagal setelah aksi
@if(session('success'))
    window.setTimeout(() => { showToast(@json(session('success')), 'success'); }, 500);
@endif
@if(session('error'))
    window.setTimeout(() => { showToast(@json(session('error')), 'danger'); }, 500);
@endif
</script>
@endpush
@push('styles')
<style>
.toast-container { pointer-events: none; }
.toast { pointer-events: auto; min-width: 260px; }
</style>
@endpush
@endsection
