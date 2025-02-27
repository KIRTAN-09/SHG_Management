@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <h1>{{ $iga->name }}</h1> -->
    <p><strong>Name:</strong> {{ $iga->name }}</p>
    <p><strong>Date:</strong> {{ $iga->created_at->format('d M Y') }}</p>
    <p><strong>Category:</strong> {{ $iga->category }}</p>
    <p><strong>Earned:</strong> {{ $iga->earned }}</p>
    <a href="{{ route('igas.index') }}" class="btn btn-primary">Back to IGAs</a>
</div>
@endsection
