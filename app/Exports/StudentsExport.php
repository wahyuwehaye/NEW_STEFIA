<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Database\Eloquent\Builder;

class StudentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Query for the export
     */
    public function query()
    {
        return Student::query()
            ->with(['major', 'academicYear', 'parents'])
            ->select([
                'students.*'
            ])
            ->when(isset($this->filters['status']), function ($query) {
                $query->where('status', $this->filters['status']);
            })
            ->when(isset($this->filters['class']), function ($query) {
                $query->where('class', $this->filters['class']);
            })
            ->when(isset($this->filters['faculty']), function ($query) {
                $query->where('faculty', $this->filters['faculty']);
            })
            ->when(isset($this->filters['department']), function ($query) {
                $query->where('department', $this->filters['department']);
            })
            ->when(isset($this->filters['cohort_year']), function ($query) {
                $query->where('cohort_year', $this->filters['cohort_year']);
            })
            ->when(isset($this->filters['student_ids']), function ($query) {
                $query->whereIn('id', $this->filters['student_ids']);
            })
            ->when(isset($this->filters['search']), function ($query) {
                $search = $this->filters['search'];
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name');
    }

    /**
     * Define the headings for the export
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
            'CREATED AT',
            'UPDATED AT',
        ];
    }

    /**
     * Map the data for each row
     */
    public function map($student): array
    {
        $parentNames = $student->parents->pluck('name')->implode(', ');
        
        return [
            $student->nim ?: $student->student_id,
            $student->name,
            $student->faculty,
            $student->program_study,
            $student->status,
            ucfirst($student->status),
            $student->total_fee ? 'Rp ' . number_format($student->total_fee, 0, ',', '.') : 'Rp 0',
            $student->paid_amount ? 'Rp ' . number_format($student->paid_amount, 0, ',', '.') : 'Rp 0',
            $student->outstanding_amount ? 'Rp ' . number_format($student->outstanding_amount, 0, ',', '.') : 'Rp 0',
            $student->class,
            $student->semester_menunggak ?: 0,
            $student->phone,
            $student->email,
            $student->address,
            $student->cohort_year,
            $student->academicYear->year ?? $student->academic_year,
            $parentNames,
            $student->created_at->format('d/m/Y H:i'),
            $student->updated_at->format('d/m/Y H:i'),
        ];
    }

    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E11D48'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            // Style all cells
            'A:N' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Set the title for the worksheet
     */
    public function title(): string
    {
        return 'Students Data';
    }
}
