@extends('adminlte::page')

@section('title', 'Role Management')

@section('content_header')
    <h1>Role Management</h1>
    @stop

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto p-4">
    <div class="flex justify-start items-center mb-4">
        @can('role-create')
            <a href="{{ route('roles.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-700"><i class="fa fa-plus"></i> Create New Role</a>
        @endcan
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
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
</script>
@stop