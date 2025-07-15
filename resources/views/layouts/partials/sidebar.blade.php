<div class="nk-sidebar nk-sidebar-fixed" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="{{ route('dashboard') }}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('images/logo-horizontal.png') }}" alt="STEFIA Logo">
                <img class="logo-dark logo-img" src="{{ asset('images/logo-horizontal.png') }}" alt="STEFIA Logo">
            </a>
        </div>
        <div class="nk-menu-trigger">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu">
                <em class="icon ni ni-arrow-left"></em>
            </a>
        </div>
    </div>
    
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    
                    <!-- Dashboard -->
                    <li class="nk-menu-item {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-dashlite"></em>
                            </span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Manajemen Mahasiswa -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-users"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Mahasiswa</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'students.index' ? 'active' : '' }}">
                                <a href="{{ route('students.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Mahasiswa</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'students.create' ? 'active' : '' }}">
                                <a href="{{ route('students.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Tambah Mahasiswa</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'students.import' ? 'active' : '' }}">
                                <a href="{{ route('students.import') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Import Data</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'students.integration' ? 'active' : '' }}">
                                <a href="{{ route('students.integration') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Integrasi iGracias</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Manajemen Piutang -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-coin"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Piutang</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'receivables.index' ? 'active' : '' }}">
                                <a href="{{ route('receivables.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Piutang</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'receivables.create' ? 'active' : '' }}">
                                <a href="{{ route('receivables.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Tambah Piutang</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'receivables.outstanding' ? 'active' : '' }}">
                                <a href="{{ route('receivables.outstanding') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Piutang Tunggakan</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'receivables.history' ? 'active' : '' }}">
                                <a href="{{ route('receivables.history') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Riwayat Piutang</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Manajemen Pembayaran -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-wallet"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Pembayaran</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'payments.index' ? 'active' : '' }}">
                                <a href="{{ route('payments.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Pembayaran</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'payments.create' ? 'active' : '' }}">
                                <a href="{{ route('payments.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Input Pembayaran</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'payments.verification' ? 'active' : '' }}">
                                <a href="{{ route('payments.verification') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Verifikasi Pembayaran</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'payments.integration' ? 'active' : '' }}">
                                <a href="{{ route('payments.integration') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Integrasi iGracias</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Laporan Tunggakan >10 Juta -->
                    <li class="nk-menu-item {{ Route::currentRouteName() === 'tunggakan.index' ? 'active' : '' }}">
                        <a href="{{ route('tunggakan.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-alert-circle"></em>
                            </span>
                            <span class="nk-menu-text">Tunggakan >10 Juta</span>
                        </a>
                    </li>
                    
                    <!-- Laporan Penagihan Piutang -->
                    <li class="nk-menu-item {{ Route::currentRouteName() === 'collection-report.index' ? 'active' : '' }}">
                        <a href="{{ route('collection-report.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-file-text"></em>
                            </span>
                            <span class="nk-menu-text">Laporan Penagihan Piutang</span>
                        </a>
                    </li>
                    
                    <!-- Laporan & Ekspor -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-bar-chart"></em>
                            </span>
                            <span class="nk-menu-text">Laporan & Ekspor</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reports.monthly' ? 'active' : '' }}">
                                <a href="{{ route('reports.monthly') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Laporan Bulanan</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reports.financial' ? 'active' : '' }}">
                                <a href="{{ route('reports.financial') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Laporan Keuangan</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reports.students' ? 'active' : '' }}">
                                <a href="{{ route('reports.students') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Laporan Mahasiswa</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reports.export' ? 'active' : '' }}">
                                <a href="{{ route('reports.export') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Ekspor Data</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Reminder Otomatis -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-clock"></em>
                            </span>
                            <span class="nk-menu-text">Reminder Otomatis</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reminders.email' ? 'active' : '' }}">
                                <a href="{{ route('reminders.email') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Email Reminder</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reminders.whatsapp' ? 'active' : '' }}">
                                <a href="{{ route('reminders.whatsapp') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">WhatsApp Reminder</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reminders.schedule' ? 'active' : '' }}">
                                <a href="{{ route('reminders.schedule') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Jadwal Reminder</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'reminders.templates' ? 'active' : '' }}">
                                <a href="{{ route('reminders.templates') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Template Pesan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Manajemen Pengguna -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-user-circle"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Pengguna</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'users.index' ? 'active' : '' }}">
                                <a href="{{ route('users.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Pengguna</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'users.create' ? 'active' : '' }}">
                                <a href="{{ route('users.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Tambah Pengguna</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'users.roles' ? 'active' : '' }}">
                                <a href="{{ route('users.roles') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Role & Hak Akses</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'users.approval' ? 'active' : '' }}">
                                <a href="{{ route('users.approval') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Approval User Baru</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'users.audit' ? 'active' : '' }}">
                                <a href="{{ route('users.audit') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Log Aktivitas</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Pengaturan Sistem -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-setting"></em>
                            </span>
                            <span class="nk-menu-text">Pengaturan Sistem</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'settings.general' ? 'active' : '' }}">
                                <a href="{{ route('settings.general') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Pengaturan Umum</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'settings.integration' ? 'active' : '' }}">
                                <a href="{{ route('settings.integration') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Integrasi iGracias</span>
                                </a>
                            </li>
                            <li class="nk-menu-item {{ Route::currentRouteName() === 'settings.backup' ? 'active' : '' }}">
                                <a href="{{ route('settings.backup') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Backup & Restore</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>
