<!DOCTYPE html>
<html>
<head>
    <title>Simple Chart Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding: 20px; 
            background: #f8f9fa;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        .chart-box {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stats-box {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            text-align: center;
            display: inline-block;
            min-width: 200px;
        }
        canvas {
            max-height: 400px !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>HarvestInn Farm Dashboard - Chart Test</h1>
        
        <!-- Quick Stats -->
        <div class="stats-box">
            <h3>{{ \App\Models\Product::count() }}</h3>
            <p>Products</p>
        </div>
        <div class="stats-box">
            <h3>{{ \App\Models\Sale::count() }}</h3>
            <p>Sales</p>
        </div>
        <div class="stats-box">
            <h3>ZMW {{ number_format(\App\Models\Sale::sum('total_amount'), 2) }}</h3>
            <p>Total Revenue</p>
        </div>
        <div class="stats-box">
            <h3>{{ \App\Models\Incubation::count() }}</h3>
            <p>Incubations</p>
        </div>
        
        <div style="clear: both;"></div>
        
        <!-- Chart 1: Revenue Trend -->
        <div class="chart-box">
            <h3>Revenue Trend (Last 12 Months)</h3>
            <canvas id="revenueChart"></canvas>
        </div>
        
        <!-- Chart 2: Simple Data -->
        <div class="chart-box">
            <h3>Sample Chart</h3>
            <canvas id="sampleChart"></canvas>
        </div>
        
        <div id="debug-info" style="background: #e9ecef; padding: 15px; margin: 20px 0; border-radius: 5px;">
            <strong>Debug Info:</strong>
            <div id="chart-status">Loading...</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const debugElement = document.getElementById('chart-status');
            
            // Check Chart.js
            if (typeof Chart === 'undefined') {
                debugElement.innerHTML = '❌ Chart.js not loaded';
                return;
            }
            
            debugElement.innerHTML = '✅ Chart.js loaded (v' + Chart.version + ')';
            
            // Revenue Chart with real data
            try {
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                const revenueLabels = @json(collect(range(11, 0))->map(fn($i) => \Carbon\Carbon::now()->subMonths($i)->format('M Y'))->values());
                const revenueData = @json(collect(range(11, 0))->map(function($i) {
                    $date = \Carbon\Carbon::now()->subMonths($i);
                    return \App\Models\Sale::whereMonth('created_at', $date->month)
                        ->whereYear('created_at', $date->year)
                        ->sum('total_amount');
                })->values());
                
                new Chart(revenueCtx, {
                    type: 'line',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            label: 'Revenue (ZMW)',
                            data: revenueData,
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'ZMW ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
                
                debugElement.innerHTML += '<br>✅ Revenue chart created';
            } catch (error) {
                debugElement.innerHTML += '<br>❌ Revenue chart error: ' + error.message;
                console.error('Revenue chart error:', error);
            }
            
            // Sample Chart
            try {
                const sampleCtx = document.getElementById('sampleChart').getContext('2d');
                new Chart(sampleCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Sample Data',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 205, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                
                debugElement.innerHTML += '<br>✅ Sample chart created';
            } catch (error) {
                debugElement.innerHTML += '<br>❌ Sample chart error: ' + error.message;
                console.error('Sample chart error:', error);
            }
        });
    </script>
</body>
</html>
