@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center mt-4">
    <div class="col-md-3 mt-3">
        <div class="card text-dark bg-info text-center p-3" style="background-color: lightblue !important; height: 150px;">
            <h3 class="text-dark">{{ $totalGroups }}</h3>
            <p class="text-dark">Total Groups</p>
            <a href="{{ route('groups.index') }}" class="text-dark">More info </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark bg-success text-center p-3" style="background-color: lightblue !important; height: 150px;">
            <h3 class="text-dark">{{ $totalMembers }}</h3>
            <p class="text-dark">Total Members</p>
            <a href="{{ route('members.index') }}" class="text-dark">More info </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark bg-danger text-center p-3" style="background-color: lightblue !important; height: 150px;">
            <h3 class="text-dark">{{ $totalActiveMembers }}</h3>
            <p class="text-dark">Total Active Members</p>
            <a href="#" class="text-dark">More info </a>
        </div>
    </div>
</div>
@endsection
