<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Controller as BaseController;

class IGraciasDummyController extends BaseController
{
    public function students(Request $request)
    {
        return response()->json([
            'data' => [
                'students' => [[
                    'nim' => 'DUMMY001',
                    'name' => 'Dummy Student',
                    'email' => 'dummy@student.ac.id',
                    'faculty' => 'Dummy Faculty',
                    'status' => 'active',
                ]],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]
        ]);
    }

    public function studentDetail($nim)
    {
        return response()->json([
            'data' => [
                'nim' => $nim,
                'name' => 'Dummy Student',
                'email' => 'dummy@student.ac.id',
                'phone' => '08123456789',
                'birth_place' => 'Bandung',
                'birth_date' => '2000-01-01',
                'faculty' => 'Dummy Faculty',
                'department' => 'Teknik Informatika',
                'cohort_year' => 2019,
                'current_semester' => 8,
                'status' => 'active',
                'total_outstanding' => 5000000,
                'outstanding_semesters' => 1,
                'last_payment_date' => '2024-01-01',
                'is_reminded' => false,
                'external_id' => 'igracias-001'
            ]
        ]);
    }

    public function payments(Request $request)
    {
        return response()->json([
            'data' => [
                'payments' => [[
                    'payment_id' => 'DUMMY-PAY-001',
                    'nim' => 'DUMMY001',
                    'name' => 'Dummy Student',
                    'amount' => 1000000,
                    'payment_date' => '2024-01-01',
                    'payment_method' => 'bank_transfer',
                    'payment_type' => 'SPP',
                    'status' => 'completed',
                    'description' => 'Dummy payment',
                    'reference_number' => 'DUMMY-REF-001'
                ]],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]
        ]);
    }

    public function paymentDetail($paymentId)
    {
        return response()->json([
            'data' => [
                'payment_id' => $paymentId,
                'nim' => 'DUMMY001',
                'name' => 'Dummy Student',
                'amount' => 1000000,
                'payment_date' => '2024-01-01',
                'payment_method' => 'bank_transfer',
                'payment_type' => 'SPP',
                'status' => 'completed',
                'description' => 'Dummy payment',
                'reference_number' => 'DUMMY-REF-001'
            ]
        ]);
    }

    public function receivables(Request $request)
    {
        return response()->json([
            'data' => [
                'receivables' => [[
                    'debt_id' => 'DUMMY-RCV-001',
                    'nim' => 'DUMMY001',
                    'name' => 'Dummy Student',
                    'fee_type' => 'SPP',
                    'amount' => 2000000,
                    'paid_amount' => 500000,
                    'outstanding_amount' => 1500000,
                    'due_date' => '2024-02-01',
                    'status' => 'partial',
                    'description' => 'Dummy receivable'
                ]],
                'pagination' => [
                    'current_page' => 1,
                    'last_page' => 1
                ]
            ]
        ]);
    }

    public function receivableDetail($receivableId)
    {
        return response()->json([
            'data' => [
                'debt_id' => $receivableId,
                'nim' => 'DUMMY001',
                'name' => 'Dummy Student',
                'fee_type' => 'SPP',
                'amount' => 2000000,
                'paid_amount' => 500000,
                'outstanding_amount' => 1500000,
                'due_date' => '2024-02-01',
                'status' => 'partial',
                'description' => 'Dummy receivable'
            ]
        ]);
    }
} 