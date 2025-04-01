<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Add this import
use App\Models\Group; // Add this import

class GroupsReportController extends Controller
{
    public function index()
    {
        // Fetch data for the groups report
        $groups = Group::all();
        return view('reports.groups' , compact('groups') );
    }
}