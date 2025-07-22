<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::orderBy('created_at', 'desc')->get();
        return view('students.index', compact('students'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students,nim',
            'email' => 'nullable|email|unique:students,email',
            'class' => 'nullable|string|max:100',
            'angkatan' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'semester' => 'nullable|integer|min:1|max:14',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:50',
        ]);
        $student = new Student();
        $student->name = $validated['name'];
        $student->nim = $validated['nim'];
        $student->email = $validated['email'] ?? null;
        $student->class = $validated['class'] ?? null;
        $student->cohort_year = $validated['angkatan'] ?? null;
        $student->current_semester = $validated['semester'] ?? null;
        $student->phone = $validated['phone'] ?? null;
        $student->status = $validated['status'] ?? 'active';
        $student->save();
        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil ditambahkan');
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:students,nim,' . $id,
            'email' => 'nullable|email|unique:students,email,' . $id,
            'class' => 'nullable|string|max:100',
            'angkatan' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'semester' => 'nullable|integer|min:1|max:14',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:50',
        ]);
        $student->name = $validated['name'];
        $student->nim = $validated['nim'];
        $student->email = $validated['email'] ?? null;
        $student->class = $validated['class'] ?? null;
        $student->cohort_year = $validated['angkatan'] ?? null;
        $student->current_semester = $validated['semester'] ?? null;
        $student->phone = $validated['phone'] ?? null;
        $student->status = $validated['status'] ?? 'active';
        $student->save();
        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
    
    /**
     * Show import page for students data
     */
    public function import()
    {
        return view('students.import');
    }
    
    /**
     * Process import of students data
     */
    public function processImport(Request $request)
    {
        // Logic untuk import data dari Excel/CSV
        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil diimport');
    }
    
    /**
     * Show integration page with iGracias
     */
    public function integration()
    {
        return view('students.integration');
    }
}
