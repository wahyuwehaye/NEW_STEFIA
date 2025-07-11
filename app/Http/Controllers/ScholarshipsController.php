<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScholarshipsController extends Controller
{
    public function index()
    {
        return view('scholarships.index');
    }
    
    public function applications()
    {
        return view('scholarships.applications');
    }
}
