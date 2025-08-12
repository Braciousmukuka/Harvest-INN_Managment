<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Charts</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f8f9fa;
        }
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
        }
        .card { 
            background: white; 
            border-radius: 8px; 
            padding: 20px; 
            margin: 20px 0; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .chart-title { 
            font-size: 18px; 
            font-weight: bold; 
            margin-bottom: 15px; 
            color: #333;
        }
        
        /* Simple Bar Chart */
        .bar-chart { 
            display: flex; 
            align-items: end; 
            height: 200px; 
            gap: 10px; 
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .bar { 
            background: linear-gradient(to top, #007bff, #0056b3); 
            border-radius: 4px 4px 0 0; 
            min-width: 30px;
            color: white;
            display: flex;
            align-items: end;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .bar:hover { 
            transform: scaleY(1.1); 
            opacity: 0.8;
        }
        
        /* Simple Pie Chart */
        .pie-chart { 
            width: 200px; 
            height: 200px; 
            border-radius: 50%; 
            background: conic-gradient(
                #28a745 0% 60%,
                #ffc107 60% 85%,
                #dc3545 85% 100%
            );
            margin: 20px auto;
            position: relative;
        }
        .pie-center { 
            position: absolute; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            background: white; 
            border-radius: 50%; 
            width: 100px; 
            height: 100px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Progress Bars */
        .progress { 
            background: #e9ecef; 
            height: 20px; 
            border-radius: 10px; 
            overflow: hidden; 
            margin: 10px 0;
        }
        .progress-bar { 
            height: 100%; 
            background: linear-gradient(90deg, #28a745, #34ce57); 
            border-radius: 10px;
            transition: width 2s ease-in-out;
        }
        
        /* Animation */
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card { animation: slideIn 0.6s ease-out; }
        
        .legend { 
            display: flex; 
            gap: 20px; 
            justify-content: center; 
            margin-top: 15px;
        }
        .legend-item { 
            display: flex; 
            align-items: center; 
            gap: 5px;
        }
        .legend-color { 
            width: 16px; 
            height: 16px; 
            border-radius: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center; color: #333; margin-bottom: 30px;">Chart Display Test</h1>
        
        <!-- Test 1: Simple Bar Chart -->
        <div class="card">
            <div class="chart-title">Test 1: Simple Bar Chart</div>
            <div class="bar-chart">
                <div class="bar" style="height: 120px;">Jan<br>25K</div>
                <div class="bar" style="height: 80px;">Feb<br>18K</div>
                <div class="bar" style="height: 150px;">Mar<br>30K</div>
                <div class="bar" style="height: 100px;">Apr<br>22K</div>
                <div class="bar" style="height: 170px;">May<br>35K</div>
            </div>
        </div>
        
        <!-- Test 2: Simple Pie Chart -->
        <div class="card">
            <div class="chart-title">Test 2: Simple Pie Chart</div>
            <div style="text-align: center;">
                <div class="pie-chart">
                    <div class="pie-center">Total<br>271</div>
                </div>
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background: #28a745;"></div>
                        <span>Completed (60%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background: #ffc107;"></div>
                        <span>Pending (25%)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background: #dc3545;"></div>
                        <span>Failed (15%)</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Test 3: Progress Bars -->
        <div class="card">
            <div class="chart-title">Test 3: Progress Bars</div>
            <div>
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>Revenue</span>
                        <strong>ZMW 45,000 (75%)</strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 75%; background: linear-gradient(90deg, #28a745, #34ce57);"></div>
                    </div>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>Expenses</span>
                        <strong>ZMW 30,000 (50%)</strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 50%; background: linear-gradient(90deg, #dc3545, #ff4757);"></div>
                    </div>
                </div>
                
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <span>Profit</span>
                        <strong>ZMW 15,000 (25%)</strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" style="width: 25%; background: linear-gradient(90deg, #007bff, #0056b3);"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Test 4: Real Data from Database -->
        <div class="card">
            <div class="chart-title">Test 4: Real Database Data</div>
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; font-family: monospace;">
                <p><strong>Sales Count:</strong> {{ \App\Models\Sale::count() }}</p>
                <p><strong>Purchase Count:</strong> {{ \App\Models\Purchase::count() }}</p>
                <p><strong>Product Count:</strong> {{ \App\Models\Product::count() }}</p>
                <p><strong>Incubation Count:</strong> {{ \App\Models\Incubation::count() }}</p>
                <p><strong>Total Revenue:</strong> ZMW {{ number_format(\App\Models\Sale::sum('total_amount'), 2) }}</p>
                <p><strong>Total Expenses:</strong> ZMW {{ number_format(\App\Models\Purchase::sum('total_amount'), 2) }}</p>
            </div>
        </div>
        
        <!-- Test 5: Dynamic Chart with Real Data -->
        <div class="card">
            <div class="chart-title">Test 5: Dynamic Chart with Real Data</div>
            <div class="bar-chart">
                @php
                    $salesCount = \App\Models\Sale::count();
                    $purchaseCount = \App\Models\Purchase::count();
                    $productCount = \App\Models\Product::count();
                    $incubationCount = \App\Models\Incubation::count();
                    $maxCount = max($salesCount, $purchaseCount, $productCount, $incubationCount);
                @endphp
                
                <div class="bar" style="height: {{ $maxCount > 0 ? ($salesCount / $maxCount) * 150 : 10 }}px;">
                    Sales<br>{{ $salesCount }}
                </div>
                <div class="bar" style="height: {{ $maxCount > 0 ? ($purchaseCount / $maxCount) * 150 : 10 }}px; background: linear-gradient(to top, #dc3545, #ff4757);">
                    Purchases<br>{{ $purchaseCount }}
                </div>
                <div class="bar" style="height: {{ $maxCount > 0 ? ($productCount / $maxCount) * 150 : 10 }}px; background: linear-gradient(to top, #ffc107, #ffda6a);">
                    Products<br>{{ $productCount }}
                </div>
                <div class="bar" style="height: {{ $maxCount > 0 ? ($incubationCount / $maxCount) * 150 : 10 }}px; background: linear-gradient(to top, #28a745, #34ce57);">
                    Incubations<br>{{ $incubationCount }}
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin: 40px 0; padding: 20px; background: #e8f5e8; border-radius: 8px;">
            <h3 style="color: #28a745; margin: 0;">✓ If you can see this message and the charts above, the charts are working!</h3>
            <p style="margin: 10px 0 0 0; color: #666;">This confirms that chart rendering is functional in your browser.</p>
        </div>
    </div>
    
    <script>
        console.log('✓ Test charts page loaded successfully');
        console.log('✓ Sales count:', {{ $salesCount ?? 0 }});
        console.log('✓ Purchase count:', {{ $purchaseCount ?? 0 }});
        console.log('✓ Product count:', {{ $productCount ?? 0 }});
        console.log('✓ Incubation count:', {{ $incubationCount ?? 0 }});
        
        // Add some animation on load
        setTimeout(() => {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        }, 500);
    </script>
</body>
</html>
