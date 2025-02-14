@extends('adminlte::page')

@section('title', 'Add Training')

@section('content_header')
    <h1>Add Training</h1>
@stop

@section('content')
<!-- Add Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <form action="{{ route('training.store') }}" method="POST">
        @csrf
        <h1 class="text-center mb-4"><b>Add Training</b></h1>
        <!-- Add your form fields here -->
        <div class="container">
            <h2 class="mb-4">IGA Training Form</h2>
            <form>
                <div class="form-group">
                    <label for="training_date">Training Date:</label>
                    <input type="date" class="form-control" id="training_date" name="training_date" required>
                </div>

                <div class="form-group">
                    <label for="training_topic">Training Topic:</label>
                    <input type="text" class="form-control" id="training_topic" name="training_topic" placeholder="Enter training topic" required>
                </div>

                <div class="form-group">
                    <label for="trainer">Trainer Name:</label>
                    <input type="text" class="form-control" id="trainer" name="trainer" placeholder="Enter trainer's name" required>
                </div>

                <div class="form-group">
                    <label for="location">Training Location:</label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required>
                </div>

                <div class="form-group">
                    <label for="participants">Number of Participants:</label>
                    <input type="number" class="form-control" id="participants" name="participants" placeholder="Enter number of participants" required>
                </div>

                <div class="form-group">
                    <label for="category">Training Category:</label>
                    <select class="form-control" id="category" name="category">
                        <option value="Farming">Farming</option>
                        <option value="Business Management">Business Management</option>
                        <option value="Handicrafts">Handicrafts</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter any remarks"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Group</button>
                </form>
        </div>
    </form>
</div>
@stop
