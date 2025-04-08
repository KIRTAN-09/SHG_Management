<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;

class AnnualReportController extends Controller
{
    public function index()
    {
        // Fetch data for the annual report
        $annualData = AnnualReport::all();
        return view('reports.annual' , compact('annualData') );
    }
}