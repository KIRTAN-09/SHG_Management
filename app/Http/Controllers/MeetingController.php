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
    public function index(Request $request)
    {
        $query = Meeting::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('group_name', 'LIKE', "%{$search}%")
                  ->orWhere('discussion', 'LIKE', "%{$search}%");
        }

        $meetings = $query->orderBy('created_at', 'desc')->paginate(10); // Sort by latest added
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
        $request->validate([
            'date' => 'required|date',
            'group_name' => 'required|string|max:255',
            'group_id' => 'nullable|numeric',
            'discussion' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $request->file('photo')->store('meetings/photos', 'public');

        Meeting::create([
            'date' => $request->date,
            'group_name' => $request->group_name,
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
        return view('meetings.edit', compact('meeting'));
    }

    /**
     * Update the specified meeting in storage.
     */
    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'date' => 'required|date',
            'group_name' => 'required|string|max:255',
            'group_id' => 'nullable|numeric',
            'discussion' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            Storage::delete('public/' . $meeting->photo);
            $meeting->photo = $request->file('photo')->store('meetings/photos', 'public');
        }

        $meeting->update([
            'date' => $request->date,
            'group_name' => $request->group_name,
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