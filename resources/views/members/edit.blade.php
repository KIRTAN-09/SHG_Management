@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Edit Member</h1>
    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="photo" class="block text-gray-700">Photo</label>
            <input type="file" class="form-control" id="photo" name="photo">
            @if ($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" alt="Member Photo" class="w-24 h-24 object-cover mt-2 rounded-full">
            @endif
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $member->name }}" required>
        </div>

        <div class="mb-4">
            <label for="number" class="block text-gray-700">Number</label>
            <input type="text" class="form-control" id="number" name="number" value="{{ $member->number }}">
        </div>

        <div class="mb-4">
            <label for="village" class="block text-gray-700">Village</label>
            <input type="text" class="form-control" id="village" name="village" value="{{ $member->village }}" required>
        </div>

        <div class="mb-4">
            <label for="group" class="block text-gray-700">Group</label>
            <input type="text" class="form-control" id="group" name="group" value="{{ $member->group }}" required>
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

        <button type="submit" class="btn btn-primary">Update Member</button>
    </form>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "{{ route('members.index') }}";
            } else {
                // Handle validation errors
                console.error(data.errors);
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
