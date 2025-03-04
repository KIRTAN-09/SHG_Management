@extends('layouts.app')

@section('title', 'Savings')

@section('content_header')
    <h1>Savings</h1>
    @stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12"><br>
        <link rel="stylesheet" href="{{ asset(path: 'css/table.css') }}">
        @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
            <a href="{{ route('savings.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Saving</a>
    <!-- Search and Sort Form -->
    <form method="GET" action="{{ route('savings.index') }}" class="mb-4">
        <div class="flex justify-end">
            <input type="text" name="search" id="search" placeholder="Search..." class="py-2 px-2 w-1/4 rounded-lg border border-gray-300 mr-2" value="{{ request('search') }}">
a        </div>
    </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Group ID</th>
                        <th>Group Name</th>
                        <th>Member ID</th>
                        <th>Member Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="savings-table-body">
                    @foreach($savings as $saving)
                        <tr>
                            <td>{{ $saving->group_id }}</td>
                            <td>{{$saving->group_name  }}</td>
                            <td>{{ $saving->member_id }}</td>
                            <td>{{ $saving->member_name }}</td>
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
            {{ $savings->links('pagination::bootstrap-4') }} <!-- Add this line for pagination links -->
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
        }, 2000); // 2000 milliseconds = 2 seconds

        // Live search functionality
        document.getElementById('search').addEventListener('keyup', function() {
            let query = this.value.toLowerCase();
            let rows = document.querySelectorAll('#savings-table-body tr');
            rows.forEach(function(row) {
                let groupName = row.children[1].textContent.toLowerCase();
                let memberName = row.children[3].textContent.toLowerCase();
                if (groupName.includes(query) || memberName.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
