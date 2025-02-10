@extends('layouts.app')

@section('content')

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Member Details</h1>
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex items-center mb-4">
            @if ($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" alt="Member Photo" class="w-24 h-24 object-cover rounded-full mr-4">
            @endif
            <h2 class="text-xl font-semibold">{{ $member->name }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <p><strong>ID:</strong> {{ $member->member_id }}</p>
            <p><strong>Number:</strong> {{ $member->number }}</p>
            <p><strong>Village:</strong> {{ $member->village }}</p>
            <p><strong>Group:</strong> {{ $member->group }}</p>
            <p><strong>Caste:</strong> {{ $member->caste }}</p>
            <p><strong>Share Price:</strong> {{ $member->share_price }}</p>
            <p><strong>Member Type:</strong> {{ $member->member_type }}</p>
            <p><strong>Status:</strong> {{ $member->status }}</p>
        </div>
    </div>
    <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Back to Members</a>
</div>
@endsection
