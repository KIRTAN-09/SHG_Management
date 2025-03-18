<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class ReportController extends Controller

{
    public function __construct(){
        $this->middleware('permission:report-list|report-create|report-edit|report-delete', ['only' => ['index','show']]);
        $this->middleware('permission:report-create', ['only' => ['create','store']]);
        $this->middleware('permission:report-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:report-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('reports.index');
    }

    public function filter(Request $request)
    {
        $reportType = $request->input('reportType');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $reportData = [];

        if ($reportType == 'members') {
            $query = Member::query();
            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('created_at', '<=', $endDate);
            }
            $reportData = $query->get();
        }

        // ...existing code for other report types...

        return view('reports.index', compact('reportData', 'reportType'));
    }

    // ...existing code...
}
