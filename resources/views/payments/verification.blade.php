@extends('layouts.admin')

@section('title', 'Payment Verification')

@push('styles')
<style>
    /* Modern Card Animations */
    .payment-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.8) 100%);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
    }

    .payment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
        z-index: 1;
    }

    .payment-card:hover::before {
        left: 100%;
    }

    .payment-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 50px rgba(31, 38, 135, 0.5);
    }

    /* Status Badges */
    .status-badge {
        position: relative;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        animation: pendingPulse 2s ease-in-out infinite;
    }

    .status-badge.pending::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
        animation: pendingBlink 1.5s ease-in-out infinite;
    }

    @keyframes pendingPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.7); }
        50% { box-shadow: 0 0 0 10px rgba(251, 191, 36, 0); }
    }

    @keyframes pendingBlink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(248,250,252,0.7) 100%);
        border-radius: 20px;
        padding: 25px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.1) 50%, transparent 60%);
        transform: rotate(-45deg);
        transition: all 0.6s ease;
        opacity: 0;
    }

    .stat-card:hover::before {
        opacity: 1;
        transform: rotate(-45deg) translate(50%, 50%);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 15px;
        position: relative;
        z-index: 2;
    }

    .stat-icon.pending {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
    }

    .stat-icon.amount {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .stat-icon.today {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .stat-icon.overdue {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    /* Filter Section */
    .filter-section {
        background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,250,252,0.9) 100%);
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        border: 1px solid rgba(255,255,255,0.3);
        backdrop-filter: blur(10px);
    }

    /* Action Buttons */
    .action-btn {
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .action-btn.verify {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .action-btn.verify:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .action-btn.view {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .action-btn.view:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    }

    .action-btn.fail {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .action-btn.fail:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    }

    /* Payment Method Icons */
    .payment-method-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        font-size: 1.2rem;
    }

    .method-cash { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
    .method-bank_transfer { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; }
    .method-credit_card { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; }
    .method-debit_card { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }
    .method-e_wallet { background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; }
    .method-other { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; }

    /* Loading Animation */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(255,255,255,0.3);
        border-top: 4px solid #fff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .payment-card {
            margin-bottom: 15px;
        }
        
        .filter-section {
            padding: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">
                    <i class="fas fa-check-circle text-warning me-2"></i>
                    Payment Verification
                </h3>
                <div class="nk-block-des text-soft">
                    <p>Review and verify pending payments from students</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <button class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu">
                        <em class="icon ni ni-menu-alt-r"></em>
                    </button>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <button class="btn btn-primary btn-modern" onclick="refreshData()">
                                    <i class="fas fa-sync-alt me-1"></i>
                                    Refresh
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-success btn-modern" onclick="bulkVerify()" id="bulkVerifyBtn" disabled>
                                    <i class="fas fa-check-double me-1"></i>
                                    Bulk Verify
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h2 text-warning mb-0">{{ number_format($stats['total_pending']) }}</div>
                <div class="stat-label text-muted">Total Pending</div>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon amount">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h2 text-success mb-0">Rp {{ number_format($stats['total_amount_pending'], 0, ',', '.') }}</div>
                <div class="stat-label text-muted">Total Amount</div>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon today">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h2 text-info mb-0">{{ number_format($stats['today_pending']) }}</div>
                <div class="stat-label text-muted">Today's Submissions</div>
            </div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon overdue">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number h2 text-danger mb-0">{{ number_format($stats['overdue_pending']) }}</div>
                <div class="stat-label text-muted">Overdue (3+ days)</div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section" data-aos="fade-up" data-aos-delay="500">
        <form method="GET" action="{{ route('payments.pending') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <div class="form-control-wrap">
                        <input type="text" name="search" class="form-control" placeholder="Payment code, student name..." value="{{ request('search') }}">
                        <div class="form-icon form-icon-left">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        <option value="">All Methods</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="debit_card" {{ request('payment_method') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                        <option value="e_wallet" {{ request('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        <option value="other" {{ request('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Date From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Date To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-modern me-2">
                        <i class="fas fa-filter me-1"></i>
                        Apply Filters
                    </button>
                    <a href="{{ route('payments.pending') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Pending Payments -->
    <div class="nk-block">
        @if($pendingPayments->count() > 0)
            <div class="row">
                @foreach($pendingPayments as $payment)
                <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="payment-card">
                        <div class="card-body p-4">
                            <!-- Header with status -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" class="payment-checkbox me-3" value="{{ $payment->id }}" onchange="updateBulkAction()">
                                    <span class="status-badge pending">Pending</span>
                                </div>
                                <small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small>
                            </div>

                            <!-- Payment Code -->
                            <h6 class="mb-3">
                                <i class="fas fa-receipt me-2 text-primary"></i>
                                {{ $payment->payment_code }}
                            </h6>

                            <!-- Student Info -->
                            <div class="student-info mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="user-avatar bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        {{ strtoupper(substr($payment->student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $payment->student->name }}</div>
                                        <small class="text-muted">{{ $payment->student->nim }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="payment-details mb-4">
                                <div class="row g-2">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Amount:</span>
                                            <span class="fw-bold text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Method:</span>
                                            <div class="d-flex align-items-center">
                                                <span class="payment-method-icon method-{{ $payment->payment_method }}">
                                                    @switch($payment->payment_method)
                                                        @case('cash')
                                                            <i class="fas fa-money-bill"></i>
                                                        @break
                                                        @case('bank_transfer')
                                                            <i class="fas fa-university"></i>
                                                        @break
                                                        @case('credit_card')
                                                            <i class="fas fa-credit-card"></i>
                                                        @break
                                                        @case('debit_card')
                                                            <i class="fas fa-credit-card"></i>
                                                        @break
                                                        @case('e_wallet')
                                                            <i class="fas fa-mobile-alt"></i>
                                                        @break
                                                        @default
                                                            <i class="fas fa-ellipsis-h"></i>
                                                    @endswitch
                                                </span>
                                                <span class="small">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Date:</span>
                                            <span>{{ $payment->payment_date->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                    @if($payment->reference_number)
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Ref:</span>
                                            <span class="small">{{ $payment->reference_number }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <div class="btn-group w-100" role="group">
                                    <button onclick="verifyPayment({{ $payment->id }})" class="btn action-btn verify flex-fill">
                                        <i class="fas fa-check"></i>
                                        <span class="d-none d-sm-inline ms-1">Verify</span>
                                    </button>
                                    <a href="{{ route('payments.show', $payment->id) }}" class="btn action-btn view flex-fill">
                                        <i class="fas fa-eye"></i>
                                        <span class="d-none d-sm-inline ms-1">View</span>
                                    </a>
                                    <button onclick="failPayment({{ $payment->id }})" class="btn action-btn fail flex-fill">
                                        <i class="fas fa-times"></i>
                                        <span class="d-none d-sm-inline ms-1">Fail</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $pendingPayments->withQueryString()->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state text-center py-5" data-aos="fade-up">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-success">All Caught Up!</h4>
                <p class="text-muted">No pending payments to verify at the moment.</p>
                <a href="{{ route('payments.index') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-list me-1"></i>
                    View All Payments
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner"></div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize page
    $(document).ready(function() {
        // Auto-submit filters on change
        $('select[name="payment_method"]').on('change', function() {
            if ($(this).val() !== '') {
                $('#filterForm').submit();
            }
        });

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    // Show/hide loading overlay
    function showLoading() {
        $('#loadingOverlay').fadeIn(300);
    }

    function hideLoading() {
        $('#loadingOverlay').fadeOut(300);
    }

    // Refresh data
    function refreshData() {
        showLoading();
        window.location.reload();
    }

    // Update bulk action button
    function updateBulkAction() {
        const checkedBoxes = $('.payment-checkbox:checked').length;
        $('#bulkVerifyBtn').prop('disabled', checkedBoxes === 0);
    }

    // Bulk verify selected payments
    function bulkVerify() {
        const selectedPayments = $('.payment-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedPayments.length === 0) {
            $.toast({
                heading: 'Warning',
                text: 'Please select payments to verify',
                icon: 'warning',
                position: 'top-right'
            });
            return;
        }

        Swal.fire({
            title: 'Bulk Verify Payments',
            text: `Are you sure you want to verify ${selectedPayments.length} payment(s)?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, verify them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: '{{ route("api.payments.bulk-verify") }}',
                    method: 'POST',
                    data: {
                        payment_ids: selectedPayments,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        hideLoading();
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        hideLoading();
                        const response = xhr.responseJSON;
                        Swal.fire('Error!', response?.message || 'Something went wrong', 'error');
                    }
                });
            }
        });
    }

    // Verify single payment
    function verifyPayment(paymentId) {
        Swal.fire({
            title: 'Verify Payment',
            text: 'Are you sure you want to verify this payment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, verify it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: `/payments/${paymentId}/verify`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        hideLoading();
                        Swal.fire({
                            title: 'Success!',
                            text: 'Payment verified successfully',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        hideLoading();
                        const response = xhr.responseJSON;
                        Swal.fire('Error!', response?.message || 'Something went wrong', 'error');
                    }
                });
            }
        });
    }

    // Fail payment with reason
    function failPayment(paymentId) {
        Swal.fire({
            title: 'Mark Payment as Failed',
            html: '<textarea id="failureReason" class="form-control" placeholder="Enter reason for failure..." rows="3"></textarea>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Mark as Failed',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const reason = document.getElementById('failureReason').value;
                if (!reason.trim()) {
                    Swal.showValidationMessage('Please enter a reason for failure');
                    return false;
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                $.ajax({
                    url: `/payments/${paymentId}/mark-failed`,
                    method: 'POST',
                    data: {
                        reason: result.value,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        hideLoading();
                        Swal.fire({
                            title: 'Payment Failed!',
                            text: 'Payment marked as failed successfully',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        hideLoading();
                        const response = xhr.responseJSON;
                        Swal.fire('Error!', response?.message || 'Something went wrong', 'error');
                    }
                });
            }
        });
    }
</script>
@endpush
