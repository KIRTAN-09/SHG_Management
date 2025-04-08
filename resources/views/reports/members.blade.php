@extends('layouts.app')

@section('content')
<div class="card">
    <link rel="stylesheet" href="{{ asset('css/MembeR.css') }}"><br>
    <div class="card-header">Members Report</div>
    <div class="card-body">
        <form>
            <div class="form-group">
                <label for="member">Select Member</label><br>
                <div class="dropdown" style="display: flex; align-items: center;">
                    <input type="text" id="member-search" class="form-control" placeholder="Search Member ID or Name" oninput="filterMembers()" style="margin-right: 10px;">
                    <select id="village-filter" class="form-control" style="width: 150px;" onchange="filterMembers()">
                        <option value="">All Villages</option>
                        @foreach($members->pluck('village')->unique()->sort() as $village)
                            <option value="{{ $village }}">{{ $village }}</option>
                        @endforeach
                    </select>
                </div>  
                <input type="hidden" id="member-id" name="member_uid" required>
            </div>
        </form>
    </div>
</div>
<script>
    const members = @json($members);

    function filterMembers() {
        const searchInput = document.getElementById('member-search').value.toLowerCase();
        const villageFilter = document.getElementById('village-filter').value.toLowerCase();
        const dropdown = document.getElementById('member-dropdown');

        dropdown.innerHTML = '';

        // Add default option
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = 'Select a member';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        dropdown.appendChild(defaultOption);

        members.forEach(member => {
            const matchesSearch = member.name.toLowerCase().includes(searchInput) || member.id.toString().includes(searchInput);
            const matchesVillage = !villageFilter || member.village.toLowerCase() === villageFilter;

            if (matchesSearch && matchesVillage) {
                const option = document.createElement('option');
                option.value = member.id;
                option.textContent = `${member.name} (${member.id})`;
                dropdown.appendChild(option);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dropdownContainer = document.createElement('select');
        dropdownContainer.id = 'member-dropdown';
        dropdownContainer.className = 'form-control';
        dropdownContainer.style.marginTop = '10px';
        dropdownContainer.onchange = function () {
            document.getElementById('member-id').value = this.value;
            displayMemberDetails(this.value);
        };

        // Append the dropdown to the form group
        const formGroup = document.querySelector('.form-group');
        formGroup.appendChild(dropdownContainer);
    });

    function displayMemberDetails(memberId) {
        const member = members.find(m => m.id == memberId);
        if (!member) return;

        const reportContainer = document.getElementById('member-report');
        reportContainer.innerHTML = `
            <h2>Member Information</h2>
            <p><strong>Member ID:</strong> ${member.id}</p>
            <p><strong>Photo:</strong> 📷</p>
            <p><strong>Name:</strong> ${member.name}</p>
            <p><strong>Number:</strong> ${member.number}</p>
            <p><strong>Village:</strong> ${member.village}</p>
            <p><strong>Group:</strong> ${member.group}</p>
            <p><strong>Caste:</strong> ${member.caste}</p>
            <p><strong>Share Price:</strong> Rs. ${member.share_price}</p>
            <p><strong>Member Type:</strong> ${member.type}</p>
            <p><strong>Status:</strong> ${member.status}</p>

            <h2>Member Savings</h2>
            <p><strong>Total Savings:</strong> Rs. ${member.total_savings}</p>
            <p><strong>Last Deposit Date:</strong> ${member.last_deposit_date}</p>
            <p><strong>Last Deposit Amount:</strong> Rs. ${member.last_deposit_amount}</p>

            <h2>Member's Join Meetings</h2>
            <p><strong>Meeting Date:</strong> ${member.meeting_date}</p>
            <p><strong>Meeting Topic:</strong> ${member.meeting_topic}</p>
            <p><strong>Attendance:</strong> ${member.attendance}</p>

            <h2>Member's Training History</h2>
            <p><strong>Training Date:</strong> ${member.training_date}</p>
            <p><strong>Training Name:</strong> ${member.training_name}</p>
            <p><strong>Trainer:</strong> ${member.trainer}</p>
            <p><strong>Status:</strong> ${member.training_status}</p>
        `;
    }
</script>

<div id="member-report">
    <h1>Members Details:</h1>
</div>
@endsection
