@extends('layouts.admin')

@section('title', 'Export Data - Piutang')

@section('content')
<x-page-header 
    title="Export Data Piutang" 
    subtitle="Ekspor data piutang ke berbagai format untuk kebutuhan pelaporan dan analisis">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('receivables.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-arrow-left"></em><span>Kembali</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Export Options -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-lg-8">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Pengaturan Export</h6>
                        </div>
                    </div>
                    
                    <form id="exportForm" class="form-validate">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Format Export</label>
                                    <select class="form-control form-select" id="exportFormat" required>
                                        <option value="">Pilih Format</option>
                                        <option value="excel">Excel (.xlsx)</option>
                                        <option value="csv">CSV (.csv)</option>
                                        <option value="pdf">PDF (.pdf)</option>
                                        <option value="json">JSON (.json)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Status Piutang</label>
                                    <select class="form-control form-select" id="statusFilter">
                                        <option value="">Semua Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="paid">Lunas</option>
                                        <option value="overdue">Tertunggak</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Kategori Piutang</label>
                                    <select class="form-control form-select" id="categoryFilter">
                                        <option value="">Semua Kategori</option>
                                        <option value="tuition">Tuition</option>
                                        <option value="lab">Lab Fee</option>
                                        <option value="library">Library</option>
                                        <option value="dormitory">Dormitory</option>
                                        <option value="fine">Fine</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Jumlah Minimum</label>
                                    <input type="number" class="form-control" id="minAmount" placeholder="0">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Kolom yang Diekspor</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_student_id" checked>
                                        <label class="custom-control-label" for="col_student_id">Student ID</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_student_name" checked>
                                        <label class="custom-control-label" for="col_student_name">Nama Mahasiswa</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_description" checked>
                                        <label class="custom-control-label" for="col_description">Deskripsi</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_amount" checked>
                                        <label class="custom-control-label" for="col_amount">Jumlah</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_status" checked>
                                        <label class="custom-control-label" for="col_status">Status</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_due_date" checked>
                                        <label class="custom-control-label" for="col_due_date">Tanggal Jatuh Tempo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_category">
                                        <label class="custom-control-label" for="col_category">Kategori</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_penalty">
                                        <label class="custom-control-label" for="col_penalty">Denda</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="col_paid_date">
                                        <label class="custom-control-label" for="col_paid_date">Tanggal Bayar</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="includeHeaders" checked>
                                <label class="custom-control-label" for="includeHeaders">Sertakan Header</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="includeSummary">
                                <label class="custom-control-label" for="includeSummary">Sertakan Summary</label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <em class="icon ni ni-download"></em> Export Data
                            </button>
                            <button type="button" class="btn btn-light" id="previewBtn">
                                <em class="icon ni ni-eye"></em> Preview
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Statistik Export</h6>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="amount">
                            <span class="amount-value text-primary" id="totalRecords">2,567</span>
                            <span class="amount-title">Total Records</span>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="amount">
                            <span class="amount-value text-success" id="filteredRecords">2,567</span>
                            <span class="amount-title">Filtered Records</span>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="amount">
                            <span class="amount-value text-info" id="estimatedSize">~2.5MB</span>
                            <span class="amount-title">Estimated Size</span>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="alert alert-pro alert-info">
                            <div class="alert-text">
                                <h6>Info Export</h6>
                                <p>File akan dikirim ke email Anda setelah proses export selesai.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Riwayat Export</h6>
                        </div>
                    </div>
                    
                    <div class="nk-block">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-status bg-primary"></div>
                                <div class="timeline-content">
                                    <div class="timeline-text">
                                        <h6>Export Excel</h6>
                                        <p>2,567 records exported</p>
                                    </div>
                                    <div class="timeline-time">2 hours ago</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-status bg-success"></div>
                                <div class="timeline-content">
                                    <div class="timeline-text">
                                        <h6>Export PDF</h6>
                                        <p>Monthly report generated</p>
                                    </div>
                                    <div class="timeline-time">1 day ago</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-status bg-info"></div>
                                <div class="timeline-content">
                                    <div class="timeline-text">
                                        <h6>Export CSV</h6>
                                        <p>Outstanding receivables</p>
                                    </div>
                                    <div class="timeline-time">3 days ago</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="progressModalLabel">Export Progress</h5>
            </div>
            <div class="modal-body">
                <div class="progress-wrap">
                    <div class="progress-text">
                        <div class="progress-label">Processing...</div>
                        <div class="progress-percent" id="progressPercent">0%</div>
                    </div>
                    <div class="progress progress-md">
                        <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
                <div class="mt-3 text-center">
                    <p id="progressMessage">Preparing export...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Update filtered records when filters change
    $('#statusFilter, #categoryFilter, #startDate, #endDate, #minAmount').on('change', function() {
        updateFilteredRecords();
    });
    
    // Preview button
    $('#previewBtn').click(function() {
        const filters = getFilters();
        
        Swal.fire({
            title: 'Preview Export',
            html: `
                <div class="text-left">
                    <p><strong>Format:</strong> ${$('#exportFormat').val() || 'Tidak dipilih'}</p>
                    <p><strong>Status:</strong> ${$('#statusFilter option:selected').text()}</p>
                    <p><strong>Kategori:</strong> ${$('#categoryFilter option:selected').text()}</p>
                    <p><strong>Rentang Tanggal:</strong> ${filters.startDate || 'Semua'} - ${filters.endDate || 'Semua'}</p>
                    <p><strong>Estimasi Records:</strong> ${$('#filteredRecords').text()}</p>
                    <p><strong>Kolom yang Diekspor:</strong> ${getSelectedColumns().length} kolom</p>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Lanjutkan Export',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#exportForm').submit();
            }
        });
    });
    
    // Form submission
    $('#exportForm').submit(function(e) {
        e.preventDefault();
        
        const format = $('#exportFormat').val();
        if (!format) {
            Swal.fire('Error', 'Pilih format export terlebih dahulu', 'error');
            return;
        }
        
        const columns = getSelectedColumns();
        if (columns.length === 0) {
            Swal.fire('Error', 'Pilih minimal satu kolom untuk diekspor', 'error');
            return;
        }
        
        startExport();
    });
    
    // Get selected columns
    function getSelectedColumns() {
        const columns = [];
        $('input[id^="col_"]:checked').each(function() {
            columns.push($(this).attr('id').replace('col_', ''));
        });
        return columns;
    }
    
    // Get filters
    function getFilters() {
        return {
            format: $('#exportFormat').val(),
            status: $('#statusFilter').val(),
            category: $('#categoryFilter').val(),
            startDate: $('#startDate').val(),
            endDate: $('#endDate').val(),
            minAmount: $('#minAmount').val(),
            columns: getSelectedColumns(),
            includeHeaders: $('#includeHeaders').is(':checked'),
            includeSummary: $('#includeSummary').is(':checked')
        };
    }
    
    // Update filtered records count
    function updateFilteredRecords() {
        // Simulate filtering
        const total = 2567;
        const filtered = Math.floor(total * (0.7 + Math.random() * 0.3));
        $('#filteredRecords').text(filtered.toLocaleString());
        
        // Update estimated size
        const sizePerRecord = 1024; // bytes
        const estimatedBytes = filtered * sizePerRecord;
        const estimatedSize = formatBytes(estimatedBytes);
        $('#estimatedSize').text('~' + estimatedSize);
    }
    
    // Format bytes
    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Start export process
    function startExport() {
        const progressModal = new bootstrap.Modal(document.getElementById('progressModal'));
        progressModal.show();
        
        let progress = 0;
        const interval = setInterval(function() {
            progress += Math.random() * 15;
            
            if (progress >= 100) {
                progress = 100;
                clearInterval(interval);
                
                $('#progressBar').css('width', '100%');
                $('#progressPercent').text('100%');
                $('#progressMessage').text('Export completed!');
                
                setTimeout(function() {
                    progressModal.hide();
                    Swal.fire({
                        title: 'Export Berhasil',
                        text: 'File telah berhasil diekspor dan dikirim ke email Anda.',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }, 1000);
            } else {
                $('#progressBar').css('width', progress + '%');
                $('#progressPercent').text(Math.round(progress) + '%');
                
                // Update progress message
                if (progress < 30) {
                    $('#progressMessage').text('Preparing export...');
                } else if (progress < 70) {
                    $('#progressMessage').text('Processing data...');
                } else {
                    $('#progressMessage').text('Generating file...');
                }
            }
        }, 500);
    }
});
</script>
@endpush

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 1.5rem;
}

.timeline-item {
    position: relative;
    padding-bottom: 1rem;
}

.timeline-item:not(:last-child):before {
    content: '';
    position: absolute;
    left: -1.3rem;
    top: 1.5rem;
    width: 1px;
    height: calc(100% - 0.5rem);
    background: #e5e9f2;
}

.timeline-status {
    position: absolute;
    left: -1.6rem;
    top: 0.2rem;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.timeline-content {
    margin-left: 0.5rem;
}

.timeline-text h6 {
    margin-bottom: 0.25rem;
    font-size: 0.875rem;
    font-weight: 600;
}

.timeline-text p {
    margin-bottom: 0.25rem;
    font-size: 0.8125rem;
    color: #6c757d;
}

.timeline-time {
    font-size: 0.75rem;
    color: #8fa8bd;
}

.amount {
    text-align: center;
    padding: 1rem;
    border: 1px solid #e5e9f2;
    border-radius: 0.5rem;
    background: #f8f9fa;
    margin-bottom: 1rem;
}

.amount-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1;
}

.amount-title {
    display: block;
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.progress-wrap {
    margin-bottom: 1rem;
}

.progress-text {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.progress-label {
    font-weight: 500;
}

.progress-percent {
    font-weight: 600;
    color: #526484;
}
</style>
@endpush
