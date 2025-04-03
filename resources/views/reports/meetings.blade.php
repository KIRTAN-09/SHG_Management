@extends('layouts.app')

@section('content')

<style>
    form {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }
    form input[type="date"] {
        margin-bottom: 10px;
        padding: 5px;
        width: 100%;
        max-width: 300px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    form button {
        padding: 8px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }
    form button:hover {
        background-color: #0056b3;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    table tr:hover {
        background-color: #f1f1f1;
    }
</style>

<form method="GET" action="{{ route('reports.meetings') }}">
    <label for="from_date">From Date:</label>
    <input type="date" id="from_date" name="from_date">
    
    <label for="to_date">To Date:</label>
    <input type="date" id="to_date" name="to_date">
    
    <button type="submit">Fetch Details</button>
</form>

@if(isset($meetings) && $meetings->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Group Name</th>
                <th>Group UID</th>
                <th>Discussion</th>
                <th>Attendance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meetings as $meeting)
                <tr>
                    <td>{{ $meeting->id }}</td>
                    <td>{{ $meeting->date }}</td>
                    <td>{{ $meeting->group_name }}</td>
                    <td>{{ $meeting->group_uid }}</td>
                    <td>{{ $meeting->discussion }}</td>
                    <td>
                        @if($meeting->attendance)
                            @php
                                $memberNames = \App\Models\Member::whereIn('id', json_decode($meeting->attendance))->pluck('name')->toArray();
                            @endphp
                            {{ implode(', ', $memberNames) }}
                        @else
                            No Attendance
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@elseif(isset($meetings))
    <p>No meetings found for the selected date range.</p>
@endif

@endsection