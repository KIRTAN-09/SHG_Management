@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Member Details</h1>
    <div class="card">
        <div class="card-header">
            {{ $member->name }}
        </div>
        <div class="card-body">
        @if ($member->photo)
                <p><strong>Photo:</strong></p>
                <img src="{{ asset('storage/' . $member->photo) }}" alt="Member Photo" style="max-width: 200px;">
            @endif
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
