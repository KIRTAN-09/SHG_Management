@extends('adminlte::page')

@section('title', 'Role Management')


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-2xl font-bold mb-4">Role Management</h2>
        </div>
        <br>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        @can('role-create')
            <a href="{{ route('roles.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-700"><i class="fa fa-plus"></i> Create New Role</a>
        @endcan
        <button id="toggleView" class="bg-blue-900 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Toggle View</button>
    </div>

    <div id="cardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($roles as $role)
            <div class="bg-blue-100 p-4 rounded-lg border border-gray-800 shadow-md hover:bg-gradient-to-b from-blue-100 to-teal-500 transform hover:scale-105 transition duration-150">
                <div class="text-center">
                    <h3 class="text-l font-bold mb-2">{{ $role->name }}</h3>
                    <div class="flex justify-center space-x-2 mt-4">
                        <button onclick="showRoleDetails({{ $role->id }})" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-700">Show</button>
                        @can('role-edit')
                            <a href="{{ route('roles.edit', $role->id) }}" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-yellow-700">Edit</a>
                        @endcan
                        @can('role-delete')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-1 px-2 rounded hover:bg-red-700">Delete</button>
                            </form>
                        @endcan
                    </div>
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
                    <th class="px-4 py-2">Permissions</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td class="border px-4 py-2">{{ $role->name }}</td>
                    <td class="border px-4 py-2">
                        @if(!empty($role->permissions))
                            @foreach($role->permissions as $permission)
                                <span class="inline-block bg-green-200 text-green-800 text-xs px-2 py-1 rounded">{{ $permission->name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td class="border px-4 py-2">
                        <button onclick="showRoleDetails({{ $role->id }})" class="btn btn-info btn-sm">Show</button>
                        @can('role-edit')
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('role-delete')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $roles->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal -->
<div id="roleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Role Details</h2>
            </div>
            <div id="modalContent" class="space-y-4">
                <!-- Role details will be loaded here -->
            </div>
            <div class="flex justify-end mt-4">
                <button onclick="closeModal()" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showRoleDetails(roleId) {
        fetch(`/roles/${roleId}/json`)
            .then(response => response.json())
            .then(data => {
                const modalContent = `
                    <p><strong>ID:</strong> ${data.id}</p>
                    <p><strong>Name:</strong> ${data.name}</p>
                    <p><strong>Permissions:</strong> ${data.permissions.map(permission => permission.name).join(', ')}</p>
                `;
                document.getElementById('modalContent').innerHTML = modalContent;
                document.getElementById('roleModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('roleModal').classList.add('hidden');
    }

    var toggleViewButton = document.getElementById('toggleView');
    var cardView = document.getElementById('cardView');
    var tableView = document.getElementById('tableView');

    toggleViewButton.addEventListener('click', function () {
        cardView.classList.toggle('hidden');
        tableView.classList.toggle('hidden');
    });
</script>
@stop