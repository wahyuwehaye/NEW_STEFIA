@extends('layouts.admin')

@section('title', 'Bulk Operations')

@section('content')
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Bulk Operations</h3>
            <div class="nk-block-des text-soft">
                <p>Perform bulk operations on receivables data</p>
            </div>
        </div>
    </div>
</div>

<div class="nk-block">
    <div class="card">
        <div class="card-inner">
            <h6 class="card-title">Select Items for Bulk Operations</h6>
            <p>Use the filters below to find and select items for bulk operations.</p>
            
            <form id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                <option value="tuition">Tuition</option>
                                <option value="lab">Lab Fee</option>
                                <option value="library">Library</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Academic Year</label>
                            <select name="academic_year" class="form-select">
                                <option value="">All Years</option>
                                <option value="2023/2024">2023/2024</option>
                                <option value="2024/2025">2024/2025</option>
                                <option value="2025/2026">2025/2026</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-primary" id="loadData">
                        <em class="icon ni ni-search"></em> Load Data
                    </button>
                    <button type="button" class="btn btn-light" id="resetFilter">
                        <em class="icon ni ni-reload"></em> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="nk-block">
    <div class="card">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Receivables Data</h6>
                </div>
                <div class="card-tools">
                    <span class="badge badge-light" id="selectedCount">0 selected</span>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Code</th>
                            <th>Student</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="nk-block">
    <div class="card">
        <div class="card-inner">
            <h6 class="card-title">Bulk Operations</h6>
            
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Select Operation</label>
                        <select name="bulk_action" class="form-select" id="bulkAction">
                            <option value="">Choose Operation</option>
                            <option value="update_status">Update Status</option>
                            <option value="send_reminder">Send Reminder</option>
                            <option value="export_selected">Export Selected</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" id="actionValueGroup" style="display: none;">
                        <label class="form-label" id="actionValueLabel">Value</label>
                        <select name="action_value" class="form-select" id="actionValue">
                            <!-- Options will be populated based on action -->
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <button type="button" class="btn btn-primary" id="executeBulkAction" disabled>
                    <em class="icon ni ni-play"></em> Execute Operation
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Load data based on filters
    $('#loadData').click(function() {
        const formData = $('#filterForm').serialize();
        loadTableData(formData);
    });
    
    // Reset filter
    $('#resetFilter').click(function() {
        $('#filterForm')[0].reset();
        loadTableData();
    });
    
    // Select All
    $('#selectAll').change(function() {
        $('input[name="selected_items[]"]').prop('checked', this.checked);
        updateSelectedCount();
    });
    
    // Bulk action change
    $('#bulkAction').change(function() {
        const action = $(this).val();
        const valueGroup = $('#actionValueGroup');
        const valueLabel = $('#actionValueLabel');
        const valueSelect = $('#actionValue');
        
        valueSelect.empty();
        
        if (action === 'update_status') {
            valueLabel.text('New Status');
            valueSelect.append('<option value="pending">Pending</option>');
            valueSelect.append('<option value="paid">Paid</option>');
            valueSelect.append('<option value="overdue">Overdue</option>');
            valueGroup.show();
        } else {
            valueGroup.hide();
        }
        
        updateButtonStates();
    });
    
    // Execute bulk action
    $('#executeBulkAction').click(function() {
        const action = $('#bulkAction').val();
        const value = $('#actionValue').val();
        const selectedIds = getSelectedIds();
        
        if (selectedIds.length === 0) {
            alert('Please select at least one item to process');
            return;
        }
        
        if (confirm(`Are you sure you want to perform this operation on ${selectedIds.length} items?`)) {
            executeBulkAction(action, value, selectedIds);
        }
    });
    
    // Update selected count when checkboxes change
    $(document).on('change', 'input[name="selected_items[]"]', function() {
        updateSelectedCount();
    });
    
    // Functions
    function loadTableData(filters = '') {
        // Simulate loading data
        const sampleData = `
            <tr>
                <td><input type="checkbox" name="selected_items[]" value="1"></td>
                <td>RCV-001</td>
                <td>John Doe</td>
                <td>Tuition</td>
                <td>$1,000</td>
                <td><span class="badge badge-warning">Pending</span></td>
                <td>2024-01-15</td>
            </tr>
            <tr>
                <td><input type="checkbox" name="selected_items[]" value="2"></td>
                <td>RCV-002</td>
                <td>Jane Smith</td>
                <td>Lab Fee</td>
                <td>$500</td>
                <td><span class="badge badge-success">Paid</span></td>
                <td>2024-01-20</td>
            </tr>
        `;
        
        $('#tableBody').html(sampleData);
        updateSelectedCount();
    }
    
    function updateSelectedCount() {
        const count = $('input[name="selected_items[]"]:checked').length;
        $('#selectedCount').text(count + ' selected');
        updateButtonStates();
    }
    
    function updateButtonStates() {
        const hasSelection = $('input[name="selected_items[]"]:checked').length > 0;
        const hasAction = $('#bulkAction').val() !== '';
        
        $('#executeBulkAction').prop('disabled', !(hasSelection && hasAction));
    }
    
    function getSelectedIds() {
        return $('input[name="selected_items[]"]:checked').map(function() {
            return $(this).val();
        }).get();
    }
    
    function executeBulkAction(action, value, selectedIds) {
        // Simulate bulk action execution
        alert(`Executing ${action} on ${selectedIds.length} items`);
        
        // Reset selections
        $('input[name="selected_items[]"]').prop('checked', false);
        $('#selectAll').prop('checked', false);
        updateSelectedCount();
    }
    
    // Initial load
    loadTableData();
});
</script>
@endpush
