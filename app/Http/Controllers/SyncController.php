<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SyncLog;
use App\Services\IGraciasApiService;
use Illuminate\Support\Facades\Artisan;

class SyncController extends Controller
{
    public function index()
    {
        $syncLogs = SyncLog::latest()->paginate(20);
        
        return view('sync.index', compact('syncLogs'));
    }
    
    public function show(SyncLog $syncLog)
    {
        return view('sync.show', compact('syncLog'));
    }
    
    public function startSync(Request $request)
    {
        $request->validate([
            'sync_type' => 'required|in:students,receivables,payments,all',
            'batch_size' => 'nullable|integer|min:1|max:1000',
        ]);
        
        $syncType = $request->sync_type;
        $batchSize = $request->batch_size ?? 100;
        
        // Start sync process in background
        Artisan::queue('sync:' . $syncType, [
            '--batch-size' => $batchSize
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Synchronization started in background',
            'sync_type' => $syncType
        ]);
    }
    
    public function stopSync(SyncLog $syncLog)
    {
        if ($syncLog->status === 'processing') {
            $syncLog->update([
                'status' => 'cancelled',
                'completed_at' => now(),
                'notes' => 'Cancelled by user'
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Synchronization cancelled'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Cannot cancel sync - not in processing state'
        ]);
    }
    
    public function getStatus(SyncLog $syncLog)
    {
        return response()->json([
            'sync_id' => $syncLog->sync_id,
            'status' => $syncLog->status,
            'progress' => $syncLog->progress_percentage,
            'total_records' => $syncLog->total_records,
            'processed_records' => $syncLog->processed_records,
            'failed_records' => $syncLog->failed_records,
            'duration' => $syncLog->duration,
            'started_at' => $syncLog->started_at,
            'completed_at' => $syncLog->completed_at,
            'errors' => $syncLog->errors
        ]);
    }
    
    public function dashboard()
    {
        $recentSyncs = SyncLog::latest()->take(10)->get();
        $stats = [
            'total_syncs' => SyncLog::count(),
            'successful_syncs' => SyncLog::completed()->count(),
            'failed_syncs' => SyncLog::failed()->count(),
            'processing_syncs' => SyncLog::processing()->count(),
        ];
        
        return view('sync.dashboard', compact('recentSyncs', 'stats'));
    }
    
    public function testConnection()
    {
        try {
            $service = new IGraciasApiService();
            $response = $service->getStudents(['per_page' => 1]);
            
            return response()->json([
                'success' => true,
                'message' => 'Connection successful',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ]);
        }
    }
    
    public function syncStudent(Request $request)
    {
        $request->validate([
            'nim' => 'required|string'
        ]);
        
        try {
            $service = new IGraciasApiService();
            $result = $service->syncStudent($request->nim);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Student synchronized successfully',
                    'student' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to sync student'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ]);
        }
    }
}
