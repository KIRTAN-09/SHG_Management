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

    <div class="container1">
        <h3 class="text-center">Monthly Savings</h3>
        <div class="d-flex justify-content-end mb-3">
            <select id="yearSelect" class="form-select w-auto">
                <option value="" disabled>Select Year</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </div>
        <canvas id="savingsChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('savingsChart').getContext('2d');
            var savingsData = {
                labels: [],
                datasets: [{
                    label: 'Savings',
                    data: [],
                    backgroundColor: 'rgba(54, 93, 235, 0.2)',
                    borderColor: 'rgba(54, 163, 235, 0.14)',
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

            function fetchSavingsData(year) {
                fetch(`/home/savings-data?year=${year}`)
                    .then(response => response.json())
                    .then(data => {
                        savingsChart.data.labels = data.months;
                        savingsChart.data.datasets[0].data = data.savings;
                        savingsChart.update();
                    });
            }

            var currentYear = new Date().getFullYear();
            fetchSavingsData(currentYear);

            document.getElementById('yearSelect').addEventListener('change', function () {
                var selectedYear = this.value;
                fetchSavingsData(selectedYear);
            });
        });
    </script>
@endsection