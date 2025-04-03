<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingsReportController extends Controller
{
    public function index(Request $request)
    {
        $meetings = null;

        if ($request->has(['from_date', 'to_date']) && ($request->from_date || $request->to_date)) {
            $meetings = Meeting::query();

            if ($request->from_date && $request->to_date) {
                $meetings->whereBetween('date', [$request->from_date, $request->to_date]);
            }

            $meetings = $meetings->select('id', 'date', 'group_name', 'group_uid', 'discussion', 'attendance', 'photo')->get();
        }

        return view('reports.meetings', compact('meetings'));
    }
}