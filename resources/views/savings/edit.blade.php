@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Create.css') }}">
<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('savings.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

<div class="container">
    <form action="{{ route('savings.update', $savings->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h1><b>Edit Savings</b></h1>

        <!-- Group ID -->
        <label for="group-id">Group ID:</label>
        <select id="group-id" name="group-id">
            <option value="">Select Group</option>
            @foreach($groups as $group)
                <option value="{{ $group->id }}" {{ $group->id == $savings->group_uid ? 'selected' : '' }}>{{ $group->name }}</option> <!-- Display group name -->
            @endforeach
        </select><br><br>

        <!-- Member ID -->
        <label for="member-id">Member Name:</label>
        <select id="member-id" name="member-id">
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}" {{ $member->id == $savings->member_id ? 'selected' : '' }}>{{ $member->name }}</option> <!-- Display member name -->
            @endforeach
        </select><br><br>

        <!-- Date of deposit -->
        <label for="date-of-deposit">Date of Deposit:</label>
        <input type="date" id="date-of-deposit" name="date-of-deposit" value="{{ $savings->date_of_deposit }}" required><br><br>

        <!-- Amount -->
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" value="{{ $savings->amount }}" required><br><br>

        <input type="submit" value="Update">    
    </form>
</div>
@endsection
