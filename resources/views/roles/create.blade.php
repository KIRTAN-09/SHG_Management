@extends('layouts.app')
@section('content')
<!-- Add Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
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
            <label for="permission"><strong>Select the permissions for this role:</strong></label>
            
            <div class="row">
                @foreach($permission as $value)
                    <div class="col-md-3 mb-3">
                        <label><input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name">
                        {{ $value->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>
@endsection