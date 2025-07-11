<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\ReceivablesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\TunggakanController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CollectionReportController;
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
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/import', [StudentsController::class, 'import'])->name('import');
        Route::post('/import', [StudentsController::class, 'processImport'])->name('process-import');
        Route::get('/integration', [StudentsController::class, 'integration'])->name('integration');
    });

    // Receivables management
    Route::resource('receivables', ReceivablesController::class);
    Route::prefix('receivables')->name('receivables.')->group(function () {
        Route::get('/outstanding', [ReceivablesController::class, 'outstanding'])->name('outstanding');
        Route::get('/history', [ReceivablesController::class, 'history'])->name('history');
        Route::post('/bulk-update', [ReceivablesController::class, 'bulkUpdate'])->name('bulk-update');
    });

    // Payments management
    Route::resource('payments', PaymentsController::class);
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/pending', [PaymentsController::class, 'pending'])->name('pending');
        Route::get('/history', [PaymentsController::class, 'history'])->name('history');
        Route::get('/verification', [PaymentsController::class, 'verification'])->name('verification');
        Route::get('/integration', [PaymentsController::class, 'integration'])->name('integration');
        Route::post('/verify/{payment}', [PaymentsController::class, 'verify'])->name('verify');
        Route::post('/sync-igracias', [PaymentsController::class, 'syncIgracias'])->name('sync-igracias');
    });

    // Tunggakan routes
    Route::prefix('tunggakan')->name('tunggakan.')->group(function () {
        Route::get('/', [TunggakanController::class, 'index'])->name('index');
        Route::get('/actions', [TunggakanController::class, 'actions'])->name('actions');
        Route::get('/export', [TunggakanController::class, 'export'])->name('export');
        Route::get('/export-pdf', [TunggakanController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export-excel', [TunggakanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/actions/create', [TunggakanController::class, 'createAction'])->name('actions.create');
        Route::post('/actions', [TunggakanController::class, 'storeAction'])->name('actions.store');
        Route::post('/update-status/{id}', [TunggakanController::class, 'updateStatus'])->name('update.status');
    });

    // Collection Report routes
    Route::prefix('collection-report')->name('collection-report.')->group(function () {
        Route::get('/', [CollectionReportController::class, 'index'])->name('index');
        Route::get('/export', [CollectionReportController::class, 'export'])->name('export');
        Route::post('/actions/{student}', [CollectionReportController::class, 'storeAction'])->name('actions.store');
        Route::get('/actions/{student}/edit', [CollectionReportController::class, 'editAction'])->name('actions.edit');
        Route::put('/actions/{student}', [CollectionReportController::class, 'updateAction'])->name('actions.update');
    });

    // Reports routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/monthly', [ReportsController::class, 'monthly'])->name('monthly');
        Route::get('/financial', [ReportsController::class, 'financial'])->name('financial');
        Route::get('/students', [ReportsController::class, 'students'])->name('students');
        Route::get('/export', [ReportsController::class, 'export'])->name('export');
    });

    // Reminder routes
    Route::prefix('reminders')->name('reminders.')->group(function () {
        Route::get('/email', [ReminderController::class, 'email'])->name('email');
        Route::get('/whatsapp', [ReminderController::class, 'whatsapp'])->name('whatsapp');
        Route::get('/schedule', [ReminderController::class, 'schedule'])->name('schedule');
        Route::get('/templates', [ReminderController::class, 'templates'])->name('templates');
    });

    // Users management
    Route::resource('users', UsersController::class);
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/pending', [UsersController::class, 'pending'])->name('pending');
        Route::get('/logs', [UsersController::class, 'logs'])->name('logs');
        Route::get('/roles', [UsersController::class, 'roles'])->name('roles');
        Route::get('/approval', [UsersController::class, 'approval'])->name('approval');
        Route::get('/audit', [UsersController::class, 'audit'])->name('audit');
        Route::post('/approve/{user}', [UsersController::class, 'approve'])->name('approve');
        Route::post('/reject/{user}', [UsersController::class, 'reject'])->name('reject');
    });

    // Settings routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', [SettingsController::class, 'general'])->name('general');
        Route::get('/integration', [SettingsController::class, 'integration'])->name('integration');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
    });
});

// Auth routes
require __DIR__.'/auth.php';
