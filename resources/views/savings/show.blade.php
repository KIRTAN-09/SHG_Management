@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            Savings Information
        </div>
        <div class="card-body">
            <p><strong>member_name:</strong> {{ $saving->member_name }}</p>
            <p><strong>member_id:</strong> {{ $saving->member_id }}</p>
            <p><strong>Amount:</strong> {{ $saving->amount }}</p>
            <p><strong>Date:</strong> {{ $saving->date_of_deposit}}</p> <!-- Ensure $saving->date is set correctly -->
        </div>
    </div>
    <a href="{{ route('savings.index') }}" class="btn btn-primary mt-3">Back to Savings List</a>
</div>
@endsection