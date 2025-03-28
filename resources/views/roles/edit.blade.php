@extends('layouts.app')

@section('content')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">

<div class="container">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

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
<div class="container">
<form method="POST" action="{{ route('roles.update', $role->id) }}">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permission:</strong>
                <br/>
                <div class="row">
                    <!-- First Column -->
                    <div class="col-md-4">
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="rolePermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Role Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="rolePermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['role-list', 'role-create', 'role-edit', 'role-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="savingsPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Savings Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="savingsPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['Savings-list', 'Savings-create', 'Savings-edit', 'Savings-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="trainingPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Training Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="trainingPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['Training-list', 'Training-create', 'Training-edit', 'Training-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Second Column -->
                    <div class="col-md-4">
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="memberPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Member Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="memberPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['Member-list', 'Member-create', 'Member-edit', 'Member-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="userPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                User Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="userPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['User-list', 'User-create', 'User-edit', 'User-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="meetingsPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Meetings Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="meetingsPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['Meetings-list', 'Meetings-create', 'Meetings-edit', 'Meetings-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Third Column -->
                    <div class="col-md-4">
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="groupPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Group Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="groupPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['Group-list', 'Group-create', 'Group-edit', 'Group-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="igaPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                IGA Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="igaPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['Iga-list', 'Iga-create', 'Iga-edit', 'Iga-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="dropdown mb-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="reportPermissionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Report Permissions
                            </button>
                            <div class="dropdown-menu" aria-labelledby="reportPermissionsDropdown">
                                @foreach($permission as $value)
                                    @if (in_array($value->name, ['report-list', 'report-create', 'report-edit', 'report-delete']))
                                        <label class="dropdown-item">
                                            <input type="checkbox" name="permission[{{$value->id}}]" value="{{$value->id}}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                            {{ $value->name }}
                                        </label>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <input type="submit" value="Submit" class="btn btn-primary">
        </div>
    </div>
</form>
</div>
<p class="text-center text-primary"><small> </small></p>
@endsection