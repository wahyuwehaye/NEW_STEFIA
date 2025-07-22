@extends('layouts.admin')
@section('title', 'Permissions & Roles')
@section('content')
<x-page-header title="Permissions & Roles" subtitle="Kelola role dan permission user">
</x-page-header>
<div class="nk-block">
    <div class="card mb-4">
        <div class="card-inner">
            <h6 class="card-title mb-3">Matrix Role & Permission</h6>
            @php
            $roles = $roles ?? ['super_admin', 'admin', 'finance', 'staff', 'student'];
            $permissions = $permissions ?? [
                'users.view', 'users.create', 'users.edit', 'users.delete',
                'students.view', 'students.create', 'students.edit', 'students.delete',
                'payments.view', 'payments.create', 'payments.edit', 'payments.delete',
                'receivables.view', 'receivables.create', 'receivables.edit', 'receivables.delete',
                'reports.view', 'reports.export', 'sync.manage'
            ];
            $rolePermissions = [
                'super_admin' => ['*'],
                'admin' => [
                    'users.view', 'users.create', 'users.edit', 'users.delete',
                    'students.view', 'students.create', 'students.edit', 'students.delete',
                    'payments.view', 'payments.create', 'payments.edit', 'payments.delete',
                    'receivables.view', 'receivables.create', 'receivables.edit', 'receivables.delete',
                    'reports.view', 'reports.export', 'sync.manage',
                ],
                'finance' => [
                    'students.view',
                    'payments.view', 'payments.create', 'payments.edit',
                    'receivables.view', 'receivables.create', 'receivables.edit',
                    'reports.view', 'reports.export',
                ],
                'staff' => [
                    'students.view',
                    'payments.view',
                    'receivables.view',
                    'reports.view',
                ],
                'student' => [],
            ];
            @endphp
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="bg-gradient-primary text-white">
                        <tr>
                            <th>Permission</th>
                            @foreach($roles as $role)
                                <th>{{ ucfirst(str_replace('_',' ',$role)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $perm)
                        <tr>
                            <td>{{ $perm }}</td>
                            @foreach($roles as $role)
                                <td class="text-center">
                                    @if(in_array('*', $rolePermissions[$role] ?? []) || in_array($perm, $rolePermissions[$role] ?? []))
                                        <span class="text-success"><em class="icon ni ni-check-circle"></em></span>
                                    @else
                                        <span class="text-danger"><em class="icon ni ni-cross"></em></span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-inner">
            <h6 class="card-title mb-3">Assign Role ke User</h6>
            @php
            $users = $users ?? [
                ['id'=>1,'name'=>'Super Admin','email'=>'super@stefia.ac.id','role'=>'super_admin'],
                ['id'=>2,'name'=>'Admin Keuangan','email'=>'admin@stefia.ac.id','role'=>'admin'],
                ['id'=>3,'name'=>'Finance Staff','email'=>'finance@stefia.ac.id','role'=>'finance'],
                ['id'=>4,'name'=>'Mahasiswa','email'=>'mahasiswa@student.ac.id','role'=>'student'],
            ];
            @endphp
            <form onsubmit="assignRole(event)">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label">User</label>
                        <select class="form-select" id="assignUser">
                            @foreach($users as $user)
                                <option value="{{ $user['id'] }}">{{ $user['name'] }} ({{ $user['email'] }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Role</label>
                        <select class="form-select" id="assignRole">
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ ucfirst(str_replace('_',' ',$role)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><em class="icon ni ni-save"></em> Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
function assignRole(e) {
    e.preventDefault();
    const user = document.getElementById('assignUser').value;
    const role = document.getElementById('assignRole').value;
    alert('Assign role ' + role + ' ke user ID ' + user + ' (dummy, implementasi endpoint diperlukan)');
    // TODO: AJAX call ke endpoint assign role
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
