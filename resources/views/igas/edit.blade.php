@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit IGA</h1>
    <form action="{{ route('igas.update', $iga->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $iga->name }}" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $iga->date }}" required>
        </div>
        <!-- <div class="form-group">
            <label for="activity">Activity Name</label>
            <input type="text" class="form-control" id="activity" name="activity" value="{{ $iga->activity }}" required>
        </div> -->
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" id="category" name="category">
                <option value="Farming" {{ $iga->category == 'Farming' ? 'selected' : '' }}>Farming</option>
                <option value="Trading" {{ $iga->category == 'Trading' ? 'selected' : '' }}>Trading</option>
                <option value="Services" {{ $iga->category == 'Services' ? 'selected' : '' }}>Services</option>
                <option value="Other" {{ $iga->category == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>
        <!-- <div class="form-group">
            <label for="investment">Amount Invested</label>
            <input type="number" class="form-control" id="investment" name="investment" value="{{ $iga->investment }}" required>
        </div> -->
        <div class="form-group">
            <label for="earned">Amount Earned</label>
            <input type="number" class="form-control" id="earned" name="earned" value="{{ $iga->earned }}" required>
        </div>
        <!-- <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea class="form-control" id="remarks" name="remarks" required>{{ $iga->remarks }}</textarea>
        </div> -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
