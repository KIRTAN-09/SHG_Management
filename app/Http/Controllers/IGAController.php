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
            'member_uid' => [
                'required',
                Rule::exists('members', 'id') // Validate that member_uid exists in the members table
            ],
            'date' => 'required|date',
            'category1' => 'nullable|string',
            'earned1' => 'nullable|numeric|min:0',
            'category2' => 'nullable|string',
            'earned2' => 'nullable|numeric|min:0',
            'category3' => 'nullable|string',
            'earned3' => 'nullable|numeric|min:0',
        ]);

        $iga = new IGA();
        $iga->member_uid = $request->input('member_uid');
        $iga->date = $request->input('date');
        $iga->category1 = $request->input('category1');
        $iga->earned1 = $request->input('earned1');
        $iga->category2 = $request->input('category2');
        $iga->earned2 = $request->input('earned2');
        $iga->category3 = $request->input('category3');
        $iga->earned3 = $request->input('earned3');
        $iga->save();

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
            'member_uid' => [
                'required',
                Rule::exists('members', 'id') // Validate that member_uid exists in the members table
            ],
            'date' => 'required|date',
            'category' => 'required|string',
            'earned' => 'required|numeric|min:0',
        ]);

        $iga = IGA::findOrFail($id);
        $iga->update([
            'member_uid' => $request->input('member_uid'),
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
