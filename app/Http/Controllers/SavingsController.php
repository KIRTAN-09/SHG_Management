<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Savings;
use App\Models\Member;
use App\Models\Group;
use App\DataTables\SavingsDataTable;


class SavingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Savings-list|Savings-create|Savings-edit|Savings-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:Savings-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Savings-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Savings-delete', ['only' => ['destroy']]);
    }

    // Display a listing of the resource.
    public function index(SavingsDataTable $dataTable)
    {
        return $dataTable->render('savings.index');
    }

    // Show the form for creating a new resource. 
    public function create(Request $request)
    {
        $groups = Group::all(['id', 'name']);
        $members = Member::all(['id', 'name']);
        
        return view('savings.create', compact('groups', 'members'));
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'group_uid' => 'required|numeric|exists:groups,id',
            'member_id' => 'required|numeric|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'date_of_deposit' => 'required|date',
        ]);

        $member = Member::findOrFail($request->input('member_id'));

        Savings::create([
            
            'group_uid' => $request->input('group_uid'),
            
            'member_name' => $member->name, // Ensure member_name is populated
            'amount' => $request->input('amount'),
            'date_of_deposit' => $request->input('date_of_deposit'),
        ]);

        return redirect()->route('savings.index')->with('success', 'Saving created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $savings = Savings::with('member')->find($id);
        return view('savings.show', compact('savings'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $savings = Savings::with('member')->find($id);
        $groups = Group::all(['id', 'name']);
        $members = Member::all(['id', 'name']);
        return view('savings.edit', compact('savings', 'groups', 'members'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'group-id' => 'nullable|numeric|exists:groups,id',
            'member-id' => 'nullable|numeric|exists:members,id',
            'amount' => 'required|numeric',
            'date-of-deposit' => 'required|date',
        ]);

        $savings = Savings::findOrFail($id);

        $member = $request->input('member-id') ? Member::findOrFail($request->input('member-id')) : null;

        $savings->update([
            'group_uid' => $request->input('group-id'),
            'member_id' => $request->input('member-id'),
            'member_name' => $member ? $member->name : $savings->member_name, // Ensure member_name is updated
            'amount' => $request->input('amount'),
            'date_of_deposit' => $request->input('date-of-deposit'),
        ]);

        return redirect()->route('savings.index')->with('success', 'Saving updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $savings = Savings::find($id);
        $savings->delete();

        return redirect()->route('savings.index')->with('success', 'Saving deleted successfully.');
    }

    public function getMembersByGroup($groupId)
    {
        $members = Member::where('group_uid', $groupId)->get(['id', 'name']);
        if ($members->isEmpty()) {
            return response()->json(['message' => 'No members found for this group'], 404);
        }
        return response()->json($members);
    }
}
