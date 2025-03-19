@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.3/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<br>
<div class="mb-3">
    <a href="{{ route('savings.create') }}" class="btn btn-primary">Create New Saving</a>
</div>

<div class="container">
    <div class="card">
        <div class="card-header">Manage Savings</div>
        <div class="card-body">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover', 'id' => 'savings-table']) }}
        </div>
    </div>
</div>
@endsection     

@push('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#savings-table')) {
                $('#savings-table').DataTable().clear().destroy(); // Clear and destroy existing instance
            }
            $('#savings-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('savings.index') }}',
                columns: [
                    // { data: 'id', name: 'id' },
                    { data: 'member_name', name: 'member_name' },
                    { data: 'amount', name: 'amount' },
                    { data: 'date_of_deposit', name: 'date_of_deposit' }, // Corrected field name
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