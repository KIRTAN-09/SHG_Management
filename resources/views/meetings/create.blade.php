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
                <label for="group">Group:</label>
                <select id="group" name="group" required>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
                <div id="members_list">
                    <!-- Members will be populated here based on the selected group -->
                </div>
            </div>
            <br><br>

            <label for="discussion">Discussion Points:</label>
            <textarea id="discussion" name="discussion" placeholder="Discussion Topic" required style="height: 100%; width: 100%;"></textarea><br>

            <label for="photo">Group Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

            <input type="submit" value="Schedule Meeting">
            <div class="pull-right">
            <a class="btn btn-primary btn-sm mb-2 create-back-button" href="{{ route('meetings.index') }}">Back</a>
        </div>
        </form>
    </div>
    <script>
        document.getElementById('group').addEventListener('change', function() {
            var groupId = this.value;
            fetch(`/groups/${groupId}/members`)
                .then(response => response.json())
                .then(data => {
                    var membersList = document.getElementById('members_list');
                    membersList.innerHTML = '';
                    data.members.forEach(member => {
                        var checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.name = 'attendance[]';
                        checkbox.value = member.id;
                        checkbox.id = 'member_' + member.id;

                        var label = document.createElement('label');
                        label.htmlFor = 'member_' + member.id;
                        label.appendChild(document.createTextNode(member.name));

                        membersList.appendChild(checkbox);
                        membersList.appendChild(label);
                        membersList.appendChild(document.createElement('br'));
                    });
                });
        });
    </script>
</body>
</html>