@extends('adminlte::page')

@section('title', 'Edit Training')

@section('content_header')
    <h1>Edit Training</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('training.update', $training->id) }}" method="POST">
    <link rel="stylesheet" href="{{ asset('css/training/Create.css') }}">
        @csrf
        @method('PUT')
        <div class="container">
            <div class="form-group custom-form-group">
                <label for="training_date">Training Date:</label>
                <input type="date" class="form-control custom-input" id="training_date" name="training_date" required>
            </div>  

            <div class="form-group custom-form-group">
                <label for="trainer">Trainer Name:</label>
                <input type="text" class="form-control custom-input" id="trainer" name="trainer" placeholder="Enter trainer's name" required>
            </div>

            <div class="form-group custom-form-group">
                <label for="members_name">Member Name:</label>
                <input type="text" class="form-control custom-input" id="members_name" name="members_name" placeholder="Enter Member's name" required>
            </div>

            <div class="form-group custom-form-group">
                <label for="members_ID">Member ID:</label>
                <input type="text" class="form-control custom-input" id="members_ID" name="members_ID" placeholder="Enter Member's ID" required>
            </div> 
            
            <div class="form-group custom-form-group">
                <label for="location">Training Location:</label>
                <input type="text" class="form-control custom-input" id="location" name="location" placeholder="Enter location" required>
            </div>


            <div class="form-group">
                <label for="category">Training Category:</label>
                <select class="form-control" id="category" name="category">
                    <option value="Farming" {{ $training->category == 'Farming' ? 'selected' : '' }}>Farming</option>
                    <option value="Business Management" {{ $training->category == 'Business Management' ? 'selected' : '' }}>Business Management</option>
                    <option value="Handicrafts" {{ $training->category == 'Handicrafts' ? 'selected' : '' }}>Handicrafts</option>
                    <option value="Other" {{ $training->category == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Training</button>
        </div>
    </form>
@stop
