@extends('layouts.admin')

@section('content')
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <h4 class="card-title">Operasi Massal Pembayaran</h4>
            
            <!-- Upload Form -->
            <form id="bulkUploadForm" enctype="multipart/form-data" method="POST" action="{{ route('payments.bulk-process') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fileInput" class="form-label">Upload CSV File:</label>
                            <input type="file" id="fileInput" name="csv_file" class="form-control" accept=".csv" required>
                            <small class="form-text text-muted">Format: nama,nim,jumlah,metode_pembayaran,keterangan</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="operation_type" class="form-label">Jenis Operasi:</label>
                            <select id="operation_type" name="operation_type" class="form-control" required>
                                <option value="">-- Pilih Operasi --</option>
                                <option value="verify_payments">Verifikasi Pembayaran</option>
                                <option value="import_payments">Import Pembayaran Baru</option>
                                <option value="update_payments">Update Pembayaran</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3">
                    <button type="button" id="previewBtn" class="btn btn-outline-primary" disabled>
                        <em class="icon ni ni-eye"></em> Preview Data
                    </button>
                    <button type="submit" id="processBtn" class="btn btn-primary" disabled>
                        <em class="icon ni ni-check"></em> Process Data
                    </button>
                    <button type="button" id="downloadTemplate" class="btn btn-outline-secondary">
                        <em class="icon ni ni-download"></em> Download Template
                    </button>
                </div>
            </form>
            
            <!-- Preview Section -->
            <div id="previewSection" class="mt-4" style="display:none;">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h6 class="card-title">Pratinjau Data CSV</h6>
                        <div class="card-tools">
                            <span id="totalRows" class="badge badge-primary">0 rows</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="previewTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>NIM</th>
                                        <th>Jumlah</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Keterangan</th>
                                        <th>Status Validasi</th>
                                    </tr>
                                </thead>
                                <tbody id="previewTableBody">
                                    <!-- Data will be populated via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Validation Summary -->
                        <div id="validationSummary" class="mt-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h6>Valid Records</h6>
                                            <h4 id="validCount">0</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning text-white">
                                        <div class="card-body text-center">
                                            <h6>Invalid Records</h6>
                                            <h4 id="invalidCount">0</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h6>Total Records</h6>
                                            <h4 id="totalCount">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Processing Results -->
            <div id="resultsSection" class="mt-4" style="display:none;">
                <div class="card card-bordered">
                    <div class="card-header">
                        <h6 class="card-title">Hasil Pemrosesan</h6>
                    </div>
                    <div class="card-body">
                        <div id="processingResults"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('fileInput');
    const previewBtn = document.getElementById('previewBtn');
    const processBtn = document.getElementById('processBtn');
    const downloadTemplate = document.getElementById('downloadTemplate');
    const previewSection = document.getElementById('previewSection');
    const operationType = document.getElementById('operation_type');
    
    let csvData = [];
    
    // Enable preview button when file is selected
    fileInput.addEventListener('change', function() {
        if (this.files[0] && operationType.value) {
            previewBtn.disabled = false;
        } else {
            previewBtn.disabled = true;
            processBtn.disabled = true;
        }
    });
    
    operationType.addEventListener('change', function() {
        if (this.value && fileInput.files[0]) {
            previewBtn.disabled = false;
        } else {
            previewBtn.disabled = true;
            processBtn.disabled = true;
        }
    });
    
    // Preview CSV data
    previewBtn.addEventListener('click', function() {
        const file = fileInput.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const csv = e.target.result;
            const lines = csv.split('\n');
            const headers = lines[0].split(',');
            
            csvData = [];
            let validCount = 0;
            let invalidCount = 0;
            
            const tbody = document.getElementById('previewTableBody');
            tbody.innerHTML = '';
            
            for (let i = 1; i < lines.length; i++) {
                if (lines[i].trim() === '') continue;
                
                const values = lines[i].split(',');
                if (values.length < 5) continue;
                
                const row = {
                    nama: values[0]?.trim(),
                    nim: values[1]?.trim(),
                    jumlah: values[2]?.trim(),
                    metode: values[3]?.trim(),
                    keterangan: values[4]?.trim()
                };
                
                // Validate row
                const isValid = row.nama && row.nim && row.jumlah && !isNaN(row.jumlah) && row.metode;
                if (isValid) validCount++; else invalidCount++;
                
                csvData.push({...row, valid: isValid});
                
                // Add row to preview table
                const tr = document.createElement('tr');
                tr.className = isValid ? 'table-success' : 'table-danger';
                tr.innerHTML = `
                    <td>${i}</td>
                    <td>${row.nama || '-'}</td>
                    <td>${row.nim || '-'}</td>
                    <td>Rp ${row.jumlah ? parseInt(row.jumlah).toLocaleString('id-ID') : '-'}</td>
                    <td>${row.metode || '-'}</td>
                    <td>${row.keterangan || '-'}</td>
                    <td>
                        <span class="badge ${isValid ? 'badge-success' : 'badge-danger'}">
                            ${isValid ? 'Valid' : 'Invalid'}
                        </span>
                    </td>
                `;
                tbody.appendChild(tr);
            }
            
            // Update counts
            document.getElementById('validCount').textContent = validCount;
            document.getElementById('invalidCount').textContent = invalidCount;
            document.getElementById('totalCount').textContent = validCount + invalidCount;
            document.getElementById('totalRows').textContent = `${validCount + invalidCount} rows`;
            
            // Show preview section
            previewSection.style.display = 'block';
            processBtn.disabled = validCount === 0;
        };
        reader.readAsText(file);
    });
    
    // Download template
    downloadTemplate.addEventListener('click', function() {
        const csv = 'nama,nim,jumlah,metode_pembayaran,keterangan\n' +
                   'John Doe,1234567890,500000,bank_transfer,Pembayaran SPP\n' +
                   'Jane Smith,0987654321,300000,cash,Pembayaran Lab';
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'bulk_payments_template.csv';
        a.click();
        window.URL.revokeObjectURL(url);
    });
    
    // Handle form submission
    document.getElementById('bulkUploadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (csvData.filter(row => row.valid).length === 0) {
            alert('Tidak ada data valid untuk diproses!');
            return;
        }
        
        // Show processing indicator
        processBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Processing...';
        processBtn.disabled = true;
        
        // Simulate processing (replace with actual AJAX call)
        setTimeout(() => {
            const validRows = csvData.filter(row => row.valid);
            const processed = validRows.length;
            
            document.getElementById('processingResults').innerHTML = `
                <div class="alert alert-success">
                    <h6>Pemrosesan Selesai!</h6>
                    <p>Berhasil memproses ${processed} record dari ${csvData.length} total record.</p>
                    <ul>
                        <li>Record berhasil: ${validRows.length}</li>
                        <li>Record gagal: ${csvData.length - validRows.length}</li>
                    </ul>
                </div>
            `;
            
            document.getElementById('resultsSection').style.display = 'block';
            processBtn.innerHTML = '<em class="icon ni ni-check"></em> Process Data';
            processBtn.disabled = false;
        }, 2000);
    });
});
</script>
@endsection
