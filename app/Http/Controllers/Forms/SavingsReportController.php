<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;

class SavingsReportController extends Controller
{
    public function index(Request $request)
    {
        // Fetch data for the savings report based on filters
        $savings = Savings::filter($request->all())->get();
        return view('reports.savings' , compact('savings') );
    }
}