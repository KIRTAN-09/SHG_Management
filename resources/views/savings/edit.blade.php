@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/savings/SavingEdit.css') }}">

<div class="container">
    <form action="{{ route('savings.update', $saving->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h1><b>Edit Savings</b></h1>

        <!-- Group ID -->
        <label for="group-id">Group ID:</label>
        <input type="text" id="group-id" name="group-id" placeholder="Enter Group ID" value="{{ $saving->group_id }}" required><br><br>

        <!-- Member ID -->
        <label for="member-id">Member ID:</label>
        <input type="text" id="member-id" name="member-id" placeholder="Enter Member ID" value="{{ $saving->member_id }}" required><br><br>

        <!-- Member Name -->
        <label for="member-name">Member Name:</label>
        <input type="text" id="member-name" name="member-name" placeholder="Enter Member Name" value="{{ $saving->member_name }}" required><br><br>

        <!-- Date of deposit -->
        <label for="date-of-deposit">Date of Deposit:</label>
        <input type="date" id="date-of-deposit" name="date-of-deposit" value="{{ $saving->date_of_deposit }}" required><br><br>

        <!-- Amount -->
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" value="{{ $saving->amount }}" required><br><br>

        <input type="submit" value="Update">    
    </form>
</div>
@endsection
