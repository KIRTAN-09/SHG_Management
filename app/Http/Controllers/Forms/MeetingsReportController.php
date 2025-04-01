<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;

class MeetingsReportController extends Controller
{
    public function index()
    {
        // Fetch data for the meetings report
        $meetings = Meeting::all();
        return view('reports.meetings' , compact('meetings') );
    }
}