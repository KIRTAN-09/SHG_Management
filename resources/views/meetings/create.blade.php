<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Form</title>
    <link rel="stylesheet" href="{{ asset('css/Meetings/Meeting.css') }}">
    <script src="{{ asset('js/Meeting.js') }}" defer></script>
</head>
<body>
    <div class="container">
        <form action="{{ route('meetings.store') }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            <h1>Meeting Form</h1>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br><br>

            <label for="group_name">Group Name:</label>
            <input type="text" id="group_name" name="group_name" placeholder="Group Name" required>
            <span class="error-message-group-name" style="display: none; color: red;">Group Name should only contain letters.</span><br><br>

            <label for="group_id">Group ID:</label>
            <input type="text" id="group_id" name="group_id" placeholder="Group ID">
            <span class="error-message-group-id" style="display: none; color: red;">Group ID should only contain numbers.</span><br><br>

            <label for="attendance_list">Attendance List:</label>
            <div id="attendance_list">
                <!-- Fetched members will be displayed here -->
            </div>
            <br><br>

            <label for="discussion">Discussion Points:</label>
            <textarea id="discussion" name="discussion" placeholder="Discussion Topic" required style="height: 100%; width: 100%;"></textarea><br>

            <label for="photo">Group Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

            <input type="submit" value="Schedule Meeting">
        </form>
    </div>
</body>
</html>