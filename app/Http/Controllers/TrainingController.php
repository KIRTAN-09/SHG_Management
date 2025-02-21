<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Training;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:training-list|training-create|training-edit|training-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:training-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:training-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:training-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $trainings = Training::paginate(10);
        return view('training.index', compact('trainings'));
    }

    public function create()
    {
        return view('training.create');
    }

    public function store(Request $request)
    {
        // Store training logic
    }

    public function show($id)
    {
        return view('training.show', compact('id'));
    }

    public function edit($id)
    {
        return view('training.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Update training logic
    }

    public function destroy($id)
    {
        // Delete training logic
    }
}
