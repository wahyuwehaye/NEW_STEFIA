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
}
