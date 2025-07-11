@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<x-page-header 
    title="Dashboard" 
    subtitle="Welcome to STEFIA Dashboard">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
            <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Add New</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Statistics Cards -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Total Students" 
            value="1,245" 
            change="4.63%" 
            changeType="up" 
            tooltip="Total registered students" 
            chartId="totalStudents" />
            
        <x-stats-card 
            title="Total Revenue" 
            value="$2,847,950" 
            change="12.38%" 
            changeType="up" 
            tooltip="Total revenue collected" 
            chartId="totalRevenue" />
            
        <x-stats-card 
            title="Pending Payments" 
            value="$89,240" 
            change="2.45%" 
            changeType="down" 
            tooltip="Payments pending approval" 
            chartId="pendingPayments" />
            
        <x-stats-card 
            title="Active Scholarships" 
            value="87" 
            change="7.28%" 
            changeType="up" 
            tooltip="Currently active scholarships" 
            chartId="activeScholarships" />
    </div>
</div>

<!-- Chart Section -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-xxl-8">
            <div class="card card-bordered h-100">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Monthly Revenue</h6>
                            <p>In last 12 months revenue of STEFIA.</p>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Monthly revenue overview"></em>
                        </div>
                    </div>
                    <div class="nk-ecwg nk-ecwg1">
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">$2,847,950</div>
                                <div class="info text-right">
                                    <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>12.38%</span>
                                    <span class="sub">vs last month</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-ecwg1-ck">
                            <canvas class="ecommerce-line-chart-s1" id="monthlyRevenue"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card card-bordered h-100">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">Student Categories</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Student distribution by category"></em>
                        </div>
                    </div>
                    <div class="nk-ecwg nk-ecwg3">
                        <div class="nk-ecwg3-ck">
                            <canvas class="ecommerce-doughnut-s1" id="studentCategories"></canvas>
                        </div>
                        <ul class="nk-ecwg3-legends">
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#6576ff"></span>
                                    <span>Undergraduate</span>
                                </div>
                                <div class="amount">65.5%</div>
                            </li>
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#eb6459"></span>
                                    <span>Graduate</span>
                                </div>
                                <div class="amount">23.8%</div>
                            </li>
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#f4bd0e"></span>
                                    <span>PhD</span>
                                </div>
                                <div class="amount">10.7%</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="nk-block">
    <div class="row g-gs">
        <div class="col-xxl-8">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Recent Transactions</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="card-tools-nav">
                                <li><a href="#"><span>View All</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-inner p-0">
                    <div class="nk-tb-list">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span>Student</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>Amount</span></div>
                            <div class="nk-tb-col tb-col-md"><span>Date</span></div>
                            <div class="nk-tb-col"><span>Status</span></div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-purple">
                                        <span>JS</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">John Smith</span>
                                        <span class="tb-sub">john.smith@example.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub">$2,500</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Jan 15, 2025</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-success">Paid</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-pink">
                                        <span>MA</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Maria Anderson</span>
                                        <span class="tb-sub">maria.anderson@example.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub">$1,850</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Jan 12, 2025</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-warning">Pending</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-blue">
                                        <span>DL</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">David Lee</span>
                                        <span class="tb-sub">david.lee@example.com</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub">$3,200</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Jan 10, 2025</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-success">Paid</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group mb-2">
                        <div class="card-title">
                            <h6 class="title">Recent Activities</h6>
                        </div>
                        <div class="card-tools">
                            <ul class="card-tools-nav">
                                <li><a href="#"><span>View All</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-inner">
                    <div class="timeline">
                        <ul class="timeline-list">
                            <li class="timeline-item">
                                <div class="timeline-status bg-primary is-outline"></div>
                                <div class="timeline-date">Just now</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">New student registration</h6>
                                    <div class="timeline-des">
                                        <p>Sarah Johnson has successfully registered for the Computer Science program.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-status bg-success is-outline"></div>
                                <div class="timeline-date">2 hours ago</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Payment received</h6>
                                    <div class="timeline-des">
                                        <p>$2,500 tuition payment received from John Smith.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-status bg-warning is-outline"></div>
                                <div class="timeline-date">5 hours ago</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Scholarship application</h6>
                                    <div class="timeline-des">
                                        <p>New scholarship application submitted by Maria Anderson.</p>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item">
                                <div class="timeline-status bg-info is-outline"></div>
                                <div class="timeline-date">1 day ago</div>
                                <div class="timeline-data">
                                    <h6 class="timeline-title">Report generated</h6>
                                    <div class="timeline-des">
                                        <p>Monthly financial report has been generated and is ready for review.</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize Charts when document is ready
    $(document).ready(function() {
        
        // Small line charts for statistics cards
        if ($('#totalStudents').length) {
            var ctx = document.getElementById('totalStudents').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [1100, 1150, 1200, 1180, 1220, 1245],
                        borderColor: '#6576ff',
                        backgroundColor: 'rgba(101, 118, 255, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    },
                    elements: {
                        point: { radius: 0 }
                    }
                }
            });
        }
        
        if ($('#totalRevenue').length) {
            var ctx = document.getElementById('totalRevenue').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [2500000, 2600000, 2750000, 2680000, 2800000, 2847950],
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    },
                    elements: {
                        point: { radius: 0 }
                    }
                }
            });
        }
        
        if ($('#pendingPayments').length) {
            var ctx = document.getElementById('pendingPayments').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [95000, 88000, 92000, 85000, 91000, 89240],
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    },
                    elements: {
                        point: { radius: 0 }
                    }
                }
            });
        }
        
        if ($('#activeScholarships').length) {
            var ctx = document.getElementById('activeScholarships').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [75, 78, 82, 80, 85, 87],
                        borderColor: '#14b8a6',
                        backgroundColor: 'rgba(20, 184, 166, 0.1)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    },
                    elements: {
                        point: { radius: 0 }
                    }
                }
            });
        }
        
        // Monthly Revenue Chart
        if ($('#monthlyRevenue').length) {
            var ctx = document.getElementById('monthlyRevenue').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue',
                        data: [2200000, 2350000, 2180000, 2450000, 2600000, 2750000, 2680000, 2800000, 2920000, 2850000, 2780000, 2847950],
                        borderColor: '#6576ff',
                        backgroundColor: 'rgba(101, 118, 255, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            display: true,
                            grid: { display: false }
                        },
                        y: {
                            display: true,
                            grid: { color: 'rgba(0,0,0,0.05)' },
                            ticks: {
                                callback: function(value) {
                                    return '$' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        }
                    },
                    elements: {
                        point: { radius: 4, hoverRadius: 6 }
                    }
                }
            });
        }
        
        // Student Categories Doughnut Chart
        if ($('#studentCategories').length) {
            var ctx = document.getElementById('studentCategories').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Undergraduate', 'Graduate', 'PhD'],
                    datasets: [{
                        data: [65.5, 23.8, 10.7],
                        backgroundColor: ['#6576ff', '#eb6459', '#f4bd0e'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
        
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Auto-refresh data every 30 seconds (in production, this would make AJAX calls)
        setInterval(function() {
            // You can add AJAX calls here to refresh data
            console.log('Refreshing dashboard data...');
        }, 30000);
        
    });
</script>
@endpush
