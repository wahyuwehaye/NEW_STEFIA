<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BasicStudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Session management
Route::middleware(['auth:sanctum'])->post('/extend-session', function (Request $request) {
    // Update session activity
    $request->session()->put('last_activity', time());
    
    return response()->json([
        'success' => true,
        'message' => 'Session extended successfully',
        'expires_at' => now()->addMinutes(config('session.lifetime'))->toISOString()
    ]);
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString()
    ]);
});

// API v1 routes
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    
    // Students API
    Route::apiResource('students', BasicStudentController::class)->names([
        'index' => 'api.students.index',
        'store' => 'api.students.store',
        'show' => 'api.students.show',
        'update' => 'api.students.update',
        'destroy' => 'api.students.destroy',
    ]);
    
    // Dashboard statistics
    Route::get('/dashboard/statistics', function () {
        return response()->json([
            'data' => [
                'total_students' => \App\Models\Student::count(),
                'total_payments' => \App\Models\Payment::count(),
                'total_receivables' => \App\Models\Receivable::count(),
                'active_receivables' => \App\Models\Receivable::where('status', 'active')->count(),
                'completed_payments' => \App\Models\Payment::where('status', 'completed')->count(),
                'monthly_revenue' => \App\Models\Payment::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('amount'),
                'collection_rate' => 85.5,
            ]
        ]);
    });
});
