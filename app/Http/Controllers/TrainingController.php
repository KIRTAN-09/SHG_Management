<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;

class TrainingController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:training-list|training-create|training-edit|training-delete', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:training-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:training-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:training-delete', ['only' => ['destroy']]);
    // }
    public function index(Request $request)
    {
        $query = Training::query();

        if ($request->has('search')) {
            $query->where('category', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%')
                  ->orWhere('trainer', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'date_asc':
                    $query->orderBy('training_date', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('training_date', 'desc');
                    break;
                case 'category':
                    $query->orderBy('category', 'asc');
                    break;
            }
        }

        $trainings = $query->paginate(10);

        return view('training.index', compact('trainings'));
    }

    public function create()
    {
        return view('training.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'training_date' => 'required|date',
            'trainer' => 'required|string|max:255',
            'members_name' => 'required|string|max:255',
            'members_ID' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        Training::create($request->all());

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
        return view('training.edit', compact('training'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'training_date' => 'required|date',
            'trainer' => 'required|string|max:255',
            'members_name' => 'required|string|max:255',
            'members_ID' => 'required|string|max:255',
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
