@extends('layouts.app')

@section('title', 'Users Management')

@section('content_header')
    <h1>Users Management</h1>
@stop

@section('content')



<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <div class="pull-right">
        @can('User-create')
            <a href="{{ route('users.create') }}" class="bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-700"><i class="fa fa-plus"></i> Create New Role</a>
        @endcan
            <button id="toggleView" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Toggle View</button>
        </div>
    </div>

@session('success')
    <div class="alert alert-success" role="alert"> 
        {{ $value }}
    </div>
@endsession

<div id="cardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
   @foreach ($data as $key => $user)
    <div class="bg-blue-100 shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-2">{{ $user->name }}</h3>
        <div class="mb-4">
          @if(!empty($user->getRoleNames()))
            @foreach($user->getRoleNames() as $v)
               <span class="inline-block bg-green-200 text-green-800 text-xs px-2 py-1 rounded">{{ $v }}</span>
            @endforeach
          @endif
        </div>
        <div class="flex space-x-2">
            <button onclick="showUserDetails({{ $user->id }})" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-700">View</button>
            <a class="bg-blue-600 text-white py-1 px-2 rounded hover:bg-blue-800" href="{{ route('users.edit',$user->id) }}"> Edit</a>
            <button type="button" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-700" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userid="{{ $user->id }}"> Delete</button>
        </div>
    </div>
 @endforeach
</div>

<div id="tableView" class="hidden">
    <link href="css/table.css"   rel="stylesheet">   
    <table class="table">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Roles</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <span class="inline-block bg-green-200 text-green-800 text-xs px-2 py-1 rounded">{{ $v }}</span>
                        @endforeach
                    @endif
                </td>
                <td class="border px-4 py-2">
                    <button onclick="showUserDetails({{ $user->id }})" class="btn btn-info">View</button>
                    <a class="btn btn-warning btn-sm" href="{{ route('users.edit',$user->id) }}"> Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userid="{{ $user->id }}"> Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
        {{ $data->links('pagination::bootstrap-4') }}
    </div></div>

<!-- Show User Details Modal -->
<div id="userModal" class="fixed inset-1 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-blue-100 p-6 rounded-lg shadow-lg w-1/3 max-w-2xl relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-black">User Details</h2>
        </div>
        <div id="modalContent" class="space-y-4">
            <!-- User details will be loaded here -->
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeModal()" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Close</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-userid');
        var form = document.getElementById('deleteForm');
        form.action = '/users/' + userId;
    });

    var toggleViewButton = document.getElementById('toggleView');
    var cardView = document.getElementById('cardView');
    var tableView = document.getElementById('tableView');

    toggleViewButton.addEventListener('click', function () {
        cardView.classList.toggle('hidden');
        tableView.classList.toggle('hidden');
    });

    function showUserDetails(userId) {
        fetch(`/users/${userId}`)
            .then(response => response.json())
            .then(data => {
                const modalContent = `
                    <div class="text-center">
                        <img src="${data.photo ? '{{ asset('storage/') }}' + '/' + data.photo : ''}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                    </div>
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
                            <td>${data.roles}</td>
                        </tr>
                    </tbody>
                </table>
            `;
            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('userModal').classList.add('flex'); // Add this line to make the modal visible
        });
    }

    function closeModal() {
        document.getElementById('userModal').classList.add('hidden');
        document.getElementById('userModal').classList.remove('flex'); // Add this line to hide the modal
    }
</script>
@endsection