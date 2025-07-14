// Alpine.js Initialization
if (typeof Alpine !== 'undefined') {
    window.Alpine = Alpine;
    Alpine.start();
}

// Modern Dashboard Initialization
class StefiaDashboard {
    constructor() {
        this.initializeApp();
    }

    initializeApp() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.init());
        } else {
            this.init();
        }
    }

    init() {
        this.initializeLibraries();
        this.initializeTheme();
        this.initializeAnimations();
        this.setupEventListeners();
        this.initializeCharts();
    console.log('🏗️ STEFIA Dashboard Modern - Initialization started!');
    }

    initializeLibraries() {
        // Initialize AOS if available
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100,
                easing: 'ease-out-cubic'
            });
        }

        // Initialize Select2 when jQuery is available
        this.waitForLibrary('jQuery', () => {
            this.waitForLibrary('select2', () => {
                if (typeof $.fn.select2 !== 'undefined') {
                    $('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: 'Select an option...',
                        allowClear: true
                    });
                }
            });
        });

        // Initialize DataTables when available
        this.waitForLibrary('DataTable', () => {
            $('.data-table').DataTable({
                responsive: true,
                pageLength: 10,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        });

        // Initialize Bootstrap tooltips
        this.waitForLibrary('bootstrap', () => {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    }

    waitForLibrary(libraryName, callback, timeout = 10000) {
        const startTime = Date.now();
        const checkLibrary = () => {
            let isAvailable = false;
            
            switch(libraryName) {
                case 'jQuery':
                    isAvailable = typeof $ !== 'undefined';
                    break;
                case 'select2':
                    isAvailable = typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined';
                    break;
                case 'DataTable':
                    isAvailable = typeof $ !== 'undefined' && typeof $.fn.DataTable !== 'undefined';
                    break;
                case 'bootstrap':
                    isAvailable = typeof bootstrap !== 'undefined';
                    break;
                case 'Highcharts':
                    isAvailable = typeof Highcharts !== 'undefined';
                    break;
                default:
                    isAvailable = typeof window[libraryName] !== 'undefined';
            }

            if (isAvailable) {
                callback();
            } else if (Date.now() - startTime < timeout) {
                setTimeout(checkLibrary, 100);
            } else {
                console.warn(`⚠️ ${libraryName} not loaded within ${timeout}ms`);
            }
        };
        checkLibrary();
    }

    initializeTheme() {
        // Load saved theme
        const savedTheme = localStorage.getItem('stefia-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        
        // Update theme toggle icon
        const themeIcon = document.querySelector('#theme-toggle em');
        if (themeIcon) {
            themeIcon.className = savedTheme === 'dark' ? 'icon ni ni-sun' : 'icon ni ni-moon';
        }
    }

    initializeAnimations() {
        // Add loading animations
        const cards = document.querySelectorAll('.stats-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fadeInUp');
        });
    }

    setupEventListeners() {
        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleTheme();
            });
        }

        // Sidebar toggle for mobile
        const sidebarToggle = document.querySelector('.nk-nav-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.toggle('sidebar-collapsed');
            });
        }

        // Search functionality
        const searchInput = document.querySelector('.global-search');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                console.log('🔍 Searching for:', searchTerm);
                // Implement search logic here
            });
        }
    }

    toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('stefia-theme', newTheme);
        
        // Update icon with animation
        const icon = document.querySelector('#theme-toggle em');
        if (icon) {
            icon.style.transform = 'rotate(360deg)';
            setTimeout(() => {
                icon.className = newTheme === 'dark' ? 'icon ni ni-sun' : 'icon ni ni-moon';
                icon.style.transform = 'rotate(0deg)';
            }, 150);
        }

        // Show toast notification
        this.showToast(`Theme switched to ${newTheme} mode`, 'info');
    }

    initializeCharts() {
        // Initialize charts with proper loading check
        this.waitForLibrary('Highcharts', () => {
            this.setupHighcharts();
        });
    }

    setupHighcharts() {
        // Check if Highcharts is already initialized to prevent error #16
        if (typeof Highcharts === 'undefined') {
            console.error('Highcharts is not loaded');
            return;
        }

        // Set global Highcharts options
        Highcharts.setOptions({
            colors: ['#e11d48', '#f43f5e', '#fb7185', '#22c55e', '#f59e0b', '#06b6d4', '#f97316', '#84cc16'],
            chart: {
                backgroundColor: 'transparent',
                style: {
                    fontFamily: 'Inter, sans-serif',
                    fontSize: '13px'
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutBounce'
                }
            },
            credits: {
                enabled: false
            },
            title: {
                style: {
                    color: '#374151',
                    fontSize: '16px',
                    fontWeight: '600'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.98)',
                borderColor: '#e5e7eb',
                borderRadius: 8,
                borderWidth: 1,
                shadow: {
                    color: 'rgba(0, 0, 0, 0.1)',
                    offsetX: 0,
                    offsetY: 2,
                    opacity: 0.5,
                    width: 3
                }
            }
        });

        // Initialize charts
        this.createSparklineCharts();
        this.createMainCharts();
    }

    createSparklineCharts() {
        const sparklineData = {
            totalStudents: [1100, 1150, 1200, 1180, 1220, 1245],
            activeReceivables: [2500000, 2600000, 2750000, 2680000, 2800000, 2847950],
            paidReceivables: [1400000, 1420000, 1380000, 1450000, 1440000, 1456780],
            highDebtors: [28, 25, 30, 27, 26, 23],
            todayPayments: [85000, 88000, 92000, 85000, 91000, 89240],
            semesterReceivables: [420000, 435000, 440000, 445000, 450000, 456780],
            yearlyReceivables: [1100000, 1150000, 1180000, 1200000, 1220000, 1234567],
            collectionRate: [92.1, 93.5, 92.8, 93.2, 94.0, 94.2]
        };

        const colors = {
            totalStudents: '#e11d48',
            activeReceivables: '#22c55e',
            paidReceivables: '#22c55e',
            highDebtors: '#ef4444',
            todayPayments: '#f59e0b',
            semesterReceivables: '#8b5cf6',
            yearlyReceivables: '#06b6d4',
            collectionRate: '#14b8a6'
        };

        Object.keys(sparklineData).forEach(key => {
            const element = document.getElementById(key);
            if (element) {
                this.createSparkline(key, sparklineData[key], colors[key]);
            }
        });
    }

    createSparkline(elementId, data, color) {
        Highcharts.chart(elementId, {
            chart: {
                type: 'areaspline',
                height: 60,
                width: 120,
                margin: [2, 0, 2, 0],
                backgroundColor: null,
                borderWidth: 0,
                style: { overflow: 'visible' },
                skipClone: true
            },
            title: { text: '' },
            credits: { enabled: false },
            xAxis: {
                labels: { enabled: false },
                title: { text: null },
                startOnTick: false,
                endOnTick: false,
                tickPositions: []
            },
            yAxis: {
                endOnTick: false,
                startOnTick: false,
                labels: { enabled: false },
                title: { text: null },
                tickPositions: [0]
            },
            legend: { enabled: false },
            tooltip: {
                hideDelay: 0,
                outside: true,
                shared: true
            },
            plotOptions: {
                series: {
                    animation: { duration: 1000 },
                    lineWidth: 2,
                    shadow: false,
                    marker: {
                        radius: 1,
                        states: { hover: { radius: 3 } }
                    },
                    fillOpacity: 0.3
                }
            },
            series: [{
                data: data,
                color: color,
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, `${color}66`],
                        [1, `${color}11`]
                    ]
                }
            }]
        });
    }

    createMainCharts() {
        // Monthly Revenue Chart
        if (document.getElementById('monthlyRevenue')) {
            this.createMonthlyRevenueChart();
        }

        // Receivable Status Chart
        if (document.getElementById('receivableStatus')) {
            this.createReceivableStatusChart();
        }

        // Payment Trends Chart
        if (document.getElementById('paymentTrends')) {
            this.createPaymentTrendsChart();
        }
    }

    createMonthlyRevenueChart() {
        Highcharts.chart('monthlyRevenue', {
            chart: {
                type: 'area',
                height: 300
            },
            title: { text: null },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: { text: 'Revenue (IDR)' },
                labels: {
                    formatter: function() {
                        return 'Rp ' + (this.value / 1000000).toFixed(1) + 'M';
                    }
                }
            },
            tooltip: {
                shared: true,
                formatter: function() {
                    let s = `<b>${this.x}</b>`;
                    this.points.forEach(point => {
                        s += `<br/>${point.series.name}: Rp ${(point.y / 1000000).toFixed(1)}M`;
                    });
                    return s;
                }
            },
            plotOptions: {
                area: {
                    fillOpacity: 0.5,
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 4,
                        states: { hover: { enabled: true } }
                    }
                }
            },
            series: [{
                name: 'Total Revenue',
                data: [2200000000, 2350000000, 2180000000, 2450000000, 2600000000, 2750000000, 2680000000, 2800000000, 2920000000, 2850000000, 2780000000, 2847950000],
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, 'rgba(225, 29, 72, 0.8)'],
                        [1, 'rgba(225, 29, 72, 0.1)']
                    ]
                },
                color: '#e11d48'
            }, {
                name: 'Target Revenue',
                data: [2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000, 2500000000],
                type: 'line',
                color: '#22c55e',
                dashStyle: 'dash'
            }]
        });
    }

    createReceivableStatusChart() {
        Highcharts.chart('receivableStatus', {
            chart: {
                type: 'pie',
                height: 350
            },
            title: { text: null },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: { enabled: false },
                    showInLegend: true,
                    innerSize: '50%'
                }
            },
            series: [{
                name: 'Status',
                colorByPoint: true,
                data: [{
                    name: 'Lunas',
                    y: 68.5,
                    color: '#22c55e',
                    sliced: true,
                    selected: true
                }, {
                    name: 'Aktif',
                    y: 28.8,
                    color: '#f59e0b'
                }, {
                    name: 'Tunggakan',
                    y: 2.7,
                    color: '#ef4444'
                }]
            }]
        });
    }

    createPaymentTrendsChart() {
        Highcharts.chart('paymentTrends', {
            chart: {
                type: 'area',
                height: 280
            },
            title: { text: null },
            xAxis: {
                categories: ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan']
            },
            yAxis: {
                title: { text: 'Pembayaran (IDR)' },
                labels: {
                    formatter: function() {
                        return 'Rp ' + (this.value / 1000000).toFixed(1) + 'M';
                    }
                }
            },
            tooltip: {
                shared: true,
                formatter: function() {
                    let s = `<b>${this.x}</b>`;
                    this.points.forEach(point => {
                        s += `<br/>${point.series.name}: Rp ${(point.y / 1000000).toFixed(1)}M`;
                    });
                    return s;
                }
            },
            plotOptions: {
                area: {
                    fillOpacity: 0.5,
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 4,
                        states: { hover: { enabled: true } }
                    }
                }
            },
            series: [{
                name: 'Pembayaran',
                data: [75000000, 82000000, 78000000, 85000000, 88000000, 91000000, 89240000],
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, 'rgba(34, 197, 94, 0.8)'],
                        [1, 'rgba(34, 197, 94, 0.1)']
                    ]
                },
                color: '#22c55e'
            }]
        });
    }

    // Global utility functions
    showNotification(title, text, type = 'success') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                text: text,
                icon: type,
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }
    }

    showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toast-container') || this.createToastContainer();
        const toast = this.createToast(message, type);
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
        return container;
    }

    createToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast show animate-fadeInUp`;
        toast.innerHTML = `
            <div class="toast-header">
                <i class="fas fa-${this.getToastIcon(type)} me-2"></i>
                <strong class="me-auto">${this.getToastTitle(type)}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">${message}</div>
        `;
        return toast;
    }

    getToastIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    getToastTitle(type) {
        const titles = {
            success: 'Success',
            error: 'Error',
            warning: 'Warning',
            info: 'Information'
        };
        return titles[type] || 'Information';
    }

    // Number formatting helper
    formatNumber(num) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(num);
    }

    // Date formatting helper
    formatDate(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    }

    // Confirm dialog helper
    confirmAction(title, text, callback) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed && callback) {
                    callback();
                }
            });
        }
    }

    // Auto-refresh data helper
    autoRefresh(callback, interval = 30000) {
        return setInterval(callback, interval);
    }
}

function startStefiaDashboard() {
    // Initialize the dashboard
    const dashboard = new StefiaDashboard();

    // Make global functions available
    window.stefiaDashboard = dashboard;
    window.showNotification = (title, text, type) => dashboard.showNotification(title, text, type);
    window.showToast = (message, type) => dashboard.showToast(message, type);
    window.formatNumber = (num) => dashboard.formatNumber(num);
    window.formatDate = (date) => dashboard.formatDate(date);
    window.confirmAction = (title, text, callback) => dashboard.confirmAction(title, text, callback);
}

// Ensure DOM Fully Loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', startStefiaDashboard);
} else {
    startStefiaDashboard();
}

// DOM ready initialization
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTables
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 10,
            lengthChange: false,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    }

    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Theme switcher
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Global notification function
    window.showNotification = function(title, text, type = 'success') {
        Swal.fire({
            title: title,
            text: text,
            icon: type,
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        });
    };

    // Global toast function
    window.showToast = function(message, type = 'success') {
        const toastContainer = document.getElementById('toast-container') || createToastContainer();
        const toast = createToast(message, type);
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    };

    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
        return container;
    }

    function createToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast show animate-fadeInUp`;
        toast.innerHTML = `
            <div class="toast-header">
                <i class="fas fa-${getToastIcon(type)} me-2"></i>
                <strong class="me-auto">${getToastTitle(type)}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">${message}</div>
        `;
        return toast;
    }

    function getToastIcon(type) {
        const icons = {
            success: 'check-circle',
            error: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    }

    function getToastTitle(type) {
        const titles = {
            success: 'Success',
            error: 'Error',
            warning: 'Warning',
            info: 'Information'
        };
        return titles[type] || 'Information';
    }

    // Loading state helper
    window.showLoading = function(element) {
        element.innerHTML = '<span class="loading-spinner"></span> Loading...';
        element.disabled = true;
    };

    window.hideLoading = function(element, originalText) {
        element.innerHTML = originalText;
        element.disabled = false;
    };

    // Form validation helper
    window.validateForm = function(formSelector) {
        const form = document.querySelector(formSelector);
        if (!form) return false;

        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });

        return isValid;
    };

    // Number formatting helper
    window.formatNumber = function(num) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(num);
    };

    // Date formatting helper
    window.formatDate = function(date) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(date));
    };

    // Confirm dialog helper
    window.confirmAction = function(title, text, callback) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed && callback) {
                callback();
            }
        });
    };

    // Auto-refresh data helper
    window.autoRefresh = function(callback, interval = 30000) {
        setInterval(callback, interval);
    };

    // Sidebar toggle for mobile
    const sidebarToggle = document.querySelector('.nk-nav-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.toggle('sidebar-collapsed');
        });
    }

    // Search functionality
    const searchInput = document.querySelector('.global-search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            // Implement search logic here
            console.log('Searching for:', searchTerm);
        });
    }

    // Initialize charts after DOM is ready
    setTimeout(() => {
        if (typeof initializeCharts === 'function') {
            initializeCharts();
        }
    }, 100);

    console.log('STEFIA Dashboard initialized successfully!');
});
