@extends('layouts.admin')
@section('title', 'Dashboard Beasiswa')
@section('content')
<x-page-header title="Dashboard Beasiswa" subtitle="Statistik, tren, dan daftar penerima beasiswa.">
</x-page-header>
<div class="nk-block">
    <!-- Statistik Beasiswa -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color:white;">
                <h3>{{ $totalScholarships ?? 8 }}</h3>
                <p>Beasiswa Aktif</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color:white;">
                <h3>{{ $totalRecipients ?? 120 }}</h3>
                <p>Total Penerima</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color:white;">
                <h3>{{ $totalApplications ?? 210 }}</h3>
                <p>Total Pengajuan</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:white;">
                <h3>Rp {{ number_format($totalFunds ?? 350000000,0,',','.') }}</h3>
                <p>Dana Tersalurkan</p>
            </div>
        </div>
    </div>
    <!-- Filter & Grafik -->
    <div class="filter-section mb-4 d-flex align-items-center">
        <input type="text" class="form-control me-2" id="searchScholarship" placeholder="Cari nama/NIM/jenis..." onkeyup="filterScholarship()" style="width:220px;">
        <select class="form-select me-2" id="filterJenis" onchange="filterScholarship()" style="width:auto;display:inline-block;">
            <option value="">Semua Jenis</option>
            <option value="Akademik">Akademik</option>
            <option value="Non-Akademik">Non-Akademik</option>
        </select>
        <select class="form-select me-2" id="filterStatus" onchange="filterScholarship()" style="width:auto;display:inline-block;">
            <option value="">Semua Status</option>
            <option value="diterima">Diterima</option>
            <option value="ditolak">Ditolak</option>
            <option value="diproses">Diproses</option>
        </select>
        <select class="form-select me-2" id="filterTahun" onchange="filterScholarship()" style="width:auto;display:inline-block;">
            <option value="">Semua Tahun</option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>
        <button class="btn btn-secondary" onclick="resetScholarshipFilter()">Reset</button>
    </div>
    <div class="card mb-4">
        <div class="card-inner">
            <h6 class="mb-3">Tren Pengajuan & Penerima Beasiswa</h6>
            <canvas id="scholarshipTrendChart" height="120"></canvas>
        </div>
    </div>
    <!-- Tabel Penerima Beasiswa -->
    <div class="card mb-4">
        <div class="card-inner">
            <h6 class="mb-3">Daftar Penerima Beasiswa</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Jenis</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $recipients = $recipients ?? [
                            ['name'=>'Ahmad Fauzi','nim'=>'2019001','jenis'=>'Akademik','periode'=>'2024/2025','status'=>'diterima'],
                            ['name'=>'Siti Nurhaliza','nim'=>'2020002','jenis'=>'Non-Akademik','periode'=>'2024/2025','status'=>'diterima'],
                            ['name'=>'Budi Santoso','nim'=>'2018003','jenis'=>'Akademik','periode'=>'2023/2024','status'=>'diterima'],
                        ];
                        @endphp
                        @foreach($recipients as $i => $r)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $r['name'] }}</td>
                            <td>{{ $r['nim'] }}</td>
                            <td>{{ $r['jenis'] }}</td>
                            <td>{{ $r['periode'] }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($r['status']) }}</span></td>
                            <td><button class="btn btn-sm btn-info" onclick="viewRecipientDetail('{{ $r['nim'] }}')">Detail</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Tabel Pengajuan Beasiswa -->
    <div class="card">
        <div class="card-inner">
            <h6 class="mb-3">Daftar Pengajuan Beasiswa</h6>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Jenis</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $applications = $applications ?? [
                            ['name'=>'Dewi Sartika','nim'=>'2021004','jenis'=>'Akademik','periode'=>'2024/2025','status'=>'diproses','tanggal'=>'2025-01-10'],
                            ['name'=>'Rizki Hidayat','nim'=>'2022005','jenis'=>'Non-Akademik','periode'=>'2024/2025','status'=>'ditolak','tanggal'=>'2025-01-09'],
                        ];
                        @endphp
                        @foreach($applications as $i => $a)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $a['name'] }}</td>
                            <td>{{ $a['nim'] }}</td>
                            <td>{{ $a['jenis'] }}</td>
                            <td>{{ $a['periode'] }}</td>
                            <td><span class="badge bg-{{ $a['status']=='diterima'?'success':($a['status']=='ditolak'?'danger':'warning') }}">{{ ucfirst($a['status']) }}</span></td>
                            <td>{{ $a['tanggal'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" onclick="viewApplicationDetail('{{ $a['nim'] }}')">Detail</button>
                                @if($a['status']=='diproses')
                                    <button class="btn btn-sm btn-success me-1" onclick="approveApplication('{{ $a['nim'] }}')">Approve</button>
                                    <button class="btn btn-sm btn-danger" onclick="rejectApplication('{{ $a['nim'] }}')">Reject</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
  <div class="toast align-items-center text-bg-success border-0 show fade-in" role="alert">
    <div class="d-flex">
      <div class="toast-body">{{ session('success') }}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif
@if(session('error'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
  <div class="toast align-items-center text-bg-danger border-0 show fade-in" role="alert">
    <div class="d-flex">
      <div class="toast-body">{{ session('error') }}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
@endif
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dummy data untuk grafik tren
const trendData = {
    labels: ['2021','2022','2023','2024','2025'],
    datasets: [
        { label: 'Pengajuan', data: [80, 120, 150, 180, 210], backgroundColor: 'rgba(54,162,235,0.5)', borderColor: 'rgba(54,162,235,1)', borderWidth: 2, type: 'line', fill: false },
        { label: 'Penerima', data: [30, 60, 90, 100, 120], backgroundColor: 'rgba(75,192,192,0.5)', borderColor: 'rgba(75,192,192,1)', borderWidth: 2, type: 'line', fill: false },
    ]
};
const ctx = document.getElementById('scholarshipTrendChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: trendData,
    options: {
        responsive: true,
        plugins: { legend: { display: true } },
        scales: { y: { beginAtZero: true } }
    }
});
function showToast(message, type) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 show fade-in`;
    toast.style = 'min-width:260px; margin-bottom:8px;';
    toast.innerHTML = `<div class='d-flex'><div class='toast-body'>${message}</div><button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button></div>`;
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = 9999;
        document.body.appendChild(container);
    }
    container.appendChild(toast);
    setTimeout(() => { toast.classList.remove('show'); toast.remove(); }, 3500);
}
function viewRecipientDetail(nim) {
    showToast('Detail penerima beasiswa NIM: ' + nim, 'info');
}
function viewApplicationDetail(nim) {
    showToast('Detail pengajuan beasiswa NIM: ' + nim, 'info');
}
function approveApplication(nim) {
    if(confirm('Approve pengajuan beasiswa NIM ' + nim + '?')) {
        showLoadingScholarship();
        setTimeout(() => {
            hideLoadingScholarship();
            showToast('Pengajuan di-approve (dummy, implementasi endpoint diperlukan)', 'success');
        }, 1200);
    }
}
function rejectApplication(nim) {
    if(confirm('Reject pengajuan beasiswa NIM ' + nim + '?')) {
        showLoadingScholarship();
        setTimeout(() => {
            hideLoadingScholarship();
            showToast('Pengajuan ditolak (dummy, implementasi endpoint diperlukan)', 'danger');
        }, 1200);
    }
}
function showLoadingScholarship() {
    let loading = document.getElementById('scholarshipLoading');
    if (!loading) {
        loading = document.createElement('div');
        loading.id = 'scholarshipLoading';
        loading.style = 'position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.6);z-index:9998;display:flex;align-items:center;justify-content:center;';
        loading.innerHTML = '<div class="spinner-border text-danger" style="width:3rem;height:3rem;"></div>';
        document.body.appendChild(loading);
    }
}
function hideLoadingScholarship() {
    let loading = document.getElementById('scholarshipLoading');
    if (loading) loading.remove();
}
function filterScholarship() {
    const jenis = document.getElementById('filterJenis').value.toLowerCase();
    const status = document.getElementById('filterStatus').value.toLowerCase();
    const tahun = document.getElementById('filterTahun').value;
    const search = document.getElementById('searchScholarship').value.toLowerCase();
    // Filter tabel penerima
    document.querySelectorAll('.table-responsive table tbody tr').forEach(row => {
        const rowText = row.innerText.toLowerCase();
        let show = true;
        if (jenis && !rowText.includes(jenis)) show = false;
        if (status && !rowText.includes(status)) show = false;
        if (tahun && !rowText.includes(tahun)) show = false;
        if (search && !rowText.includes(search)) show = false;
        row.style.display = show ? '' : 'none';
    });
}
function resetScholarshipFilter() {
    document.getElementById('filterJenis').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterTahun').value = '';
    document.getElementById('searchScholarship').value = '';
    filterScholarship();
}
// Feedback notifikasi sukses/gagal setelah aksi
@if(session('success'))
    window.setTimeout(() => { showToast(@json(session('success')), 'success'); }, 500);
@endif
@if(session('error'))
    window.setTimeout(() => { showToast(@json(session('error')), 'danger'); }, 500);
@endif
</script>
@endpush
@push('styles')
<style>
/* Responsive filter bar */
.filter-section, .action-buttons, .d-flex.align-items-center {
    flex-wrap: wrap;
    gap: 0.5rem;
}
@media (max-width: 600px) {
    .filter-section, .action-buttons, .d-flex.align-items-center {
        flex-direction: column;
        align-items: stretch;
    }
    .table-responsive {
        overflow-x: auto;
    }
}
/* Konsistensi badge */
.badge, .badge-status, .badge-role-table {
    font-size: 0.92rem;
    border-radius: 8px;
    padding: 0.32rem 1.1rem;
    font-weight: 600;
    letter-spacing: 1px;
}
/* Animasi hover tabel */
.table-hover tbody tr:hover, .nk-tb-list .nk-tb-item:hover {
    background: #f43f5e0d !important;
    transition: background 0.2s;
    cursor: pointer;
}
/* Animasi tombol */
.btn, .form-select, .form-control {
    transition: box-shadow 0.2s, background 0.2s, color 0.2s;
}
.btn:hover, .form-select:focus, .form-control:focus {
    box-shadow: 0 2px 8px rgba(225,29,72,0.08);
}
/* Padding tabel mobile */
@media (max-width: 600px) {
    .table, .table th, .table td {
        padding: 0.5rem !important;
        font-size: 0.95rem;
    }
}
.toast-container { pointer-events: none; }
.toast { pointer-events: auto; min-width: 260px; }
#scholarshipLoading { pointer-events: all; }
</style>
@endpush
@endsection
