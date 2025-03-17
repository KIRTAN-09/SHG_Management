@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Meeting Details</h2>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#meetingModal{{ $meeting->id }}">View Details</button>
    <a href="{{ route('meetings.index') }}" class="btn btn-secondary mt-3">Back to Meetings</a>

    <!-- Modal -->
<div id="meetingModal" class="fixed z-50 inset-0 overflow-y-auto hidden bg-gray-900 bg-opacity-50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-6 rounded-lg shadow-lg w-2/4 flex">
            <div class="w-2/3">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Meeting Details</h3>
                </div>
                <div id="modalContent" class="mt-4">
                    <!-- Meeting details will be loaded here via JavaScript -->
                </div>
                <div class="flex justify-end mt-4">
                    <button onclick="closeModal()" class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Close</button>
                </div>
            </div>
            <div class="w-1/3 flex justify-center items-center">
                <img id="modalPhoto" src="" alt="Group Photo" class="w-full h-auto rounded-lg">
            </div>
        </div>
    </div>
</div>

<script>
    function showmeetingdetails(meetingId) {
        // Fetch meeting details via AJAX and display in the modal
        fetch(`/meetings/${meetingId}/details`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalContent').innerHTML = `
                    <table>
                        <tr><td><strong>Date:</strong></td><td>${data.date}</td></tr>
                        <tr><td><strong>Group Name:</strong></td><td>${data.group_name}</td></tr>
                        <tr><td><strong>Group ID:</strong></td><td>${data.group_id}</td></tr>
                        <tr><td><strong>Discussion Points:</strong></td><td>${data.discussion}</td></tr>
                        <tr><td><strong>No. Members Present:</strong></td><td>${data.attendance_list}</td></tr>
                    </table>
                `;
                document.getElementById('modalPhoto').src = `/storage/${data.photo}`;
                document.getElementById('meetingModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('meetingModal').classList.add('hidden');
    }
</script>
@endsection
