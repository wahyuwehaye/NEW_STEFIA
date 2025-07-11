<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For now, return a simple view with sample data
        $students = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'class' => 'X-A', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'class' => 'X-B', 'status' => 'Active'],
            ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com', 'class' => 'XI-A', 'status' => 'Inactive'],
        ];
        
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
        // TODO: Implement store logic
        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TODO: Implement show logic
        return view('students.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // TODO: Implement edit logic
        return view('students.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implement update logic
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Implement destroy logic
        return redirect()->route('students.index')->with('success', 'Student deleted successfully');
    }
}
