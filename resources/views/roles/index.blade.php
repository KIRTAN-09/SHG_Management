@extends('layouts.app')

@section('title', 'Roles Management')

@section('content_header')
    <h1>Roles Management</h1>
    @stop

@section('content')

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .modal-table {
        width: 100%;
        border-collapse: collapse;
        color: black;
    }
    .modal-table th, .modal-table td {
        border: 1px solid black;
        padding: 8px;
        color: black;
        background-color: white;
    }
    .modal-table td{
        text-align: center;
    }
    
</style>

<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <div class="pull-right">
        @can('role-create')
            <a href="{{ route('roles.create') }}" class="bg-green-500 text-white py-2.5 px-4 rounded-lg hover:bg-green-700"><i class="fa fa-plus"></i> Create New Role</a>
        @endcan
        <button id="toggleView" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Toggle View</button>
        </div>
    </div>

    <div id="cardView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($roles as $role)
            <div class="bg-blue-100 p-4 rounded-lg border border-gray-800 shadow-md hover:bg-gradient-to-b from-blue-100 to-teal-500 transform hover:scale-105 transition duration-150">
                <div class="text-center">
                    <h3 class="text-lg font-bold mb-2"><u>{{ $role->name }}</u></h3>
                    <div class="flex justify-center space-x-2 mt-4">
                        <button onclick="showRoleDetails({{ $role->id }})" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-700">Show</button>
                        @can('role-edit')
                            <a href="{{ route('roles.edit', $role->id) }}" class="bg-blue-500 text-white py-1 px-2 rounded hover:bg-yellow-700">Edit</a>
                        @endcan
                        @can('role-delete')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
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
                        <table class="w-full">
                            @if(!empty($role->permissions))
                                @foreach($role->permissions->chunk(4) as $chunk)
                                <tr>
                                    @foreach($chunk as $permission)
                                    <td class="text-center">{{ $permission->name }}</td>
                                    @endforeach
                                    @for($i = $chunk->count(); $i < 4; $i++)
                                    <td class="text-center"></td>
                                    @endfor
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="3">No X</td>
                                </tr>
                            @endif
                        </table>
                    </td>
                    <td class="border px-4 py-2">
                        <button onclick="showRoleDetails({{ $role->id }})" class="btn btn-info1 btn-sm">Show</button>
                        @can('role-edit')
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning1 btn-sm">Edit</a>
                        @endcan
                        @can('role-delete')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger1 btn-sm">Delete</button>
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
        <div class="bg-blue-100 p-6 rounded-lg shadow-lg w-full max-w-2xl">
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
                console.log('Permissions Data:', data.permissions); // Log permissions data for debugging

                const categories = ['Role', 'Group', 'Member', 'Saving', 'IGAS', 'Training', 'Meeting'];
                let permissionsByCategory = {};

                // Group permissions by category with case-insensitive matching
                categories.forEach(category => {
                    permissionsByCategory[category] = data.permissions.filter(permission => {
                        const normalizedPermission = permission.name.toLowerCase().trim();
                        const normalizedCategory = category.toLowerCase().trim();
                        return normalizedPermission.includes(normalizedCategory);
                    });
                });

                // Generate rows for each category
                const permissionsGrid = categories.map(category => {
                    const permissions = permissionsByCategory[category]
                        .map(permission => `<td class="text-center">${permission.name}</td>`)
                        .join('');
                    return `
                        <tr>
                            <th>${category}:</th>
                            <td>
                                <table class="w-full">
                                    <tr>${permissions || '<td class="text-center">No Permissions</td>'}</tr>
                                </table>
                            </td>
                        </tr>
                    `;
                }).join('');

                const modalContent = `
                    <table class="modal-table mx-auto">
                        <tbody>
                            <tr>
                                <th>Name:</th>
                                <td>${data.name}</td>
                            </tr>
                            ${permissionsGrid}
                        </tbody>
                    </table>
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