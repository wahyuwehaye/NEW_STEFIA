<div class="nk-sidebar nk-sidebar-fixed is-dark" data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="{{ route('dashboard') }}" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('images/logo.png') }}" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('images/logo.png') }}" alt="logo-dark">
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
                    
                    <!-- Student Management -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('students.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-user-list"></em>
                            </span>
                            <span class="nk-menu-text">Students</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('students.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">All Students</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('students.create') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Add Student</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Financial Management -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('financials.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-wallet"></em>
                            </span>
                            <span class="nk-menu-text">Financial</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('financials.transactions') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Transactions</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('financials.payments') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Payments</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('financials.reports') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Reports</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Scholarship Management -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('scholarships.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-award"></em>
                            </span>
                            <span class="nk-menu-text">Scholarships</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('scholarships.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">All Scholarships</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('scholarships.applications') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Applications</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Fee Management -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('fees.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-coin"></em>
                            </span>
                            <span class="nk-menu-text">Fee Management</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('fees.structure') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Fee Structure</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('fees.collection') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Fee Collection</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('fees.outstanding') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Outstanding Fees</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Reports -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-bar-chart"></em>
                            </span>
                            <span class="nk-menu-text">Reports</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('reports.financial') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Financial Report</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reports.students') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Student Report</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('reports.scholarship') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Scholarship Report</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Notifications -->
                    <li class="nk-menu-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <a href="{{ route('notifications.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-bell"></em>
                            </span>
                            <span class="nk-menu-text">Notifications</span>
                            <span class="nk-menu-badge">0</span>
                        </a>
                    </li>
                    
                    <!-- Reminders -->
                    <li class="nk-menu-item {{ request()->routeIs('reminders.*') ? 'active' : '' }}">
                        <a href="{{ route('reminders.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-clock"></em>
                            </span>
                            <span class="nk-menu-text">Reminders</span>
                        </a>
                    </li>
                    
                    <!-- Settings -->
                    <li class="nk-menu-item has-sub {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-setting"></em>
                            </span>
                            <span class="nk-menu-text">Settings</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('settings.general') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">General Settings</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('settings.users') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">User Management</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('settings.permissions') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Permissions</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>
