@extends('adminlte::page')

@section('title', 'Add Training')

@section('content_header')
@stop

@section('content')
<!-- Add Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <form action="{{ route('training.store') }}" method="POST" onsubmit="return handleFormSubmit(event)">
        @csrf
        <h1 class="text-center mb-4"><b>Add Training</b></h1>
        <!-- Add your form fields here -->
        <div class="container">
            <div class="form-group">
                <label for="training_date">Training Date:</label>
                <input type="date" class="form-control" id="training_date" name="training_date" required>
            </div>  

            <div class="form-group">
                <label for="trainer">Trainer Name:</label>
                <input type="text" class="form-control" id="trainer" name="trainer" placeholder="Enter trainer's name" required>
            </div>

            <div class="form-group">
                <label for="members_name">Member Name:</label>
                <input type="text" class="form-control" id="members_name" name="members_name" placeholder="Enter Member's name" required>
            </div>

            <div class="form-group">
                <label for="members_ID">Member ID:</label>
                <input type="text" class="form-control" id="members_ID" name="members_ID" placeholder="Enter Member's ID" required>
            </div> 
            
            <div class="form-group">
                <label for="location">Training Location:</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Enter location" required>
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

            <button type="submit" class="btn btn-primary">Add Training</button>
        </div>
    </form>
</div>

<script>
    function handleFormSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        }).then(response => {
            if (response.ok) {
                window.location.href = "{{ route('training.index') }}";
            } else {
                alert('Failed to add training. Please try again.');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Failed to add training. Please try again.');
        });

        return false;
    }
</script>
@stop
