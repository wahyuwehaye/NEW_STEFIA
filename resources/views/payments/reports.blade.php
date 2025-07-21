@extends('layouts.admin')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
  
  * {
    font-family: 'Inter', sans-serif;
  }
  
  .dashboard-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px;
  }
  
  .glass-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    opacity: 0;
    transform: translateY(30px);
    animation: slideUp 0.8s ease-out forwards;
  }
  
  .glass-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }
  
  @keyframes slideUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .page-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 40px;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    animation: fadeInDown 1s ease-out;
  }
  
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .stat-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.1));
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: all 0.6s;
  }
  
  .stat-card:hover::before {
    left: 100%;
  }
  
  .stat-card:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  }
  
  .stat-number {
    font-size: 2.2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 8px;
    display: block;
  }
  
  .stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .stat-icon {
    font-size: 2.5rem;
    margin-bottom: 15px;
    opacity: 0.8;
  }
  
  .filter-section {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
  }
  
  .form-control {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
  }
  
  .form-control:focus {
    background: white;
    border-color: #667eea;
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
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
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
  }
  
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
  }
  
  .chart-container {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }
  
  .table-modern {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }
  
  .table-modern thead {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
  }
  
  .table-modern thead th {
    border: none;
    padding: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
  }
  
  .table-modern tbody tr {
    transition: all 0.3s ease;
  }
  
  .table-modern tbody tr:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: scale(1.01);
  }
  
  .table-modern tbody td {
    border: none;
    padding: 16px 18px;
    vertical-align: middle;
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
    background: linear-gradient(135deg, #11998e, #38ef7d);
    color: white;
  }
  
  .status-pending {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
  }
  
  .status-failed {
    background: linear-gradient(135deg, #fc466b, #3f5efb);
    color: white;
  }
  
  .breakdown-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  }
  
  .breakdown-card:hover {
    transform: translateY(-5px) rotate(1deg);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
  }
  
  .breakdown-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
    text-transform: capitalize;
  }
  
  .breakdown-amount {
    font-size: 1.8rem;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  
  .breakdown-count {
    font-size: 0.9rem;
    color: #666;
    font-weight: 500;
  }
  
  .section-title {
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 25px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  }
  
  .loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
  }
  
  @keyframes spin {
    to { transform: rotate(360deg); }
  }
  
  .pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
  }
  
  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
  }
  
  .floating {
    animation: floating 3s ease-in-out infinite;
  }
  
  @keyframes floating {
    0% { transform: translate(0, 0px); }
    50% { transform: translate(0, -10px); }
    100% { transform: translate(0, 0px); }
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .page-title {
      font-size: 2rem;
    }
    
    .stat-number {
      font-size: 1.8rem;
    }
    
    .glass-card {
      padding: 20px;
    }
  }
</style>
<div class="dashboard-container">
    <!-- Page Title -->
    <h1 class="page-title floating">📊 Payment Analytics Dashboard</h1>
    
    <!-- Filter Section -->
    <div class="glass-card">
        <div class="filter-section">
            <h3 class="section-title" style="color: #333; margin-bottom: 20px;">📅 Filter Reports</h3>
            <form action="{{ route('payments.reports') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label for="startDate" style="color: white; font-weight: 600; margin-bottom: 8px; display: block;">Start Date</label>
                        <input type="date" id="startDate" name="start_date" class="form-control" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="endDate" style="color: white; font-weight: 600; margin-bottom: 8px; display: block;">End Date</label>
                        <input type="date" id="endDate" name="end_date" class="form-control" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">🔍 Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats Grid -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card pulse">
                <div class="stat-icon">💰</div>
                <span class="stat-number">${{ number_format($reportData['summary']['total_amount'], 0) }}</span>
                <span class="stat-label">Total Revenue</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card pulse" style="animation-delay: 0.2s;">
                <div class="stat-icon">📊</div>
                <span class="stat-number">{{ number_format($reportData['summary']['total_count']) }}</span>
                <span class="stat-label">Total Payments</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card pulse" style="animation-delay: 0.4s;">
                <div class="stat-icon">✅</div>
                <span class="stat-number">${{ number_format($reportData['summary']['completed_amount'], 0) }}</span>
                <span class="stat-label">Completed</span>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card pulse" style="animation-delay: 0.6s;">
                <div class="stat-icon">⏳</div>
                <span class="stat-number">${{ number_format($reportData['summary']['pending_amount'], 0) }}</span>
                <span class="stat-label">Pending</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="chart-container">
                <h4 style="color: #333; margin-bottom: 20px; font-weight: 700;">📈 Payment Trends (Last 30 Days)</h4>
                <canvas id="dailyTrendChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-container">
                <h4 style="color: #333; margin-bottom: 20px; font-weight: 700;">🎯 Status Overview</h4>
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Breakdown Cards -->
    <div class="glass-card">
        <h3 class="section-title">💳 Payment Method Breakdown</h3>
        <div class="row">
            @foreach($reportData['payment_methods'] as $method)
            <div class="col-md-2 col-sm-4 mb-3">
                <div class="breakdown-card">
                    <div class="breakdown-title">{{ str_replace('_', ' ', ucwords($method->payment_method)) }}</div>
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
                    <div class="breakdown-title">{{ str_replace('_', ' ', ucwords($type->payment_type)) }}</div>
                    <div class="breakdown-amount">${{ number_format($type->total, 0) }}</div>
                    <div class="breakdown-count">{{ $type->count }} payments</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Payments Table -->
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
                        <td>{{ str_replace('_', ' ', ucwords($payment->payment_method)) }}</td>
                        <td>
                            <span class="status-badge status-{{ $payment->status }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 8px; padding: 4px 12px;">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Students -->
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Example daily trend chart setup
    const dailyTrendCtx = document.getElementById('dailyTrendChart').getContext('2d');
    new Chart(dailyTrendCtx, {
        type: 'line',
        data: {
            labels: @json($reportData['daily_trend']->pluck('date')->map(fn($date) => $date->format('Y-m-d'))),
            datasets: [{
                label: 'Daily Payments',
                data: @json($reportData['daily_trend']->pluck('total')),
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'day'
                    }
                }
            }
        }
    });
</script>
@endsection
