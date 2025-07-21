@extends('layouts.admin')
@section('title', 'Laporan Keuangan')
@section('content')
<x-page-header title="Laporan Keuangan" subtitle="Laporan dan analisis keuangan mahasiswa">
</x-page-header>

<style>
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
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
.chart-container {
    height: 400px;
    margin: 20px 0;
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
.btn-export {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    margin-right: 10px;
}
.btn-print {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
}
</style>

<div class="nk-block">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h3>Rp {{ number_format($totalPiutang ?? 0, 0, ',', '.') }}</h3>
                <p>Total Piutang</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>Rp {{ number_format($piutangLunas ?? 0, 0, ',', '.') }}</h3>
                <p>Piutang Terbayar</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>Rp {{ number_format($piutangBelumLunas ?? 0, 0, ',', '.') }}</h3>
                <p>Piutang Belum Lunas</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ $totalMahasiswa ?? 0 }}</h3>
                <p>Total Mahasiswa</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5>Filter Laporan Keuangan</h5>
        <form method="GET" action="{{ route('reports.financial') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Nama/NIM</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fakultas</label>
                    <select class="form-select" name="fakultas">
                        <option value="">Semua Fakultas</option>
                        <option value="FTI" {{ request('fakultas') == 'FTI' ? 'selected' : '' }}>Fakultas Teknologi Informasi</option>
                        <option value="FE" {{ request('fakultas') == 'FE' ? 'selected' : '' }}>Fakultas Ekonomi</option>
                        <option value="FH" {{ request('fakultas') == 'FH' ? 'selected' : '' }}>Fakultas Hukum</option>
                        <option value="FK" {{ request('fakultas') == 'FK' ? 'selected' : '' }}>Fakultas Kedokteran</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun Akademik</label>
                    <select class="form-select" name="tahun">
                        <option value="">Semua Tahun</option>
                        @for($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}/{{ $year + 1 }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="nunggak" {{ request('status') == 'nunggak' ? 'selected' : '' }}>Menunggak</option>
                    </select>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-3">
                    <label class="form-label">Rentang Piutang Minimum</label>
                    <input type="number" class="form-control" name="min_piutang" value="{{ request('min_piutang') }}" placeholder="0">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rentang Piutang Maximum</label>
                    <input type="number" class="form-control" name="max_piutang" value="{{ request('max_piutang') }}" placeholder="100000000">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('reports.financial') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn-export" onclick="exportToExcel()">Export Excel</button>
        <button class="btn-export" onclick="exportToPDF()">Export PDF</button>
        <button class="btn-print" onclick="printReport()">Print</button>
    </div>

    <!-- Financial Data Table -->
    <div class="card">
        <div class="card-inner">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Fakultas/Jurusan</th>
                            <th>Tahun Akademik</th>
                            <th>Total Piutang</th>
                            <th>Terbayar</th>
                            <th>Sisa Piutang</th>
                            <th>Status</th>
                            <th>Terakhir Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students ?? [] as $index => $student)
                        <tr>
                            <td>{{ $loop->iteration + (($students->currentPage() - 1) * $students->perPage()) }}</td>
                            <td>{{ $student->nim }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->fakultas }}/{{ $student->jurusan }}</td>
                            <td>{{ $student->tahun_akademik }}</td>
                            <td>Rp {{ number_format($student->total_piutang, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($student->terbayar, 0, ',', '.') }}</td>
                            <td class="{{ $student->sisa_piutang > 10000000 ? 'text-danger fw-bold' : '' }}">
                                Rp {{ number_format($student->sisa_piutang, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($student->sisa_piutang == 0)
                                    <span class="badge bg-success">Lunas</span>
                                @elseif($student->sisa_piutang > 0 && $student->sisa_piutang <= 5000000)
                                    <span class="badge bg-warning">Belum Lunas</span>
                                @else
                                    <span class="badge bg-danger">Menunggak</span>
                                @endif
                            </td>
                            <td>{{ $student->last_payment ? $student->last_payment->format('d/m/Y') : 'Belum ada' }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewDetail({{ $student->id }})">Detail</button>
                                <button class="btn btn-sm btn-warning" onclick="addPayment({{ $student->id }})">Bayar</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada data laporan keuangan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($students) && $students->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-inner">
                    <h6 class="card-title">Grafik Piutang per Fakultas</h6>
                    <div class="chart-container">
                        <canvas id="piutangChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-inner">
                    <h6 class="card-title">Trend Pembayaran Bulanan</h6>
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Mahasiswa -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Keuangan Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="paymentForm">
                <div class="modal-body">
                    <input type="hidden" id="student_id" name="student_id">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Pembayaran</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js untuk grafik piutang per fakultas
const piutangCtx = document.getElementById('piutangChart').getContext('2d');
const piutangChart = new Chart(piutangCtx, {
    type: 'doughnut',
    data: {
        labels: ['FTI', 'FE', 'FH', 'FK'],
        datasets: [{
            data: [30, 25, 20, 25],
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#4BC0C0'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Chart.js untuk trend pembayaran
const trendCtx = document.getElementById('trendChart').getContext('2d');
const trendChart = new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Pembayaran (Juta Rp)',
            data: [65, 59, 80, 81, 56, 55],
            borderColor: '#36A2EB',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Functions for actions
function exportToExcel() {
    alert('Export to Excel functionality will be implemented');
}

function exportToPDF() {
    alert('Export to PDF functionality will be implemented');
}

function printReport() {
    window.print();
}

function viewDetail(studentId) {
    // Load student detail via AJAX
    fetch(`/api/student-financial-detail/${studentId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = data.html;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        })
        .catch(error => {
            alert('Error loading student detail');
        });
}

function addPayment(studentId) {
    document.getElementById('student_id').value = studentId;
    document.getElementById('payment_date').value = new Date().toISOString().split('T')[0];
    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

// Handle payment form submission
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/api/add-payment', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Pembayaran berhasil ditambahkan');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error adding payment');
    });
});
</script>
@endpush
@endsection
