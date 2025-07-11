<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function financial()
    {
        return view('reports.financial');
    }
    
    public function students()
    {
        return view('reports.students');
    }
    
    public function scholarship()
    {
        return view('reports.scholarship');
    }

    public function monthly()
    {
        // Monthly reports data
        $monthlyData = [
            'total_revenue' => 2847950000,
            'total_students' => 1245,
            'total_payments' => 892,
            'outstanding_balance' => 458320000,
            'monthly_breakdown' => [
                'January' => 2200000000,
                'February' => 2350000000,
                'March' => 2180000000,
                'April' => 2450000000,
                'May' => 2600000000,
                'June' => 2847950000,
            ],
            'payment_methods' => [
                'Bank Transfer' => 45.2,
                'Cash' => 32.8,
                'Credit Card' => 15.5,
                'Scholarship' => 6.5
            ],
            'fee_categories' => [
                'Tuition Fee' => 65.8,
                'Laboratory Fee' => 12.3,
                'Library Fee' => 8.9,
                'Development Fee' => 7.2,
                'Other Fees' => 5.8
            ]
        ];
        
        return view('reports.monthly', compact('monthlyData'));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'financial');
        $format = $request->get('format', 'excel');
        
        // Export logic would go here
        // For now, just return a view with export options
        return view('reports.export', compact('type', 'format'));
    }
}
