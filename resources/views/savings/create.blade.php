@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/Create.css') }}">

<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('savings.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
<div class="container">
    <form action="{{ route('savings.store') }}" method="post">
        @csrf
        <h1><b>Savings  Form</b></h1>
        <!-- Group ID -->
        <label for="group-id">Group Name:</label>
        <select id="group-id" name="group-id">
            <option value="">Select Group</option>
            @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select><br><br>
        
        <!-- Member Name -->
        <label for="member-name">Member Name:</label>
        <select id="member-name" name="member-name"> <!-- Changed from 'member-id' to 'member-name' -->
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->name }}">{{ $member->name }}</option>
            @endforeach
        </select><br><br>
        
        <!-- Date of deposit -->
        <label for="date-of-deposit">Date of Deposit:</label>
        <input type="date" id="date-of-deposit" name="date-of-deposit" required><br><br>
        
        <!-- Amount -->
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" required>
        <span id="amount-error" class="error-message" style="display: none; color: red;">Amount Can't Be Negative</span><br><br>
        
        <input type="submit" value="Submit">    
    </form>
</div>

<script>
// Prevent future dates in the date of deposit field
const dateOfDeposit = document.getElementById('date-of-deposit');
const today = new Date().toISOString().split('T')[0];
dateOfDeposit.setAttribute('max', today);

// Validation for Group ID input
document.getElementById('group-id').addEventListener('input', function() {
    const value = this.value;
    if (isNaN(value) || /[^0-9]/.test(value)) {
        document.getElementById('group-id-error').style.display = 'block';
    } else {
        document.getElementById('group-id-error').style.display = 'none';
    }
});

// Validation for Member ID and Name inputs
document.getElementById('member-id').addEventListener('input', function() {
    const value = this.value;
    if (isNaN(value) || /[^0-9]/.test(value)) {
        document.getElementById('member-id-error').style.display = 'block';
    } else {
        document.getElementById('member-id-error').style.display = 'none';
    }
});

document.getElementById('member-name').addEventListener('input', function() {
    const value = this.value;
    if (/[^a-zA-Z]/.test(value)) {
        document.getElementById('member-name-error').style.display = 'block';
    } else {
        document.getElementById('member-name-error').style.display = 'none';
    }
});

// Validation for Amount input
document.getElementById('amount').addEventListener('input', function() {
    const value = this.value;
    if (value < 0) {
        this.value = '';
        document.getElementById('amount-error').style.display = 'block';
    } else {
        document.getElementById('amount-error').style.display = 'none';
    }
});
</script>
@endsection
