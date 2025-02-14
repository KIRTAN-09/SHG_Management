@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Training List</h2>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <a href="{{ route('training.create') }}" class="btn btn-primary mb-4">Add Training</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Members UID</th>
                    <th class="py-2 px-4 border-b">Training Date</th>
                    <th class="py-2 px-4 border-b">Training Topic</th>
                    <th class="py-2 px-4 border-b">Training Location</th>
                    <th class="py-2 px-4 border-b">Number of Participants</th>
                    <th class="py-2 px-4 border-b">Training Category</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainings as $training)
                    <tr>
                        <td class="py-2 px-4 border-b">{{ $training->training_id }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->date }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->topic }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->trainer }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->duration }}</td>
                        <td class="py-2 px-4 border-b">{{ $training->status }}</td>
                        <td class="py-2 px-4 border-b action-buttons">
                            <a href="{{ route('training.show', $training->id) }}" class="view-btn">View</a>
                            <a href="{{ route('training.edit', $training->id) }}" class="edit-btn">Edit</a>
                            <form action="{{ route('training.destroy', $training->id) }}" method="POST" class="inline">
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
        {{ $trainings->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
