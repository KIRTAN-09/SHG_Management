@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center mt-4">
    <div class="col-md-3 mt-3">
        <div class="card text-dark bg-info text-center p-3" style="background-color: lightblue !important; height: 150px;">
            <h3 class="text-dark">{{ $totalGroups }}</h3>
            <p class="text-dark">Total Groups</p>
            <a href="{{ route('groups.index') }}" class="text-dark">More info </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark bg-success text-center p-3" style="background-color: lightblue !important; height: 150px;">
            <h3 class="text-dark">{{ $totalMembers }}</h3>
            <p class="text-dark">Total Members</p>
            <a href="{{ route('members.index') }}" class="text-dark">More info </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark bg-danger text-center p-3" style="background-color: lightblue !important; height: 150px;">
            <h3 class="text-dark">{{ $totalActiveMembers }}</h3>
            <p class="text-dark">Total Active Members</p>
            <a href="#" class="text-dark">More info </a>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Savings Graph</div>
            <div class="card-body">
                <canvas id="savingsChart"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('savingsChart').getContext('2d');
        var savingsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($savingsDates),
                datasets: [{
                    label: 'Amount of Deposit',
                    data: @json($savingsAmounts),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day'
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
