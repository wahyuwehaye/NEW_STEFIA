@extends('layouts.admin')
@section('title', 'WhatsApp Reminders')
@section('content')
<x-page-header title="WhatsApp Reminders" subtitle="Manage automated WhatsApp reminders for overdue payments">
</x-page-header>

<style>
.stats-card {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
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
    background: #25d366;
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
.btn-test {
    background: #ffc107;
    color: #000;
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
.status-sent { background: #25d366; color: #fff; }
.status-failed { background: #dc3545; color: #fff; }
.status-scheduled { background: #17a2b8; color: #fff; }
.status-delivered { background: #28a745; color: #fff; }
.status-read { background: #007bff; color: #fff; }
.whatsapp-config {
    background: #e8f5e8;
    border: 1px solid #25d366;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}
</style>

<div class="nk-block">
    <!-- WhatsApp API Configuration Status -->
    <div class="whatsapp-config">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="mb-1">WhatsApp API Status</h6>
                <span class="badge {{ $apiStatus['connected'] ?? false ? 'bg-success' : 'bg-danger' }}">
                    {{ $apiStatus['connected'] ?? false ? 'Connected' : 'Disconnected' }}
                </span>
                <small class="text-muted d-block">
                    Provider: {{ $apiStatus['provider'] ?? 'Not configured' }} | 
                    Last sync: {{ $apiStatus['last_sync'] ?? 'Never' }}
                </small>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-sm btn-outline-primary" onclick="testConnection()">Test Connection</button>
                <button class="btn btn-sm btn-primary" onclick="configureAPI()">Configure API</button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);">
                <h3>{{ $stats['total'] ?? 0 }}</h3>
                <p>Total WA Reminders</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #20bf6b 0%, #26d0ce 100%);">
                <h3>{{ $stats['sent'] ?? 0 }}</h3>
                <p>Messages Sent</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $stats['delivered'] ?? 0 }}</h3>
                <p>Delivered</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $stats['read'] ?? 0 }}</h3>
                <p>Read by Recipients</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5>Filter WhatsApp Reminders</h5>
        <form method="GET" action="{{ route('reminders.whatsapp') }}">
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
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Template</label>
                    <select class="form-select" name="template">
                        <option value="">All Templates</option>
                        <option value="reminder" {{ request('template') == 'reminder' ? 'selected' : '' }}>Payment Reminder</option>
                        <option value="overdue" {{ request('template') == 'overdue' ? 'selected' : '' }}>Overdue Notice</option>
                        <option value="warning" {{ request('template') == 'warning' ? 'selected' : '' }}>Warning</option>
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
                    <a href="{{ route('reminders.whatsapp') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn-send" onclick="sendBulkWhatsApp()">Send Bulk Messages</button>
        <button class="btn-schedule" onclick="scheduleWhatsApp()">Schedule Messages</button>
        <button class="btn-test" onclick="sendTestMessage()">Send Test Message</button>
        <button class="btn btn-info" onclick="createTemplate()">Create Template</button>
        <button class="btn btn-secondary" onclick="viewAnalytics()">View Analytics</button>
    </div>

    <!-- WhatsApp Reminders Table -->
    <div class="card">
        <div class="card-inner">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Student</th>
                            <th>Phone Number</th>
                            <th>Outstanding Amount</th>
                            <th>Due Date</th>
                            <th>Template</th>
                            <th>Status</th>
                            <th>Scheduled At</th>
                            <th>Sent At</th>
                            <th>Read At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($whatsappReminders ?? [] as $reminder)
                        <tr>
                            <td><input type="checkbox" name="reminder_ids[]" value="{{ $reminder->id }}"></td>
                            <td>
                                <strong>{{ $reminder->student_name }}</strong><br>
                                <small class="text-muted">{{ $reminder->student_nim }}</small>
                            </td>
                            <td>{{ $reminder->phone_number }}</td>
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
                                @if($reminder->delivery_status)
                                    <small class="d-block text-muted">{{ $reminder->delivery_status }}</small>
                                @endif
                            </td>
                            <td>{{ $reminder->scheduled_at ? $reminder->scheduled_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $reminder->sent_at ? $reminder->sent_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $reminder->read_at ? $reminder->read_at->format('d/m/Y H:i') : '-' }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($reminder->status == 'pending' || $reminder->status == 'failed')
                                            <li><a class="dropdown-item" href="#" onclick="sendNow({{ $reminder->id }})">Send Now</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="reschedule({{ $reminder->id }})">Reschedule</a></li>
                                        @endif
                                        <li><a class="dropdown-item" href="#" onclick="previewMessage({{ $reminder->id }})">Preview</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="checkStatus({{ $reminder->id }})">Check Status</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="viewHistory({{ $reminder->id }})">View History</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="cancelReminder({{ $reminder->id }})">Cancel</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <i class="fab fa-whatsapp fa-3x text-success mb-3"></i>
                                <p class="text-muted">No WhatsApp reminders found</p>
                                <button class="btn btn-success" onclick="createFirstWhatsApp()">Create First Reminder</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($whatsappReminders) && $whatsappReminders->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $whatsappReminders->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Send WhatsApp Modal -->
<div class="modal fade" id="sendWhatsAppModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Send WhatsApp Reminder</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="sendWhatsAppForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Template</label>
                        <select class="form-select" name="template_id" required>
                            <option value="">Choose template...</option>
                            <option value="reminder">Payment Reminder</option>
                            <option value="overdue">Overdue Payment Notice</option>
                            <option value="warning">Payment Warning</option>
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
                        <small class="text-muted">Note: WhatsApp messages should be sent during business hours for better delivery rates.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message Options</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="include_payment_link" value="1">
                            <label class="form-check-label">Include Payment Link</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="request_read_receipt" value="1" checked>
                            <label class="form-check-label">Request Read Receipt</label>
                        </div>
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
                    <button type="submit" class="btn btn-success">Send Messages</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- WhatsApp API Configuration Modal -->
<div class="modal fade" id="apiConfigModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">WhatsApp API Configuration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="apiConfigForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">API Provider</label>
                        <select class="form-select" name="provider" required>
                            <option value="">Choose provider...</option>
                            <option value="wablas">Wablas</option>
                            <option value="fonnte">Fonnte</option>
                            <option value="whatsapp_business">WhatsApp Business API</option>
                            <option value="twilio">Twilio</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API Token/Key</label>
                        <input type="text" class="form-control" name="api_token" placeholder="Enter your API token">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">API URL (Optional)</label>
                        <input type="url" class="form-control" name="api_url" placeholder="https://api.provider.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sender Number</label>
                        <input type="text" class="form-control" name="sender_number" placeholder="628123456789">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Message Preview Modal -->
<div class="modal fade" id="messagePreviewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">WhatsApp Message Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="whatsapp-preview-container">
                    <div id="messagePreviewContent" class="whatsapp-message">
                        <!-- Message preview will be loaded here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="sendPreviewedMessage">Send This Message</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.whatsapp-preview-container {
    background: #075e54;
    padding: 20px;
    border-radius: 10px;
    max-width: 300px;
    margin: 0 auto;
}
.whatsapp-message {
    background: #dcf8c6;
    padding: 10px 15px;
    border-radius: 18px;
    color: #000;
    font-size: 14px;
    position: relative;
    margin-left: auto;
    max-width: 250px;
    word-wrap: break-word;
}
.whatsapp-message::after {
    content: '';
    position: absolute;
    top: 0;
    right: -10px;
    width: 0;
    height: 0;
    border: 10px solid transparent;
    border-left-color: #dcf8c6;
    border-right: 0;
    border-top: 0;
    margin-top: 10px;
}
</style>
@endpush

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
function sendBulkWhatsApp() {
    const checkedBoxes = document.querySelectorAll('input[name="reminder_ids[]"]:checked');
    if (checkedBoxes.length === 0) {
        alert('Please select at least one reminder to send.');
        return;
    }
    new bootstrap.Modal(document.getElementById('sendWhatsAppModal')).show();
}

function scheduleWhatsApp() {
    document.querySelector('input[name="send_mode"][value="schedule"]').checked = true;
    document.getElementById('scheduleDateTime').style.display = 'block';
    new bootstrap.Modal(document.getElementById('sendWhatsAppModal')).show();
}

function sendTestMessage() {
    const testNumber = prompt('Enter WhatsApp number for test message (e.g., 628123456789):');
    if (testNumber) {
        fetch('/reminders/whatsapp/test', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ phone_number: testNumber })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Test message sent successfully!');
            } else {
                alert('Failed to send test message: ' + data.message);
            }
        });
    }
}

function testConnection() {
    fetch('/reminders/whatsapp/test-connection', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.success ? 'Connection successful!' : 'Connection failed: ' + data.message);
    });
}

function configureAPI() {
    new bootstrap.Modal(document.getElementById('apiConfigModal')).show();
}

function sendNow(reminderId) {
    if (confirm('Send WhatsApp reminder now?')) {
        fetch(`/reminders/whatsapp/${reminderId}/send`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('WhatsApp message sent successfully!');
                location.reload();
            } else {
                alert('Failed to send message: ' + data.message);
            }
        });
    }
}

function previewMessage(reminderId) {
    fetch(`/reminders/whatsapp/${reminderId}/preview`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('messagePreviewContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('messagePreviewModal')).show();
        });
}

function checkStatus(reminderId) {
    fetch(`/reminders/whatsapp/${reminderId}/status`)
        .then(response => response.json())
        .then(data => {
            alert(`Status: ${data.status}\nDelivery: ${data.delivery_status}\nRead: ${data.read_at || 'Not read'}`);
        });
}

function reschedule(reminderId) {
    const newDate = prompt('Enter new schedule date (YYYY-MM-DD HH:MM):');
    if (newDate) {
        fetch(`/reminders/whatsapp/${reminderId}/reschedule`, {
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
    if (confirm('Cancel this WhatsApp reminder?')) {
        fetch(`/reminders/whatsapp/${reminderId}/cancel`, {
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
    window.location.href = `/reminders/whatsapp/${reminderId}/history`;
}

function createTemplate() {
    window.location.href = '{{ route("reminders.templates") }}';
}

function viewAnalytics() {
    window.location.href = '/reminders/whatsapp/analytics';
}

function createFirstWhatsApp() {
    sendBulkWhatsApp();
}

// Handle forms
document.getElementById('sendWhatsAppForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const checkedBoxes = document.querySelectorAll('input[name="reminder_ids[]"]:checked');
    const reminderIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    formData.append('reminder_ids', JSON.stringify(reminderIds));
    
    fetch('/reminders/whatsapp/send-bulk', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('WhatsApp reminders processed successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
});

document.getElementById('apiConfigForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/reminders/whatsapp/configure', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('API configuration saved successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
});
</script>
@endpush
@endsection
