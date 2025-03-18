@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <div class="mb-3">
            <a href="{{ route('igas.create') }}" class="btn btn-primary">Create New IGA</a>
        </div>
        <div class="card">
            <div class="card-header">Manage IGAS</div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover', 'id' => 'igas-table']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#igas-table')) {
                $('#igas-table').DataTable().clear().destroy(); // Clear and destroy existing instance
            }
            $('#igas-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('igas.index') }}', // Ensure the correct route is used
                columns: [ // Ensure columns match the data returned by the query
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'category', name: 'category' },
                    { data: 'date', name: 'date' },
                    { data: 'earned', name: 'earned' },
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

