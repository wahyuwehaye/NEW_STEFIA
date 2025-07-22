@extends('layouts.admin')

@section('title', 'Laporan Pembayaran')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-lg">
                    <div class="nk-block-head-content">
                        <h2 class="nk-block-title fw-normal">Laporan Pembayaran</h2>
                        <div class="nk-block-des">
                            <p>Analisis dan rekap pembayaran mahasiswa</p>
                        </div>
                    </div>
                </div>
                <!-- Statistik Cards -->
                <div class="nk-block">
                    <div class="row g-3">
                        <div class="col-xxl-3 col-md-6">
                            <div class="card card-full bg-primary">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title text-white">Total Revenue</h6>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount text-white">${{ number_format($reportData['summary']['total_amount'], 0) }}</span>
                                    </div>
                                    <div class="card-note">
                                        <span class="text-white">Total pemasukan</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card card-full bg-success">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title text-white">Total Payments</h6>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount text-white">{{ number_format($reportData['summary']['total_count']) }}</span>
                                    </div>
                                    <div class="card-note">
                                        <span class="text-white">Transaksi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card card-full bg-warning">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title text-white">Completed</h6>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount text-white">${{ number_format($reportData['summary']['completed_amount'], 0) }}</span>
                                    </div>
                                    <div class="card-note">
                                        <span class="text-white">Pembayaran selesai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div class="card card-full bg-danger">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title text-white">Pending</h6>
                                        </div>
                                    </div>
                                    <div class="card-amount">
                                        <span class="amount text-white">${{ number_format($reportData['summary']['pending_amount'], 0) }}</span>
                                    </div>
                                    <div class="card-note">
                                        <span class="text-white">Belum selesai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Chart Section -->
                <div class="nk-block">
                    <div class="row g-3">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Tren Pembayaran 30 Hari Terakhir</h6>
                                        </div>
                                    </div>
                                    <div class="nk-chart-wrap">
                                        <div id="dailyTrendChart" style="height:220px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Status Overview</h6>
                                        </div>
                                    </div>
                                    <div class="nk-chart-wrap">
                                        <div id="statusChart" style="height:220px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Breakdown Metode Pembayaran -->
                <div class="nk-block">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Breakdown Metode Pembayaran</h6>
                                </div>
                            </div>
                            <div class="row g-3">
                                @foreach($reportData['payment_methods'] as $method)
                                <div class="col-md-2 col-6 mb-2">
                                    <div class="text-soft small">{{ ucwords(str_replace('_', ' ', $method->payment_method)) }}</div>
                                    <div class="fw-bold" style="color:#e14954;">${{ number_format($method->total, 0) }}</div>
                                    <div class="small text-muted">{{ $method->count }} transaksi</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Breakdown Tipe Pembayaran -->
                <div class="nk-block">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Breakdown Tipe Pembayaran</h6>
                                </div>
                            </div>
                            <div class="row g-3">
                                @foreach($reportData['payment_types'] as $type)
                                <div class="col-md-2 col-6 mb-2">
                                    <div class="text-soft small">{{ ucwords(str_replace('_', ' ', $type->payment_type)) }}</div>
                                    <div class="fw-bold" style="color:#e14954;">${{ number_format($type->total, 0) }}</div>
                                    <div class="small text-muted">{{ $type->count }} pembayaran</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tabel Transaksi Terbaru -->
                <div class="nk-block">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Transaksi Pembayaran Terbaru</h6>
                                </div>
                            </div>
                            <div class="nk-tb-list">
                                <div class="nk-tb-item">
                                    <div class="nk-tb-head">
                                        <div class="nk-tb-col"><span class="sub-text">Tanggal</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Mahasiswa</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Jumlah</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Metode</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Aksi</span></div>
                                    </div>
                                    <div class="nk-tb-body">
                                        @foreach($recentPayments as $payment)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span>{{ $payment->payment_date->format('d M Y') }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>{{ $payment->student->name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>${{ number_format($payment->amount, 2) }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span class="badge badge-dot badge-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($payment->status) }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-xs btn-primary">Detail</a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tabel Top Mahasiswa -->
                <div class="nk-block">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Top Mahasiswa Kontributor</h6>
                                </div>
                            </div>
                            <div class="nk-tb-list">
                                <div class="nk-tb-item">
                                    <div class="nk-tb-head">
                                        <div class="nk-tb-col"><span class="sub-text">#</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Mahasiswa</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Total</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Jumlah Bayar</span></div>
                                        <div class="nk-tb-col"><span class="sub-text">Rata-rata</span></div>
                                    </div>
                                    <div class="nk-tb-body">
                                        @foreach($reportData['top_students'] as $index => $student)
                                        <div class="nk-tb-item">
                                            <div class="nk-tb-col">
                                                <span>{{ $index+1 }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>{{ $student->student->name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>${{ number_format($student->total_amount, 2) }}</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>{{ $student->payment_count }} pembayaran</span>
                                            </div>
                                            <div class="nk-tb-col">
                                                <span>${{ $student->payment_count > 0 ? number_format($student->total_amount / $student->payment_count, 2) : '0.00' }}</span>
                                            </div>
                                        </div>
                                        @endforeach
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
@endsection

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
<script>
Highcharts.chart('dailyTrendChart', {
    chart: { type: 'line', backgroundColor: '#fff' },
    title: { text: null },
    xAxis: {
        categories: @json($reportData['daily_trend']->pluck('date')),
        labels: { style: { color: '#364a63', fontWeight: '600' } }
    },
    yAxis: {
        title: { text: 'Total Pembayaran' },
        labels: { style: { color: '#364a63' } }
    },
    series: [{
        name: 'Total Pembayaran',
        color: '#e14954',
        data: @json($reportData['daily_trend']->pluck('total'))
    }],
    credits: { enabled: false },
    exporting: { enabled: true },
    lang: { noData: 'Tidak Ada Data' },
    noData: { style: { fontWeight: 'bold', fontSize: '1.2em', color: '#e14954' } }
});
Highcharts.chart('statusChart', {
    chart: { type: 'pie', backgroundColor: '#fff' },
    title: { text: null },
    tooltip: { pointFormat: '{series.name}: <b>{point.y}</b>' },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}',
                style: { color: '#e14954', fontWeight: '600' }
            }
        }
    },
    series: [{
        name: 'Payments',
        colorByPoint: true,
        data: [
            { name: 'Completed', y: {{ $reportData['summary']['completed_count'] ?? 0 }}, color: '#1ee0ac' },
            { name: 'Pending', y: {{ $reportData['summary']['pending_count'] ?? 0 }}, color: '#ffa353' },
            { name: 'Failed', y: {{ $reportData['status_breakdown']['failed'] ?? 0 }}, color: '#e14954' }
        ]
    }],
    credits: { enabled: false },
    exporting: { enabled: true },
    lang: { noData: 'Tidak Ada Data' },
    noData: { style: { fontWeight: 'bold', fontSize: '1.2em', color: '#e14954' } }
});
</script>
@endpush

