@extends('layouts.app')

@section('title', 'Training')
@section('content_header')
<h2 class="text-2xl font-bold mb-4">Training</h2>
@stop

@section('content')
<div class="container">
    <div class="pull-right">
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">
        <a href="{{ route('training.create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Add Training</a>
    </div>
    <!-- Live Search Bar -->
    <div class="flex justify-end">
        <input type="text" id="liveSearch" placeholder="Search..." class="py-2 px-2 w-1/4 rounded-lg border border-gray-300">
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    @foreach(['training_date' => 'Date', 'category' => 'Category', 'location' => 'Location', 'participants' => 'Participants', 'trainer' => 'Trainer'] as $column => $label)
                    <th>
                        <form method="GET" action="{{ route('training.index') }}">
                            <input type="hidden" name="column" value="{{ $column }}">
                            <input type="hidden" name="sort" value="{{ request('column') === $column && request('sort') === 'asc' ? 'desc' : 'asc' }}">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="page" value="{{ request('page', 1) }}">
                            <button type="submit" class="header-button">
                                {{ $label }} {{ request('column') === $column ? (request('sort') === 'asc' ? '▲' : '▼') : '' }}
                            </button>
                        </form>
                    </th>
                    @endforeach
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="trainingTable">
                @foreach ($trainings as $training)
                    <tr>
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

<script>
    document.getElementById('liveSearch').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.getElementById('trainingTable').getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].innerText.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    });
</script>
@endsection
