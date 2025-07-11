<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FinancialsController extends Controller
{
    public function transactions()
    {
        return view('financials.transactions');
    }
    
    public function payments()
    {
        return view('financials.payments');
    }
    
    public function reports()
    {
        return view('financials.reports');
    }
}
