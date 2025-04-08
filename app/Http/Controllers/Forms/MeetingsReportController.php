<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Member;
use Illuminate\Http\Request;

class MeetingsReportController extends Controller
{
    public function index(Request $request)
    {
        $meetings = null;
        $members = Member::all();

        if ($request->has(['from_date', 'to_date', 'member_id']) && ($request->from_date || $request->to_date || $request->member_id)) {
            $meetings = Meeting::query();

            if ($request->from_date && $request->to_date) {
                $meetings->whereBetween('date', [$request->from_date, $request->to_date]);
            }

            if ($request->member_id) {
                $meetings->where(function ($q) use ($request) {
                    $q->whereNotNull('attendance')
                      ->whereRaw('JSON_CONTAINS(attendance, \'["' . $request->member_id . '"]\')');
                });
            }

            $meetings = $meetings->select('id', 'date', 'group_name', 'group_uid', 'discussion', 'attendance', 'photo')->get();
        }

        // Handle AJAX request
        if ($request->ajax()) {
            return view('reports.partials.meetings_table', compact('meetings'))->render();
        }

        return view('reports.meetings', compact('meetings', 'members'));
    }
}