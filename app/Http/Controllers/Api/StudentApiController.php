<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Services\StudentService;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class StudentApiController extends Controller
{
    public function __construct(
        private StudentService $studentService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Student::query();
            
            // Apply filters
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
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            if ($request->filled('academic_year')) {
                $query->where('academic_year', $request->academic_year);
            }
            
            $perPage = $request->per_page ?? 15;
            $students = $query->latest()->paginate($perPage);
            
            return response()->json([
                'data' => $students->items(),
                'meta' => [
                    'current_page' => $students->currentPage(),
                    'per_page' => $students->perPage(),
                    'total' => $students->total(),
                    'last_page' => $students->lastPage(),
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve students', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve students'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request): JsonResponse
    {
        try {
            $student = $this->studentService->createStudent($request->validated());
            
            return response()->json([
                'data' => $student
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create student', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $student = Student::with(['payments', 'receivables', 'studentFees.fee'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $student,
                'message' => 'Student retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Student not found'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $updatedStudent = $this->studentService->updateStudent($student, $request->validated());
            
            return response()->json([
                'success' => true,
                'data' => $updatedStudent,
                'message' => 'Student updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update student', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update student: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete student'
            ], 500);
        }
    }
    
    /**
     * Get student financial summary
     */
    public function financialSummary(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $summary = $this->studentService->getFinancialSummary($student);
            
            return response()->json([
                'success' => true,
                'data' => $summary,
                'message' => 'Financial summary retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve financial summary'
            ], 500);
        }
    }
    
    /**
     * Get students with outstanding payments
     */
    public function outstandingPayments(string $id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $data = [
                'student_id' => $student->id,
                'outstanding_receivables' => $student->receivables()->where('status', 'active')->get(),
                'total_outstanding' => $student->receivables()->where('status', 'active')->sum('amount'),
                'overdue_count' => $student->receivables()->where('status', 'active')->where('due_date', '<', now())->count(),
            ];
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Outstanding payments retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve outstanding payments'
            ], 500);
        }
    }

    /**
     * Bulk update students
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'student_ids' => 'required|array',
                'student_ids.*' => 'exists:students,id',
                'status' => 'sometimes|string|in:active,inactive,graduated'
            ]);
            
            $updatedCount = Student::whereIn('id', $request->student_ids)
                ->update(collect($request->only(['status']))->filter()->toArray());
            
            return response()->json([
                'success' => true,
                'message' => 'Students updated successfully',
                'updated_count' => $updatedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update students'
            ], 500);
        }
    }
}
