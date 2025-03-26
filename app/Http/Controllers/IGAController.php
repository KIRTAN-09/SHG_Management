<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IGA;
use App\Models\Member; // Add this line to import the Member model
use App\DataTables\IgasDataTable; // Add this line to import the IgasDataTable
use Illuminate\Validation\Rule; // Add this line to use validation rules

class IGAController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Iga-list|Iga-create|Iga-edit|Iga-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:Iga-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Iga-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Iga-delete', ['only' => ['destroy']]);
    }

    public function index(IgasDataTable $dataTable)
    {
        return $dataTable->render('igas.index');
    }

    public function create()
    {
        $members = Member::all(); // Fetch all members
        return view('igas.create', compact('members')); // Pass members to the view 
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => [
                'required',
                Rule::exists('members', 'id') // Validate that member_id exists in the members table
            ],
            'date' => 'required|date',
            'category' => 'required|string',
            'earned' => 'required|numeric|min:0',
        ]);

        // Create a new IGA record
        IGA::create([
            'member_id' => $request->input('member_id'),
            'date' => $request->input('date'),
            'category' => $request->input('category'),
            'earned' => $request->input('earned'),
        ]);

        return redirect()->route('igas.index')->with('success', 'IGA created successfully.');
    }

    public function show($id)
    {
        $iga = IGA::findOrFail($id);
        return response()->json($iga); // Corrected variable name to $iga
    }

    public function edit($id)
    {
        $iga = IGA::findOrFail($id);
        $members = Member::all(); // Fetch all members
        return view('igas.edit', compact('iga', 'members')); // Pass members to the view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => [
                'required',
                Rule::exists('members', 'id') // Validate that member_id exists in the members table
            ],
            'date' => 'required|date',
            'category' => 'required|string',
            'earned' => 'required|numeric|min:0',
        ]);

        $iga = IGA::findOrFail($id);
        $iga->update([
            'member_id' => $request->input('member_id'),
            'date' => $request->input('date'),
            'category' => $request->input('category'),
            'earned' => $request->input('earned'),
        ]);

        return redirect()->route('igas.index')->with('success', 'IGA updated successfully.');
    }

    public function destroy($id)
    {
        $iga = IGA::findOrFail($id);
        $iga->delete();
        return redirect()->route('igas.index');
    }
}
