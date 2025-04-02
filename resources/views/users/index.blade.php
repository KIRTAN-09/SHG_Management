@extends('layouts.app')

@section('title', 'Users')

@section('content_header')
<h1>Users</h1>

@stop

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">


    <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <div class="pull-right">
        @can('role-create')
            <a href="{{ route('users.create') }}" class="bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-700"><i class="fa fa-plus"></i> Create New User</a>
        @endcan
        <button id="toggleView" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Toggle View</button>
        </div>
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
                <div
                    class="bg-blue-100 p-4 rounded-lg border border-gray-800 shadow-md hover:bg-gradient-to-b from-blue-100 to-teal-500 transform hover:scale-105 transition duration-150">
                    <div class="card-body">
                        <h5 class="card-title font-bold text-lg"><u>{{ $user->name }}</u></h5>
                        <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="card-text"><strong>Role:</strong> {{ $user->roles->pluck('name')->join(', ') }}</p>
                        <br>
                        <a href="{{ route('users.edit', $user->id) }}"
                            class="bg-blue-500 text-white  py-2.5 px-3 rounded hover:bg-blue-700">Edit</a>
                        <button data-user-id="{{ $user->id }}"
                            class="delete-button bg-red-500 text-white py-2 px-2 rounded hover:bg-red-700">Delete</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>



    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
                <p>Are you sure you want to delete this user?</p>
                <div class="flex justify-end mt-4">
                    <button onclick="closeDeleteModal()"
                        class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700 mr-2">Cancel</button>
                    <form id="deleteForm" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-700">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggleViewButton = document.getElementById('toggleView');
            var cardView = document.getElementById('cardView');
            var tableView = document.getElementById('tableView');

            toggleViewButton.addEventListener('click', function () {
                cardView.classList.toggle('hidden');
                tableView.classList.toggle('hidden');
            });

            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
                    confirmDelete(this.dataset.userId);
                });
            });
        });

        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                const deleteForm = document.createElement('form');
                deleteForm.method = 'POST';
                deleteForm.action = `/users/${userId}`;
                deleteForm.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(deleteForm);
                deleteForm.submit();
            }
        }

        function closeDeleteModal() {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.classList.add('hidden');
        }
    </script>
@endsection