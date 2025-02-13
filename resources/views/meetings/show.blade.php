@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Meeting Details</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $meeting->group_name }}</h5>
            <p class="card-text"><strong>Date:</strong> {{ $meeting->date }}</p>
            <p class="card-text"><strong>Group ID:</strong> {{ $meeting->group_id }}</p>
            <p class="card-text"><strong>Discussion Points:</strong> {{ $meeting->discussion }}</p>
            <p class="card-text"><strong>No. Members Present:</strong> {{ $meeting->attendance_list }}</p>
            <img src="{{ asset('storage/' . $meeting->photo) }}" alt="Group Photo" style="width: 100px; height: auto;">
        </div>
    </div>
    <a href="{{ route('meetings.index') }}" class="btn btn-primary mt-3">Back to Meetings</a>
</div>
@endsection
