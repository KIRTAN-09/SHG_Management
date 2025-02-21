<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MeetingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:meeting-list|meeting-create|meeting-edit|meeting-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:meeting-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:meeting-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:meeting-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $meetings = Meeting::paginate(10); // Adjust the number as needed
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'group-name' => 'required|string',
            'group-id' => 'nullable|numeric',
            'discussion' => 'required|string',
            'photo' => 'required|image',
            'No of members present' => 'required|numeric',  
        ]);

        $meeting = new Meeting();
        $meeting->date = $request->input('date');
        $meeting->group_name = $request->input('group-name');
        $meeting->group_id = $request->input('group-id');
        $meeting->discussion = $request->input('discussion');

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $meeting->photo = $photoPath;
        }

        $meeting->save();

        return redirect()->route('meetings.index')->with('success', 'Meeting scheduled successfully.');
    }

    public function show($id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        return view('meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $meeting->update($request->all());
        return redirect()->route('meetings.index');
    }

    public function destroy(Meeting $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index');
    }
}
