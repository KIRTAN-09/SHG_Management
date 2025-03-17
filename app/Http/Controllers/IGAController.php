<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IGA;
use App\Models\Member; // Add this line to import the Member model

class IGAController extends Controller
{
    public function __construct()
    {
        // // $this->middleware('permission:IGA-list|IGA-create|IGA-edit|IGA-delete', ['only' => ['index', 'show']]);
        // $this->middleware('permission:IGA-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:IGA-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:IGA-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $igas = IGA::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('category', 'LIKE', "%{$search}%")
            ->get();
        return view('igas.index', compact('igas'));
    }

    public function create()
    {
        $members = Member::all(); // Fetch all members
        return view('igas.create', compact('members')); // Pass members to the view
    }

    public function store(Request $request)
    {
        $iga = new IGA($request->all());
        $iga->member_id = $request->input('member_id'); // Add this line to handle the member_id field
        $iga->date = $request->input('date'); // Add this line to handle the date field
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
