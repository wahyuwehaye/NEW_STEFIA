<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Receivable;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['student', 'user']);
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_code', 'like', "%{$search}%")
                  ->orWhere('receipt_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%");
                  });
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }
        
        $payments = $query->latest()->paginate(15);
        
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $students = Student::active()->get();
        $selectedStudent = null;
        
        if ($request->filled('student_id')) {
            $selectedStudent = Student::findOrFail($request->student_id);
        }
        
        return view('payments.create', compact('students', 'selectedStudent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,debit_card,e_wallet,other',
            'payment_type' => 'required|in:tuition,registration,exam,library,laboratory,other',
            'reference_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'student_id' => $request->student_id,
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'payment_type' => $request->payment_type,
                'reference_number' => $request->reference_number,
                'description' => $request->description,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('payments.show', $payment->id)
                           ->with('success', 'Payment created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with(['student', 'user', 'verifiedBy'])->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::findOrFail($id);
        $students = Student::active()->get();
        
        // Only allow editing if payment is still pending
        if ($payment->status !== 'pending') {
            return redirect()->route('payments.show', $payment->id)
                           ->with('error', 'Cannot edit payment that is not pending');
        }
        
        return view('payments.edit', compact('payment', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);
        
        // Only allow editing if payment is still pending
        if ($payment->status !== 'pending') {
            return redirect()->route('payments.show', $payment->id)
                           ->with('error', 'Cannot edit payment that is not pending');
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,debit_card,e_wallet,other',
            'payment_type' => 'required|in:tuition,registration,exam,library,laboratory,other',
            'reference_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $payment->update($request->all());

        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Payment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        
        // Only allow deletion if payment is pending or failed
        if (!in_array($payment->status, ['pending', 'failed'])) {
            return redirect()->route('payments.show', $payment->id)
                           ->with('error', 'Cannot delete payment that is completed or cancelled');
        }
        
        $payment->delete();

        return redirect()->route('payments.index')
                         ->with('success', 'Payment deleted successfully');
    }

    /**
     * Display analytics for payments.
     */
    public function analytics()
    {
        // Get basic statistics
        $totalPayments = Payment::count();
        $totalAmount = Payment::where('status', 'completed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $completedPayments = Payment::where('status', 'completed')->count();
        
        // Get trend data for last 6 months
        $trendData = [
            'labels' => [],
            'completed' => [],
            'pending' => [],
            'failed' => []
        ];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $trendData['labels'][] = $date->format('M Y');
            
            $trendData['completed'][] = Payment::where('status', 'completed')
                ->whereYear('payment_date', $date->year)
                ->whereMonth('payment_date', $date->month)
                ->count();
                
            $trendData['pending'][] = Payment::where('status', 'pending')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
                
            $trendData['failed'][] = Payment::where('status', 'failed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }
        
        // Get payment method distribution
        $methodStats = [
            'labels' => ['Transfer Bank', 'Tunai', 'E-Wallet', 'Kartu Kredit', 'Kartu Debit', 'Lainnya'],
            'data' => [
                Payment::where('payment_method', 'bank_transfer')->count(),
                Payment::where('payment_method', 'cash')->count(),
                Payment::where('payment_method', 'e_wallet')->count(),
                Payment::where('payment_method', 'credit_card')->count(),
                Payment::where('payment_method', 'debit_card')->count(),
                Payment::where('payment_method', 'other')->count()
            ]
        ];
        
        // Get daily revenue for last 30 days
        $revenueData = [
            'labels' => [],
            'data' => []
        ];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenueData['labels'][] = $date->format('d/m');
            $revenueData['data'][] = Payment::where('status', 'completed')
                ->whereDate('payment_date', $date)
                ->sum('amount');
        }
        
        // Get status distribution
        $totalPaymentsForStatus = Payment::count();
        $statusData = [
            'labels' => ['Completed', 'Pending', 'Failed', 'Cancelled'],
            'data' => [
                $totalPaymentsForStatus > 0 ? round((Payment::where('status', 'completed')->count() / $totalPaymentsForStatus) * 100, 1) : 0,
                $totalPaymentsForStatus > 0 ? round((Payment::where('status', 'pending')->count() / $totalPaymentsForStatus) * 100, 1) : 0,
                $totalPaymentsForStatus > 0 ? round((Payment::where('status', 'failed')->count() / $totalPaymentsForStatus) * 100, 1) : 0,
                $totalPaymentsForStatus > 0 ? round((Payment::where('status', 'cancelled')->count() / $totalPaymentsForStatus) * 100, 1) : 0
            ]
        ];
        
        // Get top performing students
        $topStudents = Student::select('students.*')
            ->selectRaw('SUM(CASE WHEN payments.status = "completed" THEN payments.amount ELSE 0 END) as total_payments')
            ->selectRaw('COUNT(payments.id) as payment_count')
            ->selectRaw('AVG(CASE WHEN payments.status = "completed" THEN payments.amount ELSE NULL END) as avg_payment')
            ->leftJoin('payments', 'students.id', '=', 'payments.student_id')
            ->groupBy('students.id')
            ->having('total_payments', '>', 0)
            ->orderBy('total_payments', 'desc')
            ->limit(10)
            ->get();
        
        return view('payments.analytics', compact(
            'totalPayments', 
            'totalAmount', 
            'pendingPayments', 
            'completedPayments',
            'trendData',
            'methodStats',
            'revenueData', 
            'statusData',
            'topStudents'
        ));
    }

    /**
     * Display reconciliation data for payments.
     */
    public function reconciliation()
    {
        // Placeholder logic for generating reconciliation data
        $reconciliationData = [];

        // TODO: Implement actual reconciliation logic

        return view('payments.reconciliation', compact('reconciliationData'));
    }

    /**
     * Display a listing of payments by student.
     */
    public function byStudent(Request $request)
    {
        // Get all students for dropdown
        $students = Student::orderBy('name')->get();
        
        $selectedStudent = null;
        $payments = collect();
        
        // If student_id is provided in request
        if ($request->filled('student_id')) {
            $selectedStudent = Student::find($request->student_id);
            
            if ($selectedStudent) {
                // Get payments for this student
                $payments = Payment::where('student_id', $selectedStudent->id)
                                 ->with(['student', 'user'])
                                 ->latest()
                                 ->paginate(15);
                
                // Calculate totals for the student
                $selectedStudent->total_receivables = $selectedStudent->receivables()->sum('amount');
                $selectedStudent->total_payments = $selectedStudent->payments()->where('status', 'completed')->sum('amount');
            }
        }
        
        return view('payments.by-student', compact('students', 'selectedStudent', 'payments'));
    }

    /**
     * Display a listing of payments by method.
     */
    public function byMethod(Request $request)
    {
        $query = Payment::with(['student', 'user']);
        
        // Filter by payment method if specified
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        $payments = $query->latest()->paginate(15);
        
        // Calculate payment method statistics
        $paymentMethodStats = [];
        $totalPayments = Payment::count();
        
        $methods = ['cash', 'bank_transfer', 'credit_card', 'debit_card', 'e_wallet', 'other'];
        
        foreach ($methods as $method) {
            $count = Payment::where('payment_method', $method)->count();
            $total = Payment::where('payment_method', $method)->sum('amount');
            $percentage = $totalPayments > 0 ? ($count / $totalPayments) * 100 : 0;
            
            if ($count > 0) {
                $paymentMethodStats[$method] = [
                    'count' => $count,
                    'total' => $total,
                    'percentage' => $percentage
                ];
            }
        }
        
        return view('payments.by-method', compact('payments', 'paymentMethodStats'));
    }

    /**
     * Display a report view for payments.
     */
    public function reports(Request $request)
    {
        // Date filtering
        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date) : Carbon::now()->endOfMonth();
        
        // Base query with date range
        $paymentsQuery = Payment::whereBetween('payment_date', [$startDate, $endDate]);
        
        // Summary statistics
        $totalAmount = $paymentsQuery->sum('amount');
        $totalCount = $paymentsQuery->count();
        $completedAmount = $paymentsQuery->where('status', 'completed')->sum('amount');
        $completedCount = $paymentsQuery->where('status', 'completed')->count();
        $pendingAmount = $paymentsQuery->where('status', 'pending')->sum('amount');
        $pendingCount = $paymentsQuery->where('status', 'pending')->count();
        
        // Payment method breakdown
        $paymentMethods = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('payment_method, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_method')
            ->get();
        
        // Payment type breakdown
        $paymentTypes = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('payment_type, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('payment_type')
            ->get();
        
        // Status breakdown
        $statusBreakdown = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('status')
            ->get();
        
        // Daily trend data (last 30 days)
        $dailyTrend = Payment::whereBetween('payment_date', [Carbon::now()->subDays(30), Carbon::now()])
            ->selectRaw('DATE(payment_date) as date, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Top paying students in period
        $topStudents = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->with('student')
            ->selectRaw('student_id, SUM(amount) as total_amount, COUNT(*) as payment_count')
            ->groupBy('student_id')
            ->orderByDesc('total_amount')
            ->take(10)
            ->get();
        
        // Recent payments for the table
        $recentPayments = Payment::with(['student', 'user'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->latest('payment_date')
            ->take(50)
            ->get();
        
        $reportData = [
            'summary' => [
                'total_amount' => $totalAmount,
                'total_count' => $totalCount,
                'completed_amount' => $completedAmount,
                'completed_count' => $completedCount,
                'pending_amount' => $pendingAmount,
                'pending_count' => $pendingCount,
                'average_payment' => $totalCount > 0 ? $totalAmount / $totalCount : 0,
            ],
            'payment_methods' => $paymentMethods,
            'payment_types' => $paymentTypes,
            'status_breakdown' => $statusBreakdown,
            'daily_trend' => $dailyTrend,
            'top_students' => $topStudents,
        ];
        
        return view('payments.reports', compact('reportData', 'recentPayments', 'startDate', 'endDate'));
    }

    /**
     * Verify/Complete a payment
     */
    public function verify(string $id)
    {
        $payment = Payment::findOrFail($id);
        
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Payment is not pending verification');
        }
        
        DB::beginTransaction();
        try {
            $payment->markAsCompleted(Auth::user());
            DB::commit();
            
            return redirect()->route('payments.show', $payment->id)
                           ->with('success', 'Payment verified successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to verify payment: ' . $e->getMessage());
        }
    }

    /**
     * Mark payment as failed
     */
    public function markFailed(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);
        
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Payment is not pending');
        }
        
        $payment->markAsFailed($request->reason);
        
        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Payment marked as failed');
    }

    /**
     * Cancel a payment
     */
    public function cancel(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);
        
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'Payment is not pending');
        }
        
        $payment->cancel($request->reason);
        
        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Payment cancelled successfully');
    }

    /**
     * Generate receipt for a payment
     */
    public function receipt(string $id)
    {
        $payment = Payment::with(['student', 'user'])->findOrFail($id);
        
        if ($payment->status !== 'completed') {
            return redirect()->back()->with('error', 'Cannot generate receipt for incomplete payment');
        }
        
        return view('payments.receipt', compact('payment'));
    }

    /**
     * Dashboard statistics
     */
    public function dashboard()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();
        
        $stats = [
            'today' => [
                'amount' => Payment::completed()->whereDate('payment_date', $today)->sum('amount'),
                'count' => Payment::completed()->whereDate('payment_date', $today)->count(),
            ],
            'month' => [
                'amount' => Payment::completed()->where('payment_date', '>=', $thisMonth)->sum('amount'),
                'count' => Payment::completed()->where('payment_date', '>=', $thisMonth)->count(),
            ],
            'year' => [
                'amount' => Payment::completed()->where('payment_date', '>=', $thisYear)->sum('amount'),
                'count' => Payment::completed()->where('payment_date', '>=', $thisYear)->count(),
            ],
            'pending' => Payment::pending()->count(),
        ];
        
        $recentPayments = Payment::with(['student', 'user'])
                                ->completed()
                                ->latest()
                                ->take(10)
                                ->get();
        
        return view('payments.dashboard', compact('stats', 'recentPayments'));
    }

    /**
     * Show export page with filters and options
     */
    public function export(Request $request)
    {
        // If this is a download request, perform the export
        if ($request->has('download') && $request->download == 'true') {
            return $this->performExport($request);
        }
        
        // Otherwise, show the export page
        $students = Student::orderBy('name')->get();
        
        // Get export statistics
        $stats = [
            'total_payments' => Payment::count(),
            'total_completed' => Payment::where('status', 'completed')->count(),
            'total_pending' => Payment::where('status', 'pending')->count(),
            'total_amount' => Payment::where('status', 'completed')->sum('amount'),
            'last_export' => now()->subDays(rand(1, 30)), // Placeholder
        ];
        
        // Payment methods for filter
        $paymentMethods = [
            'cash' => 'Cash',
            'bank_transfer' => 'Bank Transfer',
            'credit_card' => 'Credit Card',
            'debit_card' => 'Debit Card',
            'e_wallet' => 'E-Wallet',
            'other' => 'Other'
        ];
        
        // Payment types for filter
        $paymentTypes = [
            'tuition' => 'Tuition',
            'registration' => 'Registration',
            'exam' => 'Exam Fee',
            'library' => 'Library Fee',
            'laboratory' => 'Laboratory Fee',
            'other' => 'Other'
        ];
        
        return view('payments.export', compact('students', 'stats', 'paymentMethods', 'paymentTypes'));
    }
    
    /**
     * Perform the actual export
     */
    private function performExport(Request $request)
    {
        $filters = [];
        
        // Build filters array from request
        if ($request->filled('status')) {
            $filters['status'] = $request->status;
        }
        
        if ($request->filled('payment_method')) {
            $filters['payment_method'] = $request->payment_method;
        }
        
        if ($request->filled('payment_type')) {
            $filters['payment_type'] = $request->payment_type;
        }
        
        if ($request->filled('date_from')) {
            $filters['date_from'] = $request->date_from;
        }
        
        if ($request->filled('date_to')) {
            $filters['date_to'] = $request->date_to;
        }
        
        if ($request->filled('student_id')) {
            $filters['student_id'] = $request->student_id;
        }
        
        $format = $request->input('format', 'xlsx');
        $filename = 'payments_' . now()->format('Y-m-d_H-i-s') . '.' . $format;
        
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PaymentsExport($filters), 
            $filename
        );
    }

    /**
     * Payment verification page
     */
    public function verification(Request $request)
    {
        $query = Payment::with(['student', 'user'])
                       ->where('status', 'pending')
                       ->orderBy('payment_date', 'asc');

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_code', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }

        $pendingPayments = $query->paginate(15);
        
        // Statistics for verification
        $stats = [
            'total_pending' => Payment::pending()->count(),
            'total_amount_pending' => Payment::pending()->sum('amount'),
            'today_pending' => Payment::pending()->whereDate('created_at', today())->count(),
            'overdue_pending' => Payment::pending()
                                       ->where('payment_date', '<', now()->subDays(3))
                                       ->count()
        ];

        return view('payments.verification', compact('pendingPayments', 'stats'));
    }

    /**
     * iGracias integration page
     */
    public function integration()
    {
        // Get integration statistics
        $stats = [
            'total_synced' => Payment::where('source', 'igracias')->count(),
            'last_sync' => Payment::where('source', 'igracias')->latest()->first()?->created_at,
            'pending_sync' => $this->getPendingIgraciasPayments(),
            'sync_errors' => $this->getRecentSyncErrors(),
        ];

        $recentSyncs = Payment::where('source', 'igracias')
                             ->with(['student'])
                             ->latest()
                             ->take(10)
                             ->get();

        return view('payments.integration', compact('stats', 'recentSyncs'));
    }

    /**
     * Sync payments from iGracias API
     */
    public function syncFromIgracias(Request $request)
    {
        DB::beginTransaction();
        try {
            $syncResults = $this->performIgraciasSync($request->all());
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Sync completed successfully',
                'results' => $syncResults
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('iGracias sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get DataTables data for payments
     */
    public function getData(Request $request)
    {
        $query = Payment::with(['student', 'user', 'verifiedBy'])
                       ->select('payments.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($payment) {
                return $payment->student ? $payment->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($payment) {
                return $payment->student ? $payment->student->nim : 'N/A';
            })
            ->addColumn('formatted_amount', function ($payment) {
                return $payment->formatted_amount;
            })
            ->addColumn('payment_method_label', function ($payment) {
                return $payment->payment_method_label;
            })
            ->addColumn('status_badge', function ($payment) {
                $statusClass = [
                    'pending' => 'warning',
                    'completed' => 'success', 
                    'failed' => 'danger',
                    'cancelled' => 'secondary'
                ][$payment->status] ?? 'secondary';
                
                return '<span class="badge badge-' . $statusClass . '">' . $payment->status_label . '</span>';
            })
            ->addColumn('formatted_date', function ($payment) {
                return $payment->payment_date->format('d/m/Y');
            })
            ->addColumn('action', function ($payment) {
                $actions = '<div class="btn-group" role="group">';
                $actions .= '<a href="' . route('payments.show', $payment->id) . '" class="btn btn-sm btn-outline-info" title="View"><i class="ni ni-eye"></i></a>';
                
                if ($payment->status === 'pending') {
                    $actions .= '<a href="' . route('payments.edit', $payment->id) . '" class="btn btn-sm btn-outline-primary" title="Edit"><i class="ni ni-edit"></i></a>';
                    $actions .= '<button class="btn btn-sm btn-outline-success" onclick="verifyPayment(' . $payment->id . ')" title="Verify"><i class="ni ni-check"></i></button>';
                }
                
                if ($payment->status === 'completed') {
                    $actions .= '<a href="' . route('payments.receipt', $payment->id) . '" class="btn btn-sm btn-outline-secondary" title="Receipt"><i class="ni ni-printer"></i></a>';
                }
                
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * Bulk verify payments
     */
    public function bulkVerify(Request $request)
    {
        $paymentIds = $request->input('payment_ids', []);
        
        if (empty($paymentIds)) {
            return response()->json([
                'success' => false,
                'message' => 'No payments selected'
            ]);
        }

        $verifiedCount = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($paymentIds as $paymentId) {
                $payment = Payment::find($paymentId);
                if ($payment && $payment->status === 'pending') {
                    if ($payment->markAsCompleted(Auth::user())) {
                        $verifiedCount++;
                    } else {
                        $errors[] = "Failed to verify payment {$payment->payment_code}";
                    }
                }
            }

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => "{$verifiedCount} payments verified successfully",
                'verified_count' => $verifiedCount,
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Bulk verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Auto-reconcile payments with receivables
     */
    public function autoReconcile(Request $request)
    {
        $studentId = $request->input('student_id');
        
        if (!$studentId) {
            return response()->json([
                'success' => false,
                'message' => 'Student ID is required'
            ]);
        }

        try {
            $results = $this->performAutoReconciliation($studentId);
            
            return response()->json([
                'success' => true,
                'message' => 'Auto-reconciliation completed',
                'results' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Auto-reconciliation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper methods for iGracias integration
     */
    private function getPendingIgraciasPayments()
    {
        // This would typically call iGracias API to get pending payments
        // For now, returning a placeholder count
        return 0;
    }

    private function getRecentSyncErrors()
    {
        // Return recent sync error logs
        return [];
    }

    private function performIgraciasSync(array $params = [])
    {
        // Implementation for syncing with iGracias API
        // This would:
        // 1. Call iGracias API to get payment data
        // 2. Process and validate the data
        // 3. Create/update Payment records
        // 4. Update related receivables
        
        $results = [
            'new_payments' => 0,
            'updated_payments' => 0,
            'errors' => []
        ];

        // Placeholder implementation
        // In real implementation, you would:
        // $response = Http::get('https://api.igracias.telkomuniversity.ac.id/payments');
        // Process the response and create/update payments
        
        return $results;
    }

    private function performAutoReconciliation(int $studentId)
    {
        $student = Student::findOrFail($studentId);
        $pendingPayments = $student->payments()->where('status', 'pending')->get();
        $outstandingReceivables = $student->receivables()->where('status', '!=', 'paid')->get();

        $reconciledCount = 0;
        $totalReconciled = 0;

        foreach ($pendingPayments as $payment) {
            foreach ($outstandingReceivables as $receivable) {
                if ($receivable->outstanding_amount > 0 && $payment->amount > 0) {
                    $amountToApply = min($payment->amount, $receivable->outstanding_amount);
                    
                    // Apply payment to receivable
                    $receivable->paid_amount += $amountToApply;
                    $receivable->outstanding_amount -= $amountToApply;
                    
                    if ($receivable->outstanding_amount <= 0) {
                        $receivable->status = 'paid';
                    } else {
                        $receivable->status = 'partial';
                    }
                    
                    $receivable->save();
                    $payment->amount -= $amountToApply;
                    $totalReconciled += $amountToApply;
                    $reconciledCount++;
                    
                    if ($payment->amount <= 0) {
                        break;
                    }
                }
            }
        }

        return [
            'reconciled_count' => $reconciledCount,
            'total_amount' => $totalReconciled
        ];
    }

    /**
     * Bulk operations for payments.
     */
    public function bulkOperations()
    {
        return view('payments.bulk-operations');
    }

    /**
     * Get pending payments data for DataTables.
     */
    public function getPendingData(Request $request)
    {
        $query = Payment::with(['student', 'user'])
                       ->where('status', 'pending')
                       ->select('payments.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($payment) {
                return $payment->student ? $payment->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($payment) {
                return $payment->student ? $payment->student->nim : 'N/A';
            })
            ->addColumn('formatted_amount', function ($payment) {
                return $payment->formatted_amount;
            })
            ->addColumn('payment_method_label', function ($payment) {
                return $payment->payment_method_label;
            })
            ->addColumn('formatted_date', function ($payment) {
                return $payment->payment_date->format('d/m/Y');
            })
            ->addColumn('action', function ($payment) {
                $actions = '<div class="btn-group" role="group">';
                $actions .= '<a href="' . route('payments.show', $payment->id) . '" class="btn btn-sm btn-outline-info" title="View"><i class="ni ni-eye"></i></a>';
                $actions .= '<a href="' . route('payments.edit', $payment->id) . '" class="btn btn-sm btn-outline-primary" title="Edit"><i class="ni ni-edit"></i></a>';
                $actions .= '<button class="btn btn-sm btn-outline-success" onclick="verifyPayment(' . $payment->id . ')" title="Verify"><i class="ni ni-check"></i></button>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Get history payments data for DataTables.
     */
    public function getHistoryData(Request $request)
    {
        $query = Payment::with(['student', 'user', 'verifiedBy'])
                       ->whereIn('status', ['completed', 'failed', 'cancelled'])
                       ->select('payments.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($payment) {
                return $payment->student ? $payment->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($payment) {
                return $payment->student ? $payment->student->nim : 'N/A';
            })
            ->addColumn('formatted_amount', function ($payment) {
                return $payment->formatted_amount;
            })
            ->addColumn('payment_method_label', function ($payment) {
                return $payment->payment_method_label;
            })
            ->addColumn('status_badge', function ($payment) {
                $statusClass = [
                    'pending' => 'warning',
                    'completed' => 'success', 
                    'failed' => 'danger',
                    'cancelled' => 'secondary'
                ][$payment->status] ?? 'secondary';
                
                return '<span class="badge badge-' . $statusClass . '">' . $payment->status_label . '</span>';
            })
            ->addColumn('formatted_date', function ($payment) {
                return $payment->payment_date->format('d/m/Y');
            })
            ->addColumn('action', function ($payment) {
                $actions = '<div class="btn-group" role="group">';
                $actions .= '<a href="' . route('payments.show', $payment->id) . '" class="btn btn-sm btn-outline-info" title="View"><i class="ni ni-eye"></i></a>';
                
                if ($payment->status === 'completed') {
                    $actions .= '<a href="' . route('payments.receipt', $payment->id) . '" class="btn btn-sm btn-outline-secondary" title="Receipt"><i class="ni ni-printer"></i></a>';
                }
                
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * Get analytics data for DataTables.
     */
    public function getAnalyticsData(Request $request)
    {
        // Implementation for analytics data API endpoint
        $analyticsData = [];
        
        // TODO: Implement actual analytics data logic
        
        return response()->json($analyticsData);
    }
}
