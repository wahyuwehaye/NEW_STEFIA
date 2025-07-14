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
                    <li class="nk-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-dashlite"></em>
                            </span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Manajemen Mahasiswa -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-users"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Mahasiswa</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('students.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Mahasiswa</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('students.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Tambah Mahasiswa</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('students.import') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Import Data</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('students.integration') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Integrasi iGracias</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Manajemen Piutang -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('receivables.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-coin"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Piutang</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('receivables.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Piutang</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('receivables.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Tambah Piutang</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('receivables.outstanding') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Piutang Tunggakan</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('receivables.history') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Riwayat Piutang</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Manajemen Pembayaran -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-wallet"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Pembayaran</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('payments.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Pembayaran</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('payments.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Input Pembayaran</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('payments.verification') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Verifikasi Pembayaran</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('payments.integration') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Integrasi iGracias</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Laporan Tunggakan >10 Juta -->
                    <li class="nk-menu-item {{ request()->routeIs('tunggakan.*') ? 'active' : '' }}">
                        <a href="{{ route('tunggakan.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-alert-circle"></em>
                            </span>
                            <span class="nk-menu-text">Tunggakan >10 Juta</span>
                        </a>
                    </li>
                    
                    <!-- Laporan Penagihan Piutang -->
                    <li class="nk-menu-item {{ request()->routeIs('collection-report.*') ? 'active' : '' }}">
                        <a href="{{ route('collection-report.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-file-text"></em>
                            </span>
                            <span class="nk-menu-text">Laporan Penagihan Piutang</span>
                        </a>
                    </li>
                    
                    <!-- Laporan & Ekspor -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-bar-chart"></em>
                            </span>
                            <span class="nk-menu-text">Laporan & Ekspor</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('reports.monthly') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Laporan Bulanan</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reports.financial') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Laporan Keuangan</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reports.students') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Laporan Mahasiswa</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reports.export') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Ekspor Data</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Reminder Otomatis -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('reminders.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-clock"></em>
                            </span>
                            <span class="nk-menu-text">Reminder Otomatis</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('reminders.email') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Email Reminder</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reminders.whatsapp') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">WhatsApp Reminder</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reminders.schedule') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Jadwal Reminder</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reminders.templates') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Template Pesan</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Manajemen Pengguna -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-user-circle"></em>
                            </span>
                            <span class="nk-menu-text">Manajemen Pengguna</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('users.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Semua Pengguna</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('users.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Tambah Pengguna</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('users.roles') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Role & Hak Akses</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('users.approval') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Approval User Baru</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('users.audit') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Log Aktivitas</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Pengaturan Sistem -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-setting"></em>
                            </span>
                            <span class="nk-menu-text">Pengaturan Sistem</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('settings.general') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Pengaturan Umum</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('settings.integration') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Integrasi iGracias</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
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
