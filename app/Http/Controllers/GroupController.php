<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Member;

class GroupController extends Controller
{

    public function __construct()
    {
         $this->middleware('permission:Group-list|Group-create|Group-edit|Group-delete', ['only' => ['index', 'show']]);
         $this->middleware('permission:Group-create', ['only' => ['create','store']]);
         $this->middleware('permission:Group-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:Group-delete', ['only' => ['destroy']]);
    }
    

    public function index(Request $request)
    {
        $search = $request->input('search');
        $groups = Group::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('group_id', 'like', "%{$search}%")
                             ->orWhere('village_name', 'like', "%{$search}%")
                             ->orWhere('president_name', 'like', "%{$search}%")
                             ->orWhere('secretary_name', 'like', "%{$search}%")
                             ->orWhere('no_of_members', 'like', "%{$search}%");
            })
            ->paginate(10);

        $totalMembers = Member::count(); // Count total members
        $totalGroups = Group::count(); // Count total groups
        return view('groups.index', compact('groups', 'totalMembers'));
    }

    public function create(): View
    {
        return view('groups.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'village_name' => 'required|string|max:255',
            'president_name' => 'required|string|max:255',
            'secretary_name' => 'required|string|max:255',
            'no_of_members' => 'required|integer|min:10|max:20',
        ], [
            'no_of_members.min' => 'The number of members must be at least 10.',
            'no_of_members.max' => 'The number of members may not be greater than 20.',
        ]);

        if ($validated['no_of_members'] < 10 || $validated['no_of_members'] > 20) {
            return redirect()->back()->withErrors([
                'no_of_members' => 'The number of members must be between 10 and 20.'
            ])->withInput();
        }

        $validated['group_id'] = uniqid('GRP');

        Group::create($validated);

        return redirect()->route('groups.index')->with('success', 'Group added successfully.');
    }

    public function show($id)
    {
        $group = Group::findOrFail($id);
        return response()->json($group);
    }

    public function edit($id): View
    {
        $group = Group::find($id);
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'village_name' => 'required|string|max:255',
            'president_name' => 'required|string|max:255',
            'secretary_name' => 'required|string|max:255',
            'no_of_members' => 'required|integer|min:10|max:20',
        ], [
            'no_of_members.min' => 'The number of members must be at least 10.',
            'no_of_members.max' => 'The number of members may not be greater than 20.',
        ]);

        if ($validated['no_of_members'] < 10 || $validated['no_of_members'] > 20) {
            return redirect()->back()->withErrors([
                'no_of_members' => 'The number of members must be between 10 and 20.'
            ])->withInput();
        }

        $group = Group::find($id);
        $group->update($validated);

        return redirect()->route('groups.index')->with('success', 'Group updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        Group::find($id)->delete();
        return redirect()->route('groups.index')->with('success', 'Group deleted successfully.');
    }
}
