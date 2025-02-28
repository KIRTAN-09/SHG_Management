@extends('layouts.app')

@section('content')
<br>
<link href="{{ asset('css/create.css') }}" rel="stylesheet">

<div class="container1">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <h1><b>Create New User</b></h1>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" placeholder="Name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm Password:</label>
            <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="roles">Role:</label>
            <select name="roles[]" class="form-control" multiple="multiple" required>
                @foreach ($roles as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection