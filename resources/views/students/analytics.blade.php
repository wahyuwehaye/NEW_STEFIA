@extends('layouts.admin')

@section('title', 'Analytics Mahasiswa')

@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Analytics Mahasiswa</h3>
                    <div class="nk-block-des text-soft">
                        <p>Dashboard analytics dan statistik mahasiswa lengkap</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a href="{{ route('students.index') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-list"></em><span>Daftar Mahasiswa</span></a></li>
                                <li><a href="{{ route('students.export') }}?format=excel" class="btn btn-white btn-outline-light"><em class="icon ni ni-download"></em><span>Export Data</span></a></li>
                                <li class="nk-block-tools-opt"><a href="{{ route('students.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Mahasiswa</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-0">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Mahasiswa</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-users text-primary"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($analytics['total_students']) }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>{{ $analytics['recent_registrations'] }}</span>
                                <span class="card-hint-text">registrasi baru (30 hari)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-0">
                                <div class="card-title">
                                    <h6 class="subtitle">Mahasiswa Aktif</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-check-circle text-success"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($analytics['active_students']) }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>{{ round(($analytics['active_students']/$analytics['total_students'])*100, 1) }}%</span>
                                <span class="card-hint-text">dari total mahasiswa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-0">
                                <div class="card-title">
                                    <h6 class="subtitle">Mahasiswa dengan Tunggakan</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-alert-circle text-warning"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">{{ number_format($analytics['students_with_debt']) }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>{{ $analytics['students_with_debt'] > 0 ? round(($analytics['students_with_debt']/$analytics['total_students'])*100, 1) : 0 }}%</span>
                                <span class="card-hint-text">dari total mahasiswa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-0">
                                <div class="card-title">
                                    <h6 class="subtitle">Total Tunggakan</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-coins text-danger"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount">Rp {{ number_format($analytics['total_outstanding'], 0, ',', '.') }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>-5.4%</span>
                                <span class="card-hint-text">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-8">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Distribusi Mahasiswa per Fakultas</h6>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" id="faculty-chart-refresh"><em class="icon ni ni-reload"></em><span>Refresh</span></a></li>
                                                <li><a href="#" id="faculty-chart-export"><em class="icon ni ni-download"></em><span>Export</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div id="faculty-chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Status Mahasiswa</h6>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div id="status-chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Analytics -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-6">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Mahasiswa per Angkatan</h6>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" id="cohort-chart-refresh"><em class="icon ni ni-reload"></em><span>Refresh</span></a></li>
                                                <li><a href="#" id="cohort-chart-export"><em class="icon ni ni-download"></em><span>Export</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div id="cohort-chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title">Trend Registrasi Bulanan</h6>
                                </div>
                                <div class="card-tools">
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" id="trend-chart-refresh"><em class="icon ni ni-reload"></em><span>Refresh</span></a></li>
                                                <li><a href="#" id="trend-chart-export"><em class="icon ni ni-download"></em><span>Export</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div id="trend-chart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Tables -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-6">
                    <div class="card card-bordered card-full">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Detail per Fakultas</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('students.export') }}?format=excel&group=faculty" class="btn btn-primary btn-sm"><em class="icon ni ni-download"></em><span>Export</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div class="nk-tb-list">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span>Fakultas</span></div>
                                        <div class="nk-tb-col text-end"><span>Jumlah</span></div>
                                        <div class="nk-tb-col text-end"><span>Persentase</span></div>
                                    </div>
                                    @foreach($analytics['students_by_faculty'] as $item)
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-name">
                                                    <span class="tb-lead">{{ $item->faculty ?: 'Tidak Diketahui' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col text-end">
                                            <span class="tb-amount">{{ number_format($item->count) }}</span>
                                        </div>
                                        <div class="nk-tb-col text-end">
                                            <span class="tb-amount">{{ round(($item->count/$analytics['total_students'])*100, 1) }}%</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6">
                    <div class="card card-bordered card-full">
                        <div class="card-inner-group">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Detail per Angkatan</h6>
                                    </div>
                                    <div class="card-tools">
                                        <a href="{{ route('students.export') }}?format=excel&group=cohort" class="btn btn-primary btn-sm"><em class="icon ni ni-download"></em><span>Export</span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner p-0">
                                <div class="nk-tb-list">
                                    <div class="nk-tb-item nk-tb-head">
                                        <div class="nk-tb-col"><span>Angkatan</span></div>
                                        <div class="nk-tb-col text-end"><span>Jumlah</span></div>
                                        <div class="nk-tb-col text-end"><span>Persentase</span></div>
                                    </div>
                                    @foreach($analytics['students_by_cohort'] as $item)
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-name">
                                                    <span class="tb-lead">{{ $item->cohort_year ?: 'Tidak Diketahui' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col text-end">
                                            <span class="tb-amount">{{ number_format($item->count) }}</span>
                                        </div>
                                        <div class="nk-tb-col text-end">
                                            <span class="tb-amount">{{ round(($item->count/$analytics['total_students'])*100, 1) }}%</span>
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
@endsection

@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
$(document).ready(function() {
    // Faculty Distribution Chart
    const facultyData = @json($analytics['students_by_faculty']->map(function($item) {
        return [
            $item->faculty ?: 'Tidak Diketahui',
            (int) $item->count
        ];
    }));
    
    Highcharts.chart('faculty-chart', {
        chart: {
            type: 'column',
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'inherit'
            }
        },
        title: {
            text: ''
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'inherit'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Mahasiswa'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.y}</b> mahasiswa'
        },
        series: [{
            name: 'Mahasiswa',
            data: facultyData,
            colorByPoint: true,
            colors: ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#00f2fe']
        }],
        exporting: {
            enabled: true,
            buttons: {
                contextButton: {
                    menuItems: [
                        'viewFullscreen',
                        'printChart',
                        'separator',
                        'downloadPNG',
                        'downloadJPEG',
                        'downloadPDF',
                        'downloadSVG',
                        'separator',
                        'downloadCSV',
                        'downloadXLS'
                    ]
                }
            }
        }
    });
    
    // Status Distribution Chart
    const statusData = [
        ['Aktif', {{ $analytics['active_students'] }}],
        ['Tidak Aktif', {{ $analytics['inactive_students'] }}],
        ['Lulus', {{ $analytics['graduated_students'] }}],
        ['Drop Out', {{ $analytics['dropped_out_students'] }}]
    ];
    
    Highcharts.chart('status-chart', {
        chart: {
            type: 'pie',
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'inherit'
            }
        },
        title: {
            text: ''
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b> ({point.y} mahasiswa)'
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
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f}%'
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Status',
            data: statusData,
            colors: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444']
        }]
    });
    
    // Cohort Distribution Chart
    const cohortData = @json($analytics['students_by_cohort']->map(function($item) {
        return [
            $item->cohort_year ? $item->cohort_year . '' : 'Tidak Diketahui',
            (int) $item->count
        ];
    }));
    
    Highcharts.chart('cohort-chart', {
        chart: {
            type: 'bar',
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'inherit'
            }
        },
        title: {
            text: ''
        },
        xAxis: {
            type: 'category',
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Mahasiswa',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ' mahasiswa'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Mahasiswa',
            data: cohortData,
            color: '#667eea'
        }]
    });
    
    // Trend Chart (Monthly Registration)
    const monthlyData = [
        ['Jan', 45], ['Feb', 52], ['Mar', 48], ['Apr', 61], ['May', 55], ['Jun', 67],
        ['Jul', 71], ['Aug', 89], ['Sep', 95], ['Oct', 87], ['Nov', 73], ['Dec', 62]
    ];
    
    Highcharts.chart('trend-chart', {
        chart: {
            type: 'spline',
            backgroundColor: 'transparent',
            style: {
                fontFamily: 'inherit'
            }
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: monthlyData.map(item => item[0])
        },
        yAxis: {
            title: {
                text: 'Jumlah Registrasi'
            }
        },
        tooltip: {
            valueSuffix: ' mahasiswa'
        },
        plotOptions: {
            spline: {
                lineWidth: 3,
                states: {
                    hover: {
                        lineWidth: 4
                    }
                },
                marker: {
                    enabled: false
                }
            }
        },
        series: [{
            name: 'Registrasi',
            data: monthlyData.map(item => item[1]),
            color: '#667eea'
        }],
        navigation: {
            menuItemStyle: {
                fontSize: '10px'
            }
        }
    });
    
    // Chart refresh handlers
    $('#faculty-chart-refresh').on('click', function(e) {
        e.preventDefault();
        location.reload();
    });
    
    $('#cohort-chart-refresh').on('click', function(e) {
        e.preventDefault();
        location.reload();
    });
    
    $('#trend-chart-refresh').on('click', function(e) {
        e.preventDefault();
        location.reload();
    });
    
    // Chart export handlers
    $('#faculty-chart-export').on('click', function(e) {
        e.preventDefault();
        const chart = Highcharts.charts[0];
        if (chart) {
            chart.exportChart({
                type: 'image/png',
                filename: 'faculty-distribution'
            });
        }
    });
    
    $('#cohort-chart-export').on('click', function(e) {
        e.preventDefault();
        const chart = Highcharts.charts[2];
        if (chart) {
            chart.exportChart({
                type: 'image/png',
                filename: 'cohort-distribution'
            });
        }
    });
    
    $('#trend-chart-export').on('click', function(e) {
        e.preventDefault();
        const chart = Highcharts.charts[3];
        if (chart) {
            chart.exportChart({
                type: 'image/png',
                filename: 'registration-trend'
            });
        }
    });
    
    // Add animations on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });
    
    // Observe all cards
    document.querySelectorAll('.card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Counter animation for stats
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 20);
    }
    
    // Animate counters when cards come into view
    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const amountElement = entry.target.querySelector('.amount');
                if (amountElement && !amountElement.classList.contains('animated')) {
                    amountElement.classList.add('animated');
                    const text = amountElement.textContent.replace(/[^0-9]/g, '');
                    const target = parseInt(text);
                    if (!isNaN(target)) {
                        animateCounter(amountElement, target);
                    }
                }
            }
        });
    });
    
    document.querySelectorAll('.card-inner').forEach(card => {
        statsObserver.observe(card);
    });
});
</script>
@endpush
