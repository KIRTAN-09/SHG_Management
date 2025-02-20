@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="text-2xl font-bold mb-4">Member List</h2>
    <link rel="stylesheet" href="{{ asset('css/Members/member.css') }}">
    <a href="{{ route('members.create') }}" class="btn btn-primary mb-4">Add Member</a>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($members as $member)
            <div class="bg">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-12 h-12 object-cover rounded-full mr-4">
                    <div>
                        <h3 class="text-lg font-bold">{{ $member->name }}</h3>
                        <p class="text-gray-600">{{ $member->member_id }}</p>
                    </div>
                </div>
                <p><strong>Number:</strong> {{ $member->number }}</p>
                <p><strong>Village:</strong> {{ $member->village }}</p>
                <p><strong>Group:</strong> {{ is_object($member->group) ? $member->group->name : '' }}</p>
                <!-- <p><strong>Caste:</strong> {{ $member->caste }}</p>
                <p><strong>Share Price:</strong> {{ $member->share_price }}</p>
                <p><strong>Member Type:</strong> {{ $member->member_type }}</p>
                <p><strong>Status:</strong> {{ $member->status }}</p> -->
                <div class="mt-4 action-buttons justify-end">
                    <a href="{{ route('members.show', $member->id) }}" class="view-btn">View</a>
                    <a href="{{ route('members.edit', $member->id) }}" class="edit-btn">Edit</a>
                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $members->links('pagination::custom') }}
    </div>
</div>
@endsection
