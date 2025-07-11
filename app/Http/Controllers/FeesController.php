<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeesController extends Controller
{
    public function structure()
    {
        return view('fees.structure');
    }
    
    public function collection()
    {
        return view('fees.collection');
    }
    
    public function outstanding()
    {
        return view('fees.outstanding');
    }
}
