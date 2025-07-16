<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentFee;
use App\Models\Fee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentService
{
    /**
     * Create a new student with related data
     */
    public function createStudent(array $data): Student
    {
        DB::beginTransaction();
        
        try {
            $student = Student::create($data);
            
            // Auto-assign mandatory fees for the student's class/program
            $this->assignMandatoryFees($student);
            
            // Calculate total fees
            $student->calculateTotalFees();
            
            DB::commit();
            
            Log::info('Student created successfully', ['student_id' => $student->id]);
            
            return $student;
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Student creation failed', [
                'data' => $data,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Update student and recalculate fees if necessary
     */
    public function updateStudent(Student $student, array $data): Student
    {
        DB::beginTransaction();
        
        try {
            $oldClass = $student->class;
            $oldProgram = $student->program_study;
            $oldAcademicYear = $student->academic_year;
            
            $student->update($data);
            
            // Check if class, program, or academic year changed
            if ($oldClass !== $student->class || 
                $oldProgram !== $student->program_study || 
                $oldAcademicYear !== $student->academic_year) {
                
                // Reassign fees based on new criteria
                $this->reassignFees($student);
            }
            
            DB::commit();
            
            Log::info('Student updated successfully', ['student_id' => $student->id]);
            
            return $student;
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Student update failed', [
                'student_id' => $student->id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }
    
    /**
     * Assign mandatory fees to a student
     */
    private function assignMandatoryFees(Student $student): void
    {
        $fees = Fee::where('status', 'active')
            ->where('is_mandatory', true)
            ->where('academic_year', $student->academic_year)
            ->where(function ($query) use ($student) {
                $query->whereNull('applicable_class')
                      ->orWhere('applicable_class', $student->class);
            })
            ->where(function ($query) use ($student) {
                $query->whereNull('applicable_program')
                      ->orWhere('applicable_program', $student->program_study);
            })
            ->get();
        
        foreach ($fees as $fee) {
            StudentFee::create([
                'student_id' => $student->id,
                'fee_id' => $fee->id,
                'amount' => $fee->amount,
                'due_date' => $fee->effective_date,
                'assigned_by' => auth()->id() ?? 1,
                'assigned_at' => now(),
                'outstanding_amount' => $fee->amount,
            ]);
        }
    }
    
    /**
     * Reassign fees when student criteria change
     */
    private function reassignFees(Student $student): void
    {
        // Remove old fee assignments that are no longer applicable
        $student->studentFees()->where('paid_amount', 0)->delete();
        
        // Assign new mandatory fees
        $this->assignMandatoryFees($student);
        
        // Recalculate total fees
        $student->calculateTotalFees();
    }
    
    /**
     * Get student financial summary
     */
    public function getFinancialSummary(Student $student): array
    {
        $totalFees = $student->studentFees()->sum('amount');
        $paidAmount = $student->payments()->where('status', 'completed')->sum('amount');
        $outstandingAmount = $totalFees - $paidAmount;
        
        $overdueReceivables = $student->receivables()
            ->where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->sum('outstanding_amount');
        
        $upcomingReceivables = $student->receivables()
            ->where('status', '!=', 'paid')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(30))
            ->sum('outstanding_amount');
        
        return [
            'total_fees' => $totalFees,
            'paid_amount' => $paidAmount,
            'outstanding_amount' => $outstandingAmount,
            'overdue_amount' => $overdueReceivables,
            'upcoming_amount' => $upcomingReceivables,
            'payment_percentage' => $totalFees > 0 ? ($paidAmount / $totalFees) * 100 : 0,
            'status' => $this->getPaymentStatus($paidAmount, $outstandingAmount),
        ];
    }
    
    /**
     * Get payment status for student
     */
    private function getPaymentStatus(float $paidAmount, float $outstandingAmount): string
    {
        if ($outstandingAmount <= 0) {
            return 'paid';
        } elseif ($paidAmount > 0) {
            return 'partial';
        } else {
            return 'pending';
        }
    }
    
    /**
     * Generate student report data
     */
    public function generateStudentReport(array $filters = []): array
    {
        $query = Student::query();
        
        // Apply filters
        if (!empty($filters['class'])) {
            $query->where('class', $filters['class']);
        }
        
        if (!empty($filters['program_study'])) {
            $query->where('program_study', $filters['program_study']);
        }
        
        if (!empty($filters['academic_year'])) {
            $query->where('academic_year', $filters['academic_year']);
        }
        
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        $students = $query->with(['payments', 'receivables', 'studentFees'])
                          ->get();
        
        $summary = [
            'total_students' => $students->count(),
            'active_students' => $students->where('status', 'active')->count(),
            'total_fees' => $students->sum('total_fee'),
            'total_paid' => $students->sum('paid_amount'),
            'total_outstanding' => $students->sum('outstanding_amount'),
        ];
        
        return [
            'students' => $students,
            'summary' => $summary,
        ];
    }
    
    /**
     * Get students with outstanding payments
     */
    public function getStudentsWithOutstandingPayments(): array
    {
        $students = Student::where('outstanding_amount', '>', 0)
            ->with(['receivables' => function ($query) {
                $query->where('status', '!=', 'paid');
            }])
            ->get();
        
        return $students->map(function ($student) {
            return [
                'student' => $student,
                'overdue_count' => $student->receivables
                    ->where('due_date', '<', now())
                    ->count(),
                'overdue_amount' => $student->receivables
                    ->where('due_date', '<', now())
                    ->sum('outstanding_amount'),
            ];
        })->toArray();
    }
    
    /**
     * Bulk import students
     */
    public function bulkImportStudents(array $studentsData): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => [],
        ];
        
        DB::beginTransaction();
        
        try {
            foreach ($studentsData as $index => $data) {
                try {
                    $this->createStudent($data);
                    $results['success']++;
                } catch (\Exception $e) {
                    $results['failed']++;
                    $results['errors'][] = [
                        'row' => $index + 1,
                        'data' => $data,
                        'error' => $e->getMessage()
                    ];
                }
            }
            
            DB::commit();
            
            Log::info('Bulk import completed', $results);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Bulk import failed', [
                'error' => $e->getMessage(),
                'results' => $results
            ]);
            
            throw $e;
        }
        
        return $results;
    }
}
