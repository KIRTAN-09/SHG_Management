<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Group;
use Illuminate\Support\Facades\Storage;

class MeetingController extends Controller
{
    /**
     * Display a listing of meetings.
     */
    public function __construct(){
        $this->middleware('permission:Meetings-list|Meetings-create|Meetings-edit|Meetings-delete', ['only' => ['index','show']]);
        $this->middleware('permission:Meetings-list', ['only' => ['index']]);
        $this->middleware('permission:Meetings-create', ['only' => ['create','store']]);
        $this->middleware('permission:Meetings-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Meetings-delete', ['only' => ['destroy']]);
        // Ensure the fetchMeetingDetails method has the correct permission
        $this->middleware('permission:Meetings-list', ['only' => ['fetchMeetingDetails']]);
    }
    public function index(Request $request)
    {
        $query = Meeting::query();

        if ($request->has('search')) {
            $query->where('group_name', 'like', '%' . $request->search . '%')
                  ->orWhere('discussion', 'like', '%' . $request->search . '%');
        }
        if ($request->has('column') && $request->has('sort')) {
            $query->orderBy($request->column, $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }
        $meetings = $query->paginate(20);
        return view('meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new meeting.
     */
    public function create()
    {
        $groups = Group::all();
        return view('meetings.create', compact('groups'));
    }

    /**
     * Store a newly created meeting in storage.
     */
    public function store(Request $request)
    {
        // dd('test');

        $request->validate([
            'date' => 'required|date',
            'group_id' => 'required|numeric',
            'discussion' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $group = Group::findOrFail($request->group_id);
        $photoPath = $request->file('photo')->store('meetings/photos', 'public');

        Meeting::create([
            'date' => $request->date,
            'group_name' => $group->name,
            'group_id' => $request->group_id,
            'discussion' => $request->discussion,
            'photo' => $photoPath,
        ]);

        return redirect()->route('meetings.index')->with('success', 'Meeting scheduled successfully!');
    }

    /**
     * Display the specified meeting.
     */
    public function show($id)
    {
        $meeting = Meeting::findOrFail($id);
        return view('meetings.show', compact('meeting'));
    }

    /**
     * Show the form for editing the specified meeting.
     */
    public function edit(Meeting $meeting)
    {
            $groups = Group::all();
        return view('meetings.edit', compact('meeting', 'groups'));
    }

    /**
     * Update the specified meeting in storage.
     */
    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'date' => 'required|date',
            'group_id' => 'required|numeric',
            'discussion' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $group = Group::findOrFail($request->group_id);

        if ($request->hasFile('photo')) {
            Storage::delete('public/' . $meeting->photo);
            $meeting->photo = $request->file('photo')->store('meetings/photos', 'public');
        }

        $meeting->update([
            'date' => $request->date,
            'group_name' => $group->name,
            'group_id' => $request->group_id,
            'discussion' => $request->discussion,
        ]);

        return redirect()->route('meetings.index')->with('success', 'Meeting updated successfully!');
    }

    /**
     * Remove the specified meeting from storage.
     */
    public function destroy(Meeting $meeting)
    {
        Storage::delete('public/' . $meeting->photo);
        $meeting->delete();
        return redirect()->route('meetings.index')->with('success', 'Meeting deleted successfully!');
    }

    /**
     * Fetch the specified meeting details for AJAX request.
     */
    public function fetchMeetingDetails($id)
    {
        $meeting = Meeting::findOrFail($id);
        return response()->json($meeting);
    }
}