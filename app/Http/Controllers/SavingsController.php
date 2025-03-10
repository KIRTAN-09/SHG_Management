<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Savings;
use App\Models\Member;

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
    public function index(Request $request)
    {
        $query = Savings::query();

        if ($request->has('search')) {
            $query->where('group_id', 'like', '%' . $request->search . '%')
                  ->orWhere('member_id', 'like', '%' . $request->search . '%')
                  ->orWhere('group_name', 'LIKE', "%{$request->search}%");
        }

        if ($request->has('column') && $request->has('sort')) {
            $query->orderBy($request->column, $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $savings = $query->paginate(10);
        return view('savings.index', compact('savings'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('savings.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'group-id' => 'nullable|numeric',
            'group-name' => 'nullable|string',
            'member-id' => 'required|numeric',
            // 'member-name' => 'required|string',
            'amount' => 'required|numeric',
            'date-of-deposit' => 'required|date',
        ]);

        Savings::create([
            'group_id' => $request->input('group-id'),
            'group_name' => $request->input('group-name'),
            'member_id' => $request->input('member-id'),
            // 'member_name' => $request->input('member-name'),
            'amount' => $request->input('amount'),
            'date_of_deposit' => $request->input('date-of-deposit'),
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
        return view('savings.edit', compact('savings'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'group-id' => 'nullable|numeric',
            'group-name' => 'nullable|string',
            'member-id' => 'required|numeric',
            // 'member-name' => 'required|string',
            'amount' => 'required|numeric',
            'date-of-deposit' => 'required|date',
        ]);

        $savings = Savings::find($id);
        $savings->update([
            'group_id' => $request->input('group-id'),
            'group_name' => $request->input('group-name'),
            'member_id' => $request->input('member-id'),    
            // 'member_name' => $request->input('member-name'),
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
}
