/**
 * Session Timeout Handler
 * Automatically redirect user to login page when session expires
 */
class SessionTimeout {
    constructor(options = {}) {
        this.timeoutMinutes = options.timeout || 120; // Default 2 hours
        this.warningMinutes = options.warning || 5;   // Warning 5 minutes before
        this.checkInterval = options.interval || 60000; // Check every minute
        this.loginUrl = options.loginUrl || '/login';
        
        this.timeoutMs = this.timeoutMinutes * 60 * 1000;
        this.warningMs = this.warningMinutes * 60 * 1000;
        
        this.lastActivity = Date.now();
        this.warningShown = false;
        
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.startTimer();
    }
    
    bindEvents() {
        // Track user activity
        const events = ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'];
        
        events.forEach(event => {
            document.addEventListener(event, () => {
                this.updateActivity();
            }, true);
        });
        
        // Handle AJAX errors for session timeout
        if (window.jQuery) {
            $(document).ajaxError((event, xhr) => {
                if (xhr.status === 401) {
                    this.handleSessionExpired();
                }
            });
        }
        
        // Handle fetch errors
        const originalFetch = window.fetch;
        window.fetch = (...args) => {
            return originalFetch.apply(this, args)
                .then(response => {
                    if (response.status === 401) {
                        this.handleSessionExpired();
                    }
                    return response;
                });
        };
    }
    
    updateActivity() {
        this.lastActivity = Date.now();
        this.warningShown = false;
        
        // Hide warning if it's showing
        this.hideWarning();
    }
    
    startTimer() {
        setInterval(() => {
            this.checkTimeout();
        }, this.checkInterval);
    }
    
    checkTimeout() {
        const now = Date.now();
        const timeSinceActivity = now - this.lastActivity;
        
        // Check if session should expire
        if (timeSinceActivity >= this.timeoutMs) {
            this.handleSessionExpired();
            return;
        }
        
        // Check if warning should be shown
        if (timeSinceActivity >= (this.timeoutMs - this.warningMs) && !this.warningShown) {
            this.showWarning();
        }
    }
    
    showWarning() {
        this.warningShown = true;
        
        const remainingMinutes = Math.ceil((this.timeoutMs - (Date.now() - this.lastActivity)) / 60000);
        
        // Create warning modal
        const modalHtml = `
            <div id="sessionWarningModal" class="modal fade" tabindex="-1" role="dialog" 
                 data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title text-white">
                                <i class="ni ni-clock"></i> Peringatan Session
                            </h5>
                        </div>
                        <div class="modal-body text-center">
                            <p>Session Anda akan berakhir dalam <strong>${remainingMinutes} menit</strong>.</p>
                            <p>Klik "Perpanjang Session" untuk tetap login.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-block" onclick="sessionTimeout.extendSession()">
                                Perpanjang Session
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove existing modal if any
        this.hideWarning();
        
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Show modal (Bootstrap 4/5 compatible)
        if (window.jQuery && window.jQuery.fn.modal) {
            $('#sessionWarningModal').modal('show');
        } else {
            // Fallback for non-Bootstrap environments
            document.getElementById('sessionWarningModal').style.display = 'block';
        }
    }
    
    hideWarning() {
        const existingModal = document.getElementById('sessionWarningModal');
        if (existingModal) {
            if (window.jQuery && window.jQuery.fn.modal) {
                $('#sessionWarningModal').modal('hide');
                setTimeout(() => existingModal.remove(), 300);
            } else {
                existingModal.remove();
            }
        }
    }
    
    extendSession() {
        // Make a request to extend session
        fetch('/api/extend-session', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                this.updateActivity();
                this.hideWarning();
                
                // Show success message
                if (typeof toastr !== 'undefined') {
                    toastr.success('Session berhasil diperpanjang');
                }
            } else {
                this.handleSessionExpired();
            }
        })
        .catch(() => {
            this.handleSessionExpired();
        });
    }
    
    handleSessionExpired() {
        // Show logout message
        if (typeof toastr !== 'undefined') {
            toastr.error('Session Anda telah habis. Mengarahkan ke halaman login...');
        }
        
        // Clear any existing warnings
        this.hideWarning();
        
        // Redirect to login after a short delay
        setTimeout(() => {
            window.location.href = this.loginUrl + '?expired=1';
        }, 2000);
    }
}

// Initialize session timeout when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Get timeout from Laravel config (if available)
    const sessionLifetime = document.querySelector('meta[name="session-lifetime"]')?.getAttribute('content') || 120;
    
    window.sessionTimeout = new SessionTimeout({
        timeout: parseInt(sessionLifetime),
        warning: 5,
        interval: 30000, // Check every 30 seconds
        loginUrl: '/login'
    });
});
