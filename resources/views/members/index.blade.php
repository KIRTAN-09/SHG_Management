@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Member List</h2>
    <link rel="stylesheet" href="{{ asset('css/member.css') }}">
    <a href="{{ route('members.create') }}" class="btn btn-primary mb-4">Add Member</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Photo</th>
                    <th class="py-2 px-4 border-b">Member UID</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Number</th>
                    <th class="py-2 px-4 border-b">Village</th>
                    <th class="py-2 px-4 border-b">Group</th>
                    <th class="py-2 px-4 border-b">Caste</th>
                    <th class="py-2 px-4 border-b">Share Price</th>
                    <th class="py-2 px-4 border-b">Member Type</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td class="py-2 px-4 border-b"><img src="{{ asset('storage/' . $member->photo) }}" class="w-16 h-16 object-cover rounded-full"></td>
                        <td class="py-2 px-4 border-b">{{ $member->member_id }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->number }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->village }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->group }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->caste }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->share_price }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->member_type }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->status }}</td>
                        <td class="py-2 px-4 border-b action-buttons">
                            <a href="{{ route('members.show', $member->id) }}" class="view-btn">View</a>
                            <a href="{{ route('members.edit', $member->id) }}" class="edit-btn">Edit</a>
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $members->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
