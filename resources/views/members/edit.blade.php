@extends('layouts.app')

@section('content')

<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('members.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

<div class="container">
<link rel="stylesheet" href="{{ asset('css/Members/Create.css') }}">
    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateMemberType()">
        @csrf
        @method('PUT')
        <h1><b>Edit Member</b></h1>
        

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
        </div>

        <div class="form-group">
            <label for="number">Contect Number:</label>
            <input type="text" class="form-control" id="number" name="number" value="{{ $member->number }}">
        </div>

        <div class="form-group">
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
        

        <div class="form-group">
            <label for="caste" class="block text-gray-700">Caste</label>
            <select class="form-control" id="caste" name="caste" required>
                <option value="General" {{ $member->caste == 'General' ? 'selected' : '' }}>General</option>
                <option value="ST" {{ $member->caste == 'ST' ? 'selected' : '' }}>ST</option>
                <option value="SC" {{ $member->caste == 'SC' ? 'selected' : '' }}>SC</option>
                <option value="OBC" {{ $member->caste == 'OBC' ? 'selected' : '' }}>OBC</option>
            </select>
        </div>

        <div class="form-group">
            <label for="share_price" class="block text-gray-700">Share Price</label>
            <input type="number" class="form-control" id="share_price" name="share_price" value="{{ $member->share_price }}" required>
        </div>

        <div class="form-group">
            <label for="member_type" class="block text-gray-700">Member Type</label>
            <select class="form-control" id="member_type" name="member_type" required>
                <option value="President" {{ $member->member_type == 'President' ? 'selected' : '' }}>President</option>
                <option value="Secretary" {{ $member->member_type == 'Secretary' ? 'selected' : '' }}>Secretary</option>
                <option value="Member" {{ $member->member_type == 'Member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status" class="block text-gray-700">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Active" {{ $member->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ $member->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        

      

        <input type="submit" value="Update Member">
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

async function fetchMembers(groupId) {
    const membersList = document.getElementById('members_list');
    membersList.innerHTML = 'Loading members...';

    try {
        const response = await fetch(`/api/groups/${groupId}/members`);
        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Failed to fetch members: ${response.status} ${response.statusText} - ${errorText}`);
        }

        const members = await response.json();
        if (!Array.isArray(members)) {
            throw new Error('Invalid response format: Expected an array of members');
        }

        membersList.innerHTML = members.map(member => `
            <div>
                <input type="checkbox" name="attendance[]" value="${member.id}">
                ${member.name}
            </div>
        `).join('');
    } catch (error) {
        membersList.innerHTML = 'Error loading members. Please try again later.';
        console.error('Error fetching members:', error);
    }
}

function selectGroup(id, name) {
    document.getElementById('group_search').value = name;
    document.getElementById('group_uid').value = id;
    document.getElementById('group_dropdown').style.display = 'none';
    fetchMembers(id); // Fetch members when a group is selected
}
</script>

@endsection
