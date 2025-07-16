<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Student;
use App\Models\Receivable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process a payment and update related records
     */
    public function processPayment(Payment $payment): bool
    {
        DB::beginTransaction();
        
        try {
            // Mark payment as completed
            $payment->update([
                'status' => 'completed',
                'verified_at' => now(),
            ]);
            
            // Update student payment summary
            $this->updateStudentPaymentSummary($payment->student);
            
            // Update related receivables
            $this->updateReceivables($payment);
            
            DB::commit();
            
            Log::info('Payment processed successfully', ['payment_id' => $payment->id]);
            
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Payment processing failed', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage()
            ]);
            
            return false;
        }
    }
    
    /**
     * Update student payment summary
     */
    private function updateStudentPaymentSummary(Student $student): void
    {
        $completedPayments = $student->payments()
            ->where('status', 'completed')
            ->sum('amount');
        
        $student->update([
            'paid_amount' => $completedPayments,
            'outstanding_amount' => max(0, $student->total_fee - $completedPayments),
        ]);
    }
    
    /**
     * Update receivables based on payment
     */
    private function updateReceivables(Payment $payment): void
    {
        $receivables = $payment->student->receivables()
            ->where('status', '!=', 'paid')
            ->orderBy('due_date', 'asc')
            ->get();
        
        $remainingAmount = $payment->amount;
        
        foreach ($receivables as $receivable) {
            if ($remainingAmount <= 0) break;
            
            $outstandingAmount = $receivable->outstanding_amount;
            $paymentAmount = min($remainingAmount, $outstandingAmount);
            
            $receivable->paid_amount += $paymentAmount;
            $receivable->outstanding_amount -= $paymentAmount;
            
            if ($receivable->outstanding_amount <= 0) {
                $receivable->status = 'paid';
            } else {
                $receivable->status = 'partial';
            }
            
            $receivable->save();
            $remainingAmount -= $paymentAmount;
        }
    }
    
    /**
     * Calculate payment statistics
     */
    public function getPaymentStats(array $filters = []): array
    {
        $query = Payment::query();
        
        // Apply filters
        if (!empty($filters['date_from'])) {
            $query->where('payment_date', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->where('payment_date', '<=', $filters['date_to']);
        }
        
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        return [
            'total_amount' => $query->sum('amount'),
            'total_count' => $query->count(),
            'average_amount' => $query->avg('amount'),
            'completed_amount' => $query->where('status', 'completed')->sum('amount'),
            'pending_amount' => $query->where('status', 'pending')->sum('amount'),
        ];
    }
    
    /**
     * Generate payment report data
     */
    public function generatePaymentReport(array $filters = []): array
    {
        $query = Payment::with(['student', 'user']);
        
        // Apply filters
        if (!empty($filters['date_from'])) {
            $query->where('payment_date', '>=', $filters['date_from']);
        }
        
        if (!empty($filters['date_to'])) {
            $query->where('payment_date', '<=', $filters['date_to']);
        }
        
        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }
        
        if (!empty($filters['payment_type'])) {
            $query->where('payment_type', $filters['payment_type']);
        }
        
        $payments = $query->orderBy('payment_date', 'desc')->get();
        
        return [
            'payments' => $payments,
            'summary' => $this->getPaymentStats($filters),
        ];
    }
    
    /**
     * Validate payment data
     */
    public function validatePayment(array $data): array
    {
        $errors = [];
        
        // Check if student exists and is active
        $student = Student::find($data['student_id']);
        if (!$student || $student->status !== 'active') {
            $errors[] = 'Student not found or not active';
        }
        
        // Check payment amount
        if ($data['amount'] <= 0) {
            $errors[] = 'Payment amount must be greater than 0';
        }
        
        // Check payment date
        if ($data['payment_date'] > now()->toDateString()) {
            $errors[] = 'Payment date cannot be in the future';
        }
        
        return $errors;
    }
    
    /**
     * Get payment recommendations for a student
     */
    public function getPaymentRecommendations(Student $student): array
    {
        $recommendations = [];
        
        // Get overdue receivables
        $overdueReceivables = $student->receivables()
            ->where('status', '!=', 'paid')
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->get();
        
        if ($overdueReceivables->isNotEmpty()) {
            $totalOverdue = $overdueReceivables->sum('outstanding_amount');
            $recommendations[] = [
                'type' => 'overdue',
                'message' => "Student has overdue receivables totaling Rp " . number_format($totalOverdue, 2),
                'amount' => $totalOverdue,
                'priority' => 'high'
            ];
        }
        
        // Get upcoming receivables
        $upcomingReceivables = $student->receivables()
            ->where('status', '!=', 'paid')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(30))
            ->orderBy('due_date', 'asc')
            ->get();
        
        if ($upcomingReceivables->isNotEmpty()) {
            $totalUpcoming = $upcomingReceivables->sum('outstanding_amount');
            $recommendations[] = [
                'type' => 'upcoming',
                'message' => "Student has upcoming receivables totaling Rp " . number_format($totalUpcoming, 2),
                'amount' => $totalUpcoming,
                'priority' => 'medium'
            ];
        }
        
        return $recommendations;
    }
}
