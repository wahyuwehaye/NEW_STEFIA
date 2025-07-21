<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Payment::query()->with(['student', 'user', 'verifiedBy']);

        // Apply filters
        if (isset($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (isset($this->filters['payment_method'])) {
            $query->where('payment_method', $this->filters['payment_method']);
        }

        if (isset($this->filters['payment_type'])) {
            $query->where('payment_type', $this->filters['payment_type']);
        }

        if (isset($this->filters['date_from'])) {
            $query->where('payment_date', '>=', $this->filters['date_from']);
        }

        if (isset($this->filters['date_to'])) {
            $query->where('payment_date', '<=', $this->filters['date_to']);
        }

        if (isset($this->filters['student_id'])) {
            $query->where('student_id', $this->filters['student_id']);
        }

        return $query->orderBy('payment_date', 'desc');
    }

    public function headings(): array
    {
        return [
            'Kode Pembayaran',
            'Nama Mahasiswa',
            'NIM',
            'Jumlah',
            'Tanggal Pembayaran',
            'Metode Pembayaran',
            'Tipe Pembayaran',
            'Nomor Referensi',
            'Status',
            'Deskripsi',
            'Catatan',
            'Dibuat Oleh',
            'Diverifikasi Oleh',
            'Tanggal Dibuat',
            'Tanggal Verifikasi'
        ];
    }

    public function map($payment): array
    {
        return [
            $payment->payment_code,
            $payment->student->name ?? 'N/A',
            $payment->student->nim ?? 'N/A',
            $payment->amount,
            $payment->payment_date->format('d/m/Y'),
            $payment->payment_method_label,
            $payment->payment_type_label,
            $payment->reference_number,
            $payment->status_label,
            $payment->description,
            $payment->notes,
            $payment->user->name ?? 'N/A',
            $payment->verifiedBy->name ?? '-',
            $payment->created_at->format('d/m/Y H:i'),
            $payment->verified_at ? $payment->verified_at->format('d/m/Y H:i') : '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],

            // Style the amount column
            'D' => ['numberFormat' => ['formatCode' => '#,##0']],
        ];
    }
}
