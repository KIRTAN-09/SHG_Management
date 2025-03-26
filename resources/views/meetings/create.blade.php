@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Create.css') }}">

<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('meetings.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="container">
        <form action="{{ route('meetings.store') }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <h1>Meeting Form</h1>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br><br>

            <label for="group_uid">Group:</label>
            <select id="group_uid" name="group_uid" required>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
            <br><br>
            <label for="attendance_list">Attendance List:</label>
            <div id="attendance_list">
                <div id="members_list">
                     Members will be populated here based on the selected group 
                </div>
            </div>

            <label for="discussion">Discussion Points:</label>
            <textarea id="discussion" name="discussion" placeholder="Discussion Topic" required style="height: 100%; width: 100%;"></textarea><br>

            <label for="photo">Group Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

            <input type="submit" value="Schedule Meeting">
            
        </form>
    </div>
@endsection