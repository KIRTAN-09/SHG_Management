@extends('layouts.app')

@section('content')

<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('members.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

<div class="container">
<link rel="stylesheet" href="{{ asset('css/Members/Create.css') }}">
    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateMemberType()">
        @csrf
        <h1><b>Add Member</b></h1>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required> 
        </div>
        <div class="form-group">
            <label for="number">Contact Number:</label>
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
            <select id="caste" name="caste" required>
                <option value="General">General</option>
                <option value="ST">ST</option>
                <option value="SC">SC</option>
                <option value="OBC">OBC</option>
            </select>
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
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo" onchange="validatePhotoSize()">
            <span id="photo-error" style="color: red; display: none;">Photo size should not be more than 1 MB</span>
        </div>
        <input type="submit" value="Add Member">
    </form>
</div>

<script>
function validatePhotoSize() {
    const photoInput = document.getElementById('photo');
    const photoError = document.getElementById('photo-error');
    const submitButton = document.querySelector('input[type="submit"]');
    const maxSize = 1; // Maximum file size in MB

    if (photoInput.files.length > 0) {
        const fileSize = photoInput.files[0].size / 1024 / 1024; // Convert size to MB
        if (fileSize >= maxSize) {
            photoError.style.display = 'block';
            photoInput.value = ''; // Clear the file input field
            submitButton.disabled = true; // Disable submit button
            return false;
        } else {
            photoError.style.display = 'none';
            submitButton.disabled = false; // Enable submit button
        }
    }
    return true;
}

function validateMemberType() {
    const memberType = document.getElementById('member_type').value;
    const group = document.getElementById('group').value;

    // Simulated check for existing President/Secretary in the group
    const existingRoles = @json($existingRoles); // Pass existing roles from the backend
    if ((memberType === 'President' || memberType === 'Secretary') && existingRoles[group]?.includes(memberType)) {
        alert(`There can only be one ${memberType} in the group.`);
        return false;
    }
    return validatePhotoSize(); // Ensure photo size validation is also performed
}
</script>

@endsection