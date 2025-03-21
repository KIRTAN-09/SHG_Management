@extends('layouts.app')

@section('content')
<div class="container">
    <link rel="stylesheet" href="{{ asset('css/Create.css') }}">
   
    <form action="{{ route('savings.store') }}" method="POST">
        @csrf
        <div class="form-group">
        <h1>Create Savings</h1>
            <label for="group_id">Group Name:</label>
            <select id="group-id" name="group_id" class="form-control">
                <option value="">Select Group</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="member_id">Member Name:</label>
            <select id="member-id" name="member_id" class="form-control">
                <option value="">Select Member</option>
            </select>
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
    document.getElementById('group-id').addEventListener('change', function () {
        const groupId = this.value;
        const memberSelect = document.getElementById('member-id');
        memberSelect.innerHTML = '<option value="">Select Member</option>'; // Reset members

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
                        const option = document.createElement('option');
                        option.value = member.id;
                        option.textContent = member.name;
                        memberSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching members:', error);
                    alert('Failed to load members. Please try again.');
                });
        }
    });
</script>
@endsection
