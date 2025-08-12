<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Debug - HarvestInn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .chart-container {
            position: relative;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-4">
        <h1>Dashboard Debug - HarvestInn Management</h1>
        
        <!-- Simple Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <h4>Products: {{ \App\Models\Product::count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4>Sales: {{ \App\Models\Sale::count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4>Purchases: {{ \App\Models\Purchase::count() }}</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4>Incubations: {{ \App\Models\Incubation::count() }}</h4>
                </div>
            </div>
        </div>

        <!-- Test Chart -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5>Test Chart 1 - Simple Bar Chart</h5>
                    <canvas id="testChart1" width="400" height="200"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5>Test Chart 2 - Revenue Data</h5>
                    <canvas id="testChart2" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- JavaScript Debug Info -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Debug Information</h5>
                        <p id="chartjsStatus">Chart.js Loading...</p>
                        <p id="dataStatus">Data Status...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Debug Chart.js availability
            const chartjsStatus = document.getElementById('chartjsStatus');
            const dataStatus = document.getElementById('dataStatus');
            
            if (typeof Chart !== 'undefined') {
                chartjsStatus.textContent = '✅ Chart.js loaded successfully (Version: ' + Chart.version + ')';
                chartjsStatus.className = 'text-success';
            } else {
                chartjsStatus.textContent = '❌ Chart.js failed to load';
                chartjsStatus.className = 'text-danger';
                return;
            }

            // Test data
            const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
            const data = [12, 19, 3, 5, 2, 3];
            
            // Create Test Chart 1 - Simple bar chart
            try {
                const ctx1 = document.getElementById('testChart1').getContext('2d');
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Test Data',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
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
                dataStatus.textContent = '✅ Test Chart 1 created successfully';
                dataStatus.className = 'text-success';
            } catch (error) {
                dataStatus.textContent = '❌ Error creating Test Chart 1: ' + error.message;
                dataStatus.className = 'text-danger';
                console.error('Chart 1 Error:', error);
            }

            // Create Test Chart 2 - Revenue data
            try {
                const ctx2 = document.getElementById('testChart2').getContext('2d');
                
                // Real revenue data from Laravel
                const revenueLabels = ["Sep 2024","Oct 2024","Nov 2024","Dec 2024","Jan 2025","Feb 2025","Mar 2025","Apr 2025","May 2025","Jun 2025","Jul 2025","Aug 2025"];
                const revenueData = [0,0,0,0,0,0,0,0,0,0,0,90.00];
                
                new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: revenueLabels,
                        datasets: [{
                            label: 'Revenue (ZMW)',
                            data: revenueData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
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
                
                const currentStatus = dataStatus.textContent;
                dataStatus.textContent = currentStatus + ' | ✅ Test Chart 2 created successfully';
                
            } catch (error) {
                dataStatus.textContent = dataStatus.textContent + ' | ❌ Error creating Test Chart 2: ' + error.message;
                dataStatus.className = 'text-danger';
                console.error('Chart 2 Error:', error);
            }
        });
    </script>
</body>
</html>
