@extends('layouts.admin')
@section('title', 'Student Report')
@section('content')
<x-page-header title="Student Report" subtitle="Detailed student report information">
</x-page-header>

<style>
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
.stats-card h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: bold;
}
.stats-card p {
    margin: 5px 0 0 0;
    opacity: 0.9;
}
.chart-container {
    height: 400px;
    margin: 20px 0;
}
.filter-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}
.action-buttons {
    margin-bottom: 20px;
}
.table-responsive {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
.btn-export {
    background: #28a745;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    margin-right: 10px;
}
.btn-print {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
}
</style>

<div class="nk-block">
    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h3>{{ $totalStudents ?? 0 }}</h3>
                <p>Total Students</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h3>{{ $activeStudents ?? 0 }}</h3>
                <p>Active Students</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h3>{{ $graduatedStudents ?? 0 }}</h3>
                <p>Graduated Students</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h3>{{ $droppedStudents ?? 0 }}</h3>
                <p>Dropped Out</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5>Filter Student Report</h5>
        <form method="GET" action="{{ route('reports.students') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Name/NIM</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search name or NIM...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Faculty</label>
                    <select class="form-select" name="faculty">
                        <option value="">All Faculties</option>
                        <option value="FTI" {{ request('faculty') == 'FTI' ? 'selected' : '' }}>Faculty of Information Technology</option>
                        <option value="FE" {{ request('faculty') == 'FE' ? 'selected' : '' }}>Faculty of Economics</option>
                        <option value="FH" {{ request('faculty') == 'FH' ? 'selected' : '' }}>Faculty of Law</option>
                        <option value="FK" {{ request('faculty') == 'FK' ? 'selected' : '' }}>Faculty of Medicine</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Academic Year</label>
                    <select class="form-select" name="year">
                        <option value="">All Years</option>
                        @for($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}/{{ $year + 1 }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="graduated" {{ request('status') == 'graduated' ? 'selected' : '' }}>Graduated</option>
                        <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped Out</option>
                    </select>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-12 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('reports.students') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Action Buttons & Filter Global -->
    <div class="action-buttons d-flex align-items-center mb-3">
        <input type="text" class="form-control me-2" id="searchStudent" placeholder="Cari nama/NIM/fakultas..." onkeyup="filterStudents()" style="width:220px;">
        <select class="form-select me-2" id="filterFaculty" onchange="filterStudents()" style="width:auto;display:inline-block;">
            <option value="">Semua Fakultas</option>
            <option value="FTI">Faculty of Information Technology</option>
            <option value="FE">Faculty of Economics</option>
            <option value="FH">Faculty of Law</option>
            <option value="FK">Faculty of Medicine</option>
        </select>
        <select class="form-select me-2" id="filterStatus" onchange="filterStudents()" style="width:auto;display:inline-block;">
            <option value="">Semua Status</option>
            <option value="active">Active</option>
            <option value="graduated">Graduated</option>
            <option value="dropped">Dropped Out</option>
        </select>
        <select class="form-select me-2" id="filterYear" onchange="filterStudents()" style="width:auto;display:inline-block;">
            <option value="">Semua Tahun</option>
            @for($year = date('Y'); $year >= 2020; $year--)
                <option value="{{ $year }}">{{ $year }}/{{ $year + 1 }}</option>
            @endfor
        </select>
        <button class="btn btn-secondary" onclick="resetStudentFilter()">Reset</button>
    </div>

    <!-- Student Data Table -->
    <div class="card">
        <div class="card-inner">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Name</th>
                            <th>Faculty/Department</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students ?? [] as $index => $student)
                        <tr>
                            <td>{{ $loop->iteration + (($students->currentPage() - 1) * $students->perPage()) }}</td>
                            <td>{{ $student->nim }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->faculty }}/{{ $student->department }}</td>
                            <td>{{ $student->academic_year }}</td>
                            <td>{{ ucfirst($student->status) }}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewDetail({{ $student->id }})">Detail</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No student data available</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(isset($students) && $students->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function filterStudents() {
    const faculty = document.getElementById('filterFaculty').value;
    const status = document.getElementById('filterStatus').value;
    const year = document.getElementById('filterYear').value;
    const search = document.getElementById('searchStudent').value.toLowerCase();
    document.querySelectorAll('.table-responsive table tbody tr').forEach(row => {
        const rowText = row.innerText.toLowerCase();
        let show = true;
        if (faculty && !rowText.includes(faculty.toLowerCase())) show = false;
        if (status && !rowText.includes(status.toLowerCase())) show = false;
        if (year && !rowText.includes(year)) show = false;
        if (search && !rowText.includes(search)) show = false;
        row.style.display = show ? '' : 'none';
    });
}
function resetStudentFilter() {
    document.getElementById('filterFaculty').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('filterYear').value = '';
    document.getElementById('searchStudent').value = '';
    filterStudents();
}
function exportToExcel() {
    window.location = '/reports/export?export_type=students&format=excel' + window.location.search;
}
function exportToCSV() {
    window.location = '/reports/export?export_type=students&format=csv' + window.location.search;
}
function exportToPDF() {
    window.location = '/reports/export?export_type=students&format=pdf' + window.location.search;
}
function printReport() {
    window.print();
}
function viewDetail(studentId) {
    alert('Viewing details for student ID: ' + studentId);
}
// Feedback notifikasi sukses/gagal setelah aksi
@if(session('success'))
    window.setTimeout(() => { alert(@json(session('success'))); }, 500);
@endif
@if(session('error'))
    window.setTimeout(() => { alert(@json(session('error'))); }, 500);
@endif
</script>
@endpush
@endsection

