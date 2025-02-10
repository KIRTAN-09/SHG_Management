@extends('layouts.app')

@section('content')
<style>
body, html {
    height: 100%;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
}

form {
    width: 100%;
    max-width: 600px;
    padding: 20px;
    border: 1px solid #343798;
    border-radius: 20px;
    box-shadow: 7px 7px 10px rgba(8, 8, 8, 0.478);
    background-color: #fff;
}

form:hover {
    box-shadow: 10px 10px 15px rgba(19, 19, 20, 0.6);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    font-weight: bold;
    color: #495057;
    font-size: 28px;
    font-style: bold;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #495057;
    font-size: 16px;
}

input[type="text"],
input[type="number"] {
    width: calc(100% - 16px);
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 14px;
    font-weight: normal; /* Ensure font is not bold */
    transition: border-color 0.3s ease-in-out;
}

input[type="text"]:focus,
input[type="number"]:focus {
    border-color: #007bff;
    outline: none;
}

input[type="submit"] {
    background-color: #092f57;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    display: block;
    margin: 0 auto;
    transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

input[type="submit"]:hover {
    background-color: #0056b3;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
<div class="container">
    
    <form action="{{ route('groups.store') }}" method="POST">
        @csrf
        <h1><b>Add Group</b></h1>
        <div class="form-group">
            <label for="name">Group Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="village_name">Village Name</label>
            <input type="text" name="village_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="president_name">Group President Name</label>
            <input type="text" name="president_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="secretary_name">Group Secretary Name</label>
            <input type="text" name="secretary_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="no_of_members">No. of Members</label>
            <input type="number" name="no_of_members" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Group</button>
    </form>
</div>
@endsection
