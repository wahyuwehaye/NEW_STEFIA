@extends('layouts.admin')

@section('title', 'Manajemen Mahasiswa')

@section('content')
<div class="nk-content-inner">
    <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title">Manajemen Mahasiswa</h3>
                    <div class="nk-block-des text-soft">
                        <p>Kelola data mahasiswa dan informasi akademik mereka</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <div class="toggle-wrap nk-block-tools-toggle">
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                        <div class="toggle-expand-content" data-content="pageMenu">
                            <ul class="nk-block-tools g-3">
                                <li><a href="{{ route('students.import-form') }}" class="btn btn-white btn-outline-light"><em class="icon ni ni-upload"></em><span>Import</span></a></li>
                                <li><a href="#" class="btn btn-white btn-outline-light" id="export-btn"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                <li class="nk-block-tools-opt"><a href="{{ route('students.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Tambah Mahasiswa</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Statistics -->
        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="title">Total Mahasiswa</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-users text-primary"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount" id="total-students">{{ $stats['total_students'] ?? 0 }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>12.5%</span>
                                <span class="card-hint-text">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="title">Mahasiswa Aktif</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-check-circle text-success"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount" id="active-students">{{ $stats['active_students'] ?? 0 }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>8.3%</span>
                                <span class="card-hint-text">dari bulan lalu</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="title">Mahasiswa Baru</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-user-add text-info"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount" id="new-students">{{ $stats['new_students'] ?? 0 }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>25.1%</span>
                                <span class="card-hint-text">bulan ini</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <div class="card-title-group align-start mb-2">
                                <div class="card-title">
                                    <h6 class="title">Lulusan</h6>
                                </div>
                                <div class="card-tools">
                                    <em class="card-hint-icon icon ni ni-graduation text-warning"></em>
                                </div>
                            </div>
                            <div class="card-amount">
                                <span class="amount" id="graduated-students">{{ $stats['graduated_students'] ?? 0 }}</span>
                            </div>
                            <div class="card-mehr">
                                <span class="change up text-success"><em class="icon ni ni-arrow-long-up"></em>15.7%</span>
                                <span class="card-hint-text">tahun ini</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Table -->
        <div class="nk-block nk-block-lg">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title">Daftar Mahasiswa</h6>
                        </div>
                        <div class="card-tools">
                            <div class="form-inline flex-nowrap gx-3">
                                <div class="form-wrap w-150px">
                                    <select class="form-select" id="status-filter" data-placeholder="Filter Status">
                                        <option value="">Semua Status</option>
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                        <option value="graduated">Lulus</option>
                                        <option value="dropped_out">Drop Out</option>
                                    </select>
                                </div>
                                <div class="form-wrap w-150px">
                                    <select class="form-select" id="faculty-filter" data-placeholder="Filter Fakultas">
                                        <option value="">Semua Fakultas</option>
                                        <option value="Fakultas Teknik">Fakultas Teknik</option>
                                        <option value="Fakultas Ekonomi">Fakultas Ekonomi</option>
                                        <option value="Fakultas Ilmu Komputer">Fakultas Ilmu Komputer</option>
                                        <option value="Fakultas Sains">Fakultas Sains</option>
                                        <option value="Fakultas Komunikasi">Fakultas Komunikasi</option>
                                        <option value="Fakultas Hukum">Fakultas Hukum</option>
                                    </select>
                                </div>
                                <div class="form-wrap w-150px">
                                    <select class="form-select" id="cohort-filter" data-placeholder="Filter Angkatan">
                                        <option value="">Semua Angkatan</option>
                                        @for($year = 2020; $year <= date('Y'); $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="btn-wrap">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-outline-light btn-icon dropdown-toggle" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="{{ route('students.create') }}"><em class="icon ni ni-user-add"></em><span>Tambah Mahasiswa</span></a></li>
                                                <li><a href="{{ route('students.import-form') }}"><em class="icon ni ni-upload"></em><span>Import Data</span></a></li>
                                                <li><a href="#" id="export-excel"><em class="icon ni ni-file-xls"></em><span>Export Excel</span></a></li>
                                                <li><a href="#" id="export-pdf"><em class="icon ni ni-file-pdf"></em><span>Export PDF</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0">
                        <div class="table-responsive">
                            <table class="table table-hover" id="students-table">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50px">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="select-all">
                                                <label class="custom-control-label" for="select-all"></label>
                                            </div>
                                        </th>
                                        <th>Mahasiswa</th>
                                        <th>Fakultas</th>
                                        <th>Program Studi</th>
                                        <th>Angkatan</th>
                                        <th>Status</th>
                                        <th class="tb-col-md">Jenis Kelamin</th>
                                        <th class="tb-col-md">Kelas</th>
                                        <th class="tb-col-lg">Tempat Lahir</th>
                                        <th class="tb-col-lg">Telepon</th>
                                        <th class="tb-col-lg">Email</th>
                                        <th class="tb-col-lg">Terdaftar</th>
                                        <th width="100px" class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.user-card {
    display: flex;
    align-items: center;
    padding: 0.5rem 0;
}

.user-avatar {
    flex-shrink: 0;
    margin-right: 12px;
}

.avatar-initial {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 14px;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.user-info {
    flex: 1;
    min-width: 0;
}

.lead-text {
    font-weight: 600;
    color: #364a63;
    margin-bottom: 2px;
    font-size: 0.875rem;
}

.sub-text {
    color: #8094ae;
    font-size: 0.75rem;
}

.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

.dataTables_wrapper .dataTables_processing {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px;
    padding: 8px 16px;
    border: 1px solid #e3e7fe;
    background: #f8f9ff;
}

.dataTables_wrapper .dataTables_length select {
    border-radius: 6px;
    padding: 6px 12px;
    border: 1px solid #e3e7fe;
    background: #f8f9ff;
}

.btn-group .btn {
    margin-right: 4px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25em 0.6em;
    border-radius: 12px;
    font-weight: 500;
}

.badge-success {
    background: #e7f9e7;
    color: #10b981;
    border: 1px solid #b8f2b8;
}

.badge-warning {
    background: #fff3cd;
    color: #f59e0b;
    border: 1px solid #fde68a;
}

.badge-info {
    background: #e0f2fe;
    color: #0284c7;
    border: 1px solid #b3e5fc;
}

.badge-danger {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.badge-outline-primary {
    background: #f0f4ff;
    color: #4338ca;
    border: 1px solid #c7d2fe;
}

.text-soft {
    color: #8094ae;
}

.card-stretch {
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.05);
    border-radius: 12px;
    border: 1px solid #e3e7fe;
}

.nk-tb-list {
    background: white;
}

.nk-tb-item {
    border-bottom: 1px solid #f1f3f4;
    transition: all 0.3s ease;
}

.nk-tb-item:hover {
    background: #f8f9ff;
}

.nk-tb-head {
    background: #f8f9ff;
    border-bottom: 2px solid #e3e7fe;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.spinner-border {
    width: 2rem;
    height: 2rem;
    border-width: 0.25em;
}

@media (max-width: 768px) {
    .tb-col-mb {
        display: none;
    }
}

@media (max-width: 992px) {
    .tb-col-lg {
        display: none;
    }
}

@media (max-width: 1200px) {
    .tb-col-md {
        display: none;
    }
}

/* Modern SweetAlert2 Styling */
.modern-swal-popup {
    border-radius: 15px !important;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15) !important;
    border: none !important;
    font-family: 'Inter', sans-serif !important;
}

.modern-swal-confirm {
    background: linear-gradient(135deg, #dc2626, #ef4444) !important;
    color: white !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3) !important;
    transition: all 0.3s ease !important;
    margin-left: 8px !important;
}

.modern-swal-confirm:hover {
    background: linear-gradient(135deg, #b91c1c, #dc2626) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4) !important;
}

.modern-swal-cancel {
    background: linear-gradient(135deg, #3b82f6, #60a5fa) !important;
    color: white !important;
    border: none !important;
    border-radius: 8px !important;
    padding: 12px 24px !important;
    font-weight: 600 !important;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3) !important;
    transition: all 0.3s ease !important;
    margin-right: 8px !important;
}

.modern-swal-cancel:hover {
    background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4) !important;
}

.swal2-icon {
    border: none !important;
    border-radius: 50% !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

.swal2-icon.swal2-warning {
    background: linear-gradient(135deg, #f59e0b, #fbbf24) !important;
    color: white !important;
}

.swal2-icon.swal2-success {
    background: linear-gradient(135deg, #10b981, #34d399) !important;
    color: white !important;
}

.swal2-icon.swal2-error {
    background: linear-gradient(135deg, #ef4444, #f87171) !important;
    color: white !important;
}

.swal2-title {
    font-weight: 700 !important;
    color: #1f2937 !important;
    font-size: 1.5rem !important;
    margin-bottom: 0.5rem !important;
}

.swal2-html-container {
    color: #6b7280 !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    margin-bottom: 1rem !important;
}

.swal2-actions {
    gap: 0.5rem !important;
    margin-top: 1.5rem !important;
}

.swal2-loading {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px) !important;
}

/* Fix table header alignment */
#students-table th {
    vertical-align: middle !important;
    text-align: center !important;
}

#students-table th:first-child,
#students-table th:last-child {
    text-align: center !important;
}

#students-table td {
    vertical-align: middle !important;
}

/* DataTable fixed columns */
.dataTables_wrapper .dataTables_scrollHead table {
    margin-bottom: 0 !important;
}

.dataTables_wrapper .dataTables_scrollBody table {
    border-top: none !important;
}

/* Responsive table fixes */
@media (max-width: 1200px) {
    .tb-col-md {
        display: none !important;
    }
}

@media (max-width: 992px) {
    .tb-col-lg {
        display: none !important;
    }
}

.badge-outline-secondary {
    background: #f8f9fa;
    color: #6c757d;
    border: 1px solid #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    let studentsTable;
    
    // Initialize DataTable
    function initDataTable() {
        if (studentsTable) {
            studentsTable.destroy();
        }
        
        studentsTable = $('#students-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            autoWidth: false,
            pageLength: 25,
            ajax: {
                url: '{{ route('students.index') }}',
                type: 'GET',
                data: function(d) {
                    d.status = $('#status-filter').val();
                    d.faculty = $('#faculty-filter').val();
                    d.cohort_year = $('#cohort-filter').val();
                }
            },
            columns: [
                {
                    data: null,
                    defaultContent: '',
                    className: 'select-checkbox',
                    orderable: false,
                    searchable: false,
                    width: '50px',
                    render: function(data, type, row) {
                        return `<div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" class="custom-control-input" id="pid-${row.id}">
                                    <label class="custom-control-label" for="pid-${row.id}"></label>
                                </div>`;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    title: 'Mahasiswa',
                    render: function(data, type, row) {
                        const initial = data ? data.charAt(0).toUpperCase() : 'N';
                        return `<div class="user-card">
                                    <div class="user-avatar">
                                        <div class="avatar-initial">${initial}</div>
                                    </div>
                                    <div class="user-info">
                                        <div class="lead-text">${data || 'N/A'}</div>
                                        <div class="sub-text">${row.nim || 'N/A'}</div>
                                    </div>
                                </div>`;
                    }
                },
                {
                    data: 'faculty',
                    name: 'faculty',
                    title: 'Fakultas',
                    render: function(data, type, row) {
                        return `<span class="text-soft">${data || 'N/A'}</span>`;
                    }
                },
                {
                    data: 'department',
                    name: 'department',
                    title: 'Program Studi',
                    render: function(data, type, row) {
                        return `<span class="text-soft">${data || 'N/A'}</span>`;
                    }
                },
                {
                    data: 'cohort_year',
                    name: 'cohort_year',
                    title: 'Angkatan',
                    render: function(data, type, row) {
                        return `<span class="badge badge-outline-primary">${data || 'N/A'}</span>`;
                    }
                },
                {
                    data: 'status',
                    name: 'status',
                    title: 'Status',
                    render: function(data, type, row) {
                        const statusMap = {
                            'active': { class: 'badge-success', text: 'Aktif' },
                            'inactive': { class: 'badge-warning', text: 'Tidak Aktif' },
                            'graduated': { class: 'badge-info', text: 'Lulus' },
                            'dropped_out': { class: 'badge-danger', text: 'Drop Out' }
                        };
                        const statusInfo = statusMap[data] || { class: 'badge-secondary', text: 'Unknown' };
                        return `<span class="badge ${statusInfo.class}">${statusInfo.text}</span>`;
                    }
                },
                {
                    data: 'gender',
                    name: 'gender',
                    title: 'Jenis Kelamin',
                    responsivePriority: 3,
                    render: function(data, type, row) {
                        if (data === 'L') return '<span class="badge badge-info">Laki-laki</span>';
                        if (data === 'P') return '<span class="badge badge-warning">Perempuan</span>';
                        return '<span class="text-soft">-</span>';
                    }
                },
                {
                    data: 'class',
                    name: 'class',
                    title: 'Kelas',
                    responsivePriority: 4,
                    render: function(data, type, row) {
                        return data ? `<span class="badge badge-outline-secondary">${data}</span>` : '<span class="text-soft">-</span>';
                    }
                },
                {
                    data: 'birth_place',
                    name: 'birth_place',
                    title: 'Tempat Lahir',
                    responsivePriority: 5,
                    render: function(data, type, row) {
                        return data ? `<span class="text-soft">${data}</span>` : '<span class="text-soft">-</span>';
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',
                    title: 'Telepon',
                    responsivePriority: 6,
                    render: function(data, type, row) {
                        return data ? `<a href="tel:${data}" class="text-primary">${data}</a>` : '<span class="text-soft">-</span>';
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    title: 'Email',
                    responsivePriority: 7,
                    render: function(data, type, row) {
                        return data ? `<a href="mailto:${data}" class="text-primary">${data}</a>` : '<span class="text-soft">-</span>';
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    title: 'Terdaftar',
                    responsivePriority: 8,
                    render: function(data, type, row) {
                        if (!data) return '-';
                        const date = new Date(data);
                        return `<span class="text-soft">${date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'short',
                            year: 'numeric'
                        })}</span>`;
                    }
                },
                {
                    data: 'id',
                    name: 'action',
                    title: 'Aksi',
                    orderable: false,
                    searchable: false,
                    width: '100px',
                    className: 'text-end',
                    render: function(data, type, row) {
                        return `<div class="dropdown">
                                    <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-bs-toggle="dropdown">
                                        <em class="icon ni ni-more-h"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="/students/${data}"><em class="icon ni ni-eye"></em><span>View</span></a></li>
                                            <li><a href="/students/${data}/edit"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                            <li><a href="#" onclick="deleteStudent(${data})"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                        </ul>
                                    </div>
                                </div>`;
                    }
                }
            ],
            order: [[1, 'asc']],
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                processing: '<div class="d-flex justify-content-center align-items-center" style="height: 200px;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>',
                search: 'Cari:',
                searchPlaceholder: 'Cari mahasiswa...',
                lengthMenu: 'Tampilkan _MENU_ data per halaman',
                info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                infoFiltered: '(difilter dari _MAX_ total data)',
                paginate: {
                    first: 'Pertama',
                    last: 'Terakhir',
                    next: 'Selanjutnya',
                    previous: 'Sebelumnya',
                },
                emptyTable: 'Tidak ada data mahasiswa yang tersedia',
                zeroRecords: 'Tidak ada data yang sesuai dengan pencarian'
            },
            columnDefs: [
                {
                    targets: [6, 7, 8, 9, 10, 11],
                    responsivePriority: 3,
                    className: 'tb-col-md tb-col-lg'
                },
                {
                    targets: [0, 1, 2, 3, 4, 5, 12],
                    responsivePriority: 1
                }
            ]
        });
    }
    $('#status-filter, #faculty-filter, #cohort-filter').on('change', function() {
        if (studentsTable) {
            studentsTable.ajax.reload();
        }
    });
    
    // Select all checkbox
    $('#select-all').on('change', function() {
        const isChecked = $(this).prop('checked');
        $('.custom-control-input[id^="pid-"]').prop('checked', isChecked);
    });
    
    // Export handlers
    $('#export-excel, #export-btn').on('click', function(e) {
        e.preventDefault();
        const params = new URLSearchParams({
            format: 'excel',
            status: $('#status-filter').val() || '',
            faculty: $('#faculty-filter').val() || '',
            cohort_year: $('#cohort-filter').val() || ''
        });
        window.open(`{{ route('students.export') }}?${params.toString()}`, '_blank');
    });
    
    $('#export-pdf').on('click', function(e) {
        e.preventDefault();
        const params = new URLSearchParams({
            format: 'pdf',
            status: $('#status-filter').val() || '',
            faculty: $('#faculty-filter').val() || '',
            cohort_year: $('#cohort-filter').val() || ''
        });
        window.open(`{{ route('students.export') }}?${params.toString()}`, '_blank');
    });
    
    // Delete student function with modern SweetAlert2
    window.deleteStudent = function(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data mahasiswa ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times"></i> Batal',
            reverseButtons: true,
            customClass: {
                popup: 'modern-swal-popup',
                confirmButton: 'modern-swal-confirm',
                cancelButton: 'modern-swal-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus Data...',
                    text: 'Mohon tunggu sebentar',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                $.ajax({
                    url: `/students/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            studentsTable.ajax.reload();
                            showSuccessToast(response.message || 'Data mahasiswa berhasil dihapus!');
                            
                            // Show success animation
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message || 'Data mahasiswa berhasil dihapus',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'modern-swal-popup'
                                }
                            });
                        } else {
                            showErrorToast(response.message || 'Terjadi kesalahan saat menghapus data');
                            
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message || 'Terjadi kesalahan saat menghapus data',
                                icon: 'error',
                                customClass: {
                                    popup: 'modern-swal-popup'
                                }
                            });
                        }
                    },
                    error: function() {
                        showErrorToast('Terjadi kesalahan saat menghapus data');
                        
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data',
                            icon: 'error',
                            customClass: {
                                popup: 'modern-swal-popup'
                            }
                        });
                    }
                });
            }
        });
    };
    
    // Initialize DataTable
    initDataTable();
});
</script>
@endpush
