<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\Member; 

class MembersReportController extends Controller
{
    public function index()
    {
        // Fetch data for the members report
        $members = Member::all();
        return view('reports.members', compact('members'));
    }
}
