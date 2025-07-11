<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TunggakanController extends Controller
{
    /**
     * Display a listing of students with outstanding balance > 10 million.
     */
    public function index()
    {
        // Sample data untuk tunggakan > 10 juta
        $tunggakan = [
            [
                'id' => 1,
                'student_name' => 'Ahmad Fauzi',
                'nim' => '2019001',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => '2019',
                'total_tunggakan' => 15000000,
                'semester' => 8,
                'status_nde' => 'Belum',
                'status_dosen_wali' => 'Sudah',
                'status_surat' => 'Sudah',
                'status_telepon' => 'Sudah',
                'status_home_visit' => 'Belum',
                'last_payment' => '2024-01-15',
                'created_at' => '2024-01-01'
            ],
            [
                'id' => 2,
                'student_name' => 'Siti Nurhaliza',
                'nim' => '2018002',
                'jurusan' => 'Sistem Informasi',
                'angkatan' => '2018',
                'total_tunggakan' => 12500000,
                'semester' => 9,
                'status_nde' => 'Sudah',
                'status_dosen_wali' => 'Sudah',
                'status_surat' => 'Sudah',
                'status_telepon' => 'Sudah',
                'status_home_visit' => 'Sudah',
                'last_payment' => '2023-12-20',
                'created_at' => '2023-12-01'
            ],
            [
                'id' => 3,
                'student_name' => 'Budi Santoso',
                'nim' => '2020003',
                'jurusan' => 'Teknik Elektro',
                'angkatan' => '2020',
                'total_tunggakan' => 18750000,
                'semester' => 6,
                'status_nde' => 'Belum',
                'status_dosen_wali' => 'Belum',
                'status_surat' => 'Belum',
                'status_telepon' => 'Belum',
                'status_home_visit' => 'Belum',
                'last_payment' => '2024-02-10',
                'created_at' => '2024-02-01'
            ]
        ];

        return view('tunggakan.index', compact('tunggakan'));
    }

    /**
     * Update follow-up status for a student.
     */
    public function updateStatus(Request $request, $id)
    {
        // Logic untuk update status tindakan follow-up
        return redirect()->route('tunggakan.index')->with('success', 'Status tindakan berhasil diupdate');
    }

    /**
     * Export tunggakan data to PDF.
     */
    public function exportPdf()
    {
        // Logic untuk export ke PDF
        return response()->download(storage_path('app/exports/tunggakan.pdf'));
    }

    /**
     * Export tunggakan data to Excel.
     */
    public function exportExcel()
    {
        // Logic untuk export ke Excel
        return response()->download(storage_path('app/exports/tunggakan.xlsx'));
    }
}
