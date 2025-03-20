@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<br>
<div class="mb-3">
    <a href="{{ route('meetings.create') }}" class="btn btn-primary">Create New Meeting</a>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">Manage Meetings</div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover', 'id' => 'meeting-table']) }}
            </div>
        </div>
    </div>
</div>
@endsection 

@push('scripts')
    <!-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} -->
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#meeting-table')) {
                $('#meeting-table').DataTable().clear().destroy(); // Clear and destroy existing instance
            }
            $('#meeting-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('meetings.index') }}', // Ensure the correct route is used
                columns: [ // Ensure columns match the data returned by the query
                    // { data: 'id', name: 'id' },
                    { data: 'group_id', name: 'group_id', title: 'Group ID' },
                    { data: 'group_name', name: 'group_name', title: 'Group Name' },
                    { data: 'discussion', name: 'discussion' },
                    { data: 'attendance', name: 'attendance' },
                    { data: 'date', name: 'date' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                dom: '<"top">rt<"bottom"l><"clear">Bfrtip', // Custom DOM layout
                buttons: [
                    'excel', 'csv', 'pdf', 'print', 'reset', 'reload'
                ],
                lengthMenu: [ // Add row in show option
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                searching: true // Enable searching
            });
        });
    </script>
@endpush