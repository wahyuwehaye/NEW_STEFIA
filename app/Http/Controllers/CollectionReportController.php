<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionReportController extends Controller
{
    public function index()
    {
        // Logic to fetch students with debts over 10 million
        return view('collection-report.index');
    }

    public function export()
    {
        // Logic to export collection report
    }

    public function storeAction(Request $request, $student)
    {
        // Logic to store actions taken by finance
    }

    public function editAction($student)
    {
        // Logic to edit actions
    }

    public function updateAction(Request $request, $student)
    {
        // Logic to update actions taken by finance
    }
}

