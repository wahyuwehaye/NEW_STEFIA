@extends('layouts.admin')

@section('content')
<div class="nk-block">
    <h4 class="nk-block-title">Analytics Pembayaran</h4>
    
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Pembayaran</h6>
                            <h4 class="mb-0">{{ number_format($totalPayments ?? 0) }}</h4>
                        </div>
                        <div class="nk-wg-icon">
                            <em class="icon ni ni-credit-card text-primary"></em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Amount</h6>
                            <h4 class="mb-0">Rp {{ number_format($totalAmount ?? 0, 0, ',', '.') }}</h4>
                        </div>
                        <div class="nk-wg-icon">
                            <em class="icon ni ni-coins text-success"></em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Pending</h6>
                            <h4 class="mb-0">{{ number_format($pendingPayments ?? 0) }}</h4>
                        </div>
                        <div class="nk-wg-icon">
                            <em class="icon ni ni-clock text-warning"></em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-bordered">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Completed</h6>
                            <h4 class="mb-0">{{ number_format($completedPayments ?? 0) }}</h4>
                        </div>
                        <div class="nk-wg-icon">
                            <em class="icon ni ni-check-circle text-success"></em>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts Section -->
    <div class="row g-3">
        <!-- Payment Trends Chart -->
        <div class="col-lg-8">
            <div class="card card-bordered">
                <div class="card-header">
                    <h6 class="card-title">Trend Pembayaran (6 Bulan Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="trendChart" style="max-height: 400px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payment Methods Distribution -->
        <div class="col-lg-4">
            <div class="card card-bordered">
                <div class="card-header">
                    <h6 class="card-title">Distribusi Metode Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="methodChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Analytics -->
    <div class="row g-3 mt-4">
        <!-- Daily Revenue Chart -->
        <div class="col-lg-6">
            <div class="card card-bordered">
                <div class="card-header">
                    <h6 class="card-title">Revenue Harian (30 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payment Status Chart -->
        <div class="col-lg-6">
            <div class="card card-bordered">
                <div class="card-header">
                    <h6 class="card-title">Status Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusChart" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Analytics Table -->
    <div class="row g-3 mt-4">
        <div class="col-12">
            <div class="card card-bordered">
                <div class="card-header">
                    <h6 class="card-title">Top Performing Students</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Total Pembayaran</th>
                                    <th>Jumlah Transaksi</th>
                                    <th>Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topStudents ?? [] as $student)
                                <tr>
                                    <td>{{ $student->name ?? 'N/A' }}</td>
                                    <td>{{ $student->nim ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($student->total_payments ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ number_format($student->payment_count ?? 0) }}</td>
                                    <td>Rp {{ number_format($student->avg_payment ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data pembayaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample data - replace with actual data from controller
    @php
        $trendData = $trendData ?? [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'completed' => [150, 180, 220, 200, 250, 300],
            'pending' => [20, 15, 25, 30, 20, 25],
            'failed' => [5, 8, 10, 7, 5, 8]
        ];
        
        $methodData = $methodData ?? [
            'labels' => ['Transfer Bank', 'Tunai', 'E-Wallet', 'Kartu Kredit', 'Lainnya'],
            'data' => [45, 25, 15, 10, 5]
        ];
        
        $revenueData = $revenueData ?? [
            'labels' => array_map(function($i) { return date('d/m', strtotime("-$i days")); }, range(29, 0)),
            'data' => array_map(function() { return rand(1000000, 5000000); }, range(0, 29))
        ];
        
        $statusData = $statusData ?? [
            'labels' => ['Completed', 'Pending', 'Failed', 'Cancelled'],
            'data' => [70, 20, 7, 3]
        ];
    @endphp
    
    const trendData = {!! json_encode($trendData) !!};
    const methodData = {!! json_encode($methodData) !!};
    const revenueData = {!! json_encode($revenueData) !!};
    const statusData = {!! json_encode($statusData) !!};
    
    // Trend Chart
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.labels,
            datasets: [{
                label: 'Completed',
                data: trendData.completed,
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                fill: true
            }, {
                label: 'Pending',
                data: trendData.pending,
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                fill: true
            }, {
                label: 'Failed',
                data: trendData.failed,
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Method Chart
    const methodCtx = document.getElementById('methodChart').getContext('2d');
    new Chart(methodCtx, {
        type: 'doughnut',
        data: {
            labels: methodData.labels,
            datasets: [{
                data: methodData.data,
                backgroundColor: [
                    '#007bff',
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#6c757d'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: revenueData.labels,
            datasets: [{
                label: 'Revenue (Rp)',
                data: revenueData.data,
                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                borderColor: '#007bff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
    
    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: statusData.labels,
            datasets: [{
                data: statusData.data,
                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#dc3545',
                    '#6c757d'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
