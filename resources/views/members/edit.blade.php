@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
<link rel="stylesheet" href="{{ asset('css/Members/Edit.css') }}">
    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6" onsubmit="return validatePhotoSize()">
        @csrf
        @method('PUT')
        <h1 class="text-2xl font-bold mb-4">Edit Member</h1>
        <div class="mb-4">
            <label for="photo" class="block text-gray-700">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" onchange="validatePhotoSize()">
            <span id="photo-error" style="color: red; display: none;">Photo size should be less than 1 MB</span>
            @if ($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" alt="Member Photo" class="w-24 h-24 object-cover mt-2 rounded-full">
            @endif
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
        </div>

        <div class="mb-4">
            <label for="number" class="block text-gray-700">Contect Number:</label>
            <input type="text" class="form-control" id="number" name="number" value="{{ $member->number }}">
        </div>

        <div class="mb-4">
            <label for="village" class="block text-gray-700">Village</label>
            <input type="text" class="form-control" id="village" name="village" value="{{ $member->village }}" required>
        </div>

        <div class="form-group">
            <label for="group">Group:</label>
            <select id="group" name="group" required>
            @foreach($groups as $group)
                <option value="{{ $group->name }}">{{ $group->name }}</option>
            @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="caste" class="block text-gray-700">Caste</label>
            <input type="text" class="form-control" id="caste" name="caste" value="{{ $member->caste }}" required>
        </div>

        <div class="mb-4">
            <label for="share_price" class="block text-gray-700">Share Price</label>
            <input type="number" class="form-control" id="share_price" name="share_price" value="{{ $member->share_price }}" required>
        </div>

        <div class="mb-4">
            <label for="member_type" class="block text-gray-700">Member Type</label>
            <select class="form-control" id="member_type" name="member_type" required>
                <option value="President" {{ $member->member_type == 'President' ? 'selected' : '' }}>President</option>
                <option value="Secretary" {{ $member->member_type == 'Secretary' ? 'selected' : '' }}>Secretary</option>
                <option value="Member" {{ $member->member_type == 'Member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Active" {{ $member->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $member->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" id="submit-btn">Update Member</button>
    </form>
</div>

<script>
function validatePhotoSize() {
    const photoInput = document.getElementById('photo');
    const photoError = document.getElementById('photo-error');
    const submitButton = document.getElementById('submit-btn');
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
</script>

@endsection
