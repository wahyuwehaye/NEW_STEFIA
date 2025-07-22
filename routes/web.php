<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ReceivableController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\FollowUpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IGraciasDummyController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// CSRF token refresh endpoint
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()]);
});

// Dashboard - protected by authentication
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Password management
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Avatar management
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'removeAvatar'])->name('profile.avatar.remove');
    
    // Activity and security
    Route::get('/profile/activity', [ProfileController::class, 'activityLog'])->name('profile.activity');
    Route::get('/profile/login-history', [ProfileController::class, 'loginHistory'])->name('profile.login-history');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
});

// Students management routes - simplified middleware
Route::middleware(['auth'])->group(function () {
    // List and view routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    
    // Static routes before dynamic routes
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
    Route::get('/students/analytics', [StudentController::class, 'analytics'])->name('students.analytics');
    Route::get('/students/bulk-operations', [StudentController::class, 'bulkOperations'])->name('students.bulk-operations');
    Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
    Route::get('/students/export-pdf', [StudentController::class, 'exportPdf'])->name('students.export-pdf');
    Route::get('/students/integration', [StudentController::class, 'integration'])->name('students.integration');
    Route::get('/students/import-form', [StudentController::class, 'importForm'])->name('students.import-form');
    Route::get('/students/download-template', [StudentController::class, 'downloadTemplate'])->name('students.download-template');
    
    // Import and bulk operations
    Route::post('/students/import', [StudentController::class, 'import'])->name('students.import');
    Route::post('/students/process-import', [StudentController::class, 'processImport'])->name('students.process-import');
    Route::post('/students/bulk-action', [StudentController::class, 'bulkAction'])->name('students.bulk-action');
    
    // Dynamic routes with student parameter
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::patch('/students/{student}', [StudentController::class, 'update']);
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    
    // Student detail pages
    Route::get('/students/{student}/financial-summary', [StudentController::class, 'financialSummary'])->name('students.financial-summary');
    Route::get('/students/{student}/payments', [StudentController::class, 'paymentHistory'])->name('students.payment-history');
    Route::get('/students/{student}/debts', [StudentController::class, 'debts'])->name('students.debts');
    Route::get('/students/{student}/fees', [StudentController::class, 'fees'])->name('students.fees');
    Route::get('/students/{student}/scholarships', [StudentController::class, 'scholarships'])->name('students.scholarships');
    Route::get('/students/{student}/dashboard', [StudentController::class, 'dashboard'])->name('students.dashboard');
    
    // Financial operations
    Route::post('/students/{student}/recalculate-financials', [StudentController::class, 'recalculateFinancials'])->name('students.recalculate-financials');
});

// Receivables management
Route::middleware(['auth'])->group(function () {
    Route::get('/receivables', [ReceivableController::class, 'index'])->name('receivables.index');
    
    // Specific routes must come before dynamic routes
    Route::get('/receivables/create', [ReceivableController::class, 'create'])->name('receivables.create');
    Route::post('/receivables', [ReceivableController::class, 'store'])->name('receivables.store');
    
    // Dynamic routes
    Route::get('/receivables/{receivable}', [ReceivableController::class, 'show'])->name('receivables.show');
    
    // Dashboard and other specific routes
    Route::get('/receivables-dashboard', [ReceivableController::class, 'dashboard'])->name('receivables.dashboard');
    Route::get('/receivables-outstanding', [ReceivableController::class, 'outstanding'])->name('receivables.outstanding');
    Route::get('/receivables-history', [ReceivableController::class, 'history'])->name('receivables.history');
    Route::get('/receivables-bulk-operations', [ReceivableController::class, 'bulkOperations'])->name('receivables.bulk-operations');
    Route::get('/receivables-export', [ReceivableController::class, 'export'])->name('receivables.export');
    Route::get('/receivables-sync-igracias', [ReceivableController::class, 'syncIgracias'])->name('receivables.sync-igracias');
    Route::get('/receivables-by-student', [ReceivableController::class, 'landingPage'])->name('receivables.landing');
    Route::get('/receivables-by-student/{studentId?}', [ReceivableController::class, 'byStudent'])->name('receivables.by-student');
    
    // API routes for DataTables
    Route::get('/api/receivables/data', [ReceivableController::class, 'getData'])->name('api.receivables.data');
    Route::get('/api/receivables/outstanding-data', [ReceivableController::class, 'getOutstandingData'])->name('api.receivables.outstanding-data');
    Route::get('/api/receivables/history-data', [ReceivableController::class, 'getHistoryData'])->name('api.receivables.history-data');
});

Route::middleware(['auth', 'user.permission:receivables.edit'])->group(function () {
    Route::get('/receivables/{receivable}/edit', [ReceivableController::class, 'edit'])->name('receivables.edit');
    Route::put('/receivables/{receivable}', [ReceivableController::class, 'update'])->name('receivables.update');
    Route::patch('/receivables/{receivable}', [ReceivableController::class, 'update']);
    Route::post('/receivables/{receivable}/send-reminder', [ReceivableController::class, 'sendReminder'])->name('receivables.send-reminder');
    Route::post('/receivables/{receivable}/mark-as-paid', [ReceivableController::class, 'markAsPaid'])->name('receivables.mark-as-paid');
});

Route::middleware(['auth', 'user.permission:receivables.delete'])->group(function () {
    Route::delete('/receivables/{receivable}', [ReceivableController::class, 'destroy'])->name('receivables.destroy');
});

// Payments management
Route::middleware(['auth', 'user.permission:payments.create'])->group(function () {
    Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
});

Route::middleware(['auth', 'user.permission:payments.view'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments-dashboard', [PaymentController::class, 'dashboard'])->name('payments.dashboard');
    Route::get('/payments-verification', [PaymentController::class, 'verification'])->name('payments.verification');
    Route::get('/payments-integration', [PaymentController::class, 'integration'])->name('payments.integration');
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::get('/payments-export', [PaymentController::class, 'export'])->name('payments.export');
    
    // Additional routes that were referenced in views
    Route::get('/payments-pending', [PaymentController::class, 'verification'])->name('payments.pending');
    Route::get('/payments-history', [PaymentController::class, 'index'])->name('payments.history');
    
    // Additional comprehensive payment management routes
    Route::get('/payments-analytics', [PaymentController::class, 'analytics'])->name('payments.analytics');
    Route::get('/payments-bulk-operations', [PaymentController::class, 'bulkOperations'])->name('payments.bulk-operations');
    Route::get('/payments-reports', [PaymentController::class, 'reports'])->name('payments.reports');
    Route::get('/payments-by-student/{studentId?}', [PaymentController::class, 'byStudent'])->name('payments.by-student');
    Route::get('/payments-by-method', [PaymentController::class, 'byMethod'])->name('payments.by-method');
    Route::get('/payments-reconciliation', [PaymentController::class, 'reconciliation'])->name('payments.reconciliation');
    
    // API routes for DataTables
    Route::get('/api/payments/data', [PaymentController::class, 'getData'])->name('api.payments.data');
    Route::get('/api/payments/pending-data', [PaymentController::class, 'getPendingData'])->name('api.payments.pending-data');
    Route::get('/api/payments/history-data', [PaymentController::class, 'getHistoryData'])->name('api.payments.history-data');
    Route::get('/api/payments/analytics-data', [PaymentController::class, 'getAnalyticsData'])->name('api.payments.analytics-data');
    Route::post('/api/payments/sync-igracias', [PaymentController::class, 'syncFromIgracias'])->name('api.payments.sync-igracias');
    Route::post('/api/payments/bulk-verify', [PaymentController::class, 'bulkVerify'])->name('api.payments.bulk-verify');
    Route::post('/api/payments/auto-reconcile', [PaymentController::class, 'autoReconcile'])->name('api.payments.auto-reconcile');
    Route::post('/payments/bulk-process', [PaymentController::class, 'bulkProcess'])->name('payments.bulk-process');
});

Route::middleware(['auth', 'user.permission:payments.edit'])->group(function () {
    Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
    Route::patch('/payments/{payment}', [PaymentController::class, 'update']);
    Route::post('/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{payment}/mark-failed', [PaymentController::class, 'markFailed'])->name('payments.mark-failed');
    Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');
});

Route::middleware(['auth', 'user.permission:payments.delete'])->group(function () {
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');
});

// Fees management - Admin and Finance only
Route::middleware(['auth', 'user.permission:fees.view'])->group(function () {
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index');
    Route::get('/fees/{fee}', [FeeController::class, 'show'])->name('fees.show');
    Route::get('/fees/{fee}/assign', [FeeController::class, 'showAssignForm'])->name('fees.assign-form');
});

Route::middleware(['auth', 'user.permission:fees.create'])->group(function () {
    Route::get('/fees/create', [FeeController::class, 'create'])->name('fees.create');
    Route::post('/fees', [FeeController::class, 'store'])->name('fees.store');
});

Route::middleware(['auth', 'user.permission:fees.edit'])->group(function () {
    Route::get('/fees/{fee}/edit', [FeeController::class, 'edit'])->name('fees.edit');
    Route::put('/fees/{fee}', [FeeController::class, 'update'])->name('fees.update');
    Route::patch('/fees/{fee}', [FeeController::class, 'update']);
    Route::post('/fees/{fee}/assign', [FeeController::class, 'assignToStudents'])->name('fees.assign');
    Route::delete('/fees/{fee}/students/{student}', [FeeController::class, 'removeFromStudent'])->name('fees.remove-from-student');
    Route::post('/fees/{fee}/activate', [FeeController::class, 'activate'])->name('fees.activate');
    Route::post('/fees/{fee}/deactivate', [FeeController::class, 'deactivate'])->name('fees.deactivate');
    Route::post('/fees/bulk-assign', [FeeController::class, 'bulkAssign'])->name('fees.bulk-assign');
});

Route::middleware(['auth', 'user.permission:fees.delete'])->group(function () {
    Route::delete('/fees/{fee}', [FeeController::class, 'destroy'])->name('fees.destroy');
});

// Scholarships management - Admin and Finance only
Route::middleware(['auth', 'user.permission:scholarships.view'])->group(function () {
    Route::get('/scholarships', [ScholarshipController::class, 'index'])->name('scholarships.index');
    Route::get('/scholarships/{scholarship}', [ScholarshipController::class, 'show'])->name('scholarships.show');
    Route::get('/scholarships-dashboard', [ScholarshipController::class, 'dashboard'])->name('scholarships.dashboard');
});

Route::middleware(['auth', 'user.permission:scholarships.create'])->group(function () {
    Route::get('/scholarships/create', [ScholarshipController::class, 'create'])->name('scholarships.create');
    Route::post('/scholarships', [ScholarshipController::class, 'store'])->name('scholarships.store');
});

Route::middleware(['auth', 'user.permission:scholarships.edit'])->group(function () {
    Route::get('/scholarships/{scholarship}/edit', [ScholarshipController::class, 'edit'])->name('scholarships.edit');
    Route::put('/scholarships/{scholarship}', [ScholarshipController::class, 'update'])->name('scholarships.update');
    Route::patch('/scholarships/{scholarship}', [ScholarshipController::class, 'update']);
    Route::post('/scholarships/{scholarship}/open', [ScholarshipController::class, 'open'])->name('scholarships.open');
    Route::post('/scholarships/{scholarship}/close', [ScholarshipController::class, 'close'])->name('scholarships.close');
    Route::post('/scholarships/{scholarship}/announce', [ScholarshipController::class, 'announce'])->name('scholarships.announce');
    Route::post('/scholarships/{scholarship}/apply', [ScholarshipController::class, 'apply'])->name('scholarships.apply');
    Route::post('/scholarships/applications/{application}/approve', [ScholarshipController::class, 'approveApplication'])->name('scholarships.applications.approve');
    Route::post('/scholarships/applications/{application}/reject', [ScholarshipController::class, 'rejectApplication'])->name('scholarships.applications.reject');
});

Route::middleware(['auth', 'user.permission:scholarships.delete'])->group(function () {
    Route::delete('/scholarships/{scholarship}', [ScholarshipController::class, 'destroy'])->name('scholarships.destroy');
});

// Reports management
Route::middleware(['auth', 'user.permission:reports.view'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports-monthly', [ReportController::class, 'monthly'])->name('reports.monthly');
    Route::get('/reports-financial', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('/reports-students', [ReportController::class, 'students'])->name('reports.students');
    Route::get('/tunggakan', [ReportController::class, 'tunggakan'])->name('tunggakan.index');
    Route::get('/collection-report', [ReportController::class, 'collectionReport'])->name('collection-report.index');
});

Route::middleware(['auth', 'user.permission:reports.export'])->group(function () {
    Route::get('/reports-export', [ReportController::class, 'export'])->name('reports.export');
    Route::post('/reports/export/process', [ReportController::class, 'processExport'])->name('reports.export.process');
    Route::post('/reports/{report}/generate', [ReportController::class, 'generate'])->name('reports.generate');
});

Route::middleware(['auth', 'user.permission:reports.create'])->group(function () {
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

Route::middleware(['auth', 'user.permission:reports.edit'])->group(function () {
    Route::get('/reports/{report}/edit', [ReportController::class, 'edit'])->name('reports.edit');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::patch('/reports/{report}', [ReportController::class, 'update']);
});

Route::middleware(['auth', 'user.permission:reports.delete'])->group(function () {
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
});

// Reminder routes - Admin and Finance only
Route::middleware(['auth', 'user.permission:reminders.view'])->group(function () {
    Route::get('/reminders/email', [NotificationController::class, 'email'])->name('reminders.email');
    Route::get('/reminders/whatsapp', [NotificationController::class, 'whatsapp'])->name('reminders.whatsapp');
    Route::get('/reminders/schedule', [NotificationController::class, 'schedule'])->name('reminders.schedule');
    Route::get('/reminders/templates', [NotificationController::class, 'templates'])->name('reminders.templates');
});

// Super Admin only routes
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/users/roles', [UsersController::class, 'roles'])->name('users.roles');
});

// Users management - Admin only
Route::middleware(['auth', 'user.permission:users.create'])->group(function () {
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
});

Route::middleware(['auth', 'user.permission:users.view'])->group(function () {
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
    Route::get('/users-approval', [UsersController::class, 'approval'])->name('users.approval');
    Route::get('/users-audit', [UsersController::class, 'audit'])->name('users.audit');
});

Route::middleware(['auth', 'user.permission:users.edit'])->group(function () {
    Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}', [UsersController::class, 'update']);
    Route::post('/users/approve/{user}', [UsersController::class, 'approve'])->name('users.approve');
    Route::post('/users/reject/{user}', [UsersController::class, 'reject'])->name('users.reject');
    Route::post('/users/toggle-status/{user}', [UsersController::class, 'toggleStatus'])->name('users.toggle-status');
});

Route::middleware(['auth', 'user.permission:users.delete'])->group(function () {
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
});

// Settings routes - Admin only
Route::middleware(['auth', 'user.permission:settings.view'])->group(function () {
    Route::get('/settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::get('/settings/integration', [SettingsController::class, 'integration'])->name('settings.integration');
    Route::get('/settings/backup', [SettingsController::class, 'backup'])->name('settings.backup');
});

// Sync routes - Admin only
Route::middleware(['auth', 'user.permission:sync.manage'])->group(function () {
    Route::get('/sync', [SyncController::class, 'index'])->name('sync.index');
    Route::get('/sync/dashboard', [SyncController::class, 'dashboard'])->name('sync.dashboard');
    Route::get('/sync/{syncLog}', [SyncController::class, 'show'])->name('sync.show');
    Route::post('/sync/start', [SyncController::class, 'startSync'])->name('sync.start');
    Route::post('/sync/stop/{syncLog}', [SyncController::class, 'stopSync'])->name('sync.stop');
    Route::get('/sync/status/{syncLog}', [SyncController::class, 'getStatus'])->name('sync.status');
    Route::post('/sync/test-connection', [SyncController::class, 'testConnection'])->name('sync.test-connection');
    Route::post('/sync/sync-student', [SyncController::class, 'syncStudent'])->name('sync.sync-student');
});

// API routes for students
Route::middleware(['auth', 'user.permission:students.view'])->group(function () {
    Route::get('/api/students', [StudentController::class, 'api'])->name('api.students');
});

// Follow Up management routes
Route::middleware(['auth'])->group(function () {
    Route::resource('followups', FollowUpController::class);
});

// Auth routes
require __DIR__.'/auth.php';

Route::prefix('dummy')->group(function () {
    Route::get('/students', [IGraciasDummyController::class, 'students']);
    Route::get('/students/{nim}', [IGraciasDummyController::class, 'studentDetail']);
    Route::get('/payments', [IGraciasDummyController::class, 'payments']);
    Route::get('/payments/{paymentId}', [IGraciasDummyController::class, 'paymentDetail']);
    Route::get('/receivables', [IGraciasDummyController::class, 'receivables']);
    Route::get('/receivables/{receivableId}', [IGraciasDummyController::class, 'receivableDetail']);
});
