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
        // Sample data mahasiswa untuk STEFIA
        $students = [
            [
                'id' => 1,
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@student.ac.id',
                'nim' => '2019001',
                'class' => 'Teknik Informatika',
                'angkatan' => '2019',
                'semester' => 8,
                'status' => 'Active',
                'tunggakan' => 15000000,
                'phone' => '+62 812-3456-7890'
            ],
            [
                'id' => 2,
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@student.ac.id',
                'nim' => '2020002',
                'class' => 'Sistem Informasi',
                'angkatan' => '2020',
                'semester' => 6,
                'status' => 'Active',
                'tunggakan' => 0,
                'phone' => '+62 813-7890-1234'
            ],
            [
                'id' => 3,
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@student.ac.id',
                'nim' => '2018003',
                'class' => 'Teknik Elektro',
                'angkatan' => '2018',
                'semester' => 9,
                'status' => 'Active',
                'tunggakan' => 7500000,
                'phone' => '+62 814-5678-9012'
            ],
            [
                'id' => 4,
                'name' => 'Dewi Sartika',
                'email' => 'dewi.sartika@student.ac.id',
                'nim' => '2021004',
                'class' => 'Teknik Mesin',
                'angkatan' => '2021',
                'semester' => 4,
                'status' => 'Active',
                'tunggakan' => 2500000,
                'phone' => '+62 815-2345-6789'
            ]
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
        return redirect()->route('students.index')->with('success', 'Data mahasiswa berhasil ditambahkan');
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
