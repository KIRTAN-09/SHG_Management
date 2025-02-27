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

        $members = Member::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('village', 'like', "%{$search}%")
                        ->orWhere('group', 'like', "%{$search}%")
                        ->orWhere('caste', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc') // Sort by latest added
            ->paginate(15);

        return view('members.index', compact('members'));
    }

    public function create()
    {
        $groups = Group::all(); // Assuming you have a Group model
        return view('members.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'image|mimes:jpg,jpeg,png|max:1024', // Validate photo size to be less than or equal to 1 MB
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:15',
            'village' => 'required|string|max:255',
            'group' => 'required|string|max:255',
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

        $validated['group'] = $request->input('group');
        $group = Group::where('name', $validated['group'])->firstOrFail();
        $group->increment('no_of_members');

        Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:15',
            'village' => 'required|string|max:255',
            'group' => 'required|string|max:255',
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
        if ($member->group !== $validated['group']) {
            // Decrement the old group's member count
            $oldGroup = Group::where('name', $member->group)->firstOrFail();
            $oldGroup->decrement('no_of_members');

            // Increment the new group's member count
            $newGroup = Group::where('name', $validated['group'])->firstOrFail();
            $newGroup->increment('no_of_members');
        }

        // Explicitly set the status field
        $member->status = $request->input('status');
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
        $member = Member::findOrFail($id);
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
        $group = Group::where('name', $member->group)->firstOrFail();
        $group->decrement('no_of_members');
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully');
    }
}
