<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Debt;
use App\Models\Fee;
use App\Models\Scholarship;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Get recent activities
        $recentActivities = $this->getRecentActivities();
        
        // Get high debtors
        $highDebtors = $this->getHighDebtors();
        
        // Get recent transactions
        $recentTransactions = $this->getRecentTransactions();
        
        // Get chart data
        $chartData = $this->getChartData();

        // Payment method composition
        $paymentMethodData = Payment::selectRaw('payment_method, COUNT(*) as count')
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method')->toArray();

        // Student trend per month
        $studentTrendMonths = [];
        $studentTrendData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $studentTrendMonths[] = $date->format('M Y');
            $studentTrendData[] = Student::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Transaction count per month
        $transactionTrendData = [];
        foreach ($studentTrendMonths as $idx => $label) {
            $date = now()->subMonths(11 - $idx);
            $transactionTrendData[] = Payment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        // Top 10 payers
        $topPayers = Student::withSum(['payments as total_paid' => function($q) {
            $q->where('status', 'completed');
        }], 'amount')
        ->orderByDesc('total_paid')
        ->limit(10)
        ->get();

        // Reminder stats (dummy)
        $reminderStats = [
            'sent' => 120,
            'failed' => 3,
            'wa_sent' => 80,
            'email_sent' => 40
        ];

        // Beasiswa stats (dummy)
        $beasiswaStats = [
            'akademik' => 12,
            'non_akademik' => 7,
            'lainnya' => 4
        ];

        // Outstanding ratio
        $outstanding = $stats['active_receivables'] ?? 0;
        $lunas = $stats['paid_receivables'] ?? 0;
        $outstandingRatio = ($outstanding + $lunas) > 0 ? round($outstanding / ($outstanding + $lunas) * 100, 1) : 0;

        // Insight otomatis
        $insights = [
            [
                'icon' => 'ni-trend-up',
                'color' => 'success',
                'text' => 'Pembayaran bulan ini naik '.($stats['today_growth'] ?? 0).'% dibanding bulan lalu.'
            ],
            [
                'icon' => 'ni-alert',
                'color' => 'danger',
                'text' => 'Ada '.$highDebtors->count().' mahasiswa dengan tunggakan > 10 juta.'
            ],
            [
                'icon' => 'ni-pie',
                'color' => 'info',
                'text' => 'Rasio outstanding: '.$outstandingRatio.'%.'
            ],
        ];

        // Tambahkan data baru ke chartData
        $chartData['payment_method'] = $paymentMethodData;
        $chartData['student_trend'] = $studentTrendData;
        $chartData['student_trend_months'] = $studentTrendMonths;
        $chartData['transaction_trend'] = $transactionTrendData;
        $chartData['top_payers'] = $topPayers;
        $chartData['reminder_stats'] = $reminderStats;
        $chartData['beasiswa_stats'] = $beasiswaStats;
        $chartData['outstanding_ratio'] = $outstandingRatio;

        return view('dashboard', compact(
            'stats',
            'recentActivities',
            'highDebtors',
            'recentTransactions',
            'chartData',
            'insights',
            'topPayers',
            'reminderStats',
            'beasiswaStats'
        ));
    }
    
    private function getDashboardStats()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth();
        
        // Total students
        $totalStudents = Student::count();
        $totalStudentsLastMonth = Student::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->count();
        $studentsGrowth = $totalStudentsLastMonth > 0 ? 
            (($totalStudents - $totalStudentsLastMonth) / $totalStudentsLastMonth) * 100 : 0;
        
        // Active debts
        $activeReceivables = Debt::where('status', 'active')->sum('amount');
        $activeReceivablesLastMonth = Debt::where('status', 'active')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');
        $receivablesGrowth = $activeReceivablesLastMonth > 0 ? 
            (($activeReceivables - $activeReceivablesLastMonth) / $activeReceivablesLastMonth) * 100 : 0;
        
        // Paid debts
        $paidReceivables = Debt::where('status', 'paid')->sum('amount');
        $paidReceivablesLastMonth = Debt::where('status', 'paid')
            ->whereMonth('updated_at', $lastMonth->month)
            ->whereYear('updated_at', $lastMonth->year)
            ->sum('amount');
        $paidGrowth = $paidReceivablesLastMonth > 0 ? 
            (($paidReceivables - $paidReceivablesLastMonth) / $paidReceivablesLastMonth) * 100 : 0;
        
        // High debtors (>10 million)
        $highDebtorsCount = Student::whereHas('debts', function($query) {
            $query->where('status', 'active');
        })->withSum(['debts' => function($query) {
            $query->where('status', 'active');
        }], 'amount')
        ->having('debts_sum_amount', '>', 10000000)
        ->count();
        
        // Today's payments
        $todayPayments = Payment::whereDate('created_at', Carbon::today())
            ->where('status', 'completed')
            ->sum('amount');
        $yesterdayPayments = Payment::whereDate('created_at', Carbon::yesterday())
            ->where('status', 'completed')
            ->sum('amount');
        $todayGrowth = $yesterdayPayments > 0 ? 
            (($todayPayments - $yesterdayPayments) / $yesterdayPayments) * 100 : 0;
        
        // Semester debts
        $semesterReceivables = Debt::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', '>=', $currentMonth <= 6 ? 1 : 7)
            ->whereMonth('created_at', '<=', $currentMonth <= 6 ? 6 : 12)
            ->sum('amount');
        
        // Yearly debts
        $yearlyReceivables = Debt::whereYear('created_at', $currentYear)
            ->sum('amount');
        
        // Collection rate
        $totalReceivables = Debt::sum('amount');
        $collectedAmount = Debt::where('status', 'paid')->sum('amount');
        $collectionRate = $totalReceivables > 0 ? ($collectedAmount / $totalReceivables) * 100 : 0;
        
        return [
            'total_students' => $totalStudents,
            'students_growth' => round($studentsGrowth, 2),
            'active_receivables' => $activeReceivables,
            'receivables_growth' => round($receivablesGrowth, 2),
            'paid_receivables' => $paidReceivables,
            'paid_growth' => round($paidGrowth, 2),
            'high_debtors' => $highDebtorsCount,
            'today_payments' => $todayPayments,
            'today_growth' => round($todayGrowth, 2),
            'semester_receivables' => $semesterReceivables,
            'yearly_receivables' => $yearlyReceivables,
            'collection_rate' => round($collectionRate, 1),
        ];
    }
    
    private function getRecentActivities()
    {
        $activities = [];
        
        // Recent student registrations
        $recentStudents = Student::latest()->limit(5)->get();
        foreach ($recentStudents as $student) {
            $activities[] = [
                'type' => 'student_registration',
                'title' => 'New student registration',
                'description' => "{$student->name} has successfully registered for the {$student->study_program} program.",
                'time' => $student->created_at->diffForHumans(),
                'icon' => 'ni-user-add',
                'color' => 'primary'
            ];
        }
        
        // Recent payments
        $recentPayments = Payment::where('status', 'completed')
            ->with('student')
            ->latest()
            ->limit(5)
            ->get();
        foreach ($recentPayments as $payment) {
            $activities[] = [
                'type' => 'payment',
                'title' => 'Payment received',
                'description' => "Rp " . number_format($payment->amount) . " payment received from {$payment->student->name}.",
                'time' => $payment->created_at->diffForHumans(),
                'icon' => 'ni-money',
                'color' => 'success'
            ];
        }
        
        // Recent scholarship applications
        $recentScholarships = Scholarship::with('student')
            ->latest()
            ->limit(3)
            ->get();
        foreach ($recentScholarships as $scholarship) {
            $activities[] = [
                'type' => 'scholarship',
                'title' => 'Scholarship application',
                'description' => "New scholarship application submitted by {$scholarship->student->name}.",
                'time' => $scholarship->created_at->diffForHumans(),
                'icon' => 'ni-award',
                'color' => 'warning'
            ];
        }
        
        // Sort by time and limit
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 10);
    }
    
    private function getHighDebtors()
    {
        return Student::whereHas('debts', function($query) {
            $query->where('status', 'active');
        })->withSum(['debts' => function($query) {
            $query->where('status', 'active');
        }], 'amount')
        ->with(['payments' => function($query) {
            $query->where('status', 'completed')->latest();
        }])
        ->having('debts_sum_amount', '>', 10000000)
        ->orderBy('debts_sum_amount', 'desc')
        ->limit(10)
        ->get();
    }
    
    private function getRecentTransactions()
    {
        return Payment::where('status', 'completed')
            ->with('student')
            ->latest()
            ->limit(10)
            ->get();
    }
    
    private function getChartData()
    {
        $monthlyRevenue = [];
        $paymentTrends = [];
        
        // Monthly revenue for last 12 months
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Payment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'completed')
                ->sum('amount');
            $monthlyRevenue[] = $revenue;
        }
        
        // Payment trends for last 6 months
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $payments = Payment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'completed')
                ->sum('amount');
            $paymentTrends[] = $payments;
        }
        
        // Debt status distribution
        $paidCount = Debt::where('status', 'paid')->count();
        $activeCount = Debt::where('status', 'active')->count();
        $overdueCount = Debt::where('status', 'overdue')->count();
        $totalCount = $paidCount + $activeCount + $overdueCount;
        
        $receivableStatus = [
            'paid' => $totalCount > 0 ? round(($paidCount / $totalCount) * 100, 1) : 0,
            'active' => $totalCount > 0 ? round(($activeCount / $totalCount) * 100, 1) : 0,
            'overdue' => $totalCount > 0 ? round(($overdueCount / $totalCount) * 100, 1) : 0,
        ];
        
        return [
            'monthly_revenue' => $monthlyRevenue,
            'payment_trends' => $paymentTrends,
            'receivable_status' => $receivableStatus,
        ];
    }
}
