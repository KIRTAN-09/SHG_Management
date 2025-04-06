@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Create.css') }}">
<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('savings.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

<div class="container">
    <form action="{{ route('savings.update', $savings->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h1><b>Edit Savings</b></h1>

        <!-- Group Name -->
        <div class="form-group">
            <label for="group_uid">Group Name:</label>
            <div class="dropdown">
                <input type="text" id="group-search" class="form-control" placeholder="Search Group Name" oninput="filterGroupDropdown()" onfocus="toggleGroupDropdown(true)" onblur="setTimeout(() => toggleGroupDropdown(false), 200)">
                <div id="group-dropdown" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 5px;">
                    @foreach($groups as $group)
                        <div class="dropdown-item" data-name="{{ strtolower($group->name) }}" onclick="selectGroup('{{ $group->id }}', '{{ $group->name }}')">
                            {{ $group->name }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="group-id" name="group_uid" value="{{ $savings->group_uid }}" required>
            </div>
        </div>

        <!-- Member Name -->
        <div class="form-group">
            <label for="member_uid">Member Name:</label>
            <div class="dropdown">
                <input type="text" id="member-search" class="form-control" placeholder="Search Member Name" oninput="filterMemberDropdown()" onfocus="toggleMemberDropdown(true)" onblur="setTimeout(() => toggleMemberDropdown(false), 200)">
                <div id="member-dropdown" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 5px;">
                    @foreach($members as $member)
                        <div class="dropdown-item" data-name="{{ strtolower($member->name) }}" onclick="selectMember('{{ $member->id }}', '{{ $member->name }}')">
                            {{ $member->name }}
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="member-id" name="member_uid" value="{{ $savings->member_uid }}" required>
            </div>
        </div>

        <!-- Date of deposit -->
        <label for="date-of-deposit">Date of Deposit:</label>
        <input type="date" id="date-of-deposit" name="date_of_deposit" value="{{ $savings->date_of_deposit }}" required><br><br>

        <!-- Amount -->
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" value="{{ $savings->amount }}" required><br><br>

        <input type="submit" value="Update">    
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
