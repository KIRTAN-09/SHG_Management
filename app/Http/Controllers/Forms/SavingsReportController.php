<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Savings; 
use App\Models\Member; // Add Member model
use App\Models\Group;  // Add Group model

class SavingsReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Savings::query();

        if ($request->has('member_uid') && $request->member_uid) {
            $query->where('member_uid', $request->member_uid);
        }

        $savings = $query->get();
        $members = Member::all();
        $groups = Group::all();

        return view('reports.savings', compact('savings', 'members', 'groups'));
    }
}