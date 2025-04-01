@extends('adminlte::page')

@section('title', 'Add Training')

@section('content_header')
@stop

@section('content')
<br>
<link rel="stylesheet" href="{{ asset('css/Training/create.css') }}">
<br>
    <div class="pull-right">
        <a class="btn btn-primary btn-sm mb-2" href="{{ route('training.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
<div class="container">
    <form action="{{ route('training.store') }}" method="POST" onsubmit="return handleFormSubmit(event)">
        @csrf
        <div class="container1">
        <h1 class="text-center mb-4"><b>Add Training</b></h1>
            <div class="form-group custom-form-group">
                <label for="training_date">Training Date:</label>
                <input type="date" class="form-control custom-input" id="training_date" name="training_date" required>
            </div>  
            
            <div class="form-group custom-form-group">
                <label for="member-id">Member ID/Name:</label>
                <div class="dropdown">
                    <input type="text" id="member-search" class="form-control custom-input" placeholder="Search Member ID or Name" onfocus="toggleDropdown(true)" onblur="setTimeout(() => toggleDropdown(false), 200)">
                    <div id="member-dropdown" class="dropdown-menu" style="display: none; max-height: 200px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 5px;">
                        @foreach($members as $member)
                            <div class="dropdown-item" onclick="selectMember('{{ $member->id }}', '{{ $member->member_uid }}-{{ $member->name }}')">
                                {{ $member->member_uid }}-{{ $member->name }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="member-id" name="member_id" required> <!-- Ensure this field is submitted -->
                </div>
            </div>

            <div class="form-group custom-form-group">
                <label for="trainer">Trainer Name:</label>
                <input type="text" class="form-control custom-input" id="trainer" name="trainer" placeholder="Enter trainer's name" required>
            </div>

            <div class="form-group custom-form-group">
                <label for="location">Training Location:</label>
                <input type="text" class="form-control custom-input" id="location" name="location" placeholder="Enter location" required>
            </div>

            <div class="form-group custom-form-group">
                <label for="category">Training Category:</label>
                <select class="form-control custom-select" id="category" name="category">
                    <option value="Farming">Farming</option>
                    <option value="Business Management">Business Management</option>
                    <option value="Handicrafts">Handicrafts</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <input type="submit" value="Add Training">
            </div>
    </form>
</div>

<script>
    function handleFormSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        }).then(response => {
            if (response.ok) {
                window.location.href = "{{ route('training.index') }}";
            } else {
                alert('Failed to add training. Please try again.');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Failed to add training. Please try again.');
        });

        return false;
    }

    function toggleDropdown(show) {
        const dropdown = document.getElementById('member-dropdown');
        dropdown.style.display = show ? 'block' : 'none';
    }

    function selectMember(id, text) {
        document.getElementById('member-id').value = id; // Sets the hidden input value
        document.getElementById('member-search').value = text;	
    }

    document.getElementById('member-search').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const items = document.querySelectorAll('#member-dropdown .dropdown-item');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchValue) ? 'block' : 'none';
        });
    });

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('member-dropdown');
        const searchInput = document.getElementById('member-search');
        if (!dropdown.contains(event.target) && event.target !== searchInput) {
            toggleDropdown(false);
        }
    });

    document.getElementById('member-dropdown').addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Ensure dropdown visibility is reset on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleDropdown(false);
    });
</script>
@stop
