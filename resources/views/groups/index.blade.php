@extends('layouts.app')

@section('content')
<link href="{{ asset('css/table.css') }}" rel="stylesheet">
<div class="container">
    <div class="card">
        <div class="card-header">Manage Groups</div>
        <div class="card-body">
        {!! $dataTable->table() !!}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dropdown.js') }}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@endpush