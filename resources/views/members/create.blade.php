@extends('adminlte::page')

@section('title', 'Add Member')

@section('content_header')
    <h1>Add Member</h1>
@stop

@section('content')
    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name:</label>
            <input type="text" name="name" id="name" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
        </div>
        <div class="mb-4">
            <label for="number" class="block text-gray-700">Number:</label>
            <input type="tel" id="number" name="number" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
        </div>
        <div class="mb-4">
            <label for="village" class="block text-gray-700">Village:</label>
            <input type="text" id="village" name="village" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
        </div>
        <div class="mb-4">
            <label for="group" class="block text-gray-700">Group:</label>
            <select id="group" name="group" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
            @foreach($groups as $group)
                <option value="{{ $group->name }}">{{ $group->name }}</option>
            @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="caste" class="block text-gray-700">Caste:</label>
            <input type="text" id="caste" name="caste" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
        </div>
        <div class="mb-4">
            <label for="share_price" class="block text-gray-700">Share Price:</label>
            <input type="number" id="share_price" name="share_price" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
        </div>
        <div class="mb-4">
            <label for="member_type" class="block text-gray-700">Member Type:</label>
            <select id="member_type" name="member_type" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
                <option value="President">President</option>
                <option value="Secretary">Secretary</option>
                <option value="Member">Member</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700">Status:</label>
            <select id="status" name="status" class="py-2 px-4 rounded-lg border border-gray-300 w-full">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="photo" class="block text-gray-700">Photo:</label>
            <input type="file" id="photo" name="photo" class="py-2 px-4 rounded-lg border border-gray-300 w-full" onchange="validatePhotoSize()">
            <span id="photo-error" style="color: red; display: none;">Photo size should not be more than 1 MB</span>
        </div>
        <div class="mb-4">
            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-700">Save</button>
        </div>
    </form>
@stop

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
</script>
