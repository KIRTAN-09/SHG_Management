@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Group</h1>
    <form action="{{ route('groups.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Group Name</label>
            <input type="text" name="name" class="form-control" value="{{ $group->name }}" required>
        </div>
        <div class="form-group">
            <label for="village_name">Village Name</label>
            <input type="text" name="village_name" class="form-control" value="{{ $group->village_name }}" required>
        </div>
        <div class="form-group"> 
            <label for="president_name">Group President Name</label>
            <input type="text" name="president_name" class="form-control" value="{{ $group->president_name }}" required>
        </div>
        <div class="form-group">
            <label for="secretary_name">Group Secretary Name</label>
            <input type="text" name="secretary_name" class="form-control" value="{{ $group->secretary_name }}" required>
        </div>
        <!-- <div class="form-group">
            <label for="no_of_members">No. of Members</label>
            <input type="number" name="no_of_members" class="form-control" value="{{ $group->no_of_members }}" required>
        </div> -->
        <button type="submit" class="btn btn-primary">Update Group</button>
    </form>
</div>
@endsection
