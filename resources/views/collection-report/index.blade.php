@extends('layouts.admin')

@section('title', 'Laporan Penagihan Piutang')

@section('content')
<div class="nk-block-head nk-block-head-sm">
    <div class="nk-block-between">
        <div class="nk-block-head-content">
            <h3 class="nk-block-title page-title">Laporan Penagihan Piutang</h3>
            <div class="nk-block-des text-soft">
                <p>Daftar mahasiswa dengan tunggakan diatas 10 juta rupiah dan tindakan penagihan yang telah dilakukan.</p>
            </div>
        </div>
        <div class="nk-block-head-content">
            <div class="toggle-wrap nk-block-tools-toggle">
                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                <div class="toggle-expand-content" data-content="pageMenu">
                    <ul class="nk-block-tools g-3">
                        <li>
                            <a href="#" class="btn btn-primary" id="exportBtn">
                                <em class="icon ni ni-download"></em>
                                <span>Export Excel</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-icon btn-primary" id="refreshBtn">
                                <em class="icon ni ni-reload"></em>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Fakultas</label>
                        <select class="form-select" id="filterFakultas">
                            <option value="">Semua Fakultas</option>
                            <option value="Teknik">Fakultas Teknik</option>
                            <option value="Ekonomi">Fakultas Ekonomi</option>
                            <option value="Hukum">Fakultas Hukum</option>
                            <option value="Sastra">Fakultas Sastra</option>
                            <option value="MIPA">Fakultas MIPA</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" id="filterJurusan">
                            <option value="">Semua Jurusan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Rentang Tunggakan</label>
                        <select class="form-select" id="filterTunggakan">
                            <option value="">Semua Rentang</option>
                            <option value="10-20">10 - 20 Juta</option>
                            <option value="20-30">20 - 30 Juta</option>
                            <option value="30-50">30 - 50 Juta</option>
                            <option value="50+">Diatas 50 Juta</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label">Status Mahasiswa</label>
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="cuti">Cuti</option>
                            <option value="non-aktif">Non-Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner-group">
            <div class="card-inner position-relative card-tools-toggle">
                <div class="card-title-group">
                    <div class="card-tools">
                        <div class="form-inline flex-nowrap gx-3">
                            <div class="form-wrap w-150px">
                                <select class="form-select" id="perPage">
                                    <option value="25">25 per halaman</option>
                                    <option value="50">50 per halaman</option>
                                    <option value="100">100 per halaman</option>
                                </select>
                            </div>
                            <div class="btn-wrap">
                                <span class="d-none d-md-block">
                                    <button class="btn btn-dim btn-outline-light" id="bulkActionBtn">
                                        <em class="icon ni ni-check-box"></em>
                                        <span>Tindakan Massal</span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-inner p-0">
                <div class="nk-tb-list nk-tb-ulist">
                    <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="selectAll">
                                <label class="custom-control-label" for="selectAll"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col"><span class="sub-text">NIM</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Mahasiswa</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Jurusan</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Fakultas</span></div>
                        <div class="nk-tb-col"><span class="sub-text">TA Saat Ini</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Semester Tunggak</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Jumlah Tunggakan</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Tindakan</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">
                            <span class="sub-text">Aksi</span>
                        </div>
                    </div>
                    
                    <!-- Sample Data Rows -->
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="student1">
                                <label class="custom-control-label" for="student1"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-lead">191011400001</span>
                        </div>
                        <div class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">Ahmad Budi Santoso</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">Teknik Informatika</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">Fakultas Teknik</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">2023/2024</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="badge badge-warning">4 Semester</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="text-danger fw-bold">Rp 15.500.000</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="badge badge-success">Aktif</span>
                        </div>
                        <div class="nk-tb-col">
                            <div class="actions-summary">
                                <span class="badge badge-primary me-1" title="NDE Fakultas">NDE</span>
                                <span class="badge badge-info me-1" title="Bekerjasama dengan Dosen Wali">DW</span>
                                <span class="badge badge-warning me-1" title="Surat kepada Orangtua">SO</span>
                                <span class="badge badge-secondary me-1" title="Kontak Telepon">TEL</span>
                            </div>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="action-btn" data-action="nde" data-student="191011400001">
                                                    <em class="icon ni ni-file-text"></em><span>NDE Fakultas</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="dosen_wali" data-student="191011400001">
                                                    <em class="icon ni ni-user-circle"></em><span>Kerjasama Dosen Wali</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="surat_ortu" data-student="191011400001">
                                                    <em class="icon ni ni-mail"></em><span>Surat ke Orangtua</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="kontak_telp" data-student="191011400001">
                                                    <em class="icon ni ni-call"></em><span>Kontak Telepon</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="home_visit" data-student="191011400001">
                                                    <em class="icon ni ni-home"></em><span>Home Visit</span>
                                                </a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" class="view-actions" data-student="191011400001">
                                                    <em class="icon ni ni-eye"></em><span>Lihat Semua Tindakan</span>
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Additional Sample Rows -->
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="student2">
                                <label class="custom-control-label" for="student2"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-lead">191011400002</span>
                        </div>
                        <div class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">Siti Nurhaliza</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">Sistem Informasi</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">Fakultas Teknik</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">2023/2024</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="badge badge-danger">6 Semester</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="text-danger fw-bold">Rp 28.750.000</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="badge badge-warning">Cuti</span>
                        </div>
                        <div class="nk-tb-col">
                            <div class="actions-summary">
                                <span class="badge badge-primary me-1" title="NDE Fakultas">NDE</span>
                                <span class="badge badge-warning me-1" title="Surat kepada Orangtua">SO</span>
                                <span class="badge badge-secondary me-1" title="Kontak Telepon">TEL</span>
                                <span class="badge badge-dark me-1" title="Home Visit">HV</span>
                            </div>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="action-btn" data-action="nde" data-student="191011400002">
                                                    <em class="icon ni ni-file-text"></em><span>NDE Fakultas</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="dosen_wali" data-student="191011400002">
                                                    <em class="icon ni ni-user-circle"></em><span>Kerjasama Dosen Wali</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="surat_ortu" data-student="191011400002">
                                                    <em class="icon ni ni-mail"></em><span>Surat ke Orangtua</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="kontak_telp" data-student="191011400002">
                                                    <em class="icon ni ni-call"></em><span>Kontak Telepon</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="home_visit" data-student="191011400002">
                                                    <em class="icon ni ni-home"></em><span>Home Visit</span>
                                                </a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" class="view-actions" data-student="191011400002">
                                                    <em class="icon ni ni-eye"></em><span>Lihat Semua Tindakan</span>
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="student3">
                                <label class="custom-control-label" for="student3"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-lead">191011400003</span>
                        </div>
                        <div class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-info">
                                    <span class="tb-lead">Dedi Wijaya</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">Teknik Elektro</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">Fakultas Teknik</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-sub">2023/2024</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="badge badge-danger">8 Semester</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="text-danger fw-bold">Rp 45.200.000</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="badge badge-danger">Non-Aktif</span>
                        </div>
                        <div class="nk-tb-col">
                            <div class="actions-summary">
                                <span class="badge badge-primary me-1" title="NDE Fakultas">NDE</span>
                                <span class="badge badge-info me-1" title="Bekerjasama dengan Dosen Wali">DW</span>
                                <span class="badge badge-warning me-1" title="Surat kepada Orangtua">SO</span>
                                <span class="badge badge-secondary me-1" title="Kontak Telepon">TEL</span>
                                <span class="badge badge-dark me-1" title="Home Visit">HV</span>
                            </div>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="#" class="action-btn" data-action="nde" data-student="191011400003">
                                                    <em class="icon ni ni-file-text"></em><span>NDE Fakultas</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="dosen_wali" data-student="191011400003">
                                                    <em class="icon ni ni-user-circle"></em><span>Kerjasama Dosen Wali</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="surat_ortu" data-student="191011400003">
                                                    <em class="icon ni ni-mail"></em><span>Surat ke Orangtua</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="kontak_telp" data-student="191011400003">
                                                    <em class="icon ni ni-call"></em><span>Kontak Telepon</span>
                                                </a></li>
                                                <li><a href="#" class="action-btn" data-action="home_visit" data-student="191011400003">
                                                    <em class="icon ni ni-home"></em><span>Home Visit</span>
                                                </a></li>
                                                <li class="divider"></li>
                                                <li><a href="#" class="view-actions" data-student="191011400003">
                                                    <em class="icon ni ni-eye"></em><span>Lihat Semua Tindakan</span>
                                                </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-inner">
                <div class="nk-block-between-md g-3">
                    <div class="g">
                        <ul class="pagination justify-content-center justify-content-md-start">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">Selanjutnya</a>
                            </li>
                        </ul>
                    </div>
                    <div class="g">
                        <div class="pagination-goto d-flex justify-content-center justify-content-md-end gx-3">
                            <div>Halaman</div>
                            <div>
                                <select class="form-select form-select-sm">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div>dari 3</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Tambah Tindakan Penagihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="actionForm">
                    <input type="hidden" id="studentId" name="student_id">
                    <input type="hidden" id="actionType" name="action_type">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tipe Tindakan</label>
                                <select class="form-select" id="actionSelect" name="action_type" required>
                                    <option value="">Pilih Tindakan</option>
                                    <option value="nde">NDE Fakultas</option>
                                    <option value="dosen_wali">Bekerjasama dengan Dosen Wali</option>
                                    <option value="surat_ortu">Mengirimkan Surat kepada Orangtua</option>
                                    <option value="kontak_telp">Melakukan Kontak via Telepon</option>
                                    <option value="home_visit">Home Visit</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Tindakan</label>
                                <input type="date" class="form-control" name="action_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Masukkan keterangan detail tindakan yang dilakukan..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Hasil Tindakan</label>
                        <select class="form-select" name="result" required>
                            <option value="">Pilih Hasil</option>
                            <option value="berhasil">Berhasil Dihubungi</option>
                            <option value="tidak_berhasil">Tidak Berhasil Dihubungi</option>
                            <option value="janji_bayar">Janji Akan Membayar</option>
                            <option value="tidak_sanggup">Tidak Sanggup Bayar</option>
                            <option value="dalam_proses">Dalam Proses</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tindak Lanjut</label>
                        <textarea class="form-control" name="follow_up" rows="2" placeholder="Rencana tindak lanjut..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveAction">Simpan Tindakan</button>
            </div>
        </div>
    </div>
</div>

<!-- View Actions Modal -->
<div class="modal fade" id="viewActionsModal" tabindex="-1" aria-labelledby="viewActionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewActionsModalLabel">Riwayat Tindakan Penagihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="timeline" id="actionsTimeline">
                    <!-- Timeline items will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Action button click handlers
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const student = this.dataset.student;
            
            document.getElementById('studentId').value = student;
            document.getElementById('actionType').value = action;
            document.getElementById('actionSelect').value = action;
            
            // Update modal title based on action
            const actionNames = {
                'nde': 'NDE Fakultas',
                'dosen_wali': 'Bekerjasama dengan Dosen Wali', 
                'surat_ortu': 'Mengirimkan Surat kepada Orangtua',
                'kontak_telp': 'Melakukan Kontak via Telepon',
                'home_visit': 'Home Visit'
            };
            
            document.getElementById('actionModalLabel').textContent = 'Tambah Tindakan: ' + actionNames[action];
            
            // Show modal
            new bootstrap.Modal(document.getElementById('actionModal')).show();
        });
    });
    
    // Save action handler
    document.getElementById('saveAction').addEventListener('click', function() {
        const form = document.getElementById('actionForm');
        const formData = new FormData(form);
        
        // Here you would typically send the data to the server
        console.log('Saving action:', Object.fromEntries(formData));
        
        // Close modal and show success message
        bootstrap.Modal.getInstance(document.getElementById('actionModal')).hide();
        
        // Show success notification
        NioApp.Toast('Tindakan berhasil disimpan!', 'success');
        
        // Refresh the page or update the UI
        location.reload();
    });
    
    // View actions handler
    document.querySelectorAll('.view-actions').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const student = this.dataset.student;
            
            // Load action history (this would typically come from server)
            loadActionHistory(student);
            
            new bootstrap.Modal(document.getElementById('viewActionsModal')).show();
        });
    });
    
    // Export handler
    document.getElementById('exportBtn').addEventListener('click', function(e) {
        e.preventDefault();
        // Export functionality
        window.location.href = '/collection-report/export';
    });
    
    // Filter handlers
    document.getElementById('filterFakultas').addEventListener('change', function() {
        // Update jurusan dropdown based on fakultas
        updateJurusanFilter(this.value);
    });
    
    function loadActionHistory(student) {
        // Sample action history data
        const timeline = document.getElementById('actionsTimeline');
        timeline.innerHTML = `
            <div class="timeline-item">
                <div class="timeline-status bg-primary"></div>
                <div class="timeline-content">
                    <h6 class="timeline-title">NDE Fakultas</h6>
                    <p class="timeline-des">Surat NDE telah dikirim ke fakultas untuk mahasiswa dengan NIM ${student}</p>
                    <div class="timeline-date">15 Januari 2024</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-status bg-info"></div>
                <div class="timeline-content">
                    <h6 class="timeline-title">Bekerjasama dengan Dosen Wali</h6>
                    <p class="timeline-des">Koordinasi dengan dosen wali untuk pendekatan personal kepada mahasiswa</p>
                    <div class="timeline-date">20 Januari 2024</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-status bg-warning"></div>
                <div class="timeline-content">
                    <h6 class="timeline-title">Surat kepada Orangtua</h6>
                    <p class="timeline-des">Surat pemberitahuan tunggakan telah dikirim ke alamat orangtua</p>
                    <div class="timeline-date">25 Januari 2024</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-status bg-secondary"></div>
                <div class="timeline-content">
                    <h6 class="timeline-title">Kontak Telepon</h6>
                    <p class="timeline-des">Melakukan kontak telepon langsung, berhasil dihubungi dan berjanji akan melakukan pembayaran</p>
                    <div class="timeline-date">30 Januari 2024</div>
                </div>
            </div>
        `;
    }
    
    function updateJurusanFilter(fakultas) {
        const jurusanSelect = document.getElementById('filterJurusan');
        jurusanSelect.innerHTML = '<option value="">Semua Jurusan</option>';
        
        const jurusanOptions = {
            'Teknik': ['Teknik Informatika', 'Sistem Informasi', 'Teknik Elektro', 'Teknik Mesin'],
            'Ekonomi': ['Akuntansi', 'Manajemen', 'Ekonomi Pembangunan'],
            'Hukum': ['Ilmu Hukum'],
            'Sastra': ['Sastra Indonesia', 'Sastra Inggris'],
            'MIPA': ['Matematika', 'Fisika', 'Kimia', 'Biologi']
        };
        
        if (jurusanOptions[fakultas]) {
            jurusanOptions[fakultas].forEach(jurusan => {
                const option = document.createElement('option');
                option.value = jurusan;
                option.textContent = jurusan;
                jurusanSelect.appendChild(option);
            });
        }
    }
});
</script>
@endpush
@endsection
