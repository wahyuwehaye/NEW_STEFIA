@extends('layouts.admin')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;display=swap');
  
  * {
    font-family: 'Inter', sans-serif;
  }
  .page-title {
    font-size: 2.3rem;
    font-weight: 800;
    margin-bottom: 38px;
    text-align: center;
    color: #e53935;
    text-shadow: 0 4px 20px rgba(229,57,53,0.10);
    letter-spacing: 1px;
  }
  .filter-section {
    background: rgba(255,255,255,0.92);
    border-radius: 16px;
    padding: 32px 28px;
    box-shadow: 0 8px 32px rgba(189,189,189,0.10);
    margin-bottom: 32px;
    border: 1.5px solid #d1d1d1;
  }
  .form-control {
    background: #fff;
    border: 1.5px solid #bdbdbd;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    color: #212121;
    transition: all 0.3s ease;
  }
  .form-control:focus {
    background: #fff;
    border-color: #e53935;
    box-shadow: 0 0 20px rgba(229,57,53,0.13);
    transform: scale(1.02);
  }
  .btn-export {
    background: linear-gradient(135deg, #e53935, #bdbdbd);
    border: none;
    color: white;
    border-radius: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 30px;
    transition: all 0.3s ease;
  }
  .btn-export:hover {
    background: linear-gradient(135deg, #bdbdbd, #e53935);
    color: #fff;
    box-shadow: 0 10px 25px rgba(229,57,53,0.13);
    transform: translateY(-2px);
  }
  .stats-section {
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }
  .stat-card {
    background: linear-gradient(135deg, #fff 60%, #f5f5f5 100%);
    color: #e53935;
    border-radius: 18px;
    padding: 20px 0 18px 0;
    flex: 1 1 20%;
    margin: 10px;
    box-shadow: 0 4px 16px rgba(189,189,189,0.07);
    text-align: center;
    border: 1.5px solid #e0e0e0;
  }
  .stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: #e53935;
  }
  .stat-label {
    margin-top: 10px;
    font-weight: 500;
    color: #616161;
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

