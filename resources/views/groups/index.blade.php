@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<div class="container">
    <div class="card">
        <div class="card-header">Manage Groups</div>
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover', 'id' => 'groups-table']) }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#groups-table')) {
                $('#groups-table').DataTable().clear().destroy(); // Clear and destroy existing instance
            }
            $('#groups-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('groups.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'village_name', name: 'village_name' },
                    { data: 'president_name', name: 'president_name' },
                    { data: 'secretary_name', name: 'secretary_name' },
                    { data: 'no_of_members', name: 'no_of_members' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ], // <-- Add missing comma here
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