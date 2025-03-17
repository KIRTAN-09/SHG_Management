@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Savings Information
        </div>
        <div class="card-body">
            <p><strong>Group ID:</strong> {{ $savings->group_id }}</p>
            <p><strong>Group Name:</strong> {{ $savings->group_name }}</p> <!-- Fetch group name from the join -->
            <p><strong>Member Name:</strong> {{ $savings->member_name }}</p>
            <!-- <p><strong>Member ID:</strong> {{ $savings->member ? $savings->member->name : 'N/A' }}</p> -->
            <p><strong>Amount:</strong> {{ $savings->amount }}</p>
            <p><strong>Date of Deposit:</strong> {{ $savings->date_of_deposit }}</p>
        </div>
    </div>
    <a href="{{ route('savings.index') }}" class="btn btn-primary mt-3">Back to Savings List</a>
</div>
@endsection