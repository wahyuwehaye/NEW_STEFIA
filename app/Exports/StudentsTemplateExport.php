<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class StudentsTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    /**
     * @return array
     */
    public function array(): array
    {
        return [
            // Sample data rows
            [
                '20230001',
                'John Doe',
                'Fakultas Teknik',
                'Teknik Informatika',
                'active',
                'active',
                '5000000',
                '2500000',
                '2500000',
                'SPP',
                '0',
                '081234567890',
                'john.doe@email.com',
                'Jl. Contoh No. 123, Jakarta',
                '2023',
                '2023/2024',
                'Budi Santoso',
            ],
            [
                '20230002',
                'Jane Smith',
                'Fakultas Ekonomi',
                'Manajemen',
                'active',
                'active',
                '4500000',
                '4500000',
                '0',
                'SPP',
                '0',
                '081234567891',
                'jane.smith@email.com',
                'Jl. Contoh No. 456, Bandung',
                '2023',
                '2023/2024',
                'Siti Rahayu',
            ],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIM',
            'NAMA',
            'FAKULTAS',
            'PROGRAM STUDI',
            'STATUS REGISTRASI',
            'STATUS MAHASISWA',
            'TAGIHAN',
            'PEMBAYARAN',
            'TOTAL PIUTANG',
            'KOMPONEN',
            'JUMLAH SEMESTER MENUNGGAK',
            'TELEPON',
            'EMAIL',
            'ALAMAT',
            'TAHUN ANGKATAN',
            'TAHUN AKADEMIK',
            'ORANG TUA/WALI',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Add instructions in a separate worksheet or comments
        $sheet->setCellValue('A20', 'PETUNJUK PENGISIAN:');
        $sheet->setCellValue('A21', '1. NIM: Nomor Induk Mahasiswa (wajib, unik)');
        $sheet->setCellValue('A22', '2. NAMA: Nama lengkap mahasiswa (wajib)');
        $sheet->setCellValue('A23', '3. FAKULTAS: Nama fakultas (wajib)');
        $sheet->setCellValue('A24', '4. PROGRAM STUDI: Nama program studi (wajib)');
        $sheet->setCellValue('A25', '5. STATUS REGISTRASI: active, inactive, graduated, dropped_out');
        $sheet->setCellValue('A26', '6. STATUS MAHASISWA: active, inactive, graduated, dropped_out');
        $sheet->setCellValue('A27', '7. TAGIHAN: Jumlah tagihan dalam rupiah (angka)');
        $sheet->setCellValue('A28', '8. PEMBAYARAN: Jumlah pembayaran dalam rupiah (angka)');
        $sheet->setCellValue('A29', '9. TOTAL PIUTANG: Sisa tagihan dalam rupiah (angka)');
        $sheet->setCellValue('A30', '10. KOMPONEN: Komponen biaya (SPP, Daftar Ulang, dll)');
        $sheet->setCellValue('A31', '11. JUMLAH SEMESTER MENUNGGAK: Jumlah semester (angka)');
        $sheet->setCellValue('A32', '12. TELEPON: Nomor telepon mahasiswa');
        $sheet->setCellValue('A33', '13. EMAIL: Email mahasiswa (wajib, unik)');
        $sheet->setCellValue('A34', '14. ALAMAT: Alamat lengkap mahasiswa');
        $sheet->setCellValue('A35', '15. TAHUN ANGKATAN: Tahun masuk (format: 2023)');
        $sheet->setCellValue('A36', '16. TAHUN AKADEMIK: Format: 2023/2024');
        $sheet->setCellValue('A37', '17. ORANG TUA/WALI: Nama orang tua atau wali');
        
        return [
            // Style the header row
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '2563EB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
            // Style the data rows
            2 => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'],
                ],
            ],
            3 => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F3F4F6'],
                ],
            ],
            // Style instructions
            'A20:A37' => [
                'font' => [
                    'size' => 10,
                    'italic' => true,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FEF3C7'],
                ],
            ],
            'A20' => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Students Import Template';
    }
}
