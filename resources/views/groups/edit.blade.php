@extends('layouts.app')

@section('content')

<link href="{{ asset('css/Create.css') }}" rel="stylesheet">

<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('groups.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
<div class="container">
    <form action="{{ route('groups.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h1>Edit Group</h1>
        <div class="form-group">
            <label for="name">Group Name</label>
            <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
        </div>
        <div class="form-group">
            <label for="village_name">Village Name</label>
            <input type="text" name="village_name" class="form-control" value="{{ $group->village_name }}" required>
        </div>
        <input type="submit" value="Update">
    </form>
</div>
@endsection
