@extends('layouts.app')

@section('content')
<div class="container">
<h2 class="text-2xl font-bold mb-4">Groups</h2>
<link rel="stylesheet" href="{{ asset(path: 'css/Groups/table.css') }}">
<a href="{{ route('groups.create') }}" class="btn btn-primary">Add Group</a>
    <div class="table-container">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Group ID</th>
                    <th>Name</th>
                    <th>Village Name</th>
                    <th>President Name</th>
                    <th>Secretary Name</th>
                    <th>No. of Members</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groups as $group)
                <tr>
                    <td>{{ $group->group_id }}</td>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->village_name }}</td>
                    <td>{{ $group->president_name }}</td>
                    <td>{{ $group->secretary_name }}</td>
                    <td>{{ $group->no_of_members }}</td>
                    <td class="action-buttons">
                        <a href="{{ route('groups.show', $group->id) }}" class="view-btn">View</a>
                        <a href="{{ route('groups.edit', $group->id) }}" class="edit-btn">Edit</a>
                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST" style="display:inline-block;">
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
        {{ $groups->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
