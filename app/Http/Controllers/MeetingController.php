<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Group;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\MeetingDatatable;

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
    public function index(MeetingDatatable $dataTable)
    {
        return $dataTable->render('meetings.index');
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
            'group_uid' => 'required|numeric',
            'discussion' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $group = Group::findOrFail($request->group_uid);
        $photoPath = $request->file('photo')->store('meetings/photos', 'public');
        $photoUrl = Storage::url($photoPath);

        Meeting::create([
            'date' => $request->date,
            'group_name' => $group->name,
            'group_uid' => $request->group_uid,
            'discussion' => $request->discussion,
            'photo' => $photoUrl,
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
        $members = $meeting->group ? $meeting->group->members : []; // Check if group exists before accessing members
        return view('meetings.edit', compact('meeting', 'groups', 'members'));
    }

    /**
     * Update the specified meeting in storage.
     */
    public function update(Request $request, Meeting $meeting)
    {
        $request->validate([
            'date' => 'required|date',
            'group_uid' => 'required|numeric',
            'discussion' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $group = Group::findOrFail($request->group_uid);

        if ($request->hasFile('photo')) {
            Storage::delete('public/' . $meeting->photo);
            $photoPath = $request->file('photo')->store('meetings/photos', 'public');
            $meeting->photo = Storage::url($photoPath);
        }

        $meeting->update([
            'date' => $request->date,
            'group_name' => $group->name,
            'group_uid' => $request->group_uid,
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

    /**
     * Get data for DataTables.
     */
    public function getData()
    {
        $meetings = Meeting::select(['id', 'date', 'photo', 'group_name', 'group_uid', 'discussion', 'attendance_list']);
        return DataTables::of($meetings)
            ->addColumn('actions', function ($meeting) {
                return view('meetings.partials.actions', compact('meeting'))->render();
            })
            ->editColumn('photo', function ($meeting) {
                return '<img src="'.asset('storage/' . $meeting->photo).'" alt="Group Photo" class="w-20 h-20 object-cover rounded-full mx-auto mb-4">';
            })
            ->rawColumns(['actions', 'photo'])
            ->make(true);
    }
}