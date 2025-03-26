@extends('adminlte::page')

@section('title', 'Edit Training')

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

<link rel="stylesheet" href="{{ asset('css/Training/create.css') }}">
<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('training.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
<div class="container">
    <br>
    <form action="{{ route('training.update', $training->id) }}" method="POST">

    @csrf
        @method('PUT')
        <div class="container1">
        <h1>Edit Training</h1>
            <div class="form-group custom-form-group">
                <label for="training_date">Training Date:</label>
                <input type="date" class="form-control custom-input" id="training_date" name="training_date" value="{{ $training->training_date }}">
            </div>  

            <div class="form-group custom-form-group">
                <label for="trainer">Trainer Name:</label>
                <input type="text" class="form-control custom-input" id="trainer_search" placeholder="Search trainer's name">
                <select class="form-control custom-select mt-2" id="trainer" name="trainer" required>
                    <option value="">Select Trainer</option>
                    @foreach($trainers as $trainer)
                        <option value="{{ $trainer->name }}" {{ $training->trainer == $trainer->name ? 'selected' : '' }}>{{ $trainer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group custom-form-group">
                <label for="members_name">Member Name:</label>
                <select class="form-control custom-select" id="members_name" name="members_name" required>
                    @foreach($members as $member)
                        <option value="{{ $member->name }}" {{ $training->members_name == $member->name ? 'selected' : '' }}>{{ $member->name }}</option>
                    @endforeach
                </select>`
            </div>

            <div class="form-group custom-form-group">
                <label for="members_ID">Member ID:</label>
                <select class="form-control custom-select" id="members_ID" name="members_ID" required>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ $training->members_ID == $member->id ? 'selected' : '' }}>{{ $member->id }}-{{$member->name}}</option>
                    @endforeach
                </select>
            </div> 
            
            <div class="form-group custom-form-group">
                <label for="location">Training Location:</label>
                <input type="text" class="form-control custom-input" id="location" name="location" value="{{ $training->location }}">
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
            <input type="submit" value="Update">
            </div>
    </form>
</div>
@stop
