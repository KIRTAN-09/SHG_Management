@extends('layouts.app')

@section('content')
<div class="container">
<h2 class="text-2xl font-bold mb-4">IGAs</h2>
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <a href="{{ route('igas.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Create IGA</a>
    <!-- Search and Sort Form -->
    <form method="GET" action="{{ route('igas.index') }}" class="mb-4">
        <div class="flex justify-end">
            <input type="text" name="search" placeholder="Search..." class="py-2 px-2 w-1/4 rounded-lg border border-gray-300 mr-2" value="{{ request('search') }}">
    
            <button type="submit" class="btn btn-primary w-auto">Search</button>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Category</th>
                <th>Earned</th>   
                <!-- <th>Activity</th>                                                                        -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($igas as $iga)
            @if (stripos($iga->name, request('search')) !== false || stripos($iga->category, request('search')) !== false)
            <tr>
                <td>{{ $iga->name }}</td>
                <td>{{ $iga->date }}</td>
                <td>{{ $iga->category }}</td>
                <td>{{ $iga->earned }}</td>
                <!-- <td>{{ $iga->activity}}</td> -->
                <td>
                    <a href="{{ route('igas.show', $iga->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('igas.edit', $iga->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('igas.destroy', $iga->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>   
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection
