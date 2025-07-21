<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $followUps = FollowUp::with(['student', 'performedBy'])
            ->orderBy('action_date', 'desc')
            ->paginate(15);

        return view('followups.index', compact('followUps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::select('id', 'name', 'nim')->orderBy('name')->get();
        return view('followups.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'action_type' => 'required|in:nde_fakultas,dosen_wali,surat_orangtua,telepon,home_visit,other',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'action_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'result' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $followUp = FollowUp::create([
            'student_id' => $request->student_id,
            'action_type' => $request->action_type,
            'title' => $request->title,
            'description' => $request->description,
            'action_date' => $request->action_date,
            'performed_by' => Auth::id(),
            'status' => $request->status,
            'result' => $request->result,
            'notes' => $request->notes,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Follow up berhasil disimpan!',
                'followUp' => $followUp
            ]);
        }

        return redirect()->route('followups.index')
            ->with('success', 'Follow up berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $followUp = FollowUp::with(['student', 'performedBy'])->findOrFail($id);
        return view('followups.show', compact('followUp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $followUp = FollowUp::findOrFail($id);
        $students = Student::select('id', 'name', 'nim')->orderBy('name')->get();
        return view('followups.edit', compact('followUp', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $followUp = FollowUp::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'action_type' => 'required|in:nde_fakultas,dosen_wali,surat_orangtua,telepon,home_visit,other',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'action_date' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'result' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $followUp->update($request->all());

        return redirect()->route('followups.index')
            ->with('success', 'Follow up berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $followUp = FollowUp::findOrFail($id);
        $followUp->delete();

        return redirect()->route('followups.index')
            ->with('success', 'Follow up berhasil dihapus!');
    }
}
