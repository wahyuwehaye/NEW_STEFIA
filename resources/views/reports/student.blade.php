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

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn-export" onclick="exportToExcel()">Export Excel</button>
        <button class="btn-export" onclick="exportToPDF()">Export PDF</button>
        <button class="btn-print" onclick="printReport()">Print</button>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Placeholder functions for actions
function exportToExcel() {
    alert('Export to Excel functionality will be implemented');
}

function exportToPDF() {
    alert('Export to PDF functionality will be implemented');
}

function printReport() {
    window.print();
}

function viewDetail(studentId) {
    alert('Viewing details for student ID: ' + studentId);
}
</script>
@endpush
@endsection

