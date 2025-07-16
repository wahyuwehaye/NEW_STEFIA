<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BasicStudentController extends Controller
{
    public function index(): JsonResponse
    {
        $students = Student::all();
        
        return response()->json([
            'data' => $students
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'student_id' => 'required|string|unique:students,student_id',
            'study_program' => 'required|string',
            'status' => 'required|in:active,inactive,graduated'
        ]);

        $student = Student::create($validated);

        return response()->json([
            'data' => $student
        ], 201);
    }

    public function show(Student $student): JsonResponse
    {
        return response()->json([
            'data' => $student
        ]);
    }

    public function update(Request $request, Student $student): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $student->id,
            'student_id' => 'sometimes|string|unique:students,student_id,' . $student->id,
            'study_program' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive,graduated'
        ]);

        $student->update($validated);

        return response()->json([
            'data' => $student
        ]);
    }

    public function destroy(Student $student): JsonResponse
    {
        $student->delete();

        return response()->json(null, 204);
    }
}
