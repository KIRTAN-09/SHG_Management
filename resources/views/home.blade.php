@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset(path: 'css/Home.css') }}">
<div class="d-flex justify-content-center mt-4">
    <div class="col-md-3 mt-3">
        <div class="card text-dark text-center p-3" style="height: 150px;">
            <h3 class="text-dark">{{ $totalGroups }}</h3>
            <p class="text-dark">Total Groups</p>
            <a href="{{ route('groups.index') }}" class="text-dark">More info </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark text-center p-3" style="height: 150px;">
            <h3 class="text-dark">{{ $totalMembers }}</h3>
            <p class="text-dark">Total Members</p>
            <a href="{{ route('members.index') }}" class="text-dark">More info </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark text-center p-3" style="height: 150px;">
            <h3 class="text-dark">{{ $totalActiveMembers }}</h3>
            <p class="text-dark">Total Active Members</p>
            <a href="#" class="text-dark">More info </a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h3 class="text-center">Monthly Savings</h3>
    <canvas id="savingsChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('savingsChart').getContext('2d');
        var savingsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Savings',
                    data: @json($savings),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection