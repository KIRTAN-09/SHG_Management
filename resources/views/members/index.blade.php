@extends('adminlte::page')

@section('title', 'Member List')

@section('content_header')

    <h1>Member List</h1>
    <div class="flex justify-end">
        <form action="{{ route('members.index') }}" method="GET" class="flex space-x-2">
            <input type="text" name="search" placeholder="Search members..." class="py-2 px-4 rounded-lg border border-gray-300" value="{{ request('search') }}">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Search</button>
        </form>
    </div>
@stop
        

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Members</h1>
        
        <a href="{{ route('members.create') }}" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-700">Add Member</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
        @foreach ($members as $member)
            <div class="bg-blue-100 p-4 rounded-lg border border-gray-800 shadow-md hover:bg-gradient-to-b from-blue-100 to-teal-500 transform hover:scale-105 transition duration-150">
                <div class="text-center">
                    <img src="{{ asset('storage/' . $member->photo) }}" class="w-20 h-20 object-cover rounded-full mx-auto mb-4">
                    <h3 class="text-l font-bold mb-2">{{ $member->name }}</h3>
                    <p class="text-gray-600 mb-2"><strong>Member UID:</strong> {{ $member->member_id }}</p>
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
        document.body.appendChild(confirmationBox);
    }

    function closeConfirmationBox() {
        document.querySelector('.fixed.inset-0').remove();
    }

    function submitDeleteForm() {
        formToSubmit.submit();
    }

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
