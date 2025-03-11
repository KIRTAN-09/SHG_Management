@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">


<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-3">
        <h1 class="text-2xl font-bold">Users</h1>
        <button id="toggleView" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Toggle View</button>
    </div>

    <div id="tableView" class="hidden">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td>
                        <button data-user-id="{{ $user->id }}" class="view-button btn btn-info">View</button>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        <button data-user-id="{{ $user->id }}" class="delete-button btn btn-danger">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="cardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach($users as $user)
        <div class="bg-blue-100 p-4 rounded-lg border border-gray-800 shadow-md hover:bg-gradient-to-b from-blue-100 to-teal-500 transform hover:scale-105 transition duration-150">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text"><strong>Role:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
                    <br>
                    <button data-user-id="{{ $user->id }}" class="view-button bg-blue-500 text-white py-2 px-2 rounded hover:bg-blue-700">View</button>
                    <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 text-white py-2 px-2 rounded hover:bg-yellow-700">Edit</a>
                    <button data-user-id="{{ $user->id }}" class="delete-button bg-red-500 text-white py-2 px-2 rounded hover:bg-red-700">Delete</button>
                </div>
        </div>
        @endforeach
    </div>
</div>

<!-- User Details Modal -->
<div id="userModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-blue-100 p-6 rounded-lg shadow-lg w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">User Details</h2>
            </div>
            <div id="modalContent" class="space-y-4">
                <!-- User details will be loaded here -->
            </div>
            <div class="flex justify-end mt-4">
                <button onclick="closeModal()" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
            <p>Are you sure you want to delete this user?</p>
            <div class="flex justify-end mt-4">
                <button onclick="closeDeleteModal()" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700 mr-2">Cancel</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-700">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.view-button').forEach(button => {
            button.addEventListener('click', function () {
                showUserDetails(this.dataset.userId);
            });
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                confirmDelete(this.dataset.userId);
            });
        });

        var toggleViewButton = document.getElementById('toggleView');
        var cardView = document.getElementById('cardView');
        var tableView = document.getElementById('tableView');

        toggleViewButton.addEventListener('click', function () {
            cardView.classList.toggle('hidden');
            tableView.classList.toggle('hidden');
        });
    });

    function showUserDetails(userId) {
        fetch(`/users/${userId}/json`)
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
                                <th>Email:</th>
                                <td>${data.email}</td>
                            </tr>
                            <tr>
                                <th>Roles:</th>
                                <td>
                                    ${data.roles.map(role => `<span class="inline-block bg-green-200 text-green-800 text-xs px-2 py-1 rounded">${role.name}</span>`).join('')}
                                </td>
                        </tbody>
                    </table>
                `;
                document.getElementById('modalContent').innerHTML = modalContent;
                document.getElementById('userModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
    }

    function confirmDelete(userId) {
        document.getElementById('deleteForm').action = `/users/${userId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
