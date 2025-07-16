<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Scholarship::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('scholarship_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $scholarships = $query->latest()->paginate(15);
        
        return view('scholarships.index', compact('scholarships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('scholarships.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:academic,achievement,financial_need,sports,arts,research,other',
            'amount' => 'required|numeric|min:0',
            'amount_type' => 'required|in:fixed,percentage',
            'percentage' => 'required_if:amount_type,percentage|nullable|numeric|min:0|max:100',
            'academic_year' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after:application_start_date',
            'announcement_date' => 'nullable|date|after:application_end_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $scholarship = Scholarship::create(array_merge($request->all(), [
            'created_by' => Auth::id(),
            'status' => 'draft',
        ]));

        return redirect()->route('scholarships.show', $scholarship->id)
                         ->with('success', 'Scholarship created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $scholarship = Scholarship::with('applications.student')->findOrFail($id);
        return view('scholarships.show', compact('scholarship'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        return view('scholarships.edit', compact('scholarship'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $scholarship = Scholarship::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:academic,achievement,financial_need,sports,arts,research,other',
            'amount' => 'required|numeric|min:0',
            'amount_type' => 'required|in:fixed,percentage',
            'percentage' => 'required_if:amount_type,percentage|nullable|numeric|min:0|max:100',
            'academic_year' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'application_start_date' => 'required|date',
            'application_end_date' => 'required|date|after:application_start_date',
            'announcement_date' => 'nullable|date|after:application_end_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $scholarship->update($request->all());

        return redirect()->route('scholarships.show', $scholarship->id)
                         ->with('success', 'Scholarship updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scholarship = Scholarship::findOrFail($id);

        if ($scholarship->applications()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete scholarship with applications');
        }

        $scholarship->delete();

        return redirect()->route('scholarships.index')
                         ->with('success', 'Scholarship deleted successfully');
    }

    /**
     * Open scholarship for applications
     */
    public function open(string $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update(['status' => 'open']);

        return redirect()->back()->with('success', 'Scholarship opened for applications');
    }

    /**
     * Close scholarship for applications
     */
    public function close(string $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update(['status' => 'closed']);

        return redirect()->back()->with('success', 'Scholarship closed for applications');
    }

    /**
     * Announce scholarship results
     */
    public function announce(string $id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update(['status' => 'announced']);

        return redirect()->back()->with('success', 'Scholarship results announced');
    }

    /**
     * Apply for a scholarship
     */
    public function apply(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $scholarship = Scholarship::findOrFail($id);

        if ($scholarship->status !== 'open') {
            return redirect()->back()->with('error', 'Scholarship is not open for applications');
        }

        DB::beginTransaction();
        try {
            ScholarshipApplication::create([
                'student_id' => $request->student_id,
                'scholarship_id' => $scholarship->id,
                'status' => 'pending',
                'application_date' => Carbon::now(),
            ]);

            DB::commit();

            return redirect()->route('scholarships.show', $scholarship->id)
                             ->with('success', 'Application submitted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to submit application: ' . $e->getMessage());
        }
    }

    /**
     * Approve scholarship application
     */
    public function approveApplication(string $applicationId)
    {
        $application = ScholarshipApplication::findOrFail($applicationId);
        
        $application->update([
            'status' => 'approved',
            'approved_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Application approved');
    }

    /**
     * Reject scholarship application
     */
    public function rejectApplication(Request $request, string $applicationId)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $application = ScholarshipApplication::findOrFail($applicationId);
        
        $application->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'reviewed_by' => Auth::id(),
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Application rejected');
    }

    /**
     * Dashboard statistics
     */
    public function dashboard()
    {
        $scholarshipCount = Scholarship::count();
        $applicationCount = ScholarshipApplication::count();
        $approvedCount = ScholarshipApplication::where('status', 'approved')->count();
        $rejectedCount = ScholarshipApplication::where('status', 'rejected')->count();
        
        $recentApplications = ScholarshipApplication::with(['student', 'scholarship'])
                                    ->latest()
                                    ->take(10)
                                    ->get();

        return view('scholarships.dashboard', compact('scholarshipCount', 'applicationCount', 'approvedCount', 'rejectedCount', 'recentApplications'));
    }
}
