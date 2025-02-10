@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Savings</h1>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <a href="{{ route('savings.create') }}" class="btn btn-primary mb-3">Add New Saving</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Member ID</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($savings as $saving)
                        <tr>
                            <td>{{ $saving->id }}</td>
                            <td>{{ $saving->name }}</td>
                            <td>{{ $saving->amount }}</td>
                            <td>{{ $saving->date }}</td>
                            <td>
                                <a href="{{ route('savings.edit', $saving->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('savings.destroy', $saving->id) }}" method="POST" style="display:inline;">
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
    </div>
</div>
@endsection
