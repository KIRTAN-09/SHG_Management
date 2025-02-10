@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/members.css') }}">
<div class="container">
    <h2>Add Member</h2>
    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="number">Number</label>
            <input type="tel" class="form-control" id="number" name="number">
        </div>
        <div class="form-group">
            <label for="village">Village</label>
            <input type="text" class="form-control" id="village" name="village" required>
        </div>
        <div class="form-group">
            <label for="group">Group</label>
            <input type="text" class="form-control" id="group" name="group" required>
        </div>
        <div class="form-group">
            <label for="caste">Caste</label>
            <input type="text" class="form-control" id="caste" name="caste" required>
        </div>
        <div class="form-group">
            <label for="share_price">Share Price</label>
            <input type="number" class="form-control" id="share_price" name="share_price" required>
        </div>
        <div class="form-group">
            <label for="member_type">Member Type</label>
            <select class="form-control" id="member_type" name="member_type" required>
                <option value="President">President</option>
                <option value="Secretary">Secretary</option>
                <option value="Member">Member</option>
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
        </div>
        <button type="submit" class="btn btn-primary">Add Member</button>
    </form>
</div>
@endsection
