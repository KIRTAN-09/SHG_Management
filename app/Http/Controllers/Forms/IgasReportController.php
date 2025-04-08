<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;

class IgasReportController extends Controller
{
    public function index()
    {
        // Fetch data for the IGAs report
        $igas = Iga::all();
        return view('reports.igas' , compact('igas') );
    }
}