@extends('layouts.admin')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;display=swap');
  
  * {
    font-family: 'Inter', sans-serif;
  }
  
  .page-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 40px;
    text-align: center;
    color: #333;
  }
  
  .filter-section {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }

  .stats-section {
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .stat-card {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 8px;
    padding: 20px;
    flex: 1 1 20%;
    margin: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    text-align: center;
  }

  .stat-value {
    font-size: 1.8rem;
    font-weight: 700;
  }

  .stat-label {
    margin-top: 10px;
    font-weight: 500;
  }

  .btn-export {
    background-color: #3498db;
    border-color: #3498db;
    color: white;
  }
</style>

<div class="container-fluid">
    <h1 class="page-title">💾 Payment Data Export</h1>

    <div class="filter-section">
        <form action="{{ route('payments.export') }}" method="GET">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="student">Student</label>
                    <select id="student" name="student_id" class="form-control">
                        <option value="">All Students</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="payment_method">Payment Method</label>
                    <select id="payment_method" name="payment_method" class="form-control">
                        <option value="">All Methods</option>
                        @foreach($paymentMethods as $key => $method)
                            <option value="{{ $key }}">{{ $method }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="payment_type">Payment Type</label>
                    <select id="payment_type" name="payment_type" class="form-control">
                        <option value="">All Types</option>
                        @foreach($paymentTypes as $key => $type)
                            <option value="{{ $key }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date_from">From Date</label>
                    <input type="date" id="date_from" name="date_from" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="date_to">To Date</label>
                    <input type="date" id="date_to" name="date_to" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <button type="submit" class="btn btn-export w-100" name="download" value="true">Export Data</button>
                </div>
            </div>
        </form>
    </div>

    <div class="stats-section">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_payments'] }}</div>
            <div class="stat-label">Total Payments</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_completed'] }}</div>
            <div class="stat-label">Completed Payments</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">${{ number_format($stats['total_amount'], 2) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_pending'] }}</div>
            <div class="stat-label">Pending Payments</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['last_export'] ? $stats['last_export']->format('Y-m-d') : 'N/A' }}</div>
            <div class="stat-label">Last Export</div>
        </div>
    </div>
</div>
@endsection

