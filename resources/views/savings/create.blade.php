@extends('layouts.app')

@section('content')
<div class="container">
    <link rel="stylesheet" href="{{ asset('css/Create.css') }}">
   
    <form action="{{ route('savings.store') }}" method="POST">
        @csrf
        <div class="form-group">
        <h1>Create Savings</h1>
            <label for="group_id">Group Name:</label>
            <div class="dropdown">
                <input type="text" id="group-search" class="form-control" placeholder="Search Group Name" oninput="filterGroupDropdown()" onfocus="toggleGroupDropdown(true)" onblur="setTimeout(() => toggleGroupDropdown(false), 200)">
                <div id="group-dropdown" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 5px;">
                    @foreach($groups as $group)
                        <div class="dropdown-item" data-name="{{ strtolower($group->name) }}" onclick="selectGroup('{{ $group->id }}', '{{ $group->name }}')">
                            {{ $group->name }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="group-id" name="group_id" required>
            </div>
        </div>
        <div class="form-group">
            <label for="member_id">Member Name:</label>
            <div class="dropdown">
                <input type="text" id="member-search" class="form-control" placeholder="Search Member Name" oninput="filterMemberDropdown()" onfocus="toggleMemberDropdown(true)" onblur="setTimeout(() => toggleMemberDropdown(false), 200)">
                <div id="member-dropdown" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 5px;">
                    <!-- Member options will be dynamically populated -->
                </div>
                <input type="hidden" id="member-id" name="member_id" required>
            </div>
        </div>
        <div class="form-group">
            <label for="date_of_deposit">Date of Deposit:</label>
            <input type="date" id="date-of-deposit" name="date_of_deposit" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    function toggleGroupDropdown(show) {
        const dropdown = document.getElementById('group-dropdown');
        dropdown.style.display = show ? 'block' : 'none';
    }

    function selectGroup(id, name) {
        document.getElementById('group-id').value = id;
        document.getElementById('group-search').value = name;
        toggleGroupDropdown(false);
        loadMembers(id); // Load members when a group is selected
    }

    function filterGroupDropdown() {
        const searchValue = document.getElementById('group-search').value.toLowerCase();
        const items = document.querySelectorAll('#group-dropdown .dropdown-item');
        items.forEach(item => {
            const groupName = item.getAttribute('data-name');
            item.style.display = groupName.includes(searchValue) ? 'block' : 'none';
        });
    }

    function toggleMemberDropdown(show) {
        const dropdown = document.getElementById('member-dropdown');
        dropdown.style.display = show ? 'block' : 'none';
    }

    function selectMember(id, name) {
        document.getElementById('member-id').value = id;
        document.getElementById('member-search').value = name;
        toggleMemberDropdown(false);
    }

    function filterMemberDropdown() {
        const searchValue = document.getElementById('member-search').value.toLowerCase();
        const items = document.querySelectorAll('#member-dropdown .dropdown-item');
        items.forEach(item => {
            const memberName = item.getAttribute('data-name');
            item.style.display = memberName.includes(searchValue) ? 'block' : 'none';
        });
    }

    function loadMembers(groupId) {
        const memberDropdown = document.getElementById('member-dropdown');
        memberDropdown.innerHTML = ''; // Clear existing members

        if (groupId) {
            fetch(`/api/groups/${groupId}/members`)
                .then(response => {
                    if (!response.ok) {
                        console.error('Error response:', response);
                        throw new Error('Failed to fetch members');
                    }
                    return response.json();
                })
                .then(data => {
                    data.forEach(member => {
                        const item = document.createElement('div');
                        item.className = 'dropdown-item';
                        item.setAttribute('data-name', member.name.toLowerCase());
                        item.onclick = () => selectMember(member.id, member.name);
                        item.textContent = member.name;
                        memberDropdown.appendChild(item);
                    });
                })
                .catch(error => {
                    console.error('Error fetching members:', error);
                    alert('Failed to load members. Please try again.');
                });
        }
    }
</script>
@endsection
