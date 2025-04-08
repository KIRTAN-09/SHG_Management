<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;

class MonthlyReportController extends Controller
{
    public function index()
    {
        // Fetch data for the monthly report
        $monthlyData = MonthlyReport::all();
        return view('reports.monthly' , compact('monthlyData') );
    }
}