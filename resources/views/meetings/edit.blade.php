@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meeting</title>
    <link rel="stylesheet" href="{{ asset('css/Create.css') }}">
    <script src="{{ asset('js/Meeting.js') }}" defer></script>
</head>
<body>
<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('meetings.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
    <div class="container">
        <form action="{{ route('meetings.update', $meeting->id) }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            @method('PUT')

            <h1>Edit Meeting</h1>

            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="{{ old('date', $meeting->date) }}" required><br><br>

            <label for="group_name">Group Name:</label>
            <input type="text" id="group_name" name="group_name" value="{{ old('group_name', $meeting->group_name) }}" required>
            <span class="error-message-group-name" style="display: none; color: red;">Group Name should only contain letters.</span><br><br>

            <label for="group_id">Group ID:</label>
            <input type="text" id="group_id" name="group_id" value="{{ old('group_id', $meeting->group_id) }}">
            <span class="error-message-group-id" style="display: none; color: red;">Group ID should only contain numbers.</span><br><br>

            <label for="attendance_list">Attendance List:</label>
            <div id="attendance_list">
                <!-- Fetched members will be displayed here -->
            </div>

            <label for="discussion">Discussion Points:</label>
            <textarea id="discussion" name="discussion" required style="height: 100%; width: 100%;">{{ old('discussion', $meeting->discussion) }}</textarea><br>

            <label for="photo">Group Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*"><br><br>

            <!-- Display existing photo -->
            @if($meeting->photo)
                <img src="{{ asset('storage/' . $meeting->photo) }}" alt="Group Photo" style="max-width: 150px; height: auto;">
            @endif
            <br>

            <input type="submit" value="Update Meeting">
            
        </form>
    </div>
</body>
@endsection
