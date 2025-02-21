@extends('layouts.app')

@section('content')

<div class="container">
<link rel="stylesheet" href="{{ asset('css/Members/Create.css') }}">
    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1><b>Add Member</b></h1>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="number">Number:</label>
            <input type="tel" id="number" name="number">
        </div>
        <div class="form-group">
            <label for="village">Village:</label>
            <input type="text" id="village" name="village" required>
        </div>
        <div class="form-group">
            <label for="group">Group:</label>
            <select id="group" name="group" required>
            @foreach($groups as $group)
                <option value="{{ $group->name }}">{{ $group->name }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="caste">Caste:</label>
            <input type="text" id="caste" name="caste" required>
        </div>
        <div class="form-group">
            <label for="share_price">Share Price:</label>
            <input type="number" id="share_price" name="share_price" required>
        </div>
        <div class="form-group">
            <label for="member_type">Member Type:</label>
            <select id="member_type" name="member_type" required>
                <option value="President">President</option>
                <option value="Secretary">Secretary</option>
                <option value="Member">Member</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo">
        </div>
        <input type="submit" value="Add Member">
    </form>
</div>
@endsection
