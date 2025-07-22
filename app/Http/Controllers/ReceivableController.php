<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Debt;
use App\Models\Student;
use App\Models\Fee;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('receivables.index');
    }

    /**
     * Show the dashboard for receivables.
     */
    public function dashboard()
    {
        // Calculate statistics for dashboard
        $stats = [
            'total_receivables' => Debt::count(),
            'total_amount' => Debt::sum('amount'),
            'total_outstanding' => Debt::where('status', '!=', 'paid')->sum('amount'),
            'total_paid' => Debt::where('status', 'paid')->sum('amount'),
            'overdue_count' => Debt::where('due_date', '<', now())
                ->where('status', '!=', 'paid')
                ->count(),
            'pending_count' => Debt::where('status', 'pending')->count(),
            'paid_count' => Debt::where('status', 'paid')->count(),
            'partial_count' => 0, // For now, set to 0 since we don't have partial status
        ];

        // Recent receivables
        $recent_receivables = Debt::with(['student', 'fee'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Overdue receivables
        $overdue_receivables = Debt::with(['student', 'fee'])
            ->where('due_date', '<', now())
            ->where('status', '!=', 'paid')
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        // Due this week
        $due_this_week = Debt::with(['student', 'fee'])
            ->where('due_date', '>=', now()->startOfWeek())
            ->where('due_date', '<=', now()->endOfWeek())
            ->where('status', '!=', 'paid')
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        // Monthly data for charts
        $monthlyData = Debt::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('receivables.dashboard', compact('stats', 'recent_receivables', 'overdue_receivables', 'due_this_week', 'monthlyData'));
    }

    /**
     * Show outstanding receivables.
     */
    public function outstanding()
    {
        return view('receivables.outstanding');
    }

    /**
     * Show receivables history.
     */
    public function history()
    {
        return view('receivables.history');
    }

    /**
     * Show bulk operations page.
     */
    public function bulkOperations()
    {
        return view('receivables.bulk-operations');
    }

    /**
     * Show export page.
     */
    public function export()
    {
        return view('receivables.export');
    }

    /**
     * Show sync iGracias page.
     */
    public function syncIgracias()
    {
        return view('receivables.sync-igracias');
    }

    /**
     * Landing page daftar mahasiswa dengan piutang
     */
    public function landingPage()
    {
        $students = Student::withCount(['debts as total_debts' => function($q) {
            $q->where('status', '!=', 'paid');
        }])->withSum('debts as total_outstanding', 'outstanding_amount')
        ->whereHas('debts', function($q) {
            $q->where('status', '!=', 'paid');
        })
        ->orderByDesc('total_outstanding')
        ->paginate(12);
        return view('receivables.landing', compact('students'));
    }

    /**
     * Show by student page.
     */
    public function byStudent($studentId = null)
    {
        // Get all students with debts for navigation
        $students = Student::has('debts')
                           ->with(['debts' => function($query) {
                               $query->select('student_id')->limit(1);
                           }])
                           ->get();
        // Jika tidak ada studentId, tampilkan landing
        if (!$studentId) {
            return redirect()->route('receivables.landing');
        }
        
        // If no students have receivables, show empty state
        if ($students->count() == 0) {
            return view('receivables.by-student', [
                'student' => null,
                'debts' => collect(),
                'students' => collect(),
                'otherStudents' => collect(),
                'stats' => [
                    'total_amount' => 0,
                    'total_paid' => 0,
                    'total_outstanding' => 0,
                    'overdue_count' => 0,
                ]
            ]);
        }
        
        $student = Student::with(['debts.fee', 'major'])->find($studentId);
        
        // Jika student tidak ditemukan, redirect ke landing
        if (!$student) {
            return redirect()->route('receivables.landing')
                            ->with('warning', 'Mahasiswa tidak ditemukan.');
        }
        
        $debts = $student->debts()->with('fee')->paginate(15);
        
        // Calculate stats for this student
        $allDebts = $student->debts;
        $stats = [
            'total_amount' => $allDebts->sum('amount'),
            'total_paid' => $allDebts->sum('paid_amount'),
            'total_outstanding' => $allDebts->sum('outstanding_amount'),
            'overdue_count' => $allDebts->where('due_date', '<', now())
                                            ->where('status', '!=', 'paid')
                                            ->count(),
        ];
        
        // Get other students with receivables for navigation dropdown
        $otherStudents = Student::has('debts')
                               ->where('id', '!=', $student->id)
                               ->with(['debts' => function($query) {
                                   $query->select('student_id')->limit(1);
                               }])
                               ->limit(10)
                               ->get();
        
        return view('receivables.by-student', compact('student', 'debts', 'students', 'otherStudents', 'stats'));
    }

    /**
     * Get data for DataTables AJAX.
     */
    public function getData(Request $request)
    {
        $query = Debt::with(['student', 'fee'])
            ->select('debts.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($debt) {
                return $debt->student ? $debt->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($debt) {
                return $debt->student ? $debt->student->nim : 'N/A';
            })
            ->addColumn('fee_name', function ($debt) {
                return $debt->fee ? $debt->fee->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($debt) {
                return 'Rp ' . number_format($debt->amount, 0, ',', '.');
            })
            ->addColumn('formatted_due_date', function ($debt) {
                return $debt->due_date ? $debt->due_date->format('d/m/Y') : 'N/A';
            })
            ->addColumn('overdue_days', function ($debt) {
                if ($debt->due_date && $debt->due_date->isPast()) {
                    return $debt->due_date->diffInDays(now());
                }
                return 0;
            })
            ->addColumn('status_badge', function ($debt) {
                $statusClass = '';
                switch ($debt->status) {
                    case 'paid':
                        $statusClass = 'badge-success';
                        break;
                    case 'overdue':
                        $statusClass = 'badge-danger';
                        break;
                    case 'pending':
                        $statusClass = 'badge-warning';
                        break;
                    default:
                        $statusClass = 'badge-secondary';
                }
                return '<span class=\"badge ' . $statusClass . '\">' . ucfirst($debt->status) . '</span>';
            })
            ->addColumn('action', function ($debt) {
                $actions = '';
                $actions .= '<a href=\"' . route('receivables.show', $debt->id) . '\" class=\"btn btn-sm btn-info\" title=\"View\"><em class=\"icon ni ni-eye\"></em></a> ';
                $actions .= '<a href=\"' . route('receivables.edit', $debt->id) . '\" class=\"btn btn-sm btn-primary\" title=\"Edit\"><em class=\"icon ni ni-edit\"></em></a> ';
                $actions .= '<button class=\"btn btn-sm btn-danger\" onclick=\"deleteReceivable(' . $debt->id . ')\" title=\"Delete\"><em class=\"icon ni ni-trash\"></em></button>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * Get outstanding receivables data for DataTables.
     */
    public function getOutstandingData(Request $request)
    {
        $query = Debt::with(['student', 'fee'])
            ->where('status', '!=', 'paid')
            ->select('debts.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($debt) {
                return $debt->student ? $debt->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($debt) {
                return $debt->student ? $debt->student->nim : 'N/A';
            })
            ->addColumn('fee_name', function ($debt) {
                return $debt->fee ? $debt->fee->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($debt) {
                return 'Rp ' . number_format($debt->amount, 0, ',', '.');
            })
            ->addColumn('formatted_due_date', function ($debt) {
                return $debt->due_date ? $debt->due_date->format('d/m/Y') : 'N/A';
            })
            ->addColumn('overdue_days', function ($debt) {
                if ($debt->due_date && $debt->due_date->isPast()) {
                    return $debt->due_date->diffInDays(now());
                }
                return 0;
            })
            ->addColumn('status_badge', function ($debt) {
                $statusClass = '';
                switch ($debt->status) {
                    case 'paid':
                        $statusClass = 'badge-success';
                        break;
                    case 'overdue':
                        $statusClass = 'badge-danger';
                        break;
                    case 'pending':
                        $statusClass = 'badge-warning';
                        break;
                    default:
                        $statusClass = 'badge-secondary';
                }
                return '<span class=\"badge ' . $statusClass . '\">' . ucfirst($debt->status) . '</span>';
            })
            ->addColumn('action', function ($debt) {
                $actions = '';
                $actions .= '<a href=\"' . route('receivables.show', $debt->id) . '\" class=\"btn btn-sm btn-info\" title=\"View\"><em class=\"icon ni ni-eye\"></em></a> ';
                $actions .= '<button class=\"btn btn-sm btn-warning\" onclick=\"sendReminder(' . $debt->id . ')\" title=\"Send Reminder\"><em class=\"icon ni ni-mail\"></em></button> ';
                $actions .= '<button class=\"btn btn-sm btn-danger\" onclick=\"deleteReceivable(' . $debt->id . ')\" title=\"Delete\"><em class=\"icon ni ni-trash\"></em></button>';
                return $actions;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * Get history data for DataTables.
     */
    public function getHistoryData(Request $request)
    {
        $query = Debt::with(['student', 'fee'])
            ->select('debts.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($debt) {
                return $debt->student ? $debt->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($debt) {
                return $debt->student ? $debt->student->nim : 'N/A';
            })
            ->addColumn('fee_name', function ($debt) {
                return $debt->fee ? $debt->fee->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($debt) {
                return 'Rp ' . number_format($debt->amount, 0, ',', '.');
            })
            ->addColumn('formatted_due_date', function ($debt) {
                return $debt->due_date ? $debt->due_date->format('d/m/Y') : 'N/A';
            })
            ->addColumn('status_badge', function ($debt) {
                $statusClass = '';
                switch ($debt->status) {
                    case 'paid':
                        $statusClass = 'badge-success';
                        break;
                    case 'overdue':
                        $statusClass = 'badge-danger';
                        break;
                    case 'pending':
                        $statusClass = 'badge-warning';
                        break;
                    default:
                        $statusClass = 'badge-secondary';
                }
                return '<span class=\"badge ' . $statusClass . '\">' . ucfirst($debt->status) . '</span>';
            })
            ->addColumn('action', function ($debt) {
                $actions = '';
                $actions .= '<a href=\"' . route('receivables.show', $debt->id) . '\" class=\"btn btn-sm btn-info\" title=\"View\"><em class=\"icon ni ni-eye\"></em></a> ';
                return $actions;
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $fees = Fee::all();
        return view('receivables.create', compact('students', 'fees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,overdue',
            'description' => 'nullable|string'
        ]);

        Debt::create($validated);

        return redirect()->route('receivables.index')
            ->with('success', 'Receivable created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $debt = Debt::with(['student', 'fee'])->findOrFail($id);
        return view('receivables.show', compact('debt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $debt = Debt::findOrFail($id);
        $students = Student::all();
        $fees = Fee::all();
        return view('receivables.edit', compact('debt', 'students', 'fees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,overdue',
            'description' => 'nullable|string'
        ]);

        $debt = Debt::findOrFail($id);
        $debt->update($validated);

        return redirect()->route('receivables.index')
            ->with('success', 'Receivable updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $debt = Debt::findOrFail($id);
        $debt->delete();

        return redirect()->route('receivables.index')
            ->with('success', 'Receivable deleted successfully.');
    }

    /**
     * Send reminder for receivable.
     */
    public function sendReminder(string $id)
    {
        $debt = Debt::with(['student', 'fee'])->findOrFail($id);
        
        // Logic to send reminder (email, SMS, etc.)
        
        return response()->json([
            'success' => true,
            'message' => 'Reminder sent successfully.'
        ]);
    }

    /**
     * Mark receivable as paid.
     */
    public function markAsPaid(string $id)
    {
        $debt = Debt::findOrFail($id);
        $debt->update(['status' => 'paid']);

        return response()->json([
            'success' => true,
            'message' => 'Receivable marked as paid.'
        ]);
    }
}
