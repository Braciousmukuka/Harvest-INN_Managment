@extends('layouts.app')

@section('title', 'CSS Dashboard Test')

@section('content')
<div class="container-fluid p-4">
    <h1 class="mb-4">CSS Charts Dashboard Test</h1>
    
    <!-- Debug Information -->
    <div class="alert alert-info mb-4">
        <h4>Debug Information:</h4>
        <p><strong>Sales:</strong> {{ \App\Models\Sale::count() }} records</p>
        <p><strong>Revenue:</strong> ZMW {{ number_format(\App\Models\Sale::sum('total_amount'), 2) }}</p>
        <p><strong>Purchases:</strong> {{ \App\Models\Purchase::count() }} records</p>
        <p><strong>Products:</strong> {{ \App\Models\Product::count() }} records</p>
    </div>
    
    <!-- Test 1: Simple Colored Boxes -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Test 1: Basic Colored Elements</h5>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 20px;">
                <div style="width: 100px; height: 100px; background: #007bff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                    Sales<br>{{ \App\Models\Sale::count() }}
                </div>
                <div style="width: 100px; height: 100px; background: #28a745; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                    Products<br>{{ \App\Models\Product::count() }}
                </div>
                <div style="width: 100px; height: 100px; background: #dc3545; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                    Purchases<br>{{ \App\Models\Purchase::count() }}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Test 2: Simple Bar Chart -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Test 2: Simple Bar Chart</h5>
        </div>
        <div class="card-body">
            @php
                $salesCount = \App\Models\Sale::count();
                $purchaseCount = \App\Models\Purchase::count();
                $productCount = \App\Models\Product::count();
                $maxCount = max($salesCount, $purchaseCount, $productCount, 1);
            @endphp
            
            <div style="display: flex; align-items: end; height: 200px; gap: 20px; background: #f8f9fa; padding: 20px; border-radius: 8px;">
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <div style="width: 60px; height: {{ ($salesCount / $maxCount) * 150 }}px; background: linear-gradient(to top, #007bff, #0056b3); border-radius: 4px 4px 0 0; margin-bottom: 10px;"></div>
                    <span style="font-size: 12px; font-weight: bold;">Sales ({{ $salesCount }})</span>
                </div>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <div style="width: 60px; height: {{ ($purchaseCount / $maxCount) * 150 }}px; background: linear-gradient(to top, #dc3545, #ff4757); border-radius: 4px 4px 0 0; margin-bottom: 10px;"></div>
                    <span style="font-size: 12px; font-weight: bold;">Purchases ({{ $purchaseCount }})</span>
                </div>
                <div style="display: flex; flex-direction: column; align-items: center;">
                    <div style="width: 60px; height: {{ ($productCount / $maxCount) * 150 }}px; background: linear-gradient(to top, #28a745, #34ce57); border-radius: 4px 4px 0 0; margin-bottom: 10px;"></div>
                    <span style="font-size: 12px; font-weight: bold;">Products ({{ $productCount }})</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Test 3: Simple Pie Chart -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Test 3: Simple Pie Chart</h5>
        </div>
        <div class="card-body">
            @php
                $completed = \App\Models\Sale::where('payment_status', 'completed')->count();
                $pending = \App\Models\Sale::where('payment_status', 'pending')->count();
                $failed = \App\Models\Sale::where('payment_status', 'failed')->count();
                $total = $completed + $pending + $failed;
            @endphp
            
            @if($total > 0)
                @php
                    $completedPercent = ($completed / $total) * 100;
                    $pendingPercent = ($pending / $total) * 100;
                    $failedPercent = ($failed / $total) * 100;
                @endphp
                
                <div style="text-align: center;">
                    <div style="width: 200px; height: 200px; border-radius: 50%; margin: 0 auto 20px; background: conic-gradient(
                        #28a745 0% {{ $completedPercent }}%,
                        #ffc107 {{ $completedPercent }}% {{ $completedPercent + $pendingPercent }}%,
                        #dc3545 {{ $completedPercent + $pendingPercent }}% 100%
                    ); position: relative;">
                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 50%; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            {{ $total }}<br><small style="font-size: 10px;">Total Sales</small>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                        <div><span style="color: #28a745; font-size: 18px;">●</span> Completed: {{ $completed }}</div>
                        <div><span style="color: #ffc107; font-size: 18px;">●</span> Pending: {{ $pending }}</div>
                        <div><span style="color: #dc3545; font-size: 18px;">●</span> Failed: {{ $failed }}</div>
                    </div>
                </div>
            @else
                <div style="text-align: center; color: #666;">
                    <p>No sales data available for pie chart</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Test 4: Progress Bars -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Test 4: Progress Bars</h5>
        </div>
        <div class="card-body">
            @php
                $totalRevenue = \App\Models\Sale::sum('total_amount');
                $totalExpenses = \App\Models\Purchase::sum('total_amount');
                $maxAmount = max($totalRevenue, $totalExpenses, 1);
            @endphp
            
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span><strong>Revenue</strong></span>
                    <span>ZMW {{ number_format($totalRevenue, 2) }}</span>
                </div>
                <div style="background: #e9ecef; height: 30px; border-radius: 15px; overflow: hidden;">
                    <div style="height: 100%; width: {{ ($totalRevenue / $maxAmount) * 100 }}%; background: linear-gradient(90deg, #28a745, #34ce57); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                        {{ number_format(($totalRevenue / $maxAmount) * 100, 1) }}%
                    </div>
                </div>
            </div>
            
            <div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span><strong>Expenses</strong></span>
                    <span>ZMW {{ number_format($totalExpenses, 2) }}</span>
                </div>
                <div style="background: #e9ecef; height: 30px; border-radius: 15px; overflow: hidden;">
                    <div style="height: 100%; width: {{ ($totalExpenses / $maxAmount) * 100 }}%; background: linear-gradient(90deg, #dc3545, #ff4757); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                        {{ number_format(($totalExpenses / $maxAmount) * 100, 1) }}%
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Success Message -->
    <div class="alert alert-success">
        <h4>✓ Chart Display Test</h4>
        <p><strong>If you can see the colored charts above, then CSS charts are working correctly!</strong></p>
        <p>This confirms that:</p>
        <ul>
            <li>CSS gradients are supported</li>
            <li>Conic gradients (pie charts) are supported</li>
            <li>Flexbox layouts are working</li>
            <li>Database data is being retrieved correctly</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
console.log('✓ CSS Dashboard loaded');
console.log('✓ Sales count:', {{ \App\Models\Sale::count() }});
console.log('✓ Total revenue:', {{ \App\Models\Sale::sum('total_amount') }});
console.log('✓ Purchase count:', {{ \App\Models\Purchase::count() }});
console.log('✓ Product count:', {{ \App\Models\Product::count() }});

// Alert to confirm JavaScript is working
setTimeout(() => {
    console.log('✓ CSS Dashboard fully initialized');
}, 1000);
</script>
@endpush
