<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\DataTables\StudentsDataTable;
use App\Exports\StudentsExport;
use App\Exports\StudentsTemplateExport;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StudentsDataTable $dataTable, Request $request)
    {
        // Get statistics for dashboard
        $stats = $this->getStudentStats();
        
        // Check if this is an AJAX request
        if ($request->ajax()) {
            // Handle DataTable AJAX request
            if ($request->has('draw')) {
                return $this->handleDataTableRequest($request);
            }
            
            // Handle custom AJAX request for our table
            $query = Student::query();
            
            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('faculty')) {
                $query->where('faculty', $request->faculty);
            }
            
            if ($request->filled('cohort_year')) {
                $query->where('cohort_year', $request->cohort_year);
            }
            
            // Get filtered results
            $students = $query->orderBy('name', 'asc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $students,
                'stats' => $stats
            ]);
        }
        
        return view('students.index', compact('stats'));
    }

    /**
     * Handle DataTable server-side processing request
     */
    private function handleDataTableRequest(Request $request)
    {
        $query = Student::query();
        
        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('faculty')) {
            $query->where('faculty', $request->faculty);
        }
        
        if ($request->filled('cohort_year')) {
            $query->where('cohort_year', $request->cohort_year);
        }
        
        // Handle global search
        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('nim', 'like', "%{$searchValue}%")
                  ->orWhere('email', 'like', "%{$searchValue}%")
                  ->orWhere('phone', 'like', "%{$searchValue}%")
                  ->orWhere('faculty', 'like', "%{$searchValue}%")
                  ->orWhere('department', 'like', "%{$searchValue}%");
            });
        }
        
        // Handle individual column search
        if ($request->has('columns')) {
            $columns = $request->input('columns');
            foreach ($columns as $index => $column) {
                if (!empty($column['search']['value'])) {
                    $searchValue = $column['search']['value'];
                    switch ($index) {
                        case 1: // Name column
                            $query->where('name', 'like', "%{$searchValue}%");
                            break;
                        case 2: // NIM column
                            $query->where('nim', 'like', "%{$searchValue}%");
                            break;
                        case 3: // Status column
                            $query->where('status', $searchValue);
                            break;
                        case 4: // Faculty column
                            $query->where('faculty', 'like', "%{$searchValue}%");
                            break;
                        case 5: // Department column
                            $query->where('department', 'like', "%{$searchValue}%");
                            break;
                        case 6: // Cohort year column
                            $query->where('cohort_year', $searchValue);
                            break;
                    }
                }
            }
        }
        
        // Get total count before applying pagination
        $recordsTotal = Student::count();
        $recordsFiltered = $query->count();
        
        // Handle ordering
        if ($request->has('order')) {
            $orderColumn = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir', 'asc');
            
            $orderColumns = [
                0 => 'id',
                1 => 'name',
                2 => 'nim',
                3 => 'status',
                4 => 'faculty',
                5 => 'department',
                6 => 'cohort_year',
                7 => 'current_semester',
                8 => 'phone',
                9 => 'email',
                10 => 'created_at'
            ];
            
            if (isset($orderColumns[$orderColumn])) {
                $query->orderBy($orderColumns[$orderColumn], $orderDirection);
            }
        } else {
            $query->orderBy('name', 'asc');
        }
        
        // Apply pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        
        $students = $query->skip($start)->take($length)->get();
        
        // Format data for DataTables
        $data = [];
        foreach ($students as $student) {
            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'nim' => $student->nim,
                'status' => $student->status,
                'faculty' => $student->faculty,
                'department' => $student->department,
                'cohort_year' => $student->cohort_year,
                'current_semester' => $student->current_semester,
                'phone' => $student->phone,
                'email' => $student->email,
                'created_at' => $student->created_at->format('Y-m-d'),
                'actions' => $this->generateActionButtons($student)
            ];
        }
        
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }
    
    /**
     * Generate action buttons for DataTables
     */
    private function generateActionButtons($student)
    {
        $actions = '<div class="dropdown">';
        $actions .= '<button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">';
        $actions .= '<i class="fas fa-ellipsis-v"></i>';
        $actions .= '</button>';
        $actions .= '<ul class="dropdown-menu">';
        $actions .= '<li><a class="dropdown-item" href="'.route('students.show', $student->id).'"><i class="fas fa-eye me-2"></i>View</a></li>';
        $actions .= '<li><a class="dropdown-item" href="'.route('students.edit', $student->id).'"><i class="fas fa-edit me-2"></i>Edit</a></li>';
        $actions .= '<li><hr class="dropdown-divider"></li>';
        $actions .= '<li><a class="dropdown-item text-danger delete-student" href="#" data-id="'.$student->id.'"><i class="fas fa-trash me-2"></i>Delete</a></li>';
        $actions .= '</ul>';
        $actions .= '</div>';
        
        return $actions;
    }
    
    /**
     * Get student statistics
     */
    private function getStudentStats()
    {
        return [
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'inactive_students' => Student::where('status', 'inactive')->count(),
            'graduated_students' => Student::where('status', 'graduated')->count(),
            'dropped_out_students' => Student::where('status', 'dropped_out')->count(),
            'new_students' => Student::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count(),
            'students_by_faculty' => Student::selectRaw('faculty, COUNT(*) as count')
                                          ->groupBy('faculty')
                                          ->pluck('count', 'faculty')
                                          ->toArray(),
            'students_by_cohort' => Student::selectRaw('cohort_year, COUNT(*) as count')
                                         ->groupBy('cohort_year')
                                         ->orderBy('cohort_year', 'desc')
                                         ->pluck('count', 'cohort_year')
                                         ->toArray(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:20|unique:students,nim',
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status_registrasi' => 'nullable|in:Aktif,Non-Aktif,Cuti',
            'status_mahasiswa' => 'nullable|in:Aktif,Lulus,DO,Mengundurkan Diri',
            'semester_saat_ini' => 'nullable|integer|min:1|max:14',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:students,email',
            'alamat' => 'nullable|string|max:500',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_ayah' => 'nullable|string|max:20',
            'telepon_ibu' => 'nullable|string|max:20',
            'alamat_ayah' => 'nullable|string|max:500',
            'alamat_ibu' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,other',
            'class' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan dalam validasi data. Silakan periksa kembali form Anda.');
        }

        // Map status values to database enum
        $statusMapping = [
            'Aktif' => 'active',
            'Lulus' => 'graduated',
            'DO' => 'dropped_out',
            'Mengundurkan Diri' => 'dropped_out',
            'Non-Aktif' => 'inactive',
            'Cuti' => 'inactive'
        ];
        
        $studentStatus = $request->status_mahasiswa ?? 'Aktif';
        $dbStatus = $statusMapping[$studentStatus] ?? 'active';
        
        // Map form fields to database columns
        $studentData = [
            'nim' => $request->nim,
            'name' => $request->nama,
            'faculty' => $request->fakultas,
            'department' => $request->program_studi,
            'cohort_year' => $request->angkatan,
            'status' => $dbStatus,
            'current_semester' => $request->semester_saat_ini ?? 1,
            'phone' => $request->telepon,
            'email' => $request->email,
            'address' => $request->alamat,
            'father_name' => $request->nama_ayah,
            'mother_name' => $request->nama_ibu,
            'father_occupation' => $request->pekerjaan_ayah,
            'mother_occupation' => $request->pekerjaan_ibu,
            'father_phone' => $request->telepon_ayah,
            'mother_phone' => $request->telepon_ibu,
            'father_address' => $request->alamat_ayah,
            'mother_address' => $request->alamat_ibu,
            'birth_date' => $request->tanggal_lahir,
            'birth_place' => $request->tempat_lahir,
            'gender' => $request->gender,
            'class' => $request->class,
            'academic_year' => date('Y') . '/' . (date('Y') + 1),
        ];

        try {
            $student = Student::create($studentData);

            return redirect()->route('students.index')
                             ->with('success', 'Data mahasiswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::findOrFail($id);
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:20|unique:students,nim,' . $id,
            'nama' => 'required|string|max:255',
            'fakultas' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status_registrasi' => 'nullable|in:Aktif,Non-Aktif,Cuti',
            'status_mahasiswa' => 'nullable|in:Aktif,Lulus,DO,Mengundurkan Diri',
            'semester_saat_ini' => 'nullable|integer|min:1|max:14',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:students,email,' . $id,
            'alamat' => 'nullable|string|max:500',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'telepon_ayah' => 'nullable|string|max:20',
            'telepon_ibu' => 'nullable|string|max:20',
            'alamat_ayah' => 'nullable|string|max:500',
            'alamat_ibu' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:male,female,other',
            'class' => 'nullable|string|max:50',
            'telepon_ortu' => 'nullable|string|max:20',
            'alamat_ortu' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan dalam validasi data. Silakan periksa kembali form Anda.');
        }

        // Map status values to database enum
        $statusMapping = [
            'Aktif' => 'active',
            'Lulus' => 'graduated',
            'DO' => 'dropped_out',
            'Mengundurkan Diri' => 'dropped_out',
            'Non-Aktif' => 'inactive',
            'Cuti' => 'inactive'
        ];
        
        $studentStatus = $request->status_mahasiswa ?? 'Aktif';
        $dbStatus = $statusMapping[$studentStatus] ?? 'active';
        
        // Map form fields to database columns
        $updateData = [
            'nim' => $request->nim,
            'name' => $request->nama,
            'faculty' => $request->fakultas,
            'department' => $request->program_studi,
            'cohort_year' => $request->angkatan,
            'status' => $dbStatus,
            'current_semester' => $request->semester_saat_ini ?? 1,
            'phone' => $request->telepon,
            'email' => $request->email,
            'address' => $request->alamat,
            'father_name' => $request->nama_ayah,
            'mother_name' => $request->nama_ibu,
            'father_occupation' => $request->pekerjaan_ayah,
            'mother_occupation' => $request->pekerjaan_ibu,
            'father_phone' => $request->telepon_ayah,
            'mother_phone' => $request->telepon_ibu,
            'father_address' => $request->alamat_ayah,
            'mother_address' => $request->alamat_ibu,
            'birth_date' => $request->tanggal_lahir,
            'birth_place' => $request->tempat_lahir,
            'gender' => $request->gender,
            'class' => $request->class,
        ];

        try {
            $student->update($updateData);

            return redirect()->route('students.show', $student->id)
                             ->with('success', 'Data mahasiswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data mahasiswa berhasil dihapus'
                ]);
            }
            
            return redirect()->route('students.index')
                             ->with('success', 'Data mahasiswa berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data'
                ], 500);
            }
            
            return redirect()->route('students.index')
                             ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }

    /**
     * Show student financial summary
     */
    public function financialSummary(string $id)
    {
        $student = Student::with(['payments', 'receivables', 'studentFees.fee'])->findOrFail($id);
        
        return view('students.financial-summary', compact('student'));
    }

    /**
     * Show student payment history
     */
    public function paymentHistory(string $id)
    {
        $student = Student::findOrFail($id);
        $payments = $student->payments()->with('user')->latest()->paginate(10);
        
        return view('students.payment-history', compact('student', 'payments'));
    }

    /**
     * Show student debts
     */
    public function debts(string $id)
    {
        $student = Student::findOrFail($id);
        $debts = $student->debts()->latest()->paginate(10);
        
        return view('students.debts', compact('student', 'debts'));
    }
    
    /**
     * Show student receivables (legacy)
     */
    public function receivables(string $id)
    {
        return $this->debts($id);
    }

    /**
     * Show student fees
     */
    public function fees(string $id)
    {
        $student = Student::findOrFail($id);
        $studentFees = $student->studentFees()->with('fee')->latest()->paginate(10);
        
        return view('students.fees', compact('student', 'studentFees'));
    }

    /**
     * Show student scholarship applications
     */
    public function scholarships(string $id)
    {
        $student = Student::findOrFail($id);
        $applications = $student->scholarshipApplications()->with('scholarship')->latest()->paginate(10);
        
        return view('students.scholarships', compact('student', 'applications'));
    }

    /**
     * Recalculate student financial summary
     */
    public function recalculateFinancials(string $id)
    {
        $student = Student::findOrFail($id);
        $student->calculateTotalFees();
        
        return redirect()->back()->with('success', 'Financial summary recalculated successfully');
    }

    /**
     * Search students
     */
    public function search(Request $request)
    {
        $query = Student::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }
        
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $students = $query->paginate(10);
        
        return view('students.index', compact('students'));
    }

    /**
     * API endpoint for student data
     */
    public function api(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('faculty')) {
            $query->where('faculty', $request->faculty);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('cohort_year')) {
            $query->where('cohort_year', $request->cohort_year);
        }

        if ($request->filled('debt_range')) {
            [$min, $max] = explode(',', $request->debt_range);
            $query->whereBetween('total_outstanding', [(float) $min, (float) $max]);
        }
        
        $students = $query->paginate($request->per_page ?? 10);

        return response()->json($students);
    }

    /**
     * Export students to Excel or PDF
     */
    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');
        $filters = $request->only(['status', 'faculty', 'department', 'cohort_year', 'search']);
        
        try {
            if ($format === 'pdf') {
                return $this->exportPdf($request);
            }
            
            return Excel::download(
                new StudentsExport($filters), 
                'students_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Export students to PDF
     */
    public function exportPdf(Request $request)
    {
        $filters = $request->only(['status', 'class', 'study_program', 'search']);
        
        $studentsExport = new StudentsExport($filters);
        $students = $studentsExport->query()->get();
        
        $pdf = Pdf::loadView('students.export-pdf', compact('students'))
                  ->setPaper('a4', 'landscape')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled' => true,
                      'defaultFont' => 'sans-serif'
                  ]);
        
        return $pdf->download('students_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Import students from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);
        
        try {
            Excel::import(new StudentsImport, $request->file('file'));
            
            return redirect()->back()->with('success', 'Students imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
    
    /**
     * Show iGracias integration page
     */
    public function integration()
    {
        return view('students.integration');
    }
    
    /**
     * Show student dashboard with analytics
     */
    public function dashboard(string $id)
    {
        $student = Student::with([
            'payments' => function($query) {
                $query->latest()->limit(5);
            },
            'debts' => function($query) {
                $query->where('status', '!=', 'paid')->latest();
            },
            'major',
            'academicYear',
            'parents'
        ])->findOrFail($id);
        
        // Calculate analytics
        $analytics = [
            'total_debt' => $student->debts()->sum('amount'),
            'total_paid' => $student->payments()->where('status', 'completed')->sum('amount'),
            'overdue_count' => $student->debts()->where('due_date', '<', now())->where('status', '!=', 'paid')->count(),
            'payment_this_month' => $student->payments()->where('status', 'completed')->whereMonth('payment_date', now()->month)->sum('amount'),
            'last_payment_date' => $student->payments()->where('status', 'completed')->latest('payment_date')->value('payment_date'),
        ];
        
        return view('students.dashboard', compact('student', 'analytics'));
    }
    
    /**
     * Show bulk operations page
     */
    public function bulkOperations()
    {
        return view('students.bulk-operations');
    }
    
    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,export',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id'
        ]);
        
        $studentIds = $request->student_ids;
        $action = $request->action;
        
        switch($action) {
            case 'delete':
                Student::whereIn('id', $studentIds)->delete();
                $message = count($studentIds) . ' students deleted successfully';
                break;
                
            case 'activate':
                Student::whereIn('id', $studentIds)->update(['status' => 'active']);
                $message = count($studentIds) . ' students activated successfully';
                break;
                
            case 'deactivate':
                Student::whereIn('id', $studentIds)->update(['status' => 'inactive']);
                $message = count($studentIds) . ' students deactivated successfully';
                break;
                
            case 'export':
                $filters = ['student_ids' => $studentIds];
                return Excel::download(
                    new StudentsExport($filters),
                    'selected_students_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
                );
        }
        
        return redirect()->back()->with('success', $message);
    }
    
    /**
     * Get student analytics data
     */
    public function analytics()
    {
        $analytics = [
            'total_students' => Student::count(),
            'active_students' => Student::where('status', 'active')->count(),
            'inactive_students' => Student::where('status', 'inactive')->count(),
            'graduated_students' => Student::where('status', 'graduated')->count(),
            'dropped_out_students' => Student::where('status', 'dropped_out')->count(),
            'students_with_debt' => Student::where('outstanding_amount', '>', 0)->count(),
            'total_outstanding' => Student::sum('outstanding_amount') ?? 0,
            'students_by_faculty' => Student::selectRaw('faculty, count(*) as count')
                ->groupBy('faculty')
                ->get(),
            'students_by_cohort' => Student::selectRaw('cohort_year, count(*) as count')
                ->groupBy('cohort_year')
                ->orderBy('cohort_year', 'desc')
                ->get(),
            'recent_registrations' => Student::whereDate('created_at', '>=', now()->subDays(30))->count(),
            'new_students' => Student::whereMonth('created_at', now()->month)
                                   ->whereYear('created_at', now()->year)
                                   ->count(),
        ];
        
        return view('students.analytics', compact('analytics'));
    }
    
    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        return Excel::download(new StudentsTemplateExport, 'students_import_template.xlsx');
    }
    
    /**
     * Show import form
     */
    public function importForm()
    {
        return view('students.import');
    }
    
    /**
     * Process import with validation
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120' // 5MB max
        ]);
        
        try {
            $import = new StudentsImport;
            Excel::import($import, $request->file('file'));
            
            $stats = $import->getStats();
            
            return redirect()->route('students.index')->with([
                'success' => 'Import completed successfully!',
                'stats' => $stats
            ]);
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            return redirect()->back()->withErrors([
                'import' => 'Import failed with validation errors.'
            ])->with('failures', $failures);
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'import' => 'Import failed: ' . $e->getMessage()
            ]);
        }
    }
}
