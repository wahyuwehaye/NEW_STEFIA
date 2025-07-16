<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\ParentModel;
use App\Models\AcademicYear;
use App\Models\Major;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading, SkipsOnError, SkipsOnFailure, WithEvents
{
    use Importable;
    
    private $stats = [
        'total_rows' => 0,
        'successful' => 0,
        'failed' => 0,
        'errors' => [],
    ];
    
    /**
     * Create a model instance from a row
     */
    public function model(array $row)
    {
        $this->stats['total_rows']++;
        
        try {
            // Check if student already exists
            $existingStudent = Student::where('nim', $row['nim'])
                ->orWhere('email', $row['email'])
                ->first();
                
            if ($existingStudent) {
                $this->stats['failed']++;
                $this->stats['errors'][] = "Student with NIM {$row['nim']} or email {$row['email']} already exists";
                return null;
            }
            
            // Create or find parent
            $parent = null;
            if (!empty($row['orang_tua_wali'])) {
                $parent = ParentModel::firstOrCreate([
                    'name' => $row['orang_tua_wali'],
                    'phone' => $row['telepon'] ?? null,
                ]);
            }
            
            // Parse financial data
            $tagihan = $this->parseRupiah($row['tagihan'] ?? '0');
            $pembayaran = $this->parseRupiah($row['pembayaran'] ?? '0');
            $totalPiutang = $this->parseRupiah($row['total_piutang'] ?? '0');
            
            $student = new Student([
                'nim' => $row['nim'],
                'name' => $row['nama'],
                'email' => $row['email'],
                'phone' => $row['telepon'],
                'address' => $row['alamat'],
                'faculty' => $row['fakultas'],
                'program_study' => $row['program_studi'],
                'department' => $row['program_studi'], // Assuming program_studi is department
                'cohort_year' => $row['tahun_angkatan'],
                'academic_year' => $row['tahun_akademik'],
                'status' => $row['status_registrasi'],
                'student_status' => $row['status_mahasiswa'],
                'total_fee' => $tagihan,
                'paid_amount' => $pembayaran,
                'outstanding_amount' => $totalPiutang,
                'semester_menunggak' => (int) ($row['jumlah_semester_menunggak'] ?? 0),
                'class' => $row['komponen'], // Using komponen as class for now
                'parent_id' => $parent ? $parent->id : null,
            ]);
            
            $this->stats['successful']++;
            return $student;
            
        } catch (\Exception $e) {
            $this->stats['failed']++;
            $this->stats['errors'][] = "Error processing row {$this->stats['total_rows']}: " . $e->getMessage();
            return null;
        }
    }
    
    /**
     * Parse rupiah string to numeric value
     */
    private function parseRupiah($value)
    {
        if (is_numeric($value)) {
            return (float) $value;
        }
        
        // Remove Rp, spaces from the value
        $cleaned = preg_replace('/[Rp\s]/', '', $value);
        
        // Handle both comma and dot as decimal separator
        // If there's a dot after comma, assume comma is thousands separator
        if (strpos($cleaned, ',') !== false && strpos($cleaned, '.') !== false) {
            // Format like 1,000.50 - remove comma (thousands separator)
            $cleaned = str_replace(',', '', $cleaned);
        } elseif (strpos($cleaned, ',') !== false) {
            // Format like 1,000,000 (Indonesian format) - remove commas
            $cleaned = str_replace(',', '', $cleaned);
        } elseif (strpos($cleaned, '.') !== false) {
            // Check if dot is thousands separator or decimal separator
            $parts = explode('.', $cleaned);
            if (count($parts) > 2 || (count($parts) == 2 && strlen($parts[1]) > 2)) {
                // Multiple dots or more than 2 digits after dot = thousands separator
                $cleaned = str_replace('.', '', $cleaned);
            }
            // else: single dot with 1-2 digits after = decimal separator, keep as is
        }
        
        return is_numeric($cleaned) ? (float) $cleaned : 0;
    }
    
    /**
     * Validation rules for import
     */
    public function rules(): array
    {
        return [
            'nim' => 'required|string|max:20|unique:students,nim',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:students,email',
            'fakultas' => 'required|string|max:100',
            'program_studi' => 'required|string|max:100',
            'status_registrasi' => 'required|in:active,inactive,graduated,dropped_out',
            'status_mahasiswa' => 'nullable|in:active,inactive,graduated,dropped_out',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'tahun_angkatan' => 'required|digits:4|min:2000|max:' . (date('Y') + 5),
            'tahun_akademik' => 'required|string|max:20',
            'tagihan' => 'nullable|string',
            'pembayaran' => 'nullable|string',
            'total_piutang' => 'nullable|string',
            'komponen' => 'nullable|string|max:100',
            'jumlah_semester_menunggak' => 'nullable|integer|min:0',
            'orang_tua_wali' => 'nullable|string|max:255',
        ];
    }
    
    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah ada dalam database.',
            'nama.required' => 'Nama mahasiswa harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'fakultas.required' => 'Fakultas harus diisi.',
            'program_studi.required' => 'Program studi harus diisi.',
            'status_registrasi.required' => 'Status registrasi harus diisi.',
            'status_registrasi.in' => 'Status registrasi harus: active, inactive, graduated, atau dropped_out.',
            'tahun_angkatan.required' => 'Tahun angkatan harus diisi.',
            'tahun_angkatan.digits' => 'Tahun angkatan harus 4 digit.',
            'tahun_akademik.required' => 'Tahun akademik harus diisi.',
        ];
    }
    
    /**
     * Handle errors during import
     */
    public function onError(Throwable $e)
    {
        $this->stats['failed']++;
        $this->stats['errors'][] = $e->getMessage();
    }
    
    /**
     * Handle validation failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->stats['failed']++;
            $this->stats['errors'][] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
        }
    }
    
    /**
     * Register events
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function(BeforeImport $event) {
                $this->stats = [
                    'total_rows' => 0,
                    'successful' => 0,
                    'failed' => 0,
                    'errors' => [],
                ];
            },
            AfterImport::class => function(AfterImport $event) {
                // Log import completion
                \Log::info('Students import completed', $this->stats);
            },
        ];
    }
    
    /**
     * Get import statistics
     */
    public function getStats(): array
    {
        return $this->stats;
    }
    
    /**
     * Batch size for processing
     */
    public function batchSize(): int
    {
        return 100;
    }
    
    /**
     * Chunk size for reading
     */
    public function chunkSize(): int
    {
        return 100;
    }
    
    /**
     * Starting row (skip template instructions)
     */
    public function startRow(): int
    {
        return 2; // Skip header row
    }
}
