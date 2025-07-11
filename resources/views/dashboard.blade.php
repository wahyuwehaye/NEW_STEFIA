@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<x-page-header 
    title="STEFIA Dashboard" 
    subtitle="Comprehensive Financial Management Overview"
    class="fade-in">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="{{ route('reports.export') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export Report</span></a></li>
            <li><a href="{{ route('students.create') }}" class="btn btn-success"><em class="icon ni ni-user-add"></em><span>Add Student</span></a></li>
            <li class="nk-block-tools-opt"><a href="{{ route('payments.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Record Payment</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Statistics Cards -->
<div class="nk-block fade-in">
    <div class="row g-gs">
        <x-stats-card 
            title="Total Mahasiswa" 
            value="1,245" 
            change="4.63%" 
            changeType="up" 
            tooltip="Total mahasiswa terdaftar dalam sistem" 
            chartId="totalStudents" />
            
        <x-stats-card 
            title="Piutang Aktif" 
            value="Rp 2.847.950.000" 
            change="12.38%" 
            changeType="up" 
            tooltip="Total piutang yang masih aktif" 
            chartId="activeReceivables" />
            
        <x-stats-card 
            title="Piutang Lunas" 
            value="Rp 1.456.780.000" 
            change="8.45%" 
            changeType="up" 
            tooltip="Total piutang yang sudah lunas" 
            chartId="paidReceivables" />
            
        <x-stats-card 
            title="Tunggakan Kritis" 
            value="23" 
            change="2.45%" 
            changeType="down" 
            tooltip="Mahasiswa dengan tunggakan >10 juta" 
            chartId="highDebtors" />
            
        <x-stats-card 
            title="Pembayaran Hari Ini" 
            value="Rp 89.240.000" 
            change="7.28%" 
            changeType="up" 
            tooltip="Pembayaran yang diterima hari ini" 
            chartId="todayPayments" />
            
        <x-stats-card 
            title="Piutang Semester Ini" 
            value="Rp 456.780.000" 
            change="15.67%" 
            changeType="up" 
            tooltip="Piutang semester tahun akademik berjalan" 
            chartId="semesterReceivables" />
            
        <x-stats-card 
            title="Piutang Tahun Ini" 
            value="Rp 1.234.567.000" 
            change="18.23%" 
            changeType="up" 
            tooltip="Total piutang tahun 2025" 
            chartId="yearlyReceivables" />
            
        <x-stats-card 
            title="Collection Rate" 
            value="94.2%" 
            change="2.1%" 
            changeType="up" 
            tooltip="Tingkat keberhasilan penagihan" 
            chartId="collectionRate" />
    </div>
</div>

<!-- Chart Section -->
<div class="nk-block fade-in">
    <div class="row g-gs">
        <div class="col-xxl-8">
            <div class="card card-bordered h-100">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title text-gradient">Monthly Revenue</h6>
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
                            <h6 class="title text-gradient">Status Piutang</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Distribusi status piutang mahasiswa"></em>
                        </div>
                    </div>
                    <div class="nk-ecwg nk-ecwg3">
                        <div class="nk-ecwg3-ck">
                            <canvas class="ecommerce-doughnut-s1" id="receivableStatus"></canvas>
                        </div>
                        <ul class="nk-ecwg3-legends">
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#22c55e"></span>
                                    <span>Lunas</span>
                                </div>
                                <div class="amount">68.5%</div>
                            </li>
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#f59e0b"></span>
                                    <span>Aktif</span>
                                </div>
                                <div class="amount">28.8%</div>
                            </li>
                            <li>
                                <div class="title">
                                    <span class="dot dot-lg sq" data-bg="#ef4444"></span>
                                    <span>Tunggakan</span>
                                </div>
                                <div class="amount">2.7%</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- High Debtors and Payment Trends -->
<div class="nk-block fade-in">
    <div class="row g-gs">
        <div class="col-xxl-6">
            <div class="card card-bordered h-100">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title text-gradient">Mahasiswa Tunggakan Kritis (>10 Juta)</h6>
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
                            <div class="nk-tb-col"><span>Mahasiswa</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>Tunggakan</span></div>
                            <div class="nk-tb-col tb-col-md"><span>Terakhir Bayar</span></div>
                            <div class="nk-tb-col"><span>Status</span></div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-danger">
                                        <span>AN</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Ahmad Nurdin</span>
                                        <span class="tb-sub">2019001234</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub text-danger">Rp 15.750.000</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Nov 15, 2024</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-danger">Kritis</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-warning">
                                        <span>SR</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Siti Rahayu</span>
                                        <span class="tb-sub">2019005678</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub text-warning">Rp 12.500.000</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Dec 20, 2024</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-warning">Tinggi</span>
                            </div>
                        </div>
                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                <div class="user-card">
                                    <div class="user-avatar user-avatar-sm bg-danger">
                                        <span>BH</span>
                                    </div>
                                    <div class="user-name">
                                        <span class="tb-lead">Budi Hartono</span>
                                        <span class="tb-sub">2020001987</span>
                                    </div>
                                </div>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub text-danger">Rp 18.200.000</span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                <span class="tb-sub">Oct 10, 2024</span>
                            </div>
                            <div class="nk-tb-col">
                                <span class="badge badge-dot badge-danger">Kritis</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card card-bordered h-100">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title text-gradient">Tren Pembayaran Bulanan</h6>
                        </div>
                        <div class="card-tools">
                            <em class="card-hint icon ni ni-help-fill" data-bs-toggle="tooltip" data-bs-placement="left" title="Tren pembayaran 6 bulan terakhir"></em>
                        </div>
                    </div>
                    <div class="nk-ecwg nk-ecwg1">
                        <div class="data">
                            <div class="data-group">
                                <div class="amount">Rp 89.240.000</div>
                                <div class="info text-right">
                                    <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>7.28%</span>
                                    <span class="sub">vs bulan lalu</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-ecwg1-ck">
                            <canvas class="ecommerce-line-chart-s1" id="paymentTrends"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="nk-block fade-in">
    <div class="row g-gs">
        <div class="col-xxl-8">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title text-gradient">Recent Transactions</h6>
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
                            <h6 class="title text-gradient">Recent Activities</h6>
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
<!-- Highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/themes/dark-unica.js"></script>

<script>
    // Initialize Charts when document is ready
    $(document).ready(function() {
        
        // Set Highcharts global options
        Highcharts.setOptions({
            colors: ['#6576ff', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#f97316', '#84cc16'],
            chart: {
                backgroundColor: 'transparent',
                style: {
                    fontFamily: 'Inter, sans-serif'
                }
            },
            title: {
                style: {
                    color: '#ffffff'
                }
            },
            legend: {
                itemStyle: {
                    color: '#ffffff'
                }
            },
            xAxis: {
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                },
                title: {
                    style: {
                        color: '#ffffff'
                    }
                }
            },
            yAxis: {
                labels: {
                    style: {
                        color: '#ffffff'
                    }
                },
                title: {
                    style: {
                        color: '#ffffff'
                    }
                }
            }
        });
        
        // Advanced Monthly Revenue Chart with Highcharts
        if ($('#monthlyRevenue').length) {
            Highcharts.chart('monthlyRevenue', {
                chart: {
                    type: 'area',
                    height: 300
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                yAxis: {
                    title: {
                        text: 'Revenue (IDR)'
                    },
                    labels: {
                        formatter: function() {
                            return 'Rp ' + (this.value / 1000000).toFixed(1) + 'M';
                        }
                    },
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + this.x + '</b>';
                        this.points.forEach(function(point) {
                            s += '<br/>' + point.series.name + ': Rp ' + 
                                 (point.y / 1000000).toFixed(1) + 'M';
                        });
                        return s;
                    }
                },
                plotOptions: {
                    area: {
                        fillOpacity: 0.5,
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 4,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Total Revenue',
                    data: [2200000000, 2350000000, 2180000000, 2450000000, 2600000000, 2750000000, 2680000000, 2800000000, 2920000000, 2850000000, 2780000000, 2847950000],
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, 'rgba(101, 118, 255, 0.8)'],
                            [1, 'rgba(101, 118, 255, 0.1)']
                        ]
                    },
                    color: '#6576ff'
                }, {
                    name: 'Target Revenue',
                    data: [2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000],
                    type: 'line',
                    color: '#22c55e',
                    dashStyle: 'dash'
                }],
                exporting: {
                    enabled: true,
                    buttons: {
                        contextButton: {
                            menuItems: ['viewFullscreen', 'separator', 'downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG']
                        }
                    }
                }
            });
        }
        
        // Receivable Status Pie Chart with Highcharts
        if ($('#receivableStatus').length) {
            Highcharts.chart('receivableStatus', {
                chart: {
                    type: 'pie',
                    height: 350
                },
                title: {
                    text: null
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true,
                        innerSize: '50%'
                    }
                },
                series: [{
                    name: 'Status',
                    colorByPoint: true,
                    data: [{
                        name: 'Lunas',
                        y: 68.5,
                        color: '#22c55e',
                        sliced: true,
                        selected: true
                    }, {
                        name: 'Aktif',
                        y: 28.8,
                        color: '#f59e0b'
                    }, {
                        name: 'Tunggakan',
                        y: 2.7,
                        color: '#ef4444'
                    }]
                }]
            });
        }
        
        // Payment Trends Chart
        if ($('#paymentTrends').length) {
            Highcharts.chart('paymentTrends', {
                chart: {
                    type: 'area',
                    height: 280
                },
                title: {
                    text: null
                },
                xAxis: {
                    categories: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'],
                    gridLineWidth: 1,
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                yAxis: {
                    title: {
                        text: 'Pembayaran (IDR)'
                    },
                    labels: {
                        formatter: function() {
                            return 'Rp ' + (this.value / 1000000).toFixed(1) + 'M';
                        }
                    },
                    gridLineColor: 'rgba(255,255,255,0.1)'
                },
                tooltip: {
                    shared: true,
                    formatter: function() {
                        var s = '<b>' + this.x + '</b>';
                        this.points.forEach(function(point) {
                            s += '<br/>' + point.series.name + ': Rp ' + 
                                 (point.y / 1000000).toFixed(1) + 'M';
                        });
                        return s;
                    }
                },
                plotOptions: {
                    area: {
                        fillOpacity: 0.5,
                        marker: {
                            enabled: false,
                            symbol: 'circle',
                            radius: 4,
                            states: {
                                hover: {
                                    enabled: true
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Pembayaran',
                    data: [75000000, 82000000, 78000000, 85000000, 88000000, 91000000, 89240000],
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, 'rgba(34, 197, 94, 0.8)'],
                            [1, 'rgba(34, 197, 94, 0.1)']
                        ]
                    },
                    color: '#22c55e'
                }]
            });
        }
        
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
