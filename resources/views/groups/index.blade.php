@extends('adminlte::page')

@section('title', 'Group List')

@section('content_header')
    <h1>Group List</h1>
    <div class="flex justify-end">
        <input type="text" id="liveSearch" placeholder="Search groups..." class="py-2 px-4 rounded-lg border border-gray-300">
    </div>
@stop

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="{{ asset('css/table.css') }}" rel="stylesheet">
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <div class="pull-right">
        <!-- @can('role-create')
            <a href="{{ route('groups.create') }}" class="bg-green-500 text-white py-2.5 px-3 rounded-lg hover:bg-green-700"><i class="fa fa-plus"></i> Create New Group</a>
        @endcan -->
        <button id="toggleView" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Toggle View</button>
        </div>
    </div>     
   
    <div id="tableView" class="hidden">
    <link href="css/table.css"   rel="stylesheet">   
        <table class="table">
            <thead>
                <tr>
                    <th class="py-2">Name</th>
                    <th class="py-2">Group ID</th>
                    <th class="py-2">Village</th>
                    <th class="py-2">President</th>
                    <th class="py-2">Secretary</th>
                    <th class="py-2">No. of Members</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groups as $group)
                    <tr class="bg-gray-100 border-b">
                        <td class="py-2">{{ $group->name }}</td>
                        <td class="py-2">{{ $group->group_id }}</td>
                        <td class="py-2">{{ $group->village_name }}</td>
                        <td class="py-2">{{ $group->members->where('member_type', 'President')->first()->name ?? 'N/A' }}</td>
                        <td class="py-2">{{ $group->members->where('member_type', 'Secretary')->first()->name ?? 'N/A' }}</td>
                        <td class="py-2">{{ $group->members->count() }}</td>
                        <td class="py-2">
                            <button onclick="showGroupDetails({{ $group->id }})" class="btn btn-info">View</button>
                            <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event, this)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div id="cardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
        @foreach ($groups as $group)
            <div class="bg-blue-100 p-4 rounded-lg border border-gray-800 shadow-md hover:bg-gradient-to-b from-blue-100 to-teal-500 transform hover:scale-105 transition duration-150">
                <div class="text-center">
                    <h3 class="text-l font-bold mb-2">{{ $group->name }}</h3>
                    <p class="text-gray-600 mb-2"><strong>Group ID:</strong> {{ $group->group_id }}</p> 
                    <div class="flex justify-center space-x-2 mt-4">
                    <button onclick="showGroupDetails({{ $group->id }})" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-700">View</button>
                    <a href="{{ route('groups.edit', $group->id) }}" class="bg-blue-600 text-white py-1 px-2 rounded hover:bg-blue-800">Edit</a>
                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event, this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4">
        {{ $groups->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal -->
<div id="groupModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="container3">
        <div class="flex justify-between items-center mb-4">
        <h1 class="font-serif text-3xl" style="color: cornflowerblue;">Group Details</h1>
        </div>
        <div id="modalContent" class="space-y-4">
            <!-- Group details will be loaded here -->
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeModal()" class="bg-gray-800 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Close</button>
        </div>
    </div>
</div>

<script>
    let formToSubmit;

    function confirmDelete(event, form) {
        event.preventDefault();
        formToSubmit = form;
        const confirmationBox = document.createElement('div');
        confirmationBox.classList.add('fixed', 'inset-0', 'flex', 'items-center', 'justify-center', 'bg-black', 'bg-opacity-50');
        confirmationBox.innerHTML = `
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
                <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
                <p class="mb-4">Are you sure you want to delete this group?</p>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeConfirmationBox()" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700">No</button>
                    <button onclick="submitDeleteForm()" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-700">Yes</button>
                </div>
            </div>
        `;
        document.body.appendChild(confirmationBox);
    }

    function closeConfirmationBox() {
        document.querySelector('.fixed.inset-0').remove();
    }

    function submitDeleteForm() {
        formToSubmit.submit();
    }

    function showGroupDetails(groupId) {
        fetch(`/groups/${groupId}`)
            .then(response => response.json())
            .then(data => {
                const modalContent = `
                    <table class="modal-table mx-auto">
                        <tbody>
                            <tr>
                                <th>Name:</th>
                                <td>${data.name}</td>
                            </tr>
                            <tr>
                                <th>ID:</th>
                                <td>${data.group_id}</td>
                            </tr>
                            <tr>
                                <th>Village:</th>
                                <td>${data.village_name}</td>
                            </tr>
                            <tr>
                                <th>President:</th>
                                <td>${data.president_name}</td>
                            </tr>
                            <tr>
                                <th>Secretary:</th>
                                <td>${data.secretary_name}</td>
                            </tr>
                            <tr>
                                <th>No. of members:</th>
                                <td>${data.members.length}</td>
                            </tr>
                        </tbody>
                    </table>
                `;
                document.getElementById('modalContent').innerHTML = modalContent;
                document.getElementById('groupModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('groupModal').classList.add('hidden');
    }

    var toggleViewButton = document.getElementById('toggleView');
    var cardView = document.getElementById('cardView');
    var tableView = document.getElementById('tableView');

    document.getElementById('liveSearch').addEventListener('input', function () {
        const searchValue = this.value.toLowerCase();
        const groups = document.querySelectorAll('#cardView > div, #tableView tbody > tr');
        
        groups.forEach(group => {
            const groupName = group.querySelector('h3, td:first-child').textContent.toLowerCase();
            if (groupName.includes(searchValue)) {
                group.style.display = '';
            } else {
                group.style.display = 'none';
            }
        });
    });

    toggleViewButton.addEventListener('click', function () {
        cardView.classList.toggle('hidden');
        tableView.classList.toggle('hidden');
        document.getElementById('viewMode').value = cardView.classList.contains('hidden') ? 'table' : 'card';
    });
</script>
@stop
