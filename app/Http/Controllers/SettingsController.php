<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        return view('settings.general');
    }
    
    public function users()
    {
        return view('settings.users');
    }
    
    public function permissions()
    {
        return view('settings.permissions');
    }
}
