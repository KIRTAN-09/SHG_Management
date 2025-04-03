<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Member;
use App\Models\Trainer; // Ensure this line is present
use App\DataTables\TrainingDataTable;

class TrainingController extends Controller
{
    
    public function __construct(){
        $this->middleware('permission:Training-list|Training-create|Training-edit|Training-delete', ['only' => ['index','show']]);
        $this->middleware('permission:Training-create', ['only' => ['create','store']]);
        $this->middleware('permission:Training-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Training-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request, TrainingDataTable $dataTable)
    {
        return $dataTable->render('training.index');
    }

    public function create()
    {
        $members = Member::all();
        return view('training.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'training_date' => 'required|date',
            'trainer' => 'required|string|max:255',
            'member_id' => 'required|string|max:255', // Ensure this matches the form field
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        Training::create([
            'training_date' => $request->training_date,
            'trainer' => $request->trainer,
            'member_id' => $request->member_id, // Ensure this matches the form field
            'location' => $request->location,
            'category' => $request->category,
        ]);

        return redirect()->route('training.create')->with('success', 'Training added successfully.');
    }

    public function show($id)
    {
        $training = Training::findOrFail($id);
        return response()->json($training); // Corrected variable name to $iga
    }

    public function edit($id)
    {
        $training = Training::findOrFail($id);
        $members = Member::all();  // Fetch members from the database
        return view('training.edit', compact('training', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'training_date' => 'required|date',
            'trainer' => 'required|string|max:255',
            // 'members_name' => 'required|string|max:255',
            // 'members_ID' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $training = Training::findOrFail($id);
        $training->update($request->all());

        return redirect()->route('training.index')->with('success', 'Training updated successfully.');
        
    }

    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return redirect()->route('training.index')->with('success', 'Training deleted successfully.');
    }
}
