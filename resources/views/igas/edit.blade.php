@extends('layouts.app')

@section('content')
<style>
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
}

form {
    width: 100%;
    max-width: 600px;
    padding: 20px;
    border: 1px solidrgb(66, 67, 70);
    border-radius: 20px;
    box-shadow: 0px 0px 10px rgba(8, 8, 8, 0.478);
    background-color: #fff;
}

form:hover {
    box-shadow: 0px 0px 15px rgba(19, 19, 20, 0.6);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    color:rgb(0, 0, 0);
    font-size: 28px;
    font-style: bold;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color:rgb(0, 0, 0);
    font-size: 16px;
}

.radio-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

input[type="text"],
input[type="date"],
input[type="number"] {
    width: calc(100% - 16px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 14px;
    font-weight: normal; /* Ensure font is not bold */
    transition: border-color 0.3s ease-in-out;
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="number"]:focus {
    border-color: #007bff;
    outline: none;
}

input[type="date"] {
    width: calc(100% - 16px);
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #092f57;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    display: block;
    margin: 0 auto;
    transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

input[type="submit"]:hover {
    background-color:rgb(15, 73, 134);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.error-message {
    font-size: 12px;
}
</style>
<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('igas.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
<div class="container">
    <form action="{{ route('igas.update', $iga->id) }}" method="POST">
    <h1>Edit IGA</h1>
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="member-id">Member ID/Name</label>
            <select class="form-control" id="member-id" name="member_uid" required>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ $iga->member_uid == $member->id ? 'selected' : '' }}>{{ $member->id }}-{{$member->name}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $iga->date }}" required>
        </div>
        <!-- <div class="form-group">
            <label for="activity">Activity Name</label>
            <input type="text" class="form-control" id="activity" name="activity" value="{{ $iga->activity }}" required>
        </div> -->
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category">
                <option value="Farming" {{ $iga->category == 'Farming' ? 'selected' : '' }}>Farming</option>
                <option value="Trading" {{ $iga->category == 'Trading' ? 'selected' : '' }}>Trading</option>
                <option value="Services" {{ $iga->category == 'Services' ? 'selected' : '' }}>Services</option>
                <option value="Other" {{ $iga->category == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <!-- <div class="form-group">
            <label for="investment">Amount Invested</label>
            <input type="number" class="form-control" id="investment" name="investment" value="{{ $iga->investment }}" required>
        </div> -->
        <div class="form-group">
            <label for="earned">Amount Earned</label>
            <input type="number" class="form-control" id="earned" name="earned" value="{{ $iga->earned }}" required>
        </div>
        <!-- <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea class="form-control" id="remarks" name="remarks" required>{{ $iga->remarks }}</textarea>
        </div> -->
        
        <input type="submit" value="Update">
    </form>
</div>
@endsection
