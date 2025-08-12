@extends('layouts.app')

@section('title', 'Dashboard - Working Charts')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col">
            <h4 class="page-title">Farm Analytics Dashboard</h4>
            <p class="text-muted">Complete overview of your farm operations</p>
        </div>
        <div class="col-auto">
            <span class="badge bg-success">Last updated: {{ now()->format('M d, Y H:i') }}</span>
        </div>
    </div>

    <!-- Key Performance Indicators -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-white mb-0">ZMW {{ number_format($salesStats['total_revenue'] ?? 0, 0) }}</h4>
                            <h6 class="text-white-50 mb-0">Total Revenue</h6>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-dollar-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-white mb-0">{{ $salesStats['total_sales'] ?? 0 }}</h4>
                            <h6 class="text-white-50 mb-0">Total Sales</h6>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-gradient-warning text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-white mb-0">{{ $stockStats['total'] ?? 0 }}</h4>
                            <h6 class="text-white-50 mb-0">Total Products</h6>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card bg-gradient-info text-white h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-white mb-0">{{ $incubationStats['active_batches'] ?? 0 }}</h4>
                            <h6 class="text-white-50 mb-0">Active Batches</h6>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-egg fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Revenue Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">📊 Monthly Revenue Trend</h5>
                    <small class="text-muted">Revenue over the last 6 months</small>
                </div>
                <div class="card-body">
                    <div style="height: 300px; display: flex; align-items: end; gap: 15px; padding: 20px 0; border-bottom: 2px solid #dee2e6;">
                        @if(isset($chartData['monthlyFinancials']['revenue']) && !empty($chartData['monthlyFinancials']['revenue']))
                            @php 
                                $revenues = $chartData['monthlyFinancials']['revenue'];
                                $labels = $chartData['monthlyFinancials']['labels'];
                                $maxRevenue = max($revenues);
                            @endphp
                            @foreach($revenues as $index => $revenue)
                                @php 
                                    $height = $maxRevenue > 0 ? ($revenue / $maxRevenue) * 250 : 20;
                                    $label = $labels[$index] ?? "Month $index";
                                @endphp
                                <div style="flex: 1; display: flex; flex-direction: column; align-items: center;">
                                    <div style="
                                        width: 100%; 
                                        height: {{ $height }}px; 
                                        background: linear-gradient(to top, #28a745, #20c997); 
                                        border-radius: 6px 6px 0 0; 
                                        position: relative;
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                    " 
                                    onmouseover="this.style.transform='scaleY(1.05)'; this.style.background='linear-gradient(to top, #20c997, #17a2b8)'"
                                    onmouseout="this.style.transform='scaleY(1)'; this.style.background='linear-gradient(to top, #28a745, #20c997)'"
                                    title="ZMW {{ number_format($revenue, 2) }}">
                                    </div>
                                    <small class="mt-2 text-center" style="font-size: 0.8rem;">{{ $label }}</small>
                                </div>
                            @endforeach
                        @else
                            <div class="w-100 text-center text-muted">
                                <i class="fas fa-chart-line fa-3x mb-3"></i>
                                <p>No revenue data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Status -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">📈 Sales Status</h5>
                    <small class="text-muted">Payment status breakdown</small>
                </div>
                <div class="card-body">
                    @if(isset($chartData['salesByStatus']['data']))
                        @php
                            $completed = $chartData['salesByStatus']['data'][0] ?? 0;
                            $pending = $chartData['salesByStatus']['data'][1] ?? 0;
                            $failed = $chartData['salesByStatus']['data'][2] ?? 0;
                            $total = $completed + $pending + $failed;
                        @endphp
                        
                        @if($total > 0)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-circle text-success"></i> Completed</span>
                                    <strong>{{ $completed }} ({{ number_format(($completed / $total) * 100, 1) }}%)</strong>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-success" style="width: {{ ($completed / $total) * 100 }}%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-circle text-warning"></i> Pending</span>
                                    <strong>{{ $pending }} ({{ number_format(($pending / $total) * 100, 1) }}%)</strong>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: {{ ($pending / $total) * 100 }}%"></div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span><i class="fas fa-circle text-danger"></i> Failed</span>
                                    <strong>{{ $failed }} ({{ number_format(($failed / $total) * 100, 1) }}%)</strong>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-danger" style="width: {{ ($failed / $total) * 100 }}%"></div>
                                </div>
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-chart-pie fa-3x mb-3"></i>
                                <p>No sales data available</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <p>Chart data not available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Charts Row -->
    <div class="row mb-4">
        <!-- Daily Sales -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">📅 Daily Sales Trend</h5>
                    <small class="text-muted">Last 10 days performance</small>
                </div>
                <div class="card-body">
                    <div style="height: 200px; display: flex; align-items: end; gap: 8px; padding: 10px 0;">
                        @if(isset($chartData['dailySalesTrend']['data']) && !empty($chartData['dailySalesTrend']['data']))
                            @php 
                                $dailyData = array_slice($chartData['dailySalesTrend']['data'], -10); // Last 10 days
                                $maxDaily = !empty($dailyData) ? max($dailyData) : 1;
                            @endphp
                            @foreach($dailyData as $index => $value)
                                @php $height = $maxDaily > 0 ? ($value / $maxDaily) * 170 : 5; @endphp
                                <div style="
                                    flex: 1; 
                                    height: {{ $height }}px; 
                                    background: linear-gradient(to top, #007bff, #0056b3); 
                                    border-radius: 3px 3px 0 0;
                                    cursor: pointer;
                                    transition: all 0.3s ease;
                                " 
                                title="Day {{ $index + 1 }}: ZMW {{ number_format($value, 2) }}"
                                onmouseover="this.style.transform='scaleY(1.1)'"
                                onmouseout="this.style.transform='scaleY(1)'">
                                </div>
                            @endforeach
                        @else
                            <!-- Sample data visualization -->
                            @for($i = 0; $i < 10; $i++)
                                @php $height = rand(20, 150); @endphp
                                <div style="
                                    flex: 1; 
                                    height: {{ $height }}px; 
                                    background: linear-gradient(to top, #007bff, #0056b3); 
                                    border-radius: 3px 3px 0 0;
                                    opacity: 0.3;
                                " title="Sample data">
                                </div>
                            @endfor
                        @endif
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted">
                            @if(isset($chartData['dailySalesTrend']['data']) && !empty($chartData['dailySalesTrend']['data']))
                                Avg: ZMW {{ number_format(array_sum($dailyData) / count($dailyData), 2) }}
                            @else
                                Sample visualization
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incubation Status -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">🥚 Incubation Progress</h5>
                    <small class="text-muted">Current batch status</small>
                </div>
                <div class="card-body">
                    @if(isset($chartData['incubationProgress']['data']))
                        @php
                            $incubationData = $chartData['incubationProgress']['data'];
                            $incubationLabels = $chartData['incubationProgress']['labels'];
                            $colors = ['#007bff', '#ffc107', '#28a745', '#dc3545'];
                            $totalIncubation = array_sum($incubationData);
                        @endphp
                        
                        @if($totalIncubation > 0)
                            @foreach($incubationLabels as $index => $label)
                                @php
                                    $value = $incubationData[$index] ?? 0;
                                    $percentage = ($value / $totalIncubation) * 100;
                                    $color = $colors[$index] ?? '#6c757d';
                                @endphp
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="fas fa-circle" style="color: {{ $color }}"></i> {{ $label }}</span>
                                        <strong>{{ $value }} ({{ number_format($percentage, 1) }}%)</strong>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" 
                                             style="width: {{ $percentage }}%; background-color: {{ $color }};">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-egg fa-3x mb-3"></i>
                                <p>No incubation data available</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                            <p>Incubation data not available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">🚀 Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('sales.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus"></i> New Sale
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('products.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-box"></i> Add Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('purchases.create') }}" class="btn btn-warning w-100">
                                <i class="fas fa-shopping-bag"></i> New Purchase
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('incubations.create') }}" class="btn btn-info w-100">
                                <i class="fas fa-egg"></i> Start Incubation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Animation styles */
.progress-bar {
    transition: width 1s ease-in-out;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

/* Custom hover effects */
.chart-hover:hover {
    transform: scale(1.05);
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Working Dashboard loaded successfully!');
    
    // Add some interactive features
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = (index * 0.1) + 's';
        card.style.animation = 'fadeInUp 0.6s ease-out forwards';
    });
    
    // Log chart data for debugging
    @if(isset($chartData))
        console.log('📊 Chart data available:', @json($chartData));
    @else
        console.log('⚠️ No chart data provided');
    @endif
});

// Keyframe animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection
