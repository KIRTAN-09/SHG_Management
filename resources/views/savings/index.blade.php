@extends('layouts.app')

@section('title', 'Savings')

@section('content_header')
<h2 class="text-2xl font-bold mb-4">Savings</h2>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12"><br>
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">
        <style>
            .header-button {
                color: inherit;
                text-decoration: none;
                background: none;
                border: none;
                padding: 0;
                cursor: pointer;
            }
        </style>
        @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('savings.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Saving</a>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    @foreach(['group_id' => 'Group ID', 
                    'member_name' =>  'Member Name', 
                    'date_of_deposit' => 'Date', 
                    'amount' => 'Amount']
                     as $column => $label)

                        <th>
                            <form method="GET" action="{{ route('savings.index') }}">
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
            <tbody id="savings-table-body">
                @foreach($savings as $saving)
                    <tr>
                        <td>{{ $saving->group_id }}</td>
                        <td>{{ $saving->member_name }}</td> <!-- Changed to display member_name -->
                        <td>{{ $saving->date_of_deposit }}</td>
                        <td>{{ $saving->amount }}</td>
                        <td>
                            <a href="{{ route('savings.show', $saving->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('savings.edit', $saving->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('savings.destroy', $saving->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this saving?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $savings->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 2000);

        // Live search functionality
        document.getElementById('search').addEventListener('keyup', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#savings-table-body tr');
            rows.forEach(function(row) {
                let date = row.children[2].textContent.toLowerCase();
                let memberName = row.children[1].textContent.toLowerCase();
                if (date.includes(query) || memberName.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
