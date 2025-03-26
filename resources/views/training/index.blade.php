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
<script src="{{ asset('js/dropdown.js') }}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
@endpush