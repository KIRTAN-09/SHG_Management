@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Training List</h2>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <a href="{{ route('training.create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Add Training</a>
    
    <!-- Search and Sort Form -->
    <form method="GET" action="{{ route('training.index') }}" class="mb-4">
        <div class="flex justify-end">
            <input type="text" name="search" placeholder="Search..." class="py-2 px-4 rounded-lg border border-gray-300 mr-2" value="{{ request('search') }}">
            <select name="sort" class="py-2 px-2 rounded-lg border border-gray-300 mr-2">
                <option value="">Sort By</option>
                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date Ascending</option>
                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date Descending</option>
                <option value="category" {{ request('sort') == 'category' ? 'selected' : '' }}>Category</option>
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <!-- <th class="py-2 px-4 border-b">Training ID</th> -->
                    <th>Training Date</th>
                    <th>Training Category</th>   
                    <th>Training Location</th>
                    <th>Number of Participants</th>
                    <th>Trainer Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainings as $training)
                    <tr>
                        <!-- <td class="py-2 px-4 border-b">{{ $training->training_id }}</td> -->
                        <td>{{ $training->training_date }}</td>
                        <td>{{ $training->category }}</td>
                        <td>{{ $training->location }}</td>
                        <td>{{ $training->participants }}</td>
                        <td>{{ $training->trainer }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('training.show', $training->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('training.edit', $training->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('training.destroy', $training->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $trainings->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
