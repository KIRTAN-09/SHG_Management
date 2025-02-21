<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Savings;

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
    public function index()
    {
        $savings = Savings::all();
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
            'member-name' => 'required|string',
            'amount' => 'required|numeric',
            'date-of-deposit' => 'required|date',
        ]);

        Savings::create([
            'group_id' => $request->input('group-id'),
            'group_name' => $request->input('group-name'),
            'member_id' => $request->input('member-id'),
            'member_name' => $request->input('member-name'),
            'amount' => $request->input('amount'),
            'date_of_deposit' => $request->input('date-of-deposit'),
        ]);

        return redirect()->route('savings.index')
                         ->with('success', 'Saving created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $saving = Savings::find($id);
        return view('savings.show', compact('saving'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $saving = Savings::find($id);
        return view('savings.edit', compact('saving'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'group-id' => 'nullable|numeric',
            'group-name' => 'nullable|string',
            'member-id' => 'required|numeric',
            'member-name' => 'required|string',
            'amount' => 'required|numeric',
            'date-of-deposit' => 'required|date',
        ]);

        $saving = Savings::find($id);
        $saving->update([
            'group_id' => $request->input('group-id'),
            'group_name' => $request->input('group-name'),
            'member_id' => $request->input('member-id'),
            'member_name' => $request->input('member-name'),
            'amount' => $request->input('amount'),
            'date_of_deposit' => $request->input('date-of-deposit'),
        ]);

        return redirect()->route('savings.index')
                         ->with('success', 'Saving updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $saving = Savings::find($id);
        $saving->delete();

        return redirect()->route('savings.index')
                         ->with('success', 'Saving deleted successfully.');
    }

    // Handle the POST request
    public function submit(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Create a new saving entry
        Savings::create($request->all());

        return redirect()->route('savings.index')
                         ->with('success', 'Saving submitted successfully.');
    }
}
