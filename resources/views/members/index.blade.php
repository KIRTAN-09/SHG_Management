@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Members</div>
            <div class="card-body">
                {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover', 'id' => 'members-table']) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).ready(function() {
            if ($.fn.dataTable.isDataTable('#members-table')) {
                $('#members-table').DataTable().clear().destroy(); // Clear and destroy existing instance
            }
            $('#members-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('members.index') }}', // Ensure the correct route is used
                columns: [ // Ensure columns match the data returned by the query
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'number', name: 'number' },
                    { data: 'village', name: 'village' },
                    { data: 'group_name', name: 'group_name' },
                    { data: 'caste', name: 'caste' },
                    { data: 'share_price', name: 'share_price' },
                    { data: 'member_type', name: 'member_type' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                dom: '<"top"f>rt<"bottom"lp><"clear">Bfrtip', // Custom DOM layout
                buttons: [
                    'excel', 'csv', 'pdf', 'print', 'reset', 'reload'
                ]
            });
        });
    </script>
@endpush