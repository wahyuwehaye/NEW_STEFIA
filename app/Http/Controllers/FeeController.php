<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Student;
use App\Models\StudentFee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Fee::with(['createdBy']);
        
        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('fee_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }
        
        $fees = $query->latest()->paginate(15);
        
        return view('fees.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tuition,registration,exam,library,laboratory,uniform,book,activity,other',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:one_time,monthly,quarterly,semester,annual',
            'academic_year' => 'required|string|max:255',
            'applicable_class' => 'nullable|string|max:255',
            'applicable_program' => 'nullable|string|max:255',
            'effective_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'is_mandatory' => 'required|boolean',
            'penalty_rate' => 'required|numeric|min:0|max:100',
            'grace_period_days' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fee = Fee::create(array_merge($request->all(), [
            'created_by' => Auth::id(),
            'status' => 'active',
        ]));

        return redirect()->route('fees.show', $fee->id)
                         ->with('success', 'Fee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fee = Fee::with(['createdBy', 'studentFees.student'])->findOrFail($id);
        return view('fees.show', compact('fee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fee = Fee::findOrFail($id);
        return view('fees.edit', compact('fee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fee = Fee::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:tuition,registration,exam,library,laboratory,uniform,book,activity,other',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:one_time,monthly,quarterly,semester,annual',
            'academic_year' => 'required|string|max:255',
            'applicable_class' => 'nullable|string|max:255',
            'applicable_program' => 'nullable|string|max:255',
            'effective_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:effective_date',
            'is_mandatory' => 'required|boolean',
            'penalty_rate' => 'required|numeric|min:0|max:100',
            'grace_period_days' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fee->update($request->all());

        return redirect()->route('fees.show', $fee->id)
                         ->with('success', 'Fee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fee = Fee::findOrFail($id);
        
        // Check if fee is assigned to any students
        if ($fee->studentFees()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete fee that is assigned to students');
        }
        
        $fee->delete();

        return redirect()->route('fees.index')
                         ->with('success', 'Fee deleted successfully');
    }

    /**
     * Assign fee to students
     */
    public function assignToStudents(Request $request, string $id)
    {
        $fee = Fee::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'due_date' => 'required|date',
            'discount_amount' => 'nullable|numeric|min:0',
            'discount_reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($request->student_ids as $studentId) {
                // Check if already assigned
                if (StudentFee::where('student_id', $studentId)->where('fee_id', $fee->id)->exists()) {
                    continue;
                }

                StudentFee::create([
                    'student_id' => $studentId,
                    'fee_id' => $fee->id,
                    'amount' => $fee->amount - ($request->discount_amount ?? 0),
                    'due_date' => $request->due_date,
                    'discount_amount' => $request->discount_amount ?? 0,
                    'discount_reason' => $request->discount_reason,
                    'assigned_by' => Auth::id(),
                    'assigned_at' => now(),
                    'outstanding_amount' => $fee->amount - ($request->discount_amount ?? 0),
                ]);
            }

            DB::commit();

            return redirect()->route('fees.show', $fee->id)
                           ->with('success', 'Fee assigned to students successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to assign fee: ' . $e->getMessage());
        }
    }

    /**
     * Remove fee assignment from student
     */
    public function removeFromStudent(string $feeId, string $studentId)
    {
        $studentFee = StudentFee::where('fee_id', $feeId)
                                ->where('student_id', $studentId)
                                ->firstOrFail();
        
        if ($studentFee->paid_amount > 0) {
            return redirect()->back()->with('error', 'Cannot remove fee that has been partially paid');
        }
        
        $studentFee->delete();
        
        return redirect()->back()->with('success', 'Fee removed from student successfully');
    }

    /**
     * Show form for assigning fee to students
     */
    public function showAssignForm(string $id)
    {
        $fee = Fee::findOrFail($id);
        $students = Student::active()->get();
        
        return view('fees.assign', compact('fee', 'students'));
    }

    /**
     * Activate fee
     */
    public function activate(string $id)
    {
        $fee = Fee::findOrFail($id);
        $fee->update(['status' => 'active']);
        
        return redirect()->back()->with('success', 'Fee activated successfully');
    }

    /**
     * Deactivate fee
     */
    public function deactivate(string $id)
    {
        $fee = Fee::findOrFail($id);
        $fee->update(['status' => 'inactive']);
        
        return redirect()->back()->with('success', 'Fee deactivated successfully');
    }

    /**
     * Bulk assign fees to students by class or program
     */
    public function bulkAssign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fee_id' => 'required|exists:fees,id',
            'criteria' => 'required|in:class,program,academic_year,all',
            'value' => 'required_unless:criteria,all',
            'due_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $fee = Fee::findOrFail($request->fee_id);
        $query = Student::active();

        switch ($request->criteria) {
            case 'class':
                $query->where('class', $request->value);
                break;
            case 'program':
                $query->where('program_study', $request->value);
                break;
            case 'academic_year':
                $query->where('academic_year', $request->value);
                break;
            case 'all':
                // No additional filter
                break;
        }

        $students = $query->get();
        $assignedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                // Check if already assigned
                if (StudentFee::where('student_id', $student->id)->where('fee_id', $fee->id)->exists()) {
                    continue;
                }

                StudentFee::create([
                    'student_id' => $student->id,
                    'fee_id' => $fee->id,
                    'amount' => $fee->amount,
                    'due_date' => $request->due_date,
                    'assigned_by' => Auth::id(),
                    'assigned_at' => now(),
                    'outstanding_amount' => $fee->amount,
                ]);

                $assignedCount++;
            }

            DB::commit();

            return redirect()->route('fees.show', $fee->id)
                           ->with('success', "Fee assigned to {$assignedCount} students successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to assign fee: ' . $e->getMessage());
        }
    }
}
