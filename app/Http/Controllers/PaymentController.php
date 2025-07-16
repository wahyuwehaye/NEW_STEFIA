<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
     * Export payments to Excel/CSV
     */
    public function export(Request $request)
    {
        // Implementation for export functionality
        // This would typically use a package like Laravel Excel
        return response()->json(['message' => 'Export functionality to be implemented']);
    }
}
