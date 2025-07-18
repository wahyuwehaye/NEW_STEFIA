@if(session('success') || session('error') || session('warning') || session('info'))
<div class="notification-container">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <em class="icon ni ni-check-circle"></em>
        </div>
        <div class="alert-content">
            <strong>Berhasil!</strong> {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <em class="icon ni ni-cross-circle"></em>
        </div>
        <div class="alert-content">
            <strong>Error!</strong> {{ session('error') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <em class="icon ni ni-alert-circle"></em>
        </div>
        <div class="alert-content">
            <strong>Peringatan!</strong> {{ session('warning') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="alert-icon">
            <em class="icon ni ni-info-circle"></em>
        </div>
        <div class="alert-content">
            <strong>Info!</strong> {{ session('info') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div>

<style>
.notification-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    max-width: 400px;
}

.notification-container .alert {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.1);
    border: none;
    padding: 16px 20px;
}

.notification-container .alert-icon {
    margin-right: 12px;
    font-size: 24px;
}

.notification-container .alert-content {
    flex: 1;
}

.notification-container .alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.notification-container .alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

.notification-container .alert-warning {
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
}

.notification-container .alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    color: #0c5460;
}

.notification-container .btn-close {
    background: none;
    border: none;
    font-size: 18px;
    opacity: 0.7;
    cursor: pointer;
}

.notification-container .btn-close:hover {
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss notifications after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.notification-container .alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endif
