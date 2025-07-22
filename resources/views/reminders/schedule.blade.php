@extends('layouts.admin')
@section('title', 'Reminder Schedule')
@section('content')
<x-page-header title="Reminder Schedule" subtitle="Manage automated reminder schedules and recurring tasks">
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
.schedule-card {
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin-bottom: 20px;
}
.schedule-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.15);
}
.schedule-header {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 12px 12px 0 0;
}
.schedule-body {
    padding: 20px;
    background: white;
    border-radius: 0 0 12px 12px;
}
.cron-display {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 10px;
    font-family: monospace;
    font-size: 14px;
}
.status-active { 
    background: #28a745; 
    color: white; 
    padding: 4px 12px; 
    border-radius: 20px; 
    font-size: 12px; 
    font-weight: bold;
}
.status-inactive { 
    background: #dc3545; 
    color: white; 
    padding: 4px 12px; 
    border-radius: 20px; 
    font-size: 12px; 
    font-weight: bold;
}
.status-paused { 
    background: #ffc107; 
    color: #000; 
    padding: 4px 12px; 
    border-radius: 20px; 
    font-size: 12px; 
    font-weight: bold;
}
.frequency-badge {
    background: #17a2b8;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: bold;
}
.next-run {
    background: #e8f5e8;
    border: 1px solid #28a745;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 13px;
    color: #155724;
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
.cron-builder {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 15px;
    margin: 15px 0;
}
</style>

@if(session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
  <div class="toast align-items-center text-bg-success border-0 show fade-in" role="alert">
    <div class="d-flex">
      <div class="toast-body">{{ session('success') }}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif
@if(session('error'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
  <div class="toast align-items-center text-bg-danger border-0 show fade-in" role="alert">
    <div class="d-flex">
      <div class="toast-body">{{ session('error') }}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif

<div class="nk-block">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h3>{{ $stats['total'] ?? 0 }}</h3>
                <p>Total Schedules</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $stats['active'] ?? 0 }}</h3>
                <p>Active Schedules</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $stats['executed'] ?? 0 }}</h3>
                <p>Executed Today</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ $stats['pending'] ?? 0 }}</h3>
                <p>Pending Execution</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5>Filter Schedules</h5>
        <form method="GET" action="{{ route('reminders.schedule') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Schedule Type</label>
                    <select class="form-select" name="type">
                        <option value="">All Types</option>
                        <option value="email" {{ request('type') == 'email' ? 'selected' : '' }}>Email Reminders</option>
                        <option value="whatsapp" {{ request('type') == 'whatsapp' ? 'selected' : '' }}>WhatsApp Reminders</option>
                        <option value="overdue" {{ request('type') == 'overdue' ? 'selected' : '' }}>Overdue Check</option>
                        <option value="payment" {{ request('type') == 'payment' ? 'selected' : '' }}>Payment Follow-up</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="paused" {{ request('status') == 'paused' ? 'selected' : '' }}>Paused</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Frequency</label>
                    <select class="form-select" name="frequency">
                        <option value="">All Frequencies</option>
                        <option value="daily" {{ request('frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ request('frequency') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ request('frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="custom" {{ request('frequency') == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search schedules...">
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-12 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('reminders.schedule') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn btn-primary" onclick="createSchedule()">Create New Schedule</button>
        <button class="btn btn-success" onclick="runAllActive()">Run All Active</button>
        <button class="btn btn-info" onclick="checkCronJobs()">Check Cron Jobs</button>
        <button class="btn btn-warning" onclick="viewLogs()">View Execution Logs</button>
        <button class="btn btn-secondary" onclick="exportSchedules()">Export Config</button>
    </div>

    <!-- Schedule Cards -->
    <div class="row g-4">
        @forelse($schedules ?? [] as $schedule)
        <div class="col-md-6 col-lg-4">
            <div class="schedule-card">
                <div class="schedule-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">{{ $schedule->name ?? 'Unnamed Schedule' }}</h6>
                        <span class="status-{{ $schedule->status ?? 'inactive' }}">
                            {{ ucfirst($schedule->status ?? 'inactive') }}
                        </span>
                    </div>
                    <small class="opacity-75">{{ ucfirst($schedule->type ?? 'general') }} Reminder</small>
                </div>
                <div class="schedule-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Description:</label>
                        <p class="mb-2">{{ $schedule->description ?? 'No description provided' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small text-muted">Frequency:</label>
                        <span class="frequency-badge">{{ ucfirst($schedule->frequency ?? 'custom') }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Cron Expression:</label>
                        <div class="cron-display">{{ $schedule->cron_expression ?? '0 9 * * *' }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Next Run:</label>
                        <div class="next-run">
                            {{ $schedule->next_run ? $schedule->next_run->format('d/m/Y H:i') : 'Not scheduled' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Last Run:</label>
                        <small class="text-muted">
                            {{ $schedule->last_run ? $schedule->last_run->format('d/m/Y H:i') : 'Never' }}
                            @if($schedule->last_status)
                                <span class="badge bg-{{ $schedule->last_status == 'success' ? 'success' : 'danger' }} ms-1">
                                    {{ ucfirst($schedule->last_status) }}
                                </span>
                            @endif
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Execution Count:</label>
                        <small class="text-muted">{{ $schedule->execution_count ?? 0 }} times</small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="editSchedule({{ $schedule->id }})">Edit</a></li>
                                @if($schedule->status == 'active')
                                    <li><a class="dropdown-item" href="#" onclick="pauseSchedule({{ $schedule->id }})">Pause</a></li>
                                @else
                                    <li><a class="dropdown-item" href="#" onclick="activateSchedule({{ $schedule->id }})">Activate</a></li>
                                @endif
                                <li><a class="dropdown-item" href="#" onclick="runNow({{ $schedule->id }})">Run Now</a></li>
                                <li><a class="dropdown-item" href="#" onclick="viewLogs({{ $schedule->id }})">View Logs</a></li>
                                <li><a class="dropdown-item" href="#" onclick="duplicateSchedule({{ $schedule->id }})">Duplicate</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteSchedule({{ $schedule->id }})">Delete</a></li>
                            </ul>
                        </div>
                        <small class="text-muted">
                            Created: {{ $schedule->created_at ? $schedule->created_at->format('d/m/Y') : 'N/A' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Reminder Schedules Found</h5>
                <p class="text-muted">Create your first automated reminder schedule to get started.</p>
                <button class="btn btn-primary" onclick="createSchedule()">Create First Schedule</button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($schedules) && $schedules->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $schedules->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Create/Edit Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalTitle">Create New Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="scheduleForm">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Schedule Name</label>
                            <input type="text" class="form-control" name="name" required placeholder="e.g., Daily Payment Reminders">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" required>
                                <option value="">Choose type...</option>
                                <option value="email">Email Reminders</option>
                                <option value="whatsapp">WhatsApp Reminders</option>
                                <option value="overdue">Overdue Check</option>
                                <option value="payment">Payment Follow-up</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Describe what this schedule does..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Frequency</label>
                            <select class="form-select" name="frequency" required onchange="toggleCronBuilder(this.value)">
                                <option value="">Choose frequency...</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="custom">Custom (Cron)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Predefined Schedule Options -->
                    <div id="predefinedOptions" style="display: none;">
                        <div class="cron-builder">
                            <h6>Schedule Options</h6>
                            <div class="row g-3">
                                <div class="col-md-6" id="timeOptions">
                                    <label class="form-label">Time</label>
                                    <input type="time" class="form-control" name="time" value="09:00">
                                </div>
                                <div class="col-md-6" id="dayOptions" style="display: none;">
                                    <label class="form-label">Day of Week</label>
                                    <select class="form-select" name="day_of_week">
                                        <option value="1">Monday</option>
                                        <option value="2">Tuesday</option>
                                        <option value="3">Wednesday</option>
                                        <option value="4">Thursday</option>
                                        <option value="5">Friday</option>
                                        <option value="6">Saturday</option>
                                        <option value="0">Sunday</option>
                                    </select>
                                </div>
                                <div class="col-md-6" id="monthOptions" style="display: none;">
                                    <label class="form-label">Day of Month</label>
                                    <input type="number" class="form-control" name="day_of_month" min="1" max="31" value="1">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Cron Expression -->
                    <div id="cronOptions" style="display: none;">
                        <div class="cron-builder">
                            <h6>Custom Cron Expression</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Cron Expression</label>
                                    <input type="text" class="form-control" name="cron_expression" placeholder="0 9 * * *">
                                    <small class="text-muted">Format: Minute Hour Day Month DayOfWeek</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <h6>Common Examples:</h6>
                                <ul class="list-unstyled">
                                    <li><code>0 9 * * *</code> - Every day at 9:00 AM</li>
                                    <li><code>0 9 * * 1</code> - Every Monday at 9:00 AM</li>
                                    <li><code>0 9 1 * *</code> - First day of every month at 9:00 AM</li>
                                    <li><code>*/30 * * * *</code> - Every 30 minutes</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Settings -->
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Minimum Outstanding Amount (Optional)</label>
                            <input type="number" class="form-control" name="min_outstanding" placeholder="e.g., 1000000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Days Overdue (Optional)</label>
                            <input type="number" class="form-control" name="days_overdue" placeholder="e.g., 7">
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="enable_notifications" value="1" checked>
                                <label class="form-check-label">Enable execution notifications</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cron Jobs Status Modal -->
<div class="modal fade" id="cronStatusModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cron Jobs Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="cronStatusContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Checking cron jobs status...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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

function createSchedule() {
    document.getElementById('scheduleModalTitle').textContent = 'Create New Schedule';
    document.getElementById('scheduleForm').reset();
    new bootstrap.Modal(document.getElementById('scheduleModal')).show();
}

function editSchedule(scheduleId) {
    document.getElementById('scheduleModalTitle').textContent = 'Edit Schedule';
    
    // Fetch schedule data and populate form
    fetch(`/reminders/schedule/${scheduleId}`)
        .then(response => response.json())
        .then(data => {
            const form = document.getElementById('scheduleForm');
            Object.keys(data).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = data[key];
                }
            });
            
            // Trigger frequency change to show appropriate options
            toggleCronBuilder(data.frequency);
        });
    
    new bootstrap.Modal(document.getElementById('scheduleModal')).show();
}

function toggleCronBuilder(frequency) {
    const predefined = document.getElementById('predefinedOptions');
    const custom = document.getElementById('cronOptions');
    const dayOptions = document.getElementById('dayOptions');
    const monthOptions = document.getElementById('monthOptions');
    
    predefined.style.display = 'none';
    custom.style.display = 'none';
    dayOptions.style.display = 'none';
    monthOptions.style.display = 'none';
    
    if (frequency === 'custom') {
        custom.style.display = 'block';
    } else if (frequency) {
        predefined.style.display = 'block';
        
        if (frequency === 'weekly') {
            dayOptions.style.display = 'block';
        } else if (frequency === 'monthly') {
            monthOptions.style.display = 'block';
        }
    }
}

function pauseSchedule(scheduleId) {
    if (confirm('Pause this schedule?')) {
        fetch(`/reminders/schedule/${scheduleId}/pause`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Schedule paused successfully!', 'success');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast('Failed to pause schedule: ' + data.message, 'danger');
            }
        });
    }
}

function activateSchedule(scheduleId) {
    if (confirm('Activate this schedule?')) {
        fetch(`/reminders/schedule/${scheduleId}/activate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Schedule activated successfully!', 'success');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast('Failed to activate schedule: ' + data.message, 'danger');
            }
        });
    }
}

function runNow(scheduleId) {
    if (confirm('Run this schedule now?')) {
        fetch(`/reminders/schedule/${scheduleId}/run`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Schedule executed successfully!', 'success');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast('Failed to run schedule: ' + data.message, 'danger');
            }
        });
    }
}

function deleteSchedule(scheduleId) {
    if (confirm('Delete this schedule? This action cannot be undone.')) {
        fetch(`/reminders/schedule/${scheduleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Schedule deleted successfully!', 'success');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast('Failed to delete schedule: ' + data.message, 'danger');
            }
        });
    }
}

function duplicateSchedule(scheduleId) {
    fetch(`/reminders/schedule/${scheduleId}/duplicate`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Schedule duplicated successfully!', 'success');
            setTimeout(() => location.reload(), 1200);
        } else {
            showToast('Failed to duplicate schedule: ' + data.message, 'danger');
        }
    });
}

function runAllActive() {
    if (confirm('Run all active schedules now?')) {
        fetch('/reminders/schedule/run-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(`Executed ${data.count} schedules successfully!`, 'success');
                setTimeout(() => location.reload(), 1200);
            } else {
                showToast('Failed to run schedules: ' + data.message, 'danger');
            }
        });
    }
}

function checkCronJobs() {
    new bootstrap.Modal(document.getElementById('cronStatusModal')).show();
    
    fetch('/reminders/schedule/cron-status')
        .then(response => response.text())
        .then(html => {
            document.getElementById('cronStatusContent').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('cronStatusContent').innerHTML = 
                '<div class="alert alert-danger">Failed to check cron status</div>';
        });
}

function viewLogs(scheduleId = null) {
    const url = scheduleId ? `/reminders/schedule/${scheduleId}/logs` : '/reminders/schedule/logs';
    window.location.href = url;
}

function exportSchedules() {
    window.location.href = '/reminders/schedule/export';
}

// Handle form submission
document.getElementById('scheduleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Generate cron expression for predefined frequencies
    const frequency = formData.get('frequency');
    if (frequency !== 'custom') {
        const time = formData.get('time') || '09:00';
        const [hour, minute] = time.split(':');
        
        let cron = `${minute} ${hour}`;
        
        switch (frequency) {
            case 'daily':
                cron += ' * * *';
                break;
            case 'weekly':
                const dayOfWeek = formData.get('day_of_week') || '1';
                cron += ` * * ${dayOfWeek}`;
                break;
            case 'monthly':
                const dayOfMonth = formData.get('day_of_month') || '1';
                cron += ` ${dayOfMonth} * *`;
                break;
        }
        
        formData.set('cron_expression', cron);
    }
    
    fetch('/reminders/schedule/store', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Schedule saved successfully!', 'success');
            setTimeout(() => location.reload(), 1200);
        } else {
            showToast('Error: ' + data.message, 'danger');
        }
    })
    .catch(error => {
        showToast('An error occurred while saving the schedule.', 'danger');
    });
});
</script>
@endpush
@push('styles')
<style>
.toast-container { pointer-events: none; }
.toast { pointer-events: auto; min-width: 260px; }
</style>
@endpush
