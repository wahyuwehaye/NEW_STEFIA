<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receivable;
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
            'total_receivables' => Receivable::count(),
            'total_amount' => Receivable::sum('amount'),
            'outstanding_amount' => Receivable::where('status', '!=', 'paid')->sum('amount'),
            'paid_amount' => Receivable::where('status', 'paid')->sum('amount'),
            'overdue_count' => Receivable::where('due_date', '<', now())
                ->where('status', '!=', 'paid')
                ->count(),
            'pending_count' => Receivable::where('status', 'pending')->count(),
            'paid_count' => Receivable::where('status', 'paid')->count(),
        ];

        // Recent receivables
        $recentReceivables = Receivable::with(['student', 'fee'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Overdue receivables
        $overdueReceivables = Receivable::with(['student', 'fee'])
            ->where('due_date', '<', now())
            ->where('status', '!=', 'paid')
            ->orderBy('due_date', 'asc')
            ->limit(10)
            ->get();

        // Monthly data for charts
        $monthlyData = Receivable::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('receivables.dashboard', compact('stats', 'recentReceivables', 'overdueReceivables', 'monthlyData'));
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
     * Show by student page.
     */
    public function byStudent($studentId = null)
    {
        $student = null;
        $receivables = collect();
        
        if ($studentId) {
            $student = Student::find($studentId);
            if ($student) {
                $receivables = $student->receivables()->with('fee')->get();
            }
        }
        
        $students = Student::has('receivables')->get();
        
        return view('receivables.by-student', compact('student', 'receivables', 'students'));
    }

    /**
     * Get data for DataTables AJAX.
     */
    public function getData(Request $request)
    {
        $query = Receivable::with(['student', 'fee'])
            ->select('receivables.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($receivable) {
                return $receivable->student ? $receivable->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($receivable) {
                return $receivable->student ? $receivable->student->nim : 'N/A';
            })
            ->addColumn('fee_name', function ($receivable) {
                return $receivable->fee ? $receivable->fee->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($receivable) {
                return 'Rp ' . number_format($receivable->amount, 0, ',', '.');
            })
            ->addColumn('formatted_due_date', function ($receivable) {
                return $receivable->due_date ? $receivable->due_date->format('d/m/Y') : 'N/A';
            })
            ->addColumn('overdue_days', function ($receivable) {
                if ($receivable->due_date && $receivable->due_date->isPast()) {
                    return $receivable->due_date->diffInDays(now());
                }
                return 0;
            })
            ->addColumn('status_badge', function ($receivable) {
                $statusClass = '';
                switch ($receivable->status) {
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
                return '<span class=\"badge ' . $statusClass . '\">' . ucfirst($receivable->status) . '</span>';
            })
            ->addColumn('action', function ($receivable) {
                $actions = '';
                $actions .= '<a href=\"' . route('receivables.show', $receivable->id) . '\" class=\"btn btn-sm btn-info\" title=\"View\"><em class=\"icon ni ni-eye\"></em></a> ';
                $actions .= '<a href=\"' . route('receivables.edit', $receivable->id) . '\" class=\"btn btn-sm btn-primary\" title=\"Edit\"><em class=\"icon ni ni-edit\"></em></a> ';
                $actions .= '<button class=\"btn btn-sm btn-danger\" onclick=\"deleteReceivable(' . $receivable->id . ')\" title=\"Delete\"><em class=\"icon ni ni-trash\"></em></button>';
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
        $query = Receivable::with(['student', 'fee'])
            ->where('status', '!=', 'paid')
            ->select('receivables.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($receivable) {
                return $receivable->student ? $receivable->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($receivable) {
                return $receivable->student ? $receivable->student->nim : 'N/A';
            })
            ->addColumn('fee_name', function ($receivable) {
                return $receivable->fee ? $receivable->fee->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($receivable) {
                return 'Rp ' . number_format($receivable->amount, 0, ',', '.');
            })
            ->addColumn('formatted_due_date', function ($receivable) {
                return $receivable->due_date ? $receivable->due_date->format('d/m/Y') : 'N/A';
            })
            ->addColumn('overdue_days', function ($receivable) {
                if ($receivable->due_date && $receivable->due_date->isPast()) {
                    return $receivable->due_date->diffInDays(now());
                }
                return 0;
            })
            ->addColumn('status_badge', function ($receivable) {
                $statusClass = '';
                switch ($receivable->status) {
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
                return '<span class=\"badge ' . $statusClass . '\">' . ucfirst($receivable->status) . '</span>';
            })
            ->addColumn('action', function ($receivable) {
                $actions = '';
                $actions .= '<a href=\"' . route('receivables.show', $receivable->id) . '\" class=\"btn btn-sm btn-info\" title=\"View\"><em class=\"icon ni ni-eye\"></em></a> ';
                $actions .= '<button class=\"btn btn-sm btn-warning\" onclick=\"sendReminder(' . $receivable->id . ')\" title=\"Send Reminder\"><em class=\"icon ni ni-mail\"></em></button> ';
                $actions .= '<button class=\"btn btn-sm btn-danger\" onclick=\"deleteReceivable(' . $receivable->id . ')\" title=\"Delete\"><em class=\"icon ni ni-trash\"></em></button>';
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
        $query = Receivable::with(['student', 'fee'])
            ->select('receivables.*');

        return DataTables::of($query)
            ->addColumn('student_name', function ($receivable) {
                return $receivable->student ? $receivable->student->name : 'N/A';
            })
            ->addColumn('student_nim', function ($receivable) {
                return $receivable->student ? $receivable->student->nim : 'N/A';
            })
            ->addColumn('fee_name', function ($receivable) {
                return $receivable->fee ? $receivable->fee->name : 'N/A';
            })
            ->addColumn('formatted_amount', function ($receivable) {
                return 'Rp ' . number_format($receivable->amount, 0, ',', '.');
            })
            ->addColumn('formatted_due_date', function ($receivable) {
                return $receivable->due_date ? $receivable->due_date->format('d/m/Y') : 'N/A';
            })
            ->addColumn('status_badge', function ($receivable) {
                $statusClass = '';
                switch ($receivable->status) {
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
                return '<span class=\"badge ' . $statusClass . '\">' . ucfirst($receivable->status) . '</span>';
            })
            ->addColumn('action', function ($receivable) {
                $actions = '';
                $actions .= '<a href=\"' . route('receivables.show', $receivable->id) . '\" class=\"btn btn-sm btn-info\" title=\"View\"><em class=\"icon ni ni-eye\"></em></a> ';
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

        Receivable::create($validated);

        return redirect()->route('receivables.index')
            ->with('success', 'Receivable created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $receivable = Receivable::with(['student', 'fee'])->findOrFail($id);
        return view('receivables.show', compact('receivable'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $receivable = Receivable::findOrFail($id);
        $students = Student::all();
        $fees = Fee::all();
        return view('receivables.edit', compact('receivable', 'students', 'fees'));
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

        $receivable = Receivable::findOrFail($id);
        $receivable->update($validated);

        return redirect()->route('receivables.index')
            ->with('success', 'Receivable updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $receivable = Receivable::findOrFail($id);
        $receivable->delete();

        return redirect()->route('receivables.index')
            ->with('success', 'Receivable deleted successfully.');
    }

    /**
     * Send reminder for receivable.
     */
    public function sendReminder(string $id)
    {
        $receivable = Receivable::with(['student', 'fee'])->findOrFail($id);
        
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
        $receivable = Receivable::findOrFail($id);
        $receivable->update(['status' => 'paid']);

        return response()->json([
            'success' => true,
            'message' => 'Receivable marked as paid.'
        ]);
    }
}
