@extends('adminlte::page')

@section('title', 'Member List')

@section('content_header')
    <h1>Member List</h1>
    <div class="flex justify-between items-center mb-4">
        <!-- <label for="rowsPerPage" class="mr-2">Rows per page:</label> -->
        <select id="rowsPerPage" class="py-2 px-4 rounded-lg border border-gray-300">
            <option value="10" {{ request('rows') == 10 ? 'selected' : '' }}>10</option>
            <option value="20" {{ request('rows') == 20 ? 'selected' : '' }}>20</option>
            <option value="50" {{ request('rows') == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ request('rows') == 100 ? 'selected' : '' }}>100</option>

        </select>
        <input type="text" id="liveSearch" placeholder="Search members..." class="py-2 px-4 rounded-lg border border-gray-300 ml-4">
    </div>
@stop

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<style>
    
    
</style>
<div class="container mx-auto p-4">
    <div class="flex justify-start items-center mb-4">
        <div class="pull-right">
        <!-- @can('User-create')
            <a href="{{ route('members.create') }}" class="bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-700"><i class="fa fa-plus"></i> Add Member</a>
        @endcan -->
            <button id="toggleView" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Toggle View</button>
            </div>
        
        <form action="{{ route('members.index') }}" method="GET" class="ml-4">
            <label for="sort" class="mr-2">Sort by Status:</label>
            <select name="sort" onchange="this.form.submit()" class="py-2 px-4 rounded-lg border border-gray-300">
                <option value="">All</option>
                <option value="active" {{ request('sort') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('sort') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </form>
       
    </div>
    <div id="tableView" class="hidden">
        <link href="css/table.css"   rel="stylesheet">   
        <table class="table">
            <thead> 
                <tr>
                    <th class="py-2">Photo</th>
                    <th class="py-2">Name</th>
                    <th class="py-2">Member UID</th>
                    <th class="py-2">Number</th>
                    <th class="py-2">Village</th>
                    <th class="py-2">Group</th>
                    <th class="py-2">Caste</th>
                    <th class="py-2">Share Price</th>
                    <th class="py-2">Member Type</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="memberTableBody">
                @foreach ($members as $member)
                    <tr class="bg-gray-100 border-b">
                        <td class="py-2"><img src="{{ asset('storage/' . $member->photo) }}" class="w-20 h-20 object-cover rounded-full mx-auto"></td>
                        <td class="py-2">{{ $member->name}}</td>
                        <td class="py-2">{{ $member->member_id}}</td>
                        <td class="py-2">{{ $member->number}}</td>
                        <td class="py-2">{{ $member->village}}</td>
                        <td class="py-2">{{ $member->group_name }}</td>
                        <td class="py-2">{{ $member->caste}}</td>
                        <td class="py-2">{{ $member->share_price}}</td>
                        <td class="py-2">{{ $member->member_type}}</td>
                        <td class="py-2">{{ $member->status}}</td>
                        <td class="py-2">
                            <div class="flex justify-center space-x-2">
                                <button onclick="showMemberDetails({{ $member->id }})" class="btn btn-info">View</button>
                                @can('member-edit')
                                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning">Edit</a>
                                @endcan
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="cardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
         @foreach ($members as $member)
            <div class="bg-blue-100 p-4 rounded-lg border border-gray-800 shadow-md hover:bg-gradient-to-b from-blue-100 to-teal-500 transform hover:scale-105 transition duration-150 member-card">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-20 h-20 object-cover rounded-full mx-auto mb-4">
                    <h3 class="text-l font-bold mb-2">{{ $member->name }}</h3>
                    <p class="text-gray-600 mb-2"><strong>Member UID:</strong> {{ $member->member_id }}</p>
                    <p class="text-gray-600 mb-2"><strong>Status:</strong> {{ $member->status }}</p>
                    <div class="flex justify-center space-x-2 mt-4">
                        <button onclick="showMemberDetails({{ $member->id }})" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-700">View</button>
                        <a href="{{ route('members.edit', $member->id) }}" class="bg-blue-600 text-white py-1 px-2 rounded hover:bg-blue-800">Edit</a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline" onsubmit="return confirmDelete(event, this)">
                             @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-700">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="ml-auto">
        {{ $members->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal -->
<link href={{ asset('css/modal.css') }}   rel="stylesheet">
<div id="memberModal" class="bg-sky-200 fixed inset-1 flex items-center justify-center bg-black bg-opacity-80 hidden">
    <div class="container3">
        <div class="flex justify-between items-center mb-4">
            <h1 class="font-serif text-3xl"  style="color: cornflowerblue;">Member Details</h1>
        </div>
        <div id="modalContent" class="space-y-4">
            <!-- Member details will be loaded here -->
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeModal()" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Close</button>
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
                <p class="mb-4">Are you sure you want to delete this member?</p>
                <div class="flex justify-end space-x-4">
                    <button onclick="closeConfirmationBox()" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700">No</button>
                    <button onclick="submitDeleteForm()" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-700">Yes</button>
                </div>
            </div>
        `;
        confirmationBox.id = 'confirmationBox';
        document.body.appendChild(confirmationBox);
    }

    function closeConfirmationBox() {
        const confirmationBox = document.getElementById('confirmationBox');
        if (confirmationBox) {
            confirmationBox.remove();
        }
    }

    function submitDeleteForm() {
        closeConfirmationBox();
        formToSubmit.submit();
    }

    function showMemberDetails(memberId) {
        fetch(`/members/${memberId}`)
            .then(response => response.json())
            .then(data => {
                const modalContent = `
                    <div class="text-center">
                        <img src="${data.photo ? '{{ asset('storage/') }}' + '/' + data.photo : ''}" class="w-40 h-40 object-cover rounded-full mx-auto mb-4">
                    </div>
                    <table class="modal-table mx-auto">
                    <tbody>
                        <tr>
                            <th>Name:</th>
                            <td>${data.name}</td>
                        </tr>
                        <tr>
                            <th>ID:</th>
                            <td>${data.member_id}</td>
                        </tr>
                        <tr>
                            <th>Number:</th>
                            <td>${data.number}</td>
                        </tr>
                        <tr>
                            <th>Village:</th>
                            <td>${data.village}</td>
                        </tr>
                        <tr>
                            <th>Group:</th>
                            <td>${data.group_name}</td>
                        </tr>
                        <tr>
                            <th>Caste:</th>
                            <td>${data.caste}</td>
                        </tr>
                        <tr>
                            <th>Share Price:</th>
                            <td>${data.share_price}</td>
                        </tr>
                        <tr>
                            <th>Member Type:</th>
                            <td>${data.member_type}</td>
                        </tr> 
                        <tr>
                            <th>Status:</th>
                            <td>${data.status}</td>
                        </tr>  
                    </tbody>
                </table>
            `;
            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('memberModal').classList.remove('hidden');
        });
    }

    function closeModal() {
        document.getElementById('memberModal').classList.add('hidden');
    }

    var toggleViewButton = document.getElementById('toggleView');
    var cardView = document.getElementById('cardView');
    var tableView = document.getElementById('tableView');

    toggleViewButton.addEventListener('click', function () {
        cardView.classList.toggle('hidden');
        tableView.classList.toggle('hidden');
    });

    document.getElementById('liveSearch').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const members = document.querySelectorAll('#cardView > div, #tableView tbody > tr');
        members.forEach(function(member) {
            const name = member.querySelector('td:nth-child(2), h3').textContent.toLowerCase();
            if (name.includes(searchValue)) {
                member.style.display = '';
            } else {
                member.style.display = 'none';
            }
        });
    });

    document.getElementById('rowsPerPage').addEventListener('change', function() {
        const rowsPerPage = this.value;
        const url = new URL(window.location.href);
        url.searchParams.set('rows', rowsPerPage);
        window.location.href = url.toString();
    });
</script>
@stop