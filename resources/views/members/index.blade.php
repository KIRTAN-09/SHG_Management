@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/members.css') }}">
    <h2>Member List</h2>
    <a href="{{ route('members.create') }}" class="btn btn-primary">Add Member</a>
    <table class="table">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Member UID</th>
                <th>Name</th>
                <th>Number</th>
                <th>Village</th>
                <th>Group</th>
                <th>Caste</th>
                <th>Share Price</th>
                <th>Member Type</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td><img src="{{ asset('storage/' . $member->photo) }}" class="profile-img"></td>
                    <td>{{ $member->member_id}}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->number }}</td>
                    <td>{{ $member->village }}</td>
                    <td>{{ $member->group }}</td>
                    <td>{{ $member->caste }}</td>
                    <td>{{ $member->share_price }}</td>
                    <td>{{ $member->member_type }}</td>
                    <td>{{ $member->status}}</td>
                    <td>
                        <a href="{{ route('members.show', $member->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $members->links('pagination::bootstrap-4') }}
    </div>
@endsection
