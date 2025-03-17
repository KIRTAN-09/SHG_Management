@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Savings Information
        </div>
        <div class="card-body">
            <p><strong>Training Category:</strong> {{ $training->category }}</p>
            <p><strong>Training Date:</strong> {{ $training->training_date}}</p>
            <p><strong>Training Location:</strong> {{ $training->location }}</p>
            <p><strong>Number of Participants:</strong> {{ $training->participants }}</p>
            <p><strong>Trainer Name:</strong> {{ $training->trainer}}</p>
            <p><strong>Member Name:</strong> {{ $training->members_name }}</p>
            <p><strong>Member ID:</strong> {{ $training->members_ID }}</p>
        </div>
    </div>
    <a href="{{ route('training.index') }}" class="btn btn-primary mt-3">Back to Training List</a>
</div>
@endsection