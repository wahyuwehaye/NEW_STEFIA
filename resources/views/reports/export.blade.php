@extends('layouts.admin')
@section('title', 'Export Reports')
@section('content')
<x-page-header title="Export Reports" subtitle="Export various reports in different formats">
</x-page-header>

<style>
.export-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 30px;
    margin-bottom: 20px;
    text-align: center;
    cursor: pointer;
    transition: transform 0.3s ease;
}
.export-card:hover {
    transform: translateY(-5px);
}
.export-card i {
    font-size: 3rem;
    margin-bottom: 15px;
}
.export-card h5 {
    margin: 0;
    font-weight: bold;
}
.export-card p {
    margin: 10px 0 0 0;
    opacity: 0.9;
}
.filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}
.btn-download {
    background: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    margin: 10px 5px;
    width: 100%;
}
.btn-download:hover {
    background: #218838;
    color: white;
}
</style>

<div class="nk-block">
    <!-- Export Options Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="export-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" onclick="showExportModal('monthly')">
                <i class="fas fa-calendar-alt"></i>
                <h5>Monthly Report</h5>
                <p>Export monthly financial and student data</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="export-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);" onclick="showExportModal('financial')">
                <i class="fas fa-chart-line"></i>
                <h5>Financial Report</h5>
                <p>Export detailed financial reports</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="export-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);" onclick="showExportModal('student')">
                <i class="fas fa-users"></i>
                <h5>Student Report</h5>
                <p>Export student information and statistics</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="export-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);" onclick="showExportModal('tunggakan')">
                <i class="fas fa-exclamation-triangle"></i>
                <h5>Tunggakan Report</h5>
                <p>Export student arrears information</p>
            </div>
        </div>
    </div>

    <!-- Export History -->
    <div class="card">
        <div class="card-inner">
            <h6 class="card-title">Recent Export History</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Report Type</th>
                            <th>Format</th>
                            <th>Status</th>
                            <th>File Size</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exportHistory ?? [] as $export)
                        <tr>
                            <td>{{ $export->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($export->type) }} Report</td>
                            <td>{{ strtoupper($export->format) }}</td>
                            <td>
                                @if($export->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($export->status == 'processing')
                                    <span class="badge bg-warning">Processing</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </td>
                            <td>{{ $export->file_size ?? 'N/A' }}</td>
                            <td>
                                @if($export->status == 'completed' && $export->file_path)
                                    <a href="{{ asset('storage/' . $export->file_path) }}" class="btn btn-sm btn-success" download>
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-file-export fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No export history available</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalTitle">Export Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="exportForm">
                <div class="modal-body">
                    <input type="hidden" id="export_type" name="export_type">
                    
                    <!-- Date Range Filter -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>

                    <!-- Faculty Filter -->
                    <div class="mb-3">
                        <label class="form-label">Faculty (Optional)</label>
                        <select class="form-select" id="faculty" name="faculty">
                            <option value="">All Faculties</option>
                            <option value="FTI">Faculty of Information Technology</option>
                            <option value="FE">Faculty of Economics</option>
                            <option value="FH">Faculty of Law</option>
                            <option value="FK">Faculty of Medicine</option>
                        </select>
                    </div>

                    <!-- Additional Filters (shown conditionally) -->
                    <div id="additionalFilters" class="mb-3" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Academic Year</label>
                                <select class="form-select" id="academic_year" name="academic_year">
                                    <option value="">All Years</option>
                                    @for($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}">{{ $year }}/{{ $year + 1 }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="status_filter" name="status_filter">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="graduated">Graduated</option>
                                    <option value="dropped">Dropped Out</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Export Format Options -->
                    <div class="mb-3">
                        <label class="form-label">Export Format</label>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn-download" onclick="exportFile('excel')">
                                    <i class="fas fa-file-excel"></i> Export to Excel
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn-download" onclick="exportFile('pdf')">
                                    <i class="fas fa-file-pdf"></i> Export to PDF
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn-download" onclick="exportFile('csv')">
                                    <i class="fas fa-file-csv"></i> Export to CSV
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Export Options -->
                    <div class="mb-3">
                        <label class="form-label">Export Options</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="include_charts" name="include_charts" checked>
                            <label class="form-check-label" for="include_charts">
                                Include Charts and Graphs
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="include_summary" name="include_summary" checked>
                            <label class="form-check-label" for="include_summary">
                                Include Summary Statistics
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="detailed_breakdown" name="detailed_breakdown">
                            <label class="form-check-label" for="detailed_breakdown">
                                Include Detailed Breakdown
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exporting Report</h5>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3" id="progressText">Preparing your export...</p>
                <div class="progress mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 0%" id="progressBar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentExportType = '';

function showExportModal(type) {
    currentExportType = type;
    document.getElementById('export_type').value = type;
    document.getElementById('exportModalTitle').textContent = 'Export ' + type.charAt(0).toUpperCase() + type.slice(1) + ' Report';
    
    // Set default dates
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    
    document.getElementById('start_date').value = firstDayOfMonth.toISOString().split('T')[0];
    document.getElementById('end_date').value = today.toISOString().split('T')[0];
    
    // Show additional filters for student reports
    if (type === 'student' || type === 'tunggakan') {
        document.getElementById('additionalFilters').style.display = 'block';
    } else {
        document.getElementById('additionalFilters').style.display = 'none';
    }
    
    new bootstrap.Modal(document.getElementById('exportModal')).show();
}

function exportFile(format) {
    // Hide export modal and show progress modal
    bootstrap.Modal.getInstance(document.getElementById('exportModal')).hide();
    const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
    progressModal.show();
    
    // Collect form data
    const formData = new FormData(document.getElementById('exportForm'));
    formData.append('format', format);
    
    // Simulate progress
    let progress = 0;
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    const progressInterval = setInterval(() => {
        progress += Math.random() * 20;
        if (progress > 90) progress = 90;
        
        progressBar.style.width = progress + '%';
        
        if (progress < 30) {
            progressText.textContent = 'Collecting data...';
        } else if (progress < 60) {
            progressText.textContent = 'Processing information...';
        } else if (progress < 90) {
            progressText.textContent = 'Generating ' + format.toUpperCase() + ' file...';
        }
    }, 500);
    
    // Actual export request
    fetch('{{ route("reports.export.process") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        clearInterval(progressInterval);
        progressBar.style.width = '100%';
        progressText.textContent = 'Export completed!';
        
        if (response.ok) {
            return response.blob();
        } else {
            throw new Error('Export failed');
        }
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = `${currentExportType}_report_${new Date().toISOString().split('T')[0]}.${format}`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        
        // Hide progress modal and show success message
        setTimeout(() => {
            progressModal.hide();
            alert('Export completed successfully!');
            location.reload(); // Refresh to update export history
        }, 1000);
    })
    .catch(error => {
        clearInterval(progressInterval);
        progressModal.hide();
        alert('Export failed: ' + error.message);
    });
}

// Set default date range on page load
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    if (startDateInput && endDateInput) {
        startDateInput.value = firstDayOfMonth.toISOString().split('T')[0];
        endDateInput.value = today.toISOString().split('T')[0];
    }
});
</script>
@endpush
@endsection
