<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HarvestInn - Minimal Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f8f9fa; 
            padding: 20px;
        }
        .container { max-width: 1200px; margin: 0 auto; }
        .header { 
            background: linear-gradient(135deg, #28a745, #20c997); 
            color: white; 
            padding: 30px; 
            border-radius: 12px; 
            margin-bottom: 30px; 
            text-align: center;
        }
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .stat-card { 
            background: white; 
            padding: 25px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            text-align: center;
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-number { 
            font-size: 2.5rem; 
            font-weight: bold; 
            color: #28a745; 
            margin-bottom: 10px; 
        }
        .stat-label { 
            color: #6c757d; 
            font-size: 1.1rem; 
        }
        .chart-section { 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            margin-bottom: 30px;
        }
        .chart-title { 
            font-size: 1.5rem; 
            margin-bottom: 20px; 
            color: #343a40; 
        }
        .bar-chart { 
            display: flex; 
            align-items: end; 
            height: 300px; 
            gap: 20px; 
            padding: 20px 0; 
            border-bottom: 2px solid #dee2e6; 
        }
        .bar { 
            flex: 1; 
            background: linear-gradient(to top, #28a745, #20c997); 
            border-radius: 6px 6px 0 0; 
            transition: all 0.3s ease; 
            cursor: pointer; 
            position: relative;
            min-height: 20px;
        }
        .bar:hover { 
            transform: scaleY(1.05); 
            background: linear-gradient(to top, #20c997, #17a2b8); 
        }
        .bar-label { 
            text-align: center; 
            margin-top: 10px; 
            font-weight: 500; 
            color: #495057; 
        }
        .bar-value { 
            position: absolute; 
            top: -25px; 
            left: 50%; 
            transform: translateX(-50%); 
            background: #343a40; 
            color: white; 
            padding: 5px 8px; 
            border-radius: 4px; 
            font-size: 0.9rem; 
            opacity: 0; 
            transition: opacity 0.3s ease;
        }
        .bar:hover .bar-value { opacity: 1; }
        .progress-section { 
            background: white; 
            padding: 30px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
        .progress-item { 
            margin-bottom: 20px; 
        }
        .progress-header { 
            display: flex; 
            justify-content: between; 
            margin-bottom: 8px; 
        }
        .progress-bar-container { 
            height: 12px; 
            background: #e9ecef; 
            border-radius: 6px; 
            overflow: hidden; 
        }
        .progress-bar { 
            height: 100%; 
            background: linear-gradient(90deg, #28a745, #20c997); 
            border-radius: 6px; 
            transition: width 1s ease-in-out; 
        }
        .animation { animation: slideInUp 0.6s ease-out; }
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header animation">
            <h1>🌾 HarvestInn Farm Management Dashboard</h1>
            <p>Your Complete Farm Analytics Overview</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card animation" style="animation-delay: 0.1s;">
                <div class="stat-number">{{ $salesCount }}</div>
                <div class="stat-label">Total Sales</div>
            </div>
            <div class="stat-card animation" style="animation-delay: 0.2s;">
                <div class="stat-number">ZMW {{ number_format($revenue, 0) }}</div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-card animation" style="animation-delay: 0.3s;">
                <div class="stat-number">{{ $products }}</div>
                <div class="stat-label">Products</div>
            </div>
            <div class="stat-card animation" style="animation-delay: 0.4s;">
                <div class="stat-number">{{ $purchases }}</div>
                <div class="stat-label">Purchases</div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="chart-section animation" style="animation-delay: 0.5s;">
            <h2 class="chart-title">📊 Monthly Revenue Trend</h2>
            <div class="bar-chart">
                @php $maxRevenue = collect($monthlyData)->max('revenue'); @endphp
                @foreach($monthlyData as $data)
                    @php 
                        $height = $maxRevenue > 0 ? ($data['revenue'] / $maxRevenue) * 250 : 20;
                    @endphp
                    <div class="bar" style="height: {{ $height }}px;">
                        <div class="bar-value">ZMW {{ number_format($data['revenue'], 0) }}</div>
                    </div>
                @endforeach
            </div>
            <div style="display: flex; gap: 20px; margin-top: 10px;">
                @foreach($monthlyData as $data)
                    <div class="bar-label" style="flex: 1;">{{ $data['month'] }}</div>
                @endforeach
            </div>
        </div>

        <!-- Progress Indicators -->
        <div class="progress-section animation" style="animation-delay: 0.6s;">
            <h2 class="chart-title">📈 Farm Performance Metrics</h2>
            
            <div class="progress-item">
                <div class="progress-header">
                    <span>Sales Growth</span>
                    <strong>{{ $salesCount > 100 ? 'Excellent' : ($salesCount > 50 ? 'Good' : 'Growing') }}</strong>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: {{ min(($salesCount / 300) * 100, 100) }}%;"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-header">
                    <span>Revenue Target</span>
                    <strong>ZMW {{ number_format($revenue, 0) }}</strong>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: {{ min(($revenue / 100000) * 100, 100) }}%; background: linear-gradient(90deg, #007bff, #0056b3);"></div>
                </div>
            </div>

            <div class="progress-item">
                <div class="progress-header">
                    <span>Product Catalog</span>
                    <strong>{{ $products }} Products</strong>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar" style="width: {{ min(($products / 20) * 100, 100) }}%; background: linear-gradient(90deg, #ffc107, #e0a800);"></div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 40px; color: #6c757d;">
            <p>🚀 HarvestInn Dashboard • Last updated: {{ now()->format('M d, Y H:i') }}</p>
        </div>
    </div>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Animate progress bars
            setTimeout(() => {
                const progressBars = document.querySelectorAll('.progress-bar');
                progressBars.forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 100);
                });
            }, 1000);

            // Add click events to stat cards
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-5px)';
                    }, 150);
                });
            });

            console.log('✅ Minimal Dashboard loaded successfully!');
            console.log('📊 Data displayed:', {
                sales: {{ $salesCount }},
                revenue: {{ $revenue }},
                products: {{ $products }},
                purchases: {{ $purchases }}
            });
        });
    </script>
</body>
</html>
