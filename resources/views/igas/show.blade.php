@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $iga->name }}</h1>
    <p>{{ $iga->description }}</p>
    <h2>IGA Activities</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Activity Name</th>
                <th>Category</th>
                <th>Amount Invested</th>
                <th>Amount Earned</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($iga->activities as $activity)
            <tr>
                <td>{{ $activity->date }}</td>
                <td>{{ $activity->name }}</td>
                <td>{{ $activity->category }}</td>
                <td>{{ $activity->investment }}</td>
                <td>{{ $activity->earned }}</td>
                <td>{{ $activity->remarks }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('igas.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
