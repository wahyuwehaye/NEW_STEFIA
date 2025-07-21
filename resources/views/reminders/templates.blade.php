@extends('layouts.admin')
@section('title', 'Reminder Templates')
@section('content')
<x-page-header title="Reminder Templates" subtitle="Manage email and WhatsApp templates for automated reminders">
</x-page-header>

<style>
.stats-card {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
.template-card {
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin-bottom: 20px;
    overflow: hidden;
}
.template-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.15);
}
.template-header {
    padding: 15px 20px;
    color: white;
    font-weight: bold;
}
.template-header.email {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.template-header.whatsapp {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
}
.template-header.sms {
    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
}
.template-body {
    padding: 20px;
    background: white;
}
.template-preview {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    font-size: 14px;
    line-height: 1.5;
    max-height: 150px;
    overflow-y: auto;
}
.template-variables {
    background: #e8f5e8;
    border: 1px solid #28a745;
    border-radius: 6px;
    padding: 10px;
    margin-top: 10px;
}
.variable-tag {
    background: #007bff;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    margin: 2px;
    display: inline-block;
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
.template-type-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    color: white;
}
.template-type-email { background: #667eea; }
.template-type-whatsapp { background: #25d366; }
.template-type-sms { background: #ff6b6b; }
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
.template-editor {
    min-height: 200px;
}
.variable-helper {
    background: #fff3cd;
    border: 1px solid #ffeaa7;
    border-radius: 8px;
    padding: 15px;
    margin: 15px 0;
}
</style>

<div class="nk-block">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $stats['total'] ?? 0 }}</h3>
                <p>Total Templates</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h3>{{ $stats['email'] ?? 0 }}</h3>
                <p>Email Templates</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);">
                <h3>{{ $stats['whatsapp'] ?? 0 }}</h3>
                <p>WhatsApp Templates</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $stats['active'] ?? 0 }}</h3>
                <p>Active Templates</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5>Filter Templates</h5>
        <form method="GET" action="{{ route('reminders.templates') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Template Type</label>
                    <select class="form-select" name="type">
                        <option value="">All Types</option>
                        <option value="email" {{ request('type') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="whatsapp" {{ request('type') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="sms" {{ request('type') == 'sms' ? 'selected' : '' }}>SMS</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Category</label>
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <option value="reminder" {{ request('category') == 'reminder' ? 'selected' : '' }}>Payment Reminder</option>
                        <option value="overdue" {{ request('category') == 'overdue' ? 'selected' : '' }}>Overdue Notice</option>
                        <option value="warning" {{ request('category') == 'warning' ? 'selected' : '' }}>Warning</option>
                        <option value="final" {{ request('category') == 'final' ? 'selected' : '' }}>Final Notice</option>
                        <option value="welcome" {{ request('category') == 'welcome' ? 'selected' : '' }}>Welcome</option>
                        <option value="confirmation" {{ request('category') == 'confirmation' ? 'selected' : '' }}>Confirmation</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search templates...">
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-12 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('reminders.templates') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn btn-primary" onclick="createTemplate()">Create New Template</button>
        <button class="btn btn-success" onclick="importTemplates()">Import Templates</button>
        <button class="btn btn-info" onclick="previewTemplates()">Bulk Preview</button>
        <button class="btn btn-warning" onclick="exportTemplates()">Export Templates</button>
        <button class="btn btn-secondary" onclick="viewUsageStats()">Usage Statistics</button>
    </div>

    <!-- Templates Grid -->
    <div class="row g-4">
        @forelse($templates ?? [] as $template)
        <div class="col-md-6 col-lg-4">
            <div class="template-card">
                <div class="template-header {{ $template->type ?? 'email' }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $template->name ?? 'Unnamed Template' }}</h6>
                            <small class="opacity-75">{{ ucfirst($template->category ?? 'general') }} Template</small>
                        </div>
                        <span class="status-{{ $template->status ?? 'inactive' }}">
                            {{ ucfirst($template->status ?? 'inactive') }}
                        </span>
                    </div>
                </div>
                <div class="template-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="template-type-badge template-type-{{ $template->type ?? 'email' }}">
                            {{ strtoupper($template->type ?? 'EMAIL') }}
                        </span>
                        <small class="text-muted">
                            Used: {{ $template->usage_count ?? 0 }} times
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Subject/Title:</label>
                        <p class="mb-2 fw-bold">{{ $template->subject ?? 'No subject' }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Preview:</label>
                        <div class="template-preview">
                            {{ Str::limit($template->content ?? 'No content available', 150) }}
                        </div>
                    </div>

                    @if(isset($template->variables) && count($template->variables) > 0)
                    <div class="template-variables">
                        <small class="text-muted d-block mb-2">Available Variables:</small>
                        @foreach($template->variables as $variable)
                            <span class="variable-tag">{{ $variable }}</span>
                        @endforeach
                    </div>
                    @endif

                    <div class="mt-3">
                        <small class="text-muted">
                            Created: {{ $template->created_at ? $template->created_at->format('d/m/Y') : 'N/A' }}
                            <br>
                            Last Modified: {{ $template->updated_at ? $template->updated_at->format('d/m/Y') : 'N/A' }}
                        </small>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="editTemplate({{ $template->id }})">Edit</a></li>
                                <li><a class="dropdown-item" href="#" onclick="previewTemplate({{ $template->id }})">Preview</a></li>
                                <li><a class="dropdown-item" href="#" onclick="duplicateTemplate({{ $template->id }})">Duplicate</a></li>
                                <li><a class="dropdown-item" href="#" onclick="testTemplate({{ $template->id }})">Send Test</a></li>
                                @if($template->status == 'active')
                                    <li><a class="dropdown-item" href="#" onclick="deactivateTemplate({{ $template->id }})">Deactivate</a></li>
                                @else
                                    <li><a class="dropdown-item" href="#" onclick="activateTemplate({{ $template->id }})">Activate</a></li>
                                @endif
                                <li><a class="dropdown-item" href="#" onclick="viewUsage({{ $template->id }})">View Usage</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteTemplate({{ $template->id }})">Delete</a></li>
                            </ul>
                        </div>
                        <small class="text-muted">
                            {{ $template->language ?? 'ID' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Templates Found</h5>
                <p class="text-muted">Create your first template to start sending automated reminders.</p>
                <button class="btn btn-primary" onclick="createTemplate()">Create First Template</button>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(isset($templates) && $templates->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $templates->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Create/Edit Template Modal -->
<div class="modal fade" id="templateModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="templateModalTitle">Create New Template</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="templateForm">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Template Name</label>
                            <input type="text" class="form-control" name="name" required placeholder="e.g., Payment Reminder - Final Notice">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <select class="form-select" name="type" required onchange="toggleTemplateOptions(this.value)">
                                <option value="">Choose type...</option>
                                <option value="email">Email</option>
                                <option value="whatsapp">WhatsApp</option>
                                <option value="sms">SMS</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category" required>
                                <option value="">Choose category...</option>
                                <option value="reminder">Payment Reminder</option>
                                <option value="overdue">Overdue Notice</option>
                                <option value="warning">Warning</option>
                                <option value="final">Final Notice</option>
                                <option value="welcome">Welcome</option>
                                <option value="confirmation">Confirmation</option>
                            </select>
                        </div>
                        
                        <!-- Email Specific Fields -->
                        <div id="emailFields" style="display: none;">
                            <div class="col-12">
                                <label class="form-label">Email Subject</label>
                                <input type="text" class="form-control" name="subject" placeholder="Enter email subject...">
                            </div>
                        </div>

                        <!-- WhatsApp/SMS Specific Fields -->
                        <div id="messageFields" style="display: none;">
                            <div class="col-md-6">
                                <label class="form-label">Message Title (Optional)</label>
                                <input type="text" class="form-control" name="subject" placeholder="Enter message title...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Character Limit</label>
                                <input type="number" class="form-control" name="char_limit" placeholder="e.g., 160 for SMS">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Language</label>
                            <select class="form-select" name="language">
                                <option value="id">Indonesian</option>
                                <option value="en">English</option>
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

                    <div class="variable-helper">
                        <h6>Available Variables:</h6>
                        <p class="mb-2">Click to insert into your template:</p>
                        <div class="d-flex flex-wrap">
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{student_name}}')" data-var="student_name">Student Name</button>
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{student_nim}}')" data-var="student_nim">Student NIM</button>
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{outstanding_amount}}')" data-var="outstanding_amount">Outstanding Amount</button>
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{due_date}}')" data-var="due_date">Due Date</button>
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{days_overdue}}')" data-var="days_overdue">Days Overdue</button>
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{payment_link}}')" data-var="payment_link">Payment Link</button>
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{contact_info}}')" data-var="contact_info">Contact Info</button>
                            <button type="button" class="btn btn-sm btn-outline-primary me-2 mb-2" onclick="insertVariable('@{{school_name}}')" data-var="school_name">School Name</button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Template Content</label>
                        <textarea class="form-control template-editor" name="content" required placeholder="Enter your template content here..."></textarea>
                        <small class="text-muted">Use the variable buttons above to insert dynamic content.</small>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" value="1">
                                <label class="form-check-label">Set as default template for this category</label>
                            </div>
                        </div>
                    </div>

                    <!-- Live Preview -->
                    <div class="mt-4">
                        <h6>Live Preview:</h6>
                        <div id="templatePreview" class="template-preview">
                            <em class="text-muted">Preview will appear here as you type...</em>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="previewInModal()">Preview</button>
                    <button type="submit" class="btn btn-primary">Save Template</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Template Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Template Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent">
                    <!-- Preview content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="sendTestFromPreview()">Send Test</button>
            </div>
        </div>
    </div>
</div>

<!-- Test Message Modal -->
<div class="modal fade" id="testModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Test Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="testForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Test Recipient</label>
                        <input type="text" class="form-control" name="test_recipient" required placeholder="Enter email or phone number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Test Data (Optional)</label>
                        <textarea class="form-control" name="test_data" rows="3" placeholder='Optional: {"student_name": "John Doe", "outstanding_amount": "1000000"}'></textarea>
                        <small class="text-muted">JSON format for custom test data</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Send Test</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentTemplateId = null;

function createTemplate() {
    document.getElementById('templateModalTitle').textContent = 'Create New Template';
    document.getElementById('templateForm').reset();
    currentTemplateId = null;
    new bootstrap.Modal(document.getElementById('templateModal')).show();
}

function editTemplate(templateId) {
    currentTemplateId = templateId;
    document.getElementById('templateModalTitle').textContent = 'Edit Template';
    
    // Fetch template data and populate form
    fetch(`/reminders/templates/${templateId}`)
        .then(response => response.json())
        .then(data => {
            const form = document.getElementById('templateForm');
            Object.keys(data).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = data[key];
                }
            });
            
            // Trigger type change to show appropriate fields
            toggleTemplateOptions(data.type);
            updatePreview();
        });
    
    new bootstrap.Modal(document.getElementById('templateModal')).show();
}

function toggleTemplateOptions(type) {
    const emailFields = document.getElementById('emailFields');
    const messageFields = document.getElementById('messageFields');
    
    emailFields.style.display = 'none';
    messageFields.style.display = 'none';
    
    if (type === 'email') {
        emailFields.style.display = 'block';
    } else if (type === 'whatsapp' || type === 'sms') {
        messageFields.style.display = 'block';
    }
}

function insertVariable(variable) {
    // Remove the @ prefix added for Blade escaping
    const cleanVariable = variable.replace('@', '');
    
    const contentTextarea = document.querySelector('textarea[name="content"]');
    const start = contentTextarea.selectionStart;
    const end = contentTextarea.selectionEnd;
    const text = contentTextarea.value;
    
    contentTextarea.value = text.substring(0, start) + cleanVariable + text.substring(end);
    contentTextarea.focus();
    contentTextarea.setSelectionRange(start + cleanVariable.length, start + cleanVariable.length);
    
    updatePreview();
}

function updatePreview() {
    const content = document.querySelector('textarea[name="content"]').value;
    const previewDiv = document.getElementById('templatePreview');
    
    if (content.trim()) {
        // Replace variables with sample data for preview
        let preview = content
            .replace(/@{{student_name}}/g, 'John Doe')
            .replace(/@{{student_nim}}/g, '12345678')
            .replace(/@{{outstanding_amount}}/g, 'Rp 1.500.000')
            .replace(/@{{due_date}}/g, '15/01/2024')
            .replace(/@{{days_overdue}}/g, '5')
            .replace(/@{{payment_link}}/g, 'https://payment.link')
            .replace(/@{{contact_info}}/g, '+62812345678')
            .replace(/@{{school_name}}/g, 'STEFIA College');
        
        previewDiv.innerHTML = preview.replace(/\n/g, '<br>');
    } else {
        previewDiv.innerHTML = '<em class="text-muted">Preview will appear here as you type...</em>';
    }
}

function previewTemplate(templateId) {
    fetch(`/reminders/templates/${templateId}/preview`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('previewContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        });
}

function previewInModal() {
    const content = document.querySelector('textarea[name="content"]').value;
    const subject = document.querySelector('input[name="subject"]').value;
    const type = document.querySelector('select[name="type"]').value;
    
    let preview = '<div class="border rounded p-3">';
    
    if (type === 'email' && subject) {
        preview += `<strong>Subject:</strong> ${subject}<br><br>`;
    }
    
    preview += content
        .replace(/@{{student_name}}/g, 'John Doe')
        .replace(/@{{student_nim}}/g, '12345678')
        .replace(/@{{outstanding_amount}}/g, 'Rp 1.500.000')
        .replace(/@{{due_date}}/g, '15/01/2024')
        .replace(/@{{days_overdue}}/g, '5')
        .replace(/@{{payment_link}}/g, 'https://payment.link')
        .replace(/@{{contact_info}}/g, '+62812345678')
        .replace(/@{{school_name}}/g, 'STEFIA College')
        .replace(/\n/g, '<br>');
    
    preview += '</div>';
    
    document.getElementById('previewContent').innerHTML = preview;
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

function testTemplate(templateId) {
    currentTemplateId = templateId;
    new bootstrap.Modal(document.getElementById('testModal')).show();
}

function duplicateTemplate(templateId) {
    fetch(`/reminders/templates/${templateId}/duplicate`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Template duplicated successfully!');
            location.reload();
        } else {
            alert('Failed to duplicate template: ' + data.message);
        }
    });
}

function activateTemplate(templateId) {
    fetch(`/reminders/templates/${templateId}/activate`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Template activated successfully!');
            location.reload();
        } else {
            alert('Failed to activate template: ' + data.message);
        }
    });
}

function deactivateTemplate(templateId) {
    fetch(`/reminders/templates/${templateId}/deactivate`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Template deactivated successfully!');
            location.reload();
        } else {
            alert('Failed to deactivate template: ' + data.message);
        }
    });
}

function deleteTemplate(templateId) {
    if (confirm('Delete this template? This action cannot be undone.')) {
        fetch(`/reminders/templates/${templateId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Template deleted successfully!');
                location.reload();
            } else {
                alert('Failed to delete template: ' + data.message);
            }
        });
    }
}

function importTemplates() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = '.json,.csv';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('file', file);
            
            fetch('/reminders/templates/import', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`${data.count} templates imported successfully!`);
                    location.reload();
                } else {
                    alert('Import failed: ' + data.message);
                }
            });
        }
    };
    input.click();
}

function exportTemplates() {
    window.location.href = '/reminders/templates/export';
}

function viewUsage(templateId) {
    window.location.href = `/reminders/templates/${templateId}/usage`;
}

function viewUsageStats() {
    window.location.href = '/reminders/templates/usage-stats';
}

// Auto-update preview as user types
document.addEventListener('DOMContentLoaded', function() {
    const contentTextarea = document.querySelector('textarea[name="content"]');
    if (contentTextarea) {
        contentTextarea.addEventListener('input', updatePreview);
    }
});

// Handle form submissions
document.getElementById('templateForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = currentTemplateId ? `/reminders/templates/${currentTemplateId}` : '/reminders/templates/store';
    const method = currentTemplateId ? 'PUT' : 'POST';
    
    if (currentTemplateId) {
        formData.append('_method', 'PUT');
    }
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Template saved successfully!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
});

document.getElementById('testForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(`/reminders/templates/${currentTemplateId}/test`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Test message sent successfully!');
        } else {
            alert('Failed to send test message: ' + data.message);
        }
    });
});
</script>
@endpush
@endsection
