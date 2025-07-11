<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\FinancialsController;
use App\Http\Controllers\ScholarshipsController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReminderController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Dashboard - protected by authentication
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Students management routes
    Route::resource('students', StudentsController::class);
    
    // Financial routes
    Route::prefix('financials')->name('financials.')->group(function () {
        Route::get('/transactions', [FinancialsController::class, 'transactions'])->name('transactions');
        Route::get('/payments', [FinancialsController::class, 'payments'])->name('payments');
        Route::get('/reports', [FinancialsController::class, 'reports'])->name('reports');
    });
    
    // Scholarship routes
    Route::prefix('scholarships')->name('scholarships.')->group(function () {
        Route::get('/', [ScholarshipsController::class, 'index'])->name('index');
        Route::get('/applications', [ScholarshipsController::class, 'applications'])->name('applications');
    });
    
    // Fee management routes
    Route::prefix('fees')->name('fees.')->group(function () {
        Route::get('/structure', [FeesController::class, 'structure'])->name('structure');
        Route::get('/collection', [FeesController::class, 'collection'])->name('collection');
        Route::get('/outstanding', [FeesController::class, 'outstanding'])->name('outstanding');
    });
    
    // Reports routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/financial', [ReportsController::class, 'financial'])->name('financial');
        Route::get('/students', [ReportsController::class, 'students'])->name('students');
        Route::get('/scholarship', [ReportsController::class, 'scholarship'])->name('scholarship');
    });
    
    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::get('/users', [SettingsController::class, 'users'])->name('users');
        Route::get('/permissions', [SettingsController::class, 'permissions'])->name('permissions');
    });
    
    // Notification routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [NotificationController::class, 'bulkDelete'])->name('bulk-delete');
        Route::get('/api/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
        Route::get('/api/recent', [NotificationController::class, 'getRecent'])->name('recent');
    });
    
    // Reminder routes
    Route::prefix('reminders')->name('reminders.')->group(function () {
        Route::get('/', [ReminderController::class, 'index'])->name('index');
        Route::get('/create', [ReminderController::class, 'create'])->name('create');
        Route::post('/', [ReminderController::class, 'store'])->name('store');
        Route::post('/payment-reminders', [ReminderController::class, 'sendPaymentReminders'])->name('payment-reminders');
        Route::post('/overdue-notices', [ReminderController::class, 'sendOverdueNotices'])->name('overdue-notices');
        Route::post('/system-alert', [ReminderController::class, 'sendSystemAlert'])->name('system-alert');
        Route::post('/process-scheduled', [ReminderController::class, 'processScheduled'])->name('process-scheduled');
        Route::post('/retry-failed', [ReminderController::class, 'retryFailed'])->name('retry-failed');
        Route::get('/statistics', [ReminderController::class, 'statistics'])->name('statistics');
        Route::get('/templates', [ReminderController::class, 'templates'])->name('templates');
    });
});

// Auth routes
require __DIR__.'/auth.php';
