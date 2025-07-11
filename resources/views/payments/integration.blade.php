@extends('layouts.admin')

@section('title', 'Payment Integration')

@section('content')
<h1>Payment Integration</h1>
<p>Manage integration with external payment systems and iGracias.</p>

<!-- Integration Status -->
<div class="card mb-4">
    <div class="card-header">
        <h5>Integration Status</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6>iGracias Integration</h6>
                        <p class="text-success">Connected</p>
                        <button class="btn btn-primary">Sync Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6>Payment Gateway</h6>
                        <p class="text-success">Active</p>
                        <button class="btn btn-primary">Test Connection</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Sync History -->
<div class="card">
    <div class="card-header">
        <h5>Recent Sync History</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>System</th>
                    <th>Records</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2025-01-11 08:30:00</td>
                    <td>iGracias</td>
                    <td>25 payments</td>
                    <td><span class="badge bg-success">Success</span></td>
                </tr>
                <tr>
                    <td>2025-01-10 08:30:00</td>
                    <td>iGracias</td>
                    <td>18 payments</td>
                    <td><span class="badge bg-success">Success</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
