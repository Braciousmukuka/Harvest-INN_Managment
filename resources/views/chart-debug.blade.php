<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Debug</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .chart-container { 
            width: 100%; 
            height: 400px; 
            margin: 20px 0; 
            border: 1px solid #ddd; 
            padding: 10px;
        }
        .debug-info {
            background: #f5f5f5;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Chart Debug Page</h1>
    
    <div class="debug-info">
        <h3>Chart Data Debug:</h3>
        <pre id="debug-data"></pre>
    </div>

    <div class="chart-container">
        <h3>Revenue vs Expenses Chart</h3>
        <canvas id="testChart" style="width: 100%; height: 300px;"></canvas>
    </div>

    <div class="chart-container">
        <h3>Sales Status Chart</h3>
        <canvas id="salesChart" style="width: 100%; height: 300px;"></canvas>
    </div>

    <script>
        // Debug: Log Chart.js version
        console.log('Chart.js Version:', Chart.version);

        // Chart data from server
        const chartData = @json($chartData ?? []);
        
        // Debug: Display chart data
        document.getElementById('debug-data').textContent = JSON.stringify(chartData, null, 2);
        console.log('Chart Data:', chartData);

        // Test Chart 1: Revenue vs Expenses
        const ctx1 = document.getElementById('testChart').getContext('2d');
        try {
            const revenueChart = new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: chartData.monthlyFinancials?.labels || ['Jan', 'Feb', 'Mar'],
                    datasets: [{
                        label: 'Revenue',
                        data: chartData.monthlyFinancials?.revenue || [1000, 1500, 2000],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Expenses',
                        data: chartData.monthlyFinancials?.expenses || [800, 1200, 1800],
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            console.log('Revenue chart created successfully');
        } catch (error) {
            console.error('Error creating revenue chart:', error);
            document.getElementById('testChart').parentElement.innerHTML += '<p style="color: red;">Error: ' + error.message + '</p>';
        }

        // Test Chart 2: Sales Status
        const ctx2 = document.getElementById('salesChart').getContext('2d');
        try {
            const salesChart = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: chartData.salesByStatus?.labels || ['Completed', 'Pending', 'Failed'],
                    datasets: [{
                        data: chartData.salesByStatus?.data || [150, 30, 5],
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
            console.log('Sales chart created successfully');
        } catch (error) {
            console.error('Error creating sales chart:', error);
            document.getElementById('salesChart').parentElement.innerHTML += '<p style="color: red;">Error: ' + error.message + '</p>';
        }
    </script>
</body>
</html>
