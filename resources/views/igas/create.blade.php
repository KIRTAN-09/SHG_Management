@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create IGA</h1>
    <form action="{{ route('igas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Member-id</label>
            <input type="text" class="form-control" id="member-id" name="member-id" required>
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
