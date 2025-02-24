@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Meetings</h2>
    <link rel="stylesheet" href="{{ asset('css/Meetings/Index.css') }}">
    <a href="{{ route('meetings.create') }}" class="btn btn-primary">Schedule a New Meeting</a>
    <div class="table-container">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Photo</th>
                    <th>Group Name</th>
                    <th>Group ID</th>
                    <th>Discussion Points</th>
                    <th>No. Members Present</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->date }}</td>
                    <td><img src="{{ asset('storage/' . $meeting->photo) }}" alt="Group Photo" style="width: 100px; height: auto;"></td>
                    <td>{{ $meeting->group_name }}</td>
                    <td>{{ $meeting->group_id }}</td>
                    <td>{{ $meeting->discussion }}</td>
                    <td>{{ $meeting->attendance_list }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('meetings.show', $meeting) }}" class="show-btn">View</a>
                        <a href="{{ route('meetings.edit', $meeting) }}" class="edit-btn">Edit</a>
                        <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" style="display:inline-block;">
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
    <div class="d-flex justify-content-center">
        {{ $meetings->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
