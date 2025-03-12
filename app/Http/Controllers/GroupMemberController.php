<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use Illuminate\Http\Request;

class GroupMemberController extends Controller
{
    public function index(Request $request)
    {
        $groupMembers = GroupMember::paginate(10);
        return view('group_members.index', compact('groupMembers'));
    }

    public function create()
    {
        return view('group_members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'group_id' => 'required|exists:groups,id',
            // 'member_id' => 'required|exists:members,id',
            'in_date' => 'required|date',
            'out_date' => 'nullable|date|after:in_date',
        ]);

        $validated['member_id'] = Member::findOrFail($validated['member_id'])->id;

        $validated['group_id'] = Group::findOrFail($validated['group_id'])->id;

        GroupMember::create($validated);
        return redirect()->route('group_members.index')->with('success', 'Group member added successfully.');
    }

    public function show($id)
    {
        $groupMember = GroupMember::findOrFail($id);
        return view('group_members.show', compact('groupMember'));
    }

    public function edit($id)
    {
        $groupMember = GroupMember::findOrFail($id);
        return view('group_members.edit', compact('groupMember'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'group_id' => 'required|exists:groups,id',
            'member_id' => 'required|exists:members,id',
            'in_date' => 'required|date',
            'out_date' => 'nullable|date|after:in_date',
        ]);

        $groupMember = GroupMember::findOrFail($id);
        $groupMember->update($validated);

        return redirect()->route('group_members.index')->with('success', 'Group member updated successfully.');
    }

    public function destroy($id)
    {
        $groupMember = GroupMember::findOrFail($id);
        $groupMember->delete();

        return redirect()->route('group_members.index')->with('success', 'Group member deleted successfully.');
    }
}
