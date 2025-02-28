@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset(path: 'css/Home.css') }}">
<div class="d-flex justify-content-center mt-4">
    <div class="col-md-3 mt-3">
        <div class="card text-dark text-center p-3" style="height: 150px;">
            <h3 class="text-dark">{{ $totalGroups }}</h3>
            <p class="text-dark">Total Groups</p>
            <a href="{{ route('groups.index') }}" class="text-dark1">More info: </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark text-center p-3" style="height: 150px;">
            <h3 class="text-dark">{{ $totalMembers }}</h3>
            <p class="text-dark">Total Members</p>
            <a href="{{ route('members.index') }}" class="text-dark1">More info: </a>
        </div>
    </div>
    <div class="col-md-3 mt-3">
        <div class="card text-dark text-center p-3" style="height: 150px;">
            <h3 class="text-dark">{{ $totalActiveMembers }}</h3>
            <p class="text-dark">Total Active Members</p>
            <!-- <a href="{{ route('members.index', ['filter' => 'Active']) }}" class="text-dark1">More info: </a> -->
        </div>
    </div>
</div>

<div class="container mt-5">
    <h3 class="text-center">Monthly Savings</h3>
    <div class="d-flex justify-content-end mb-3">
        <form method="get" class="d-flex justify-content-right">
            <input type="number" name="year" value="{{ request('year') }}" class="form-control" placeholder="Enter year">
            <button type="submit" class="btn btn-primary ml-2">Filter</button>
        </form>
        <button id="sortButton" class="btn btn-secondary ml-2">Sort by Savings</button>
    </div>
    <canvas id="savingsChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('savingsChart').getContext('2d');
        var savingsData = {
            labels: @json($months),
            datasets: [{
                label: 'Savings',
                data: @json($savings),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };
        var savingsChart = new Chart(ctx, {
            type: 'bar',
            data: savingsData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        @if(request('year'))
            // Filter data by year
            var filteredData = savingsData.datasets[0].data.filter((value, index) => {
                return new Date(savingsData.labels[index] + '-01').getFullYear() == {{ request('year') }};
            });
            var filteredLabels = savingsData.labels.filter((label, index) => {
                return new Date(label + '-01').getFullYear() == {{ request('year') }};
            });
            savingsChart.data.labels = filteredLabels;
            savingsChart.data.datasets[0].data = filteredData;
            savingsChart.update();
        @endif

        document.getElementById('sortButton').addEventListener('click', function() {
            var sortedData = savingsChart.data.datasets[0].data.slice().sort((a, b) => b - a);
            var sortedLabels = savingsChart.data.labels.slice().sort((a, b) => savingsChart.data.datasets[0].data[savingsChart.data.labels.indexOf(b)] - savingsChart.data.datasets[0].data[savingsChart.data.labels.indexOf(a)]);
            savingsChart.data.labels = sortedLabels;
            savingsChart.data.datasets[0].data = sortedData;
            savingsChart.update();
        });
    });
</script> 
@endsection