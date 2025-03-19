@extends('layouts.app')

@section('content')
    <div class="container">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

        <br>
        <div class="mb-3">
            <a href="{{ route('training.create') }}" class="btn btn-primary">Create New Training</a>
        </div>
        <div class="card">
            <div class="card-header">Manage Training</div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover', 'id' => 'training-table']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#Trainig-table')) {
                $('#training-table').DataTable().clear().destroy(); // Clear and destroy existing instance
            }
            $('#training-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('training.index') }}', // Ensure the correct route is used
                columns: [ // Ensure columns match the data returned by the query
                    { data: 'training_date', name: 'training_date' },
                    { data: 'trainer', name: 'trainer' },
                    { data: 'members_name', name: 'members_name' },
                    { data: 'members_ID', name: 'members_ID' }, // Corrected column name
                    { data: 'location', name: 'location' },
                    { data: 'category', name: 'category' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                dom: '<"top">rt<"bottom"l>Bfrtip', // Custom DOM layout
                buttons: [
                    'excel', 'csv', 'pdf', 'print', 'reset', 'reload'
                ],
                lengthMenu: [ // Add row in show option
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                searching: true, // Enables search
                order: [[0, 'asc']], // Sort by ID in ascending order by default
            });
        });
    </script>
@endpush