@extends('layouts.app')

@section('content')
<!-- Add Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
body, html {
    height: 100%;
    margin: 0;
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
    border: 1px solidrgb(38, 42, 174);
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

.radio-group {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}

input[type="text"],
input[type="date"],
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
input[type="date"]:focus,
input[type="number"]:focus {
    border-color: #007bff;
    outline: none;
}

input[type="date"] {
    width: calc(100% - 16px);
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
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

.error-message {
    font-size: 12px;
}
</style>
<div class="container">
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <h1><b>Create New Role</b></h1>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label for="name"><strong>Role Name:</strong></label>
            <input type="text" name="name" placeholder="Add role name" class="form-control">
        </div>
        <div class="form-group">
            <label for="permission"><strong>Permission:</strong></label>
            <br/>
            @foreach($permission as $value)
                <label><input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name">
                {{ $value->name }}</label>
            <br/>
            @endforeach
            <label><input type="checkbox" name="permission[]" value="role-list"> role-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="role-create"> role-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="role-edit"> role-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="role-delete"> role-delete</label><br/>
            <label><input type="checkbox" name="permission[]" value="Member-list"> Member-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="Member-create"> Member-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="Member-edit"> Member-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="Member-delete"> Member-delete</label><br/>
            <label><input type="checkbox" name="permission[]" value="Group-list"> Group-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="Group-create"> Group-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="Group-edit"> Group-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="Group-delete"> Group-delete</label><br/>
            <label><input type="checkbox" name="permission[]" value="Savings-list"> Savings-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="Savings-create"> Savings-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="Savings-edit"> Savings-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="Savings-delete"> Savings-delete</label><br/>
            <label><input type="checkbox" name="permission[]" value="User-list"> User-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="User-create"> User-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="User-edit"> User-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="User-delete"> User-delete</label><br/>
            <label><input type="checkbox" name="permission[]" value="Iga-list"> Iga-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="Iga-create"> Iga-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="Iga-edit"> Iga-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="Iga-delete"> Iga-delete</label><br/>
            <label><input type="checkbox" name="permission[]" value="Training-list"> Training-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="Training-create"> Training-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="Training-edit"> Training-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="Training-delete"> Training-delete</label><br/>
            <label><input type="checkbox" name="permission[]" value="Meetings-list"> Meetings-list</label><br/>
            <label><input type="checkbox" name="permission[]" value="Meetings-create"> Meetings-create</label><br/>
            <label><input type="checkbox" name="permission[]" value="Meetings-edit"> Meetings-edit</label><br/>
            <label><input type="checkbox" name="permission[]" value="Meetings-delete"> Meetings-delete</label><br/>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>
@endsection