<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Member; // Assuming a Member model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MemberReportController extends Controller
{
    public function showMembersForm()
    {
        $members = Member::all(); // Fetch all members from the database
        return view('reports.forms.members', compact('members'));
    }

    public function getMemberDetails(Request $request)
    {
        if ($request->has('search')) {
            $search = $request->input('search');
            $type = $request->input('type', 'name'); // Default to name search

            $members = $type === 'id'
                ? Member::where('id', 'like', "$search%")->get() // Search by ID
                : Member::where('name', 'like', "%$search%")->get(); // Search by name

            return Response::json($members);
        }

        $member = Member::where('member_uid', $request->member_uid)->first();

        if ($member) {
            return Response::json($member);
        }

        return Response::json(['error' => 'Member not found'], 404);
    }
}
