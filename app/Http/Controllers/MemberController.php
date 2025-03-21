<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Group;
use App\DataTables\MembersDataTable;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Member-list|Member-create|Member-edit|Member-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:Member-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Member-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Member-delete', ['only' => ['destroy']]);
    }
    public function index(MembersDataTable $dataTable)
    {
        return $dataTable->render('members.index');
    }

    public function create()
    {
        $groups = Group::all();
        
        // Fetch existing roles for each group
        $existingRoles = Member::select('group', 'member_type')
            ->get()
            ->groupBy('group')
            ->map(function ($members) {
                return $members->pluck('member_type')->toArray();
            });

        return view('members.create', compact('groups', 'existingRoles'));	
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'image|mimes:jpg,jpeg,png|max:1024', // Validate photo size to be less than or equal to 1 MB
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:15',
            'village' => 'required|string|max:255',
            'group' => 'required|string|max:255', // Validate group as a string
            'caste' => 'required|string|max:255',
            'share_price' => 'required|numeric|min:1',
            'member_type' => 'required|in:President,Secretary,Member',
            'status' => 'required|in:Active,Inactive',
        ]);

        $group_id = Group::where('name', $request->input('group'))->first()->id;

        // Validate that there is only one President and Secretary in a group
        if (in_array($request->input('member_type'), ['President', 'Secretary'])) {
            $existingMember = Member::where('group_id', $group_id)
                ->where('member_type', $request->input('member_type'))
                ->first();

            if ($existingMember) {
                return redirect()->back()->withErrors(['member_type' => 'A ' . $request->input('member_type') . ' already exists in this group.']);
            }
        }

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images', 'public');
            Log::info('Photo stored at: ' . $validated['photo']);
        }

        $validated['share_quantity'] = 1;

        // Generate member_id based on the first letter of the name followed by a serial number
        $firstLetter = strtoupper(substr($request->input('name'), 0, 1));
        $lastMember = Member::where('member_id', 'like', $firstLetter . '%')->orderBy('member_id', 'desc')->first();
        $serialNumber = $lastMember ? intval(substr($lastMember->member_id, 1)) + 1 : 1;
        $validated['member_id'] = $firstLetter . str_pad($serialNumber, 4, '0', STR_PAD_LEFT);

        $validated['status'] = $request->input('status'); // Add status to validated data
        $validated['group_id'] = Group::where('name', $request->input('group'))->first()->id; // Use group_id

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
            'group' => 'required|string|max:255', // Validate group as a string
            'caste' => 'required|string|max:255',
            'share_price' => 'required|numeric|min:1',
            'member_type' => 'required|in:President,Secretary,Member',
            'status' => 'required|in:Active,Inactive',
        ]);

        $group_id = Group::where('name', $request->input('group'))->first()->id;

        // Validate that there is only one President and Secretary in a group
        if (in_array($request->input('member_type'), ['President', 'Secretary'])) {
            $existingMember = Member::where('group_id', $group_id)
                ->where('member_type', $request->input('member_type'))
                ->where('id', '!=', $id)
                ->first();

            if ($existingMember) {
                return redirect()->back()->withErrors(['member_type' => 'A ' . $request->input('member_type') . ' already exists in this group.']);
            }
        }

        $member = Member::findOrFail($id);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('images', 'public');
            Log::info('Photo updated at: ' . $validated['photo']);
        }
        // Explicitly set the status field
        $member->status = $request->input('status');
        $member->group_id = Group::where('name', $request->input('group'))->first()->id; // Update group_id
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
        
        // Fetch existing roles for each group
        $existingRoles = Member::select('group', 'member_type')
            ->get()
            ->groupBy('group')
            ->map(function ($members) {
                return $members->pluck('member_type')->toArray();
            });

        return view('members.edit', compact('member', 'groups', 'existingRoles'));
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->status = 'Inactive';
        $member->save();
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member status set to Inactive and deleted successfully');
    }
    
}
