@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Reports</h1>
    <div class="row">
        <!-- Cards for report selection -->
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('members')">
                <div class="card-body">
                    <h5 class="card-title">Members Report</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('groups')">
                <div class="card-body">
                    <h5 class="card-title">Groups Report</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('savings')">
                <div class="card-body">
                    <h5 class="card-title">Savings Report</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('igas')">
                <div class="card-body">
                    <h5 class="card-title">IGAs Report</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('training')">
                <div class="card-body">
                    <h5 class="card-title">Training Report</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('meetings')">
                <div class="card-body">
                    <h5 class="card-title">Meetings Report</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('monthly')">
                <div class="card-body">
                    <h5 class="card-title">Monthly Report</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center bg-light text-dark hover-secondary" onclick="loadReportForm('annual')">
                <div class="card-body">
                    <h5 class="card-title">Annual Report</h5>
                </div>
            </div>
        </div>
    </div>
    <div id="reportFormContainer" class="mt-4">
        <!-- Dynamic form content will be loaded here -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadReportForm(type) {
        $.ajax({
            url: "{{ url('/reports') }}/" + type,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    $("#reportFormContainer").html(response.html);
                } else {
                    $("#reportFormContainer").html('<div class="alert alert-danger">Form not found!</div>');
                }
            },
            error: function() {
                $("#reportFormContainer").html('<div class="alert alert-danger">An error occurred while loading the form.</div>');
            }
        });
    }
</script>


<style>
    .hover-secondary {
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease-in-out; /* Add transition for zoom effect */
    }

    .hover-secondary::before {
        content: '';
        position: absolute;
        bottom: -100%; /* Start from the bottom */
        left: 0;
        width: 100%;
        height: 100%;
        background-color: var(--bs-secondary);
        z-index: 0;
        transition: bottom 0.3s ease-in-out; /* Animate from bottom to top */
    }

    .hover-secondary:hover::before {
        bottom: 0; /* Fill to the top */
    }

    .hover-secondary:hover {
        color: white !important; /* Change text color on hover */
        transform: scale(1.05); /* Zoom effect */
    }

    .hover-secondary .card-body {
        position: relative;
        z-index: 1;
    }
</style>

@endsection
