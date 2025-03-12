<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IGA;

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
        return view('igas.create');
    }

    public function store(Request $request)
    {
        $iga = new IGA($request->all());
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
        return view('igas.edit', compact('iga'));
    }

    public function update(Request $request, $id)
    {
        $iga = IGA::findOrFail($id);
        $iga->update($request->all());
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
