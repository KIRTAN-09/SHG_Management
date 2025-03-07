@extends('layouts.app')

@section('content')
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
    <h2 class="text-2xl font-bold mb-4">Training List</h2>
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <a href="{{ route('training.create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Add Training</a>
    
    <!-- Live Search Bar -->
    <div class="flex justify-end">
    <input type="text" id="liveSearch" placeholder="Search..." class="py-2 px-2 w-1/4 rounded-lg border border-gray-300">
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <!-- <th class="py-2 px-4 border-b">Training ID</th> -->
                    <th>Training Date</th>
                    <th>Training Category</th>   
                    <th>Training Location</th>
                    <th>Number of Participants</th>
                    <th>Trainer Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="trainingTable">
                @foreach ($trainings as $training)
                    <tr>
                        <!-- <td class="py-2 px-4 border-b">{{ $training->training_id }}</td> -->

                        <td>{{ $training->training_date }}</td>
                        <td>{{ $training->category }}</td>
                        <td>{{ $training->location }}</td>
                        <td>{{ $training->participants }}</td>
                        <td>{{ $training->trainer }}</td>
                        <td class="action-buttons">
                            <button onclick="showTrainingDetails({{ $training->id }})" class="btn btn-info">View</button>
                            <a href="{{ route('training.edit', $training->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('training.destroy', $training->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $trainings->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal -->
<div id="trainingModal" class="fixed inset-1 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-blue-100 p-6 rounded-lg shadow-lg w-1/3 max-w-2xl relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-black">Training Details</h2>
        </div>
        <div id="trainingModalContent" class="space-y-4">
            <!-- Training details will be loaded here -->
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeTrainingModal()" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Close</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function showTrainingDetails(trainingId) {
        fetch(`/training/${trainingId}`)
            .then(response => response.json())
            .then(data => {
                const modalContent = `
                    <table class="modal-table mx-auto">
                        <tbody>
                            <tr>
                                <th>Training Date:</th>
                                <td>${data.training_date}</td>
                            </tr>
                            <tr>
                                <th>Category:</th>
                                <td>${data.category}</td>
                            </tr>
                            <tr>
                                <th>Location:</th>
                                <td>${data.location}</td>
                            </tr>
                            <tr>
                                <th>Participants:</th>
                                <td>${data.participants}</td>
                            </tr>
                            <tr>
                                <th>Trainer:</th>
                                <td>${data.trainer}</td>
                            </tr>
                        </tbody>
                    </table>
                `;
                document.getElementById('trainingModalContent').innerHTML = modalContent;
                document.getElementById('trainingModal').classList.remove('hidden');
            });
    }

    function closeTrainingModal() {
        document.getElementById('trainingModal').classList.add('hidden');
    }

    document.getElementById('liveSearch').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.getElementById('trainingTable').getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName('td');
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].innerText.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    });

    window.showTrainingDetails = showTrainingDetails;
    window.closeTrainingModal = closeTrainingModal;
});
</script>
@endsection
