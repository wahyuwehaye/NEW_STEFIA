@extends('layouts.admin')
@section('title', 'User Management')
@section('content')
<x-page-header title="User Management" subtitle="Manage system users">
    <x-slot name="actions">
        <a href="#" class="btn btn-primary" onclick="addUserModal()"><em class="icon ni ni-user-add"></em> Tambah User</a>
    </x-slot>
</x-page-header>
<div class="nk-block">
    <div class="card">
        <div class="card-inner">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="card-title mb-0">Daftar User</h6>
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2" id="searchUser" placeholder="Cari nama/email/role..." onkeyup="filterUsers()" style="width:200px;">
                    <select class="form-select me-2" id="filterRole" onchange="filterUsers()" style="width:auto;display:inline-block;">
                        <option value="">Semua Role</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="admin">Admin</option>
                        <option value="finance">Finance</option>
                        <option value="staff">Staff</option>
                        <option value="student">Student</option>
                    </select>
                    <select class="form-select me-2" id="filterStatus" onchange="filterUsers()" style="width:auto;display:inline-block;">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Nonaktif</option>
                        <option value="locked">Locked</option>
                    </select>
                    <button class="btn btn-secondary" onclick="resetUserFilter()">Reset</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="userTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $users = $users ?? [
                            [
                                'name' => 'Super Admin',
                                'email' => 'super@stefia.ac.id',
                                'role' => 'super_admin',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Admin Keuangan',
                                'email' => 'admin@stefia.ac.id',
                                'role' => 'admin',
                                'status' => 'active',
                            ],
                            [
                                'name' => 'Finance Staff',
                                'email' => 'finance@stefia.ac.id',
                                'role' => 'finance',
                                'status' => 'pending',
                            ],
                            [
                                'name' => 'Mahasiswa',
                                'email' => 'mahasiswa@student.ac.id',
                                'role' => 'student',
                                'status' => 'inactive',
                            ],
                        ];
                        @endphp
                        @foreach($users as $user)
                        <tr data-role="{{ $user['role'] }}" data-status="{{ $user['status'] }}">
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td><span class="badge bg-outline-{{ $user['role'] == 'super_admin' ? 'danger' : ($user['role'] == 'admin' ? 'primary' : ($user['role'] == 'finance' ? 'success' : ($user['role'] == 'staff' ? 'info' : 'secondary'))) }}">{{ ucfirst(str_replace('_',' ',$user['role'])) }}</span></td>
                            <td>
                                @php
                                    $badge = [
                                        'active' => 'success',
                                        'pending' => 'warning',
                                        'inactive' => 'secondary',
                                        'locked' => 'danger',
                                    ][$user['status']] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($user['status']) }}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" onclick="editUserModal('{{ $user['email'] }}')"><em class="icon ni ni-edit"></em> Edit</button>
                                <button class="btn btn-sm btn-warning me-1" onclick="suspendUserModal('{{ $user['email'] }}')"><em class="icon ni ni-na"></em> Suspend</button>
                                <button class="btn btn-sm btn-secondary" onclick="resetPasswordModal('{{ $user['email'] }}')"><em class="icon ni ni-lock"></em> Reset Password</button>
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
<script>
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
function filterUsers() {
    const role = document.getElementById('filterRole').value;
    const status = document.getElementById('filterStatus').value;
    const search = document.getElementById('searchUser').value.toLowerCase();
    document.querySelectorAll('#userTable tbody tr').forEach(row => {
        const rowRole = row.getAttribute('data-role');
        const rowStatus = row.getAttribute('data-status');
        const rowText = row.innerText.toLowerCase();
        let show = true;
        if (role && rowRole !== role) show = false;
        if (status && rowStatus !== status) show = false;
        if (search && !rowText.includes(search)) show = false;
        row.style.display = show ? '' : 'none';
    });
}
function resetUserFilter() {
    document.getElementById('filterRole').value = '';
    document.getElementById('filterStatus').value = '';
    document.getElementById('searchUser').value = '';
    filterUsers();
}
function addUserModal() {
    showToast('Tambah user - to be implemented (show modal form)', 'info');
}
function editUserModal(email) {
    showToast('Edit user: ' + email + ' - to be implemented (show modal form)', 'info');
}
function suspendUserModal(email) {
    if(confirm('Suspend user ' + email + '?')) {
        showToast('User suspended (dummy, implementasi endpoint diperlukan)', 'warning');
    }
}
function resetPasswordModal(email) {
    if(confirm('Reset password user ' + email + '?')) {
        showToast('Password reset (dummy, implementasi endpoint diperlukan)', 'success');
    }
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
</style>
@endpush
@endsection
