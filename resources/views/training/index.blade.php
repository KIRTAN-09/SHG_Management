@extends('layouts.app')

@section('title', 'Training')
@section('content_header')
<h2 class="text-2xl font-bold mb-4">Training</h2>
@stop

@section('content')
    <style>
        .container3 {
            font-size: 14px;
            height: auto;
            width: 600px;
            background: rgba(245, 245, 220, 0.714);
            padding: 20px;
            border: 1px solid #f4f3f357;
            border-radius: 6px;
        }

        .modal-table {
            width: 100%;
            border-radius: 8px;
            border-collapse: collapse;
        }

        .modal-table th,
        .modal-table td {
            border: 1px solid rgba(0, 0, 0, 0.549);
            padding: 6px;
            color: black;
            background-color: rgba(41, 41, 41, 0.226);
        }

        .modal-table td {
            background-color: rgba(41, 41, 41, 0.226);
            color: rgb(27, 26, 26);
            text-align: center;
        }
    </style>

    <div class="container mx-auto p-4">
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">

        <a href="{{ route('training.create') }}" class="btn btn-primary mb-4"><i class="fa fa-plus"></i> Add Training</a>

        <!-- Live Search Bar -->
        <div class="flex justify-end">
            <input type="text" id="liveSearch" placeholder="Search..."
                class="py-2 px-2 w-1/4 rounded-lg border border-gray-300">
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        @foreach(['training_date' => 'Date', 'members_name' => 'Member Name', 'members_ID' => 'Member ID','category' => 'Category', 'location' => 'Location',  'trainer' => 'Trainer' ] as $column => $label)
                            <th>
                                <form method="GET" action="{{ route('training.index') }}">
                                    <input type="hidden" name="column" value="{{ $column }}">
                                    <input type="hidden" name="sort"
                                        value="{{ request('column') === $column && request('sort') === 'asc' ? 'desc' : 'asc' }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                    <button type="submit" class="header-button">
                                        {{ $label }}
                                        {{ request('column') === $column ? (request('sort') === 'asc' ? '▲' : '▼') : '' }}
                                    </button>
                                </form>
                            </th>
                        @endforeach
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="trainingTable">
                    @foreach ($trainings as $training)
                        <tr>
                            <td>{{ $training->training_date }}</td>
                            <td>{{ $training->members_name }}</td>
                            <td>{{ $training->members_ID }}</td>
                            <td>{{ $training->category }}</td>
                            <td>{{ $training->location }}</td>
                            <!-- <td>{{ $training->participants }}</td> -->
                            <td>{{ $training->trainer }}</td>
                            <td class="action-buttons">
                                <button onclick="showTrainingDetails({{ $training->id }})" class="btn btn-info">View</button>
                                <a href="{{ route('training.edit', $training->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('training.destroy', $training->id) }}" method="POST"
                                    style="display:inline;">
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
        <div class="container3">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-serif text-3xl" style="color: cornflowerblue;">Training Details</h2>
            </div>
            <div id="trainingModalContent" class="space-y-4">
                <!-- Training details will be loaded here -->
            </div>
            <div class="flex justify-end mt-4">
                <button onclick="closeTrainingModal()"
                    class="bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

            document.getElementById('liveSearch').addEventListener('keyup', function () {
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