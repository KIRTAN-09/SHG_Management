<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Group;

class MemberController extends Controller
{

    public function index(Request $request)
    {

        $search = $request->input('search');
        $status = $request->input('sort');
        $query = Member::query();

        if ($request->has('sort')) {
            $query->where('status', $request->input('sort'));
        }

        $rows = $request->input('rows', 10); // Default to 10 rows per page if not specified

        $members = $query->paginate($rows);

        //     $group_name = Group::where('name')->first();
        // $group_name->increment('no_of_members');
        return view('members.index', compact('members'));
    }
    

    public function create()
    {
        
        $groups = Group::all();
        return view('members.create', compact('groups'));	
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'image|mimes:jpg,jpeg,png|max:1024', // Validate photo size to be less than or equal to 1 MB
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:15',
            'village' => 'required|string|max:255',
            'group' => 'required|exists:groups,id', // Validate group as an existing group ID
            'caste' => 'required|string|max:255',
            'share_price' => 'required|numeric|min:1',
            'member_type' => 'required|in:President,Secretary,Member',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images', 'public');
            Log::info('Photo stored at: ' . $validated['photo']);
        }

        $validated['share_quantity'] = 1;
        $validated['member_id'] = uniqid('MEM');
        $validated['status'] = $request->input('status'); // Add status to validated data
        $validated['group_id'] = $request->input('group'); // Use group_id

        Member::create($validated);
        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    public function update(Request $request, $id)
    {
        // dd('test');
        $validated = $request->validate([
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:15',
            'village' => 'required|string|max:255',
            'group' => 'required|exists:groups,id', // Validate group as an existing group ID
            'caste' => 'required|string|max:255',
            'share_price' => 'required|numeric|min:1',
            'member_type' => 'required|in:President,Secretary,Member',
            'status' => 'required|in:Active,Inactive',
        ]);

        $member = Member::findOrFail($id);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images', 'public');
            Log::info('Photo updated at: ' . $validated['photo']);
        }

        // Check if the group has changed
        // if ($member->group_id !== $request->input('group')) {
        //     // Decrement the old group's member count
        //     $oldGroup = Group::findOrFail($member->group_id);
        //     // $oldGroup->decrement('no_of_members'); // Remove this line

        //     // Increment the new group's member count
        //     $newGroup = Group::findOrFail($request->input('group'));
        //     // $newGroup->increment('no_of_members'); // Remove this line
        // }

        // Explicitly set the status field
        $member->status = $request->input('status');
        $member->group_id = $request->input('group'); // Update group_id
        $member->update($validated);

        // Redirect to the index page after successful update
        return redirect()->route('members.index')->with('success', 'Member updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::query()
            ->leftJoin('groups', 'members.group_id', '=', 'groups.id') // Join with groups table using group_id
            ->select('members.*', 'groups.name as group_name') // Select group name
            ->where('members.id', $id)
            ->firstOrFail();

        return response()->json($member);
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        $groups = Group::all(); // Assuming you have a Group model to fetch all groups
        return view('members.edit', compact('member', 'groups'));
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $group = Group::findOrFail($member->group_id);
        // $group->decrement('no_of_members'); // Remove this line
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully');
    }
}
