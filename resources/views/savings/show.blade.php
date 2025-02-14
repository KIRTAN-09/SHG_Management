@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Savings Details</h1>
    <div class="card">
        <div class="card-header">
            Savings Information
        </div>
        <div class="card-body">
            <p><strong>Amount:</strong> {{ $saving->amount }}</p>
            <p><strong>Date:</strong> {{ $saving->date }}</p>
            <p><strong>Description:</strong> {{ $saving->description }}</p>
        </div>
    </div>
    <a href="{{ route('savings.index') }}" class="btn btn-primary mt-3">Back to Savings List</a>
</div>
@endsection