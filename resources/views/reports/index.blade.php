@extends('adminlte::page')

@section('title', 'Reports List')

@section('content_header')
<div class="container">
    <h1>Reports</h1>
    <form action="{{ route('reports.filter') }}" method="GET">
        <div class="form-group">
            <label for="reportType">Report Type:</label>
            <select name="reportType" id="reportType" class="form-control">
                <option value="all">All</option>    
                <option value="members">Members</option>
                <option value="groups">Groups</option>
                <option value="savings">Savings</option>
                <option value="igas">IGAs</option>
                <option value="training">Training</option>
                <option value="meetings">Meetings</option>
            </select>
        </div>
        <div class="form-group">
            <label for="startDate">Start Date:</label>
            <input type="date" name="startDate" id="startDate" class="form-control">
        </div>
        <div class="form-group">
            <label for="endDate">End Date:</label>
            <input type="date" name="endDate" id="endDate" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>
    <hr>
    <div id="reportResults">
        <!-- Report results will be displayed here -->
        @if(isset($reportData) && $reportType == 'members')
            <h2>Members Report</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Joined Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
