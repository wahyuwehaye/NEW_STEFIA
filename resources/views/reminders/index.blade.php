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

function openPaymentReminderModal() {
    $('#paymentReminderModal').modal('show');
    loadUsers();
}

function openOverdueNoticeModal() {
    // Implementation for overdue notice modal
    alert('Overdue Notice modal - to be implemented');
}

function openSystemAlertModal() {
    // Implementation for system alert modal
    alert('System Alert modal - to be implemented');
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
            alert(data.message);
            $('#paymentReminderModal').modal('hide');
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while sending reminders');
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
        alert(data.message);
        if (data.processed > 0) {
            location.reload();
        }
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
        alert(data.message);
        if (data.retried > 0) {
            location.reload();
        }
    });
}

function loadTemplates() {
    fetch('/reminders/templates')
    .then(response => response.json())
    .then(data => {
        console.log('Templates:', data);
        alert('Templates loaded - check console for details');
    });
}
</script>
@endpush
@endsection
