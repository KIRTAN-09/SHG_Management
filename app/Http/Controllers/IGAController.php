<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IGA;
use App\Models\Member; // Add this line to import the Member model
use App\DataTables\IgasDataTable; // Add this line to import the IgasDataTable

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
            'member_id' => 'required',
            'member_name' => 'required',
            
            'date' => 'required',
            'category' => 'required',
            'earned' => 'required',
            
        ]);
        $iga = new IGA($request->all());
        $iga->member_id = $request->input('member_id'); // Add this line to handle the member_id field
        $iga->name = $request->input('member_name'); // Add this line to handle the name field
        $iga->date = $request->input('date'); // Add this line to handle the date field
        $iga->category = $request->input('category'); // Add this line to handle the category field
        $iga->earned = $request->input('earned'); // Add this line to handle the earned field
        // dd($request->all());
        $iga->save();   
        return redirect()->route('igas.index');
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
        $iga = IGA::findOrFail($id);
        $iga->update($request->all());
        $iga->member_id = $request->input('member_id'); // Add this line to handle the member_id field
        $iga->date = $request->input('date'); // Add this line to handle the date field
        $iga->save();
        return redirect()->route('igas.index');
    }

    public function destroy($id)
    {
        $iga = IGA::findOrFail($id);
        $iga->delete();
        return redirect()->route('igas.index');
    }
}
