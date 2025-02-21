@extends('adminlte::page')

@section('title', 'Member List')

@section('content_header')
    <h1>Member List</h1>
    <form action="{{ route('members.index') }}" method="GET" class="flex space-x-2">
        <input type="text" name="search" placeholder="Search members..." class="py-2 px-4 rounded-lg border border-gray-300" value="{{ request('search') }}">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Search</button>
    </form>
@stop
        

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Member List</h2>
    <link rel="stylesheet" href="{{ asset('css/Members/member.css') }}">
    <a href="{{ route('members.create') }}" class="btn btn-primary mb-4">Add Member</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Photo</th>
                    <th class="py-2 px-4 border-b">Member UID</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Number</th>
                    <th class="py-2 px-4 border-b">Village</th>
                    <th class="py-2 px-4 border-b">Group</th>
                    <th class="py-2 px-4 border-b">Caste</th>
                    <th class="py-2 px-4 border-b">Share Price</th>
                    <th class="py-2 px-4 border-b">Member Type</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td class="py-2 px-4 border-b"><img src="{{ asset('storage/' . $member->photo) }}" class="w-16 h-16 object-cover rounded-full"></td>
                        <td class="py-2 px-4 border-b">{{ $member->member_id }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->name }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->number }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->village }}</td>
                        <td class="py-2 px-4 border-b">{{ is_object($member->group) ? $member->group->name : '' }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->caste }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->share_price }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->member_type }}</td>
                        <td class="py-2 px-4 border-b">{{ $member->status }}</td>
                        <td class="py-2 px-4 border-b action-buttons">
                            <a href="{{ route('members.show', $member->id) }}" class="view-btn">View</a>
                            <a href="{{ route('members.edit', $member->id) }}" class="edit-btn">Edit</a>
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $members->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal -->
<div id="memberModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Member Details</h2>
            <span class="text-2xl cursor-pointer" onclick="closeModal()">&times;</span>
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
    function showMemberDetails(memberId) {
        fetch(`/members/${memberId}`)
            .then(response => response.json())
            .then(data => {
                const modalContent = `
                    <div class="text-center">
                        <img src="${data.photo ? '{{ asset('storage/') }}' + '/' + data.photo : ''}" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                    </div>
                    <p><strong>ID:</strong> ${data.member_id}</p>
                    <p><strong>Number:</strong> ${data.number}</p>
                    <p><strong>Village:</strong> ${data.village}</p>
                    <p><strong>Group:</strong> ${data.group}</p>
                    <p><strong>Caste:</strong> ${data.caste}</p>
                    <p><strong>Share Price:</strong> ${data.share_price}</p>
                    <p><strong>Member Type:</strong> ${data.member_type}</p>
                    <p><strong>Status:</strong> ${data.status}</p>
                `;
                document.getElementById('modalContent').innerHTML = modalContent;
                document.getElementById('memberModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('memberModal').classList.add('hidden');
    }
</script>
@stop
