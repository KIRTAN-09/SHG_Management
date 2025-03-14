@extends('layouts.app')

@section('title', 'Meetings')
@section('content_header')
<h2 class="text-2xl font-bold mb-4">Meetings</h2>
@stop

@section('content')
    <div class="container">
        <div class="pull-right">
            <link rel="stylesheet" href="{{ asset('css/table.css') }}">
            <a href="{{ route('meetings.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Schedule a New
                Meeting</a>
        </div>
        <!-- Live Search Bar -->
        <div class="flex justify-end mb-4">
            <input type="text" id="liveSearch" placeholder="Search..."
                class="py-2 px-2 w-1/4 rounded-lg border border-gray-300 mr-2">
        </div>
        <div class="table-container">
            <table class="table mt-3">
                <thead>
                    <tr>

                        <th>
                            @foreach (['Date'] as $column)
                                    <form method="GET" action="{{ route('meetings.index') }}">
                                        <input type="hidden" name="column" value="{{ $column }}">
                                        <input type="hidden" name="sort"
                                            value="{{ request('column') === $column && request('sort') === 'asc' ? 'desc' : 'asc' }}">
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                                        <button type="submit" class="header-button">
                                            {{ $column }}
                                            {{ request('column') === $column ? (request('sort') === 'asc' ? '▲' : '▼') : '' }}
                                        </button>
                                    </form>
                                </th>

                            @endforeach
                        <th>Photo</th>
                        <th>Group Name</th>
                        <th>Group ID</th>
                        <th>Discussion Points</th>
                        <th>Attendance List</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="meetingsTable">
                    @foreach($meetings as $meeting)
                        <tr>
                            <td>{{ $meeting->date }}</td>
                            <td><img src="{{ asset('storage/' . $meeting->photo) }}" alt="Group Photo"
                                    class="w-20 h-20 object-cover rounded-full mx-auto mb-4"></td>
                            <td>{{ $meeting->group_name }}</td>
                            <td>{{ $meeting->group_id }}</td>
                            <td>{{ $meeting->discussion }}</td>
                            <td>{{ $meeting->attendance_list }}</td>
                            <td class="action-buttons">
                                <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#meetingModal{{ $meeting->id }}">View</button>
                                <a href="{{ route('meetings.edit', $meeting) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('meetings.destroy', $meeting) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <style>
                            .modal {
                                transition: opacity 0.25s;
                            }

                            .container3 {
                                font-size: 14px;
                                height: auto;
                                width: 600px;
                                background: rgba(245, 245, 220, 0.714);
                                padding: 20px;
                                border: 1px solid #f4f3f357;
                                border-radius: 6px;
                            }
                        </style>
                        <div class="modal" id="meetingModal{{ $meeting->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="meetingModalLabel{{ $meeting->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="container3">
                                    <div class="modal-header">
                                        <h5 class=font-serif text-3xl style="color: cornflowerblue;"
                                            id="meetingModalLabel{{ $meeting->id }}">Meeting Details</h5>
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Date:</strong> {{ $meeting->date }}</p>
                                        <p><strong>Group Name:</strong> {{ $meeting->group_name }}</p>
                                        <p><strong>Group ID:</strong> {{ $meeting->group_id }}</p>
                                        <p><strong>Discussion Points:</strong> {{ $meeting->discussion }}</p>
                                        <p><strong>No. Members Present:</strong> {{ $meeting->attendance_list }}</p>
                                        <img src="{{ asset('storage/' . $meeting->photo) }}" alt="Group Photo"
                                            style="width: 100%; height: auto;">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $meetings->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function debounce(func, wait) {
                let timeout;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            const liveSearch = document.getElementById('liveSearch');
            liveSearch.addEventListener('keyup', debounce(function () {
                let filter = liveSearch.value.toLowerCase();
                let rows = document.querySelectorAll('#meetingsTable tr');
                rows.forEach(row => {
                    let text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            }, 300));

            document.querySelectorAll('.view-meeting').forEach(button => {
                button.addEventListener('click', function () {
                    let meetingId = this.getAttribute('data-meeting-id');
                    let modal = document.getElementById('meetingModal' + meetingId);
                    $(modal).modal('show');
                });
            });
        });
    </script>
@endsection