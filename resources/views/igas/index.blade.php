@extends('layouts.app')

@section('content')
<div class="container">
<h2 class="text-2xl font-bold mb-4">IGAs</h2>
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
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
    <a href="{{ route('igas.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Create IGA</a>
    <!-- Live Search Input -->
    <div class= "flex justify-end">
        <input type="text" id="search" placeholder="Search..." class="py-2 px-2 w-1/4 rounded-lg border border-gray-300 mr-2">
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Category</th>
                <th>Earned</th>   
                <!-- <th>Activity</th>-->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="igaTable">
            @foreach($igas as $iga)
            <tr>
                <td>{{ $iga->name }}</td>
                <td>{{ $iga->date }}</td>
                <td>{{ $iga->category }}</td>
                <td>{{ $iga->earned }}</td>
                <!-- <td>{{ $iga->activity}}</td> -->
                <td>
                    <button onclick="showIgaDetails({{ $iga->id }})" class="btn btn-info">View</button>
                    <a href="{{ route('igas.edit', $iga->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('igas.destroy', $iga->id) }}" method="POST" style="display:inline;">
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

<!-- Modal -->
<div id="igaModal" class="fixed inset-1 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-blue-100 p-6 rounded-lg shadow-lg w-1/3 max-w-2xl relative">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-black">IGA Details</h2>
        </div>
        <div id="igaModalContent" class="space-y-4">
            <!-- IGA details will be loaded here -->
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeIgaModal()" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Close</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function showIgaDetails(igaId) {
        fetch(`/igas/${igaId}`)
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
                                <th>Date:</th>
                                <td>${data.date}</td>
                            </tr>
                            <tr>
                                <th>Category:</th>
                                <td>${data.category}</td>
                            </tr>
                            <tr>
                                <th>Earned:</th>
                                <td>${data.earned}</td>
                            </tr>
                        </tbody>
                    </table>
                `;
                document.getElementById('igaModalContent').innerHTML = modalContent;
                document.getElementById('igaModal').classList.remove('hidden');
            });
    }

    function closeIgaModal() {
        document.getElementById('igaModal').classList.add('hidden');
    }

    document.getElementById('search').addEventListener('keyup', function() {
        var searchValue = this.value.toLowerCase();
        var rows = document.querySelectorAll('#igaTable tr');
        rows.forEach(function(row) {
            var name = row.cells[0].textContent.toLowerCase();
            var category = row.cells[2].textContent.toLowerCase();
            if (name.includes(searchValue) || category.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    window.showIgaDetails = showIgaDetails;
    window.closeIgaModal = closeIgaModal;
});
</script>
@endsection
