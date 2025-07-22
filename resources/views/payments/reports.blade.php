@extends('layouts.admin')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
  * { font-family: 'Inter', sans-serif; }
  .dashboard-container {
    background: linear-gradient(135deg, #e0e0e0 0%, #bdbdbd 100%);
    min-height: 100vh;
    padding: 20px;
  }
  .glass-card {
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(10px);
    border: 1.5px solid #d1d1d1;
    border-radius: 22px;
    padding: 32px 28px;
    margin-bottom: 32px;
    box-shadow: 0 8px 32px rgba(189,189,189,0.10);
    transition: all 0.4s cubic-bezier(.175,.885,.32,1.275);
  }
  .glass-card:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow: 0 16px 40px rgba(189,189,189,0.13);
  }
  .page-title {
    color: #e53935;
    font-size: 2.3rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 38px;
    text-shadow: 0 4px 20px rgba(229,57,53,0.10);
    letter-spacing: 1px;
  }
  .stat-card {
    background: linear-gradient(135deg, #fff 60%, #f5f5f5 100%);
    border: 1.5px solid #e0e0e0;
    border-radius: 18px;
    padding: 22px 0 18px 0;
    text-align: center;
    box-shadow: 0 4px 16px rgba(189,189,189,0.07);
    margin-bottom: 12px;
  }
  .stat-number {
    font-size: 2.1rem;
    font-weight: 700;
    color: #e53935;
    margin-bottom: 7px;
    display: block;
  }
  .stat-label {
    font-size: 0.93rem;
    color: #616161;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .stat-icon {
    font-size: 2.2rem;
    margin-bottom: 13px;
    color: #bdbdbd;
    opacity: 0.85;
  }
  .filter-section {
    background: rgba(255,255,255,0.98);
    border-radius: 16px;
    padding: 22px 18px 18px 18px;
    margin-bottom: 18px;
    border: 1px solid #e0e0e0;
  }
  .form-control {
    background: #fff;
    border: 1.5px solid #bdbdbd;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
    color: #212121;
  }
  .form-control:focus {
    background: #fff;
    border-color: #e53935;
    box-shadow: 0 0 20px rgba(229,57,53,0.13);
    transform: scale(1.02);
  }
  .btn {
    border-radius: 12px;
    padding: 12px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
  }
  .btn-primary {
    background: linear-gradient(135deg, #e53935, #bdbdbd);
    color: white;
  }
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(229,57,53,0.13);
  }
  .chart-container {
    background: #fff;
    border-radius: 16px;
    padding: 25px 18px 18px 18px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(189,189,189,0.07);
    border: 1px solid #e0e0e0;
  }
  .table-modern {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(189,189,189,0.07);
    border: 1px solid #e0e0e0;
  }
  .table-modern thead {
    background: linear-gradient(135deg, #e53935, #bdbdbd);
    color: white;
  }
  .table-modern thead th {
    border: none;
    padding: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.87rem;
  }
  .table-modern tbody tr {
    transition: all 0.3s ease;
  }
  .table-modern tbody tr:hover {
    background: rgba(229,57,53,0.07);
    transform: scale(1.01);
  }
  .table-modern tbody td {
    border: none;
    padding: 14px 16px;
    vertical-align: middle;
    color: #212121;
  }
  .status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .status-completed {
    background: #fff;
    color: #e53935;
    border: 1px solid #e53935;
  }
  .status-pending {
    background: #bdbdbd;
    color: #fff;
  }
  .status-failed {
    background: #e53935;
    color: #fff;
  }
  .breakdown-card {
    background: #fff;
    border-radius: 16px;
    padding: 18px 10px 14px 10px;
    margin-bottom: 18px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(189,189,189,0.07);
    border: 1px solid #e0e0e0;
  }
  .breakdown-title {
    font-size: 1.08rem;
    font-weight: 700;
    color: #e53935;
    margin-bottom: 7px;
    text-transform: capitalize;
  }
  .breakdown-amount {
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #e53935, #bdbdbd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .breakdown-count {
    font-size: 0.9rem;
    color: #616161;
    font-weight: 500;
  }
  .section-title {
    color: #e53935;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 22px;
    text-shadow: 0 2px 10px rgba(229,57,53,0.10);
  }
  /* Responsive Design */
  @media (max-width: 768px) {
    .page-title { font-size: 1.5rem; }
    .stat-number { font-size: 1.2rem; }
    .glass-card { padding: 14px; }
  }
</style>
<div class="dashboard-container">
    <h1 class="page-title">📊 Payment Analytics Report</h1>
    <div class="glass-card">
        <div class="filter-section">
            <h3 class="section-title" style="color: #e53935; margin-bottom: 18px;">📅 Filter Reports</h3>
            <form action="{{ route('payments.reports') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="startDate" style="color: #e53935; font-weight: 600; margin-bottom: 8px; display: block;">Start Date</label>
                        <input type="date" id="startDate" name="start_date" class="form-control" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="endDate" style="color: #e53935; font-weight: 600; margin-bottom: 8px; display: block;">End Date</label>
                        <input type="date" id="endDate" name="end_date" class="form-control" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">🔍 Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">💰</div>
                <span class="stat-number">${{ number_format($reportData['summary']['total_amount'], 0) }}</span>
                <span class="stat-label">Total Revenue</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <span class="stat-number">{{ number_format($reportData['summary']['total_count']) }}</span>
                <span class="stat-label">Total Payments</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <span class="stat-number">${{ number_format($reportData['summary']['completed_amount'], 0) }}</span>
                <span class="stat-label">Completed</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <span class="stat-number">${{ number_format($reportData['summary']['pending_amount'], 0) }}</span>
                <span class="stat-label">Pending</span>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="chart-container">
                <h4 style="color: #e53935; margin-bottom: 18px; font-weight: 700;">📈 Payment Trends (Last 30 Days)</h4>
                <div id="dailyTrendChart" style="height: 220px;"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-container">
                <h4 style="color: #e53935; margin-bottom: 18px; font-weight: 700;">🎯 Status Overview</h4>
                <div id="statusChart" style="height: 220px;"></div>
            </div>
        </div>
    </div>
    <div class="glass-card">
        <h3 class="section-title">💳 Payment Method Breakdown</h3>
        <div class="row">
            @foreach($reportData['payment_methods'] as $method)
            <div class="col-md-2 col-sm-4 mb-3">
                <div class="breakdown-card">
                    <div class="breakdown-title">{{ ucwords(str_replace('_', ' ', $method->payment_method)) }}</div>
                    <div class="breakdown-amount">${{ number_format($method->total, 0) }}</div>
                    <div class="breakdown-count">{{ $method->count }} transactions</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="glass-card">
        <h3 class="section-title">🏷️ Payment Type Breakdown</h3>
        <div class="row">
            @foreach($reportData['payment_types'] as $type)
            <div class="col-md-2 col-sm-4 mb-3">
                <div class="breakdown-card">
                    <div class="breakdown-title">{{ ucwords(str_replace('_', ' ', $type->payment_type)) }}</div>
                    <div class="breakdown-amount">${{ number_format($type->total, 0) }}</div>
                    <div class="breakdown-count">{{ $type->count }} payments</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="glass-card">
        <h3 class="section-title">📋 Recent Payment Transactions</h3>
        <div class="table-modern">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>📅 Date</th>
                        <th>👨‍🎓 Student</th>
                        <th>💵 Amount</th>
                        <th>💳 Method</th>
                        <th>📊 Status</th>
                        <th>🔗 Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPayments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td><strong>{{ $payment->student->name ?? 'N/A' }}</strong></td>
                        <td><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                        <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                        <td>
                            <span class="status-badge status-{{ $payment->status }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-primary" style="border-radius: 8px; padding: 4px 12px; font-size: 0.95rem;">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="glass-card">
        <h3 class="section-title">🏆 Top Contributing Students</h3>
        <div class="table-modern">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>🥇 Rank</th>
                        <th>👨‍🎓 Student</th>
                        <th>💰 Total Amount</th>
                        <th>🔢 Payment Count</th>
                        <th>📊 Average</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData['top_students'] as $index => $student)
                    <tr>
                        <td>
                            <span style="font-size: 1.5rem;">
                                @if($index == 0) 🥇
                                @elseif($index == 1) 🥈
                                @elseif($index == 2) 🥉
                                @else {{ $index + 1 }}
                                @endif
                            </span>
                        </td>
                        <td><strong>{{ $student->student->name ?? 'N/A' }}</strong></td>
                        <td><strong>${{ number_format($student->total_amount, 2) }}</strong></td>
                        <td>{{ $student->payment_count }} payments</td>
                        <td>${{ $student->payment_count > 0 ? number_format($student->total_amount / $student->payment_count, 2) : '0.00' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
<script>
// Payment Trends (Line)
Highcharts.chart('dailyTrendChart', {
    chart: { type: 'line', backgroundColor: 'rgba(255,255,255,0.0)' },
    title: { text: null },
    xAxis: {
        categories: @json($reportData['daily_trend']->pluck('date')->map(fn($date) => $date->format('Y-m-d'))),
        labels: { style: { color: '#e53935', fontWeight: '600' } }
    },
    yAxis: {
        title: { text: 'Total Payment' },
        labels: { style: { color: '#bdbdbd' } }
    },
    series: [{
        name: 'Total Payment',
        data: @json($reportData['daily_trend']->pluck('total')),
        color: '#e53935',
        lineWidth: 4,
        marker: { radius: 5, fillColor: '#bdbdbd', lineColor: '#e53935', lineWidth: 2 }
    }],
    credits: { enabled: false },
    exporting: { enabled: true },
    lang: { noData: 'Tidak Ada Data' },
    noData: { style: { fontWeight: 'bold', fontSize: '1.2em', color: '#e53935' } }
});
// Status Overview (Pie)
Highcharts.chart('statusChart', {
    chart: { type: 'pie', backgroundColor: 'rgba(255,255,255,0.0)' },
    title: { text: null },
    tooltip: { pointFormat: '{series.name}: <b>{point.y}</b>' },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y}',
                style: { color: '#e53935', fontWeight: '600' }
            }
        }
    },
    series: [{
        name: 'Payments',
        colorByPoint: true,
        data: [
            { name: 'Completed', y: {{ $reportData['summary']['completed_count'] ?? 0 }}, color: '#fff' },
            { name: 'Pending', y: {{ $reportData['summary']['pending_count'] ?? 0 }}, color: '#bdbdbd' },
            { name: 'Failed', y: {{ $reportData['status_breakdown']['failed'] ?? 0 }}, color: '#e53935' }
        ]
    }],
    credits: { enabled: false },
    exporting: { enabled: true },
    lang: { noData: 'Tidak Ada Data' },
    noData: { style: { fontWeight: 'bold', fontSize: '1.2em', color: '#e53935' } }
});
</script>
@endsection
