@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Training List</h2>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <a href="{{ route('training.create') }}" class="btn btn-primary mb-4">Add Training</a>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead">
                <tr>
                    <!-- <th class="py-2 px-4 border-b">Training ID</th> -->
                    <th class="py-2 px-4 border-b">Training Date</th>
                    <th class="py-2 px-4 border-b">members_name</th>
                    <th class="py-2 px-4 border-b">members_ID</th>
                    <th class="py-2 px-4 border-b">Training Category</th>   
                    <th class="py-2 px-4 border-b">Training Location</th>
                    <th class="py-2 px-4 border-b">Number of Participants</th>
                    <th class="py-2 px-4 border-b">Trainer Name</th>
                    <th class="py-2 px-4 border-b">Traning Category</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainings as $training)
                    <tr>
                        <!-- <td class="py-2 px-4 border-b">{{ $training->training_id }}</td> -->
                        <td class="py-2 px-4 border-b">{{ $training->training_date }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->members_name }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->members_ID }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->category }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->location }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->participants }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->trainer }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->category }}</td>
                        <td class="py-2 px-4 border-b action-buttons">
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
