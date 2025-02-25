@extends('layouts.app')

@section('content')
<div class="container">
<h2 class="text-2xl font-bold mb-4">IGAs</h2>
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <a href="{{ route('igas.create') }}" class="btn btn-primary">Create IGA</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Category</th>
                <th>Earned</th>                                                                          
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($igas as $iga)
            <tr>
                <td>{{ $iga->name }}</td>
                <td>{{ $iga->date }}</td>
                <td>{{ $iga->category }}</td>
                <td>{{ $iga->earned }}</td>
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
            @endforeach
        </tbody>
    </table>
</div>
@endsection
