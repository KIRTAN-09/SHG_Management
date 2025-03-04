@extends('layouts.app')

@section('content')
<div class="container">
<h2 class="text-2xl font-bold mb-4">IGAs</h2>
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <a href="{{ route('igas.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Create IGA</a>
    <!-- Live Search Input -->
    <div class= "flex justify-end">
        <input type="text" id="search" placeholder="Search..." class="py-2 px-2 w-1/4 rounded-lg border border-gray-300 mr-2">
    </div>
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
        <tbody id="igaTable">
            @foreach($igas as $iga)
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
            @endforeach
        </tbody>
    </table>
</div>

<script>
document.getElementById('search').addEventListener('keyup', function() {
    var searchValue = this.value.toLowerCase();
    var rows = document.querySelectorAll('#igaTable tr');
    rows.forEach(function(row) {
        var name = row.cells[0].textContent.toLowerCase();
        var category = row.cells[2].textContent.toLowerCase();
        if (name.includes(searchValue) || category.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection
