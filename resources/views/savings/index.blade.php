@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12"><br>
        <h2 class="text-2xl font-bold mb-4">Savings</h2>
        <link rel="stylesheet" href="{{ asset(path: 'css/table.css') }}">
        @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
            <a href="{{ route('savings.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus"></i> Add New Saving</a>
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
                <tbody>
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
    });
</script>
@endsection
