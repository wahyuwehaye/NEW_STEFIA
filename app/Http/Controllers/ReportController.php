<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Debt;
use App\Models\FollowUp;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display laporan tunggakan > 10 juta
     */
    public function tunggakan(Request $request)
    {
        $query = Student::query()
            ->with(['debts' => function($query) {
                $query->where('status', '!=', 'paid')
                      ->orderBy('due_date', 'desc');
            }, 'followUps' => function($query) {
                $query->orderBy('action_date', 'desc');
            }, 'academicYear', 'major'])
            ->where('outstanding_amount', '>', 10000000);

        // Filter berdasarkan request
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program_study')) {
            $query->where('program_study', $request->get('program_study'));
        }

        if ($request->filled('class')) {
            $query->where('class', $request->get('class'));
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->get('academic_year'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'outstanding_amount');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $students = $query->paginate(15)->withQueryString();

        // Statistik
        $stats = $this->getTunggakanStats();

        // Data untuk filter dropdown
        $programStudies = Student::distinct()->pluck('program_study')->filter()->sort();
        $classes = Student::distinct()->pluck('class')->filter()->sort();
        $academicYears = Student::distinct()->pluck('academic_year')->filter()->sort();

        return view('reports.tunggakan', compact(
            'students', 
            'stats', 
            'programStudies', 
            'classes', 
            'academicYears'
        ));
    }

    /**
     * Get statistical data for tunggakan report
     */
    private function getTunggakanStats()
    {
        // Total mahasiswa dengan tunggakan > 10 juta
        $totalStudents = Student::where('outstanding_amount', '>', 10000000)->count();

        // Total nilai tunggakan
        $totalOutstanding = Student::where('outstanding_amount', '>', 10000000)
            ->sum('outstanding_amount');

        // Get student IDs with outstanding amount > 10M for follow up stats
        $studentIds = Student::where('outstanding_amount', '>', 10000000)->pluck('id')->toArray();

        // Berdasarkan tindakan follow up
        $followUpStats = [
            'nde_fakultas' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'nde_fakultas')->count(),
            
            'dosen_wali' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'dosen_wali')->count(),
            
            'surat_orangtua' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'surat_orangtua')->count(),
            
            'telepon' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'telepon')->count(),
            
            'home_visit' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'home_visit')->count(),
        ];

        // Status tindakan terbaru
        $actionStats = FollowUp::whereIn('student_id', $studentIds)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return [
            'total_students' => $totalStudents,
            'total_outstanding' => $totalOutstanding,
            'follow_up_stats' => $followUpStats,
            'action_stats' => $actionStats,
        ];
    }

    /**
     * Export tunggakan data to Excel/PDF
     */
    public function exportTunggakan(Request $request)
    {
        // Implementation for export functionality
        // This can be implemented based on requirements
    }

    /**
     * Display laporan penagihan piutang
     */
    public function collectionReport(Request $request)
    {
        $query = Student::query()
            ->with([
                'debts' => function($query) {
                    $query->where('status', '!=', 'paid')
                          ->orderBy('due_date', 'desc');
                }, 
                'followUps' => function($query) {
                    $query->orderBy('action_date', 'desc')
                          ->with('performedBy');
                },
                'academicYear', 
                'major'
            ])
            ->where('outstanding_amount', '>', 10000000);

        // Filter berdasarkan request
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('faculty')) {
            $query->where('faculty', $request->get('faculty'));
        }

        if ($request->filled('program_study')) {
            $query->where('program_study', $request->get('program_study'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('semester_menunggak')) {
            $query->where('semester_menunggak', '>=', $request->get('semester_menunggak'));
        }

        if ($request->filled('action_type')) {
            $actionType = $request->get('action_type');
            $query->whereHas('followUps', function($q) use ($actionType) {
                $q->where('action_type', $actionType);
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'outstanding_amount');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $students = $query->paginate(20)->withQueryString();

        // Collection Statistics
        $collectionStats = $this->getCollectionStats();

        // Data untuk filter dropdown
        $faculties = Student::distinct()->pluck('faculty')->filter()->sort();
        $programStudies = Student::distinct()->pluck('program_study')->filter()->sort();
        $studentStatuses = Student::distinct()->pluck('status')->filter()->sort();

        return view('reports.collection-report', compact(
            'students',
            'collectionStats',
            'faculties',
            'programStudies',
            'studentStatuses'
        ));
    }

    /**
     * Get collection statistics
     */
    private function getCollectionStats()
    {
        // Base query for students with outstanding > 10M
        $baseQuery = Student::where('outstanding_amount', '>', 10000000);
        $studentIds = $baseQuery->pluck('id')->toArray();

        // Total collection metrics
        $totalStudents = count($studentIds);
        $totalOutstanding = $baseQuery->sum('outstanding_amount');
        $averageOutstanding = $totalStudents > 0 ? $totalOutstanding / $totalStudents : 0;

        // Collection actions performed
        $actionStats = [
            'nde_fakultas' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'nde_fakultas')->count(),
            'dosen_wali' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'dosen_wali')->count(),
            'surat_orangtua' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'surat_orangtua')->count(),
            'telepon' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'telepon')->count(),
            'home_visit' => FollowUp::whereIn('student_id', $studentIds)
                ->where('action_type', 'home_visit')->count(),
        ];

        // Follow-up status distribution
        $followUpStatus = FollowUp::whereIn('student_id', $studentIds)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Students by semester menunggak
        $semesterStats = Student::where('outstanding_amount', '>', 10000000)
            ->select('semester_menunggak', DB::raw('count(*) as total'))
            ->groupBy('semester_menunggak')
            ->pluck('total', 'semester_menunggak')
            ->toArray();

        // Collection performance metrics
        $performanceMetrics = [
            'students_with_followup' => FollowUp::whereIn('student_id', $studentIds)
                ->distinct('student_id')->count('student_id'),
            'students_without_followup' => $totalStudents - FollowUp::whereIn('student_id', $studentIds)
                ->distinct('student_id')->count('student_id'),
            'completed_actions' => FollowUp::whereIn('student_id', $studentIds)
                ->where('status', 'completed')->count(),
            'pending_actions' => FollowUp::whereIn('student_id', $studentIds)
                ->where('status', 'pending')->count(),
        ];

        return [
            'total_students' => $totalStudents,
            'total_outstanding' => $totalOutstanding,
            'average_outstanding' => $averageOutstanding,
            'action_stats' => $actionStats,
            'followup_status' => $followUpStatus,
            'semester_stats' => $semesterStats,
            'performance_metrics' => $performanceMetrics,
        ];
    }

    /**
     * Export collection report to Excel/PDF
     */
    public function exportCollectionReport(Request $request)
    {
        // Implementation for export functionality
        // This can be implemented based on requirements
    }

    /**
     * Display monthly reports
     */
    public function monthly(Request $request)
    {
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $startDate = Carbon::parse($currentMonth)->startOfMonth();
        $endDate = Carbon::parse($currentMonth)->endOfMonth();

        // Monthly statistics
        $monthlyStats = $this->getMonthlyStats($startDate, $endDate);

        // Students data with filters
        $query = Student::query()
            ->with(['debts', 'followUps', 'payments'])
            ->where('outstanding_amount', '>', 0);

        // Apply filters
        $this->applyFilters($query, $request);

        $students = $query->paginate(20)->withQueryString();

        // Filter options
        $filterOptions = $this->getFilterOptions();

        return view('reports.monthly', compact(
            'monthlyStats',
            'students',
            'filterOptions',
            'currentMonth'
        ));
    }

    /**
     * Display financial reports
     */
    public function financial(Request $request)
    {
        $dateRange = $this->getDateRange($request);
        
        // Financial statistics
        $financialStats = $this->getFinancialStats($dateRange['start'], $dateRange['end']);
        
        // Outstanding balances by category
        $outstandingByCategory = $this->getOutstandingByCategory();
        
        // Payment trends
        $paymentTrends = $this->getPaymentTrends($dateRange['start'], $dateRange['end']);
        
        // Collection effectiveness
        $collectionMetrics = $this->getCollectionMetrics($dateRange['start'], $dateRange['end']);
        
        // Students data for the financial report
        $query = Student::query()
            ->with(['debts', 'payments', 'followUps'])
            ->where('outstanding_amount', '>', 0);
        
        // Apply filters
        $this->applyFinancialFilters($query, $request);
        
        $students = $query->paginate(15)->withQueryString();
        
        // Prepare data for the view with proper names
        $totalPiutang = Student::sum('outstanding_amount');
        $piutangLunas = DB::table('payments')
            ->where('status', 'completed')
            ->sum('amount');
        $piutangBelumLunas = $totalPiutang - $piutangLunas;
        $totalMahasiswa = Student::count();

        return view('reports.financial', compact(
            'totalPiutang',
            'piutangLunas', 
            'piutangBelumLunas',
            'totalMahasiswa',
            'students',
            'financialStats',
            'outstandingByCategory',
            'paymentTrends',
            'collectionMetrics',
            'dateRange'
        ));
    }

    /**
     * Display student reports
     */
    public function students(Request $request)
    {
        // Student statistics
        $studentStats = $this->getStudentStats();
        
        // Students query with filters
        $query = Student::query()->with(['academicYear', 'major', 'debts', 'payments']);
        $this->applyFilters($query, $request);
        
        $students = $query->paginate(25)->withQueryString();
        
        // Filter options
        $filterOptions = $this->getFilterOptions();
        
        // Prepare data with the correct variable names for the view
        $totalStudents = $studentStats['total_students'];
        $activeStudents = $studentStats['active_students'];
        $graduatedStudents = Student::where('status', 'graduated')->count();
        $droppedStudents = Student::where('status', 'dropped')->count();
        
        return view('reports.student', compact(
            'totalStudents',
            'activeStudents', 
            'graduatedStudents',
            'droppedStudents',
            'students', 
            'filterOptions'
        ));
    }

    /**
     * Display export page and handle exports
     */
    public function export(Request $request)
    {
        if ($request->isMethod('post')) {
            return $this->processExport($request);
        }

        // Show export form
        $filterOptions = $this->getFilterOptions();
        $exportStats = $this->getExportStats();
        
        return view('reports.export', compact('filterOptions', 'exportStats'));
    }

    /**
     * Process export request
     */
    public function processExport(Request $request)
    {
        $request->validate([
            'export_type' => 'required|in:students,financial,collection,monthly',
            'format' => 'required|in:excel,pdf,csv',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $exportType = $request->get('export_type');
        $format = $request->get('format');
        
        // Build query based on export type
        switch ($exportType) {
            case 'students':
                $data = $this->getStudentsExportData($request);
                break;
            case 'financial':
                $data = $this->getFinancialExportData($request);
                break;
            case 'collection':
                $data = $this->getCollectionExportData($request);
                break;
            case 'monthly':
                $data = $this->getMonthlyExportData($request);
                break;
            default:
                return back()->withErrors(['export_type' => 'Invalid export type']);
        }

        // Generate export file
        return $this->generateExport($data, $format, $exportType);
    }

    /**
     * Get monthly statistics
     */
    private function getMonthlyStats($startDate, $endDate)
    {
        $totalStudents = Student::count();
        $studentsWithDebt = Student::where('outstanding_amount', '>', 0)->count();
        $totalOutstanding = Student::sum('outstanding_amount');
        $totalPaidThisMonth = DB::table('payments')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount');

        $newDebtsThisMonth = DB::table('debts')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $followUpsThisMonth = FollowUp::whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            'total_students' => $totalStudents,
            'students_with_debt' => $studentsWithDebt,
            'total_outstanding' => $totalOutstanding,
            'total_paid_this_month' => $totalPaidThisMonth,
            'new_debts_this_month' => $newDebtsThisMonth,
            'followups_this_month' => $followUpsThisMonth,
        ];
    }

    /**
     * Get financial statistics
     */
    private function getFinancialStats($startDate, $endDate)
    {
        return [
            'total_outstanding' => Student::sum('outstanding_amount'),
            'total_paid' => DB::table('payments')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed')
                ->sum('amount'),
            'average_debt' => Student::where('outstanding_amount', '>', 0)
                ->avg('outstanding_amount'),
            'collection_rate' => $this->calculateCollectionRate($startDate, $endDate),
        ];
    }

    /**
     * Get student statistics
     */
    private function getStudentStats()
    {
        return [
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'students_with_debt' => Student::where('outstanding_amount', '>', 0)->count(),
            'students_above_10m' => Student::where('outstanding_amount', '>', 10000000)->count(),
        ];
    }

    /**
     * Apply filters to query
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('faculty')) {
            $query->where('faculty', $request->get('faculty'));
        }

        if ($request->filled('program_study')) {
            $query->where('program_study', $request->get('program_study'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('min_outstanding')) {
            $query->where('outstanding_amount', '>=', $request->get('min_outstanding'));
        }

        if ($request->filled('max_outstanding')) {
            $query->where('outstanding_amount', '<=', $request->get('max_outstanding'));
        }

        if ($request->filled('semester_menunggak')) {
            $query->where('semester_menunggak', '>=', $request->get('semester_menunggak'));
        }
    }
    
    /**
     * Apply financial filters to query
     */
    private function applyFinancialFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas')) {
            $query->where('faculty', $request->get('fakultas'));
        }

        if ($request->filled('tahun')) {
            $query->where('academic_year', $request->get('tahun'));
        }

        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status == 'lunas') {
                $query->where('outstanding_amount', '=', 0);
            } elseif ($status == 'belum_lunas') {
                $query->where('outstanding_amount', '>', 0)->where('outstanding_amount', '<=', 10000000);
            } elseif ($status == 'nunggak') {
                $query->where('outstanding_amount', '>', 10000000);
            }
        }

        if ($request->filled('min_piutang')) {
            $query->where('outstanding_amount', '>=', $request->get('min_piutang'));
        }

        if ($request->filled('max_piutang')) {
            $query->where('outstanding_amount', '<=', $request->get('max_piutang'));
        }
    }

    /**
     * Get filter options
     */
    private function getFilterOptions()
    {
        return [
            'faculties' => Student::distinct()->pluck('faculty')->filter()->sort(),
            'program_studies' => Student::distinct()->pluck('program_study')->filter()->sort(),
            'statuses' => Student::distinct()->pluck('status')->filter()->sort(),
            'academic_years' => Student::distinct()->pluck('academic_year')->filter()->sort(),
        ];
    }

    /**
     * Get date range from request
     */
    private function getDateRange(Request $request)
    {
        $start = $request->get('date_from', now()->startOfMonth());
        $end = $request->get('date_to', now()->endOfMonth());
        
        return [
            'start' => Carbon::parse($start),
            'end' => Carbon::parse($end)
        ];
    }

    /**
     * Calculate collection rate
     */
    private function calculateCollectionRate($startDate, $endDate)
    {
        $totalDebt = Student::sum('outstanding_amount');
        $totalPaid = DB::table('payments')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount');
            
        return $totalDebt > 0 ? ($totalPaid / $totalDebt) * 100 : 0;
    }

    /**
     * Get outstanding by category
     */
    private function getOutstandingByCategory()
    {
        return [
            'below_5m' => Student::whereBetween('outstanding_amount', [1, 5000000])->count(),
            '5m_to_10m' => Student::whereBetween('outstanding_amount', [5000001, 10000000])->count(),
            'above_10m' => Student::where('outstanding_amount', '>', 10000000)->count(),
        ];
    }

    /**
     * Get payment trends
     */
    private function getPaymentTrends($startDate, $endDate)
    {
        // Implementation for payment trends
        return [];
    }

    /**
     * Get collection metrics
     */
    private function getCollectionMetrics($startDate, $endDate)
    {
        // Implementation for collection metrics
        return [];
    }

    /**
     * Get export statistics
     */
    private function getExportStats()
    {
        return [
            'total_records' => Student::count(),
            'exportable_records' => Student::where('outstanding_amount', '>', 0)->count(),
            'last_export' => null, // Can be implemented with export log
        ];
    }

    /**
     * Generate export file
     */
    private function generateExport($data, $format, $type)
    {
        switch ($format) {
            case 'excel':
                return $this->generateExcelExport($data, $type);
            case 'pdf':
                return $this->generatePDFExport($data, $type);
            case 'csv':
                return $this->generateCSVExport($data, $type);
        }
    }

    /**
     * Get students export data
     */
    private function getStudentsExportData(Request $request)
    {
        $query = Student::query()->with(['academicYear', 'major']);
        $this->applyFilters($query, $request);
        return $query->get();
    }

    /**
     * Get financial export data
     */
    private function getFinancialExportData(Request $request)
    {
        // Implementation for financial export data
        return collect();
    }

    /**
     * Get collection export data
     */
    private function getCollectionExportData(Request $request)
    {
        // Implementation for collection export data
        return collect();
    }

    /**
     * Get monthly export data
     */
    private function getMonthlyExportData(Request $request)
    {
        // Implementation for monthly export data
        return collect();
    }

    /**
     * Generate Excel export
     */
    private function generateExcelExport($data, $type)
    {
        if ($type === 'students') {
            $export = new StudentsExport();
            $filename = 'students_export_' . now()->format('Ymd_His') . '.xlsx';
            return Excel::download($export, $filename);
        }
        // Untuk type lain, bisa ditambahkan export class sesuai kebutuhan
        return response()->json(['message' => 'Excel export for this type not yet implemented']);
    }

    /**
     * Generate PDF export
     */
    private function generatePDFExport($data, $type)
    {
        return response()->json(['message' => 'PDF export not yet implemented']);
    }

    /**
     * Generate CSV export
     */
    private function generateCSVExport($data, $type)
    {
        return response()->json(['message' => 'CSV export not yet implemented']);
    }
}
