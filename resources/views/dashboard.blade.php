@extends('layouts.app')

@section('title', 'Dashboard - Analytics Overview')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Farm Analytics Dashboard</h1>
                    <p class="text-gray-600 text-sm sm:text-base">Welcome! Here's what's happening on your farm today.</p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 w-fit">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                        Live
                    </span>
                    <span class="text-xs sm:text-sm text-gray-500">Updated: {{ now()->format('M d, H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6">
            <!-- Revenue Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                <div class="p-4 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">ZMW {{ number_format(\App\Models\Sale::sum('total_amount'), 0) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                <div class="p-4 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 3m0 10a2 2 0 11-4 0 2 2 0 014 0zM17 21a2 2 0 100-4 2 2 0 000 4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Sales</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ \App\Models\Sale::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                <div class="p-4 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Products</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ \App\Models\Product::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incubation Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-300">
                <div class="p-4 sm:p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"></path>
                            </svg>
                        </div>
                        <div class="ml-4 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Active Batches</dt>
                                <dd class="text-lg sm:text-xl font-medium text-gray-900">{{ \App\Models\Incubation::count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Monthly Income vs Expense Chart -->
            <div class="lg:col-span-2 xl:col-span-2 bg-white shadow rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Monthly Income vs Expenses</h2>
                        <p class="text-sm text-gray-500">Last 12 months trend</p>
                    </div>
                    <div class="h-64 sm:h-80">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Expenses by Category Pie Chart -->
            <div class="bg-white shadow rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Expenses by Category</h2>
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    </div>
                    <div class="h-64 sm:h-80 flex items-center justify-center">
                        <canvas id="expensesPieChart" class="max-w-full max-h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Overview and Quick Actions Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Financial Overview -->
            <div class="lg:col-span-2 bg-white shadow rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Financial Overview</h2>
                            <p class="text-sm text-gray-500 mt-1">Revenue vs Expenses</p>
                        </div>
                    </div>

                    @php
                        $totalRevenue = \App\Models\Sale::sum('total_amount');
                        $totalExpenses = \App\Models\Purchase::sum('total_amount');
                        $salesCount = \App\Models\Sale::count();
                        $purchaseCount = \App\Models\Purchase::count();
                    @endphp

                    <div class="space-y-4 sm:space-y-6">
                        <!-- Summary Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-green-50 rounded-lg p-3 sm:p-4 text-center">
                                <h3 class="text-xl sm:text-2xl font-bold text-green-600">ZMW {{ number_format($totalRevenue, 0) }}</h3>
                                <p class="text-sm text-gray-600 font-medium">Total Revenue</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $salesCount }} transactions</p>
                            </div>
                            <div class="bg-red-50 rounded-lg p-3 sm:p-4 text-center">
                                <h3 class="text-xl sm:text-2xl font-bold text-red-600">ZMW {{ number_format($totalExpenses, 0) }}</h3>
                                <p class="text-sm text-gray-600 font-medium">Total Expenses</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $purchaseCount }} purchases</p>
                            </div>
                        </div>

                        <!-- Visual Comparison -->
                        <div class="space-y-4">
                            @php
                                $maxAmount = max($totalRevenue, $totalExpenses, 1);
                                $revenueWidth = ($totalRevenue / $maxAmount) * 100;
                                $expensesWidth = ($totalExpenses / $maxAmount) * 100;
                            @endphp
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-green-600">Revenue</span>
                                    <span class="text-xs text-gray-500">{{ number_format($revenueWidth, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-green-500 h-3 rounded-full transition-all duration-500" style="width: {{ $revenueWidth }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-red-600">Expenses</span>
                                    <span class="text-xs text-gray-500">{{ number_format($expensesWidth, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-red-500 h-3 rounded-full transition-all duration-500" style="width: {{ $expensesWidth }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="p-4 sm:p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="#" class="block w-full text-left px-3 sm:px-4 py-2 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">Add New Sale</span>
                            </div>
                        </a>
                        <a href="#" class="block w-full text-left px-3 sm:px-4 py-2 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">Add Product</span>
                            </div>
                        </a>
                        <a href="#" class="block w-full text-left px-3 sm:px-4 py-2 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-yellow-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"></path>
                                </svg>
                                <span class="text-sm font-medium text-gray-900">New Incubation</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incubation Progress Chart -->
        <div class="bg-white shadow rounded-lg mb-6 sm:mb-8">
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Incubation Progress</h2>
                        <p class="text-sm text-gray-500 mt-1">Track your hatching success rates</p>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Active Monitoring
                        </span>
                    </div>
                </div>
                <div class="h-64 sm:h-80">
                    <canvas id="incubationChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <div class="bg-white shadow rounded-lg">
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2 sm:mb-0">Recent Activity</h2>
                    <button class="text-sm text-blue-600 hover:text-blue-800 font-medium w-fit">View All</button>
                </div>
                <div class="space-y-3">
                    @php
                        $recentSales = \App\Models\Sale::latest()->take(5)->get();
                    @endphp
                    
                    @if($recentSales->count() > 0)
                        @foreach($recentSales as $sale)
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-gray-50 rounded-lg space-y-2 sm:space-y-0">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Sale #{{ $sale->id }}</p>
                                        <p class="text-xs text-gray-500">ZMW {{ number_format($sale->total_amount, 2) }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 sm:ml-4">{{ $sale->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-center">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get chart data from PHP
    @php
        // Monthly Income vs Expense data for last 12 months
        $monthlyData = [];
        $categories = ['Feed', 'Equipment', 'Medicine', 'Labor', 'Utilities', 'Other'];
        $expensesByCategory = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyRevenue = \App\Models\Sale::whereYear('created_at', $month->year)
                                           ->whereMonth('created_at', $month->month)
                                           ->sum('total_amount');
            $monthlyExpenses = \App\Models\Purchase::whereYear('created_at', $month->year)
                                                 ->whereMonth('created_at', $month->month)
                                                 ->sum('total_amount');
            
            $monthlyData[] = [
                'month' => $month->format('M Y'),
                'revenue' => $monthlyRevenue,
                'expenses' => $monthlyExpenses
            ];
        }
        
        // Simulate expense categories (you can replace this with actual data)
        foreach ($categories as $category) {
            $expensesByCategory[$category] = rand(1000, 50000);
        }
        
        // Incubation data
        $incubationBatches = \App\Models\Incubation::select('id', 'eggs_placed', 'start_date', 'created_at')
                                                  ->orderBy('start_date', 'desc')
                                                  ->take(10)
                                                  ->get();
    @endphp
    
    const monthlyData = @json($monthlyData);
    const expensesByCategory = @json($expensesByCategory);
    const incubationBatches = @json($incubationBatches);
    
    // Monthly Income vs Expense Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyData.map(d => d.month),
            datasets: [{
                label: 'Revenue',
                data: monthlyData.map(d => d.revenue),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                fill: true,
                tension: 0.4
            }, {
                label: 'Expenses',
                data: monthlyData.map(d => d.expenses),
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ZMW ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'ZMW ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
    
    // Expenses Pie Chart
    const expensesCtx = document.getElementById('expensesPieChart').getContext('2d');
    new Chart(expensesCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(expensesByCategory),
            datasets: [{
                data: Object.values(expensesByCategory),
                backgroundColor: [
                    '#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6', '#6B7280'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ZMW ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
    
    // Incubation Progress Chart
    const incubationCtx = document.getElementById('incubationChart').getContext('2d');
    new Chart(incubationCtx, {
        type: 'bar',
        data: {
            labels: incubationBatches.map((batch, index) => `Batch ${batch.id}`),
            datasets: [{
                label: 'Eggs Placed',
                data: incubationBatches.map(batch => batch.eggs_placed),
                backgroundColor: 'rgba(245, 158, 11, 0.8)',
                borderColor: 'rgba(245, 158, 11, 1)',
                borderWidth: 1,
                borderRadius: 4
            }, {
                label: 'Expected Hatch',
                data: incubationBatches.map(batch => Math.floor(batch.eggs_placed * 0.85)), // 85% hatch rate
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: 'rgba(34, 197, 94, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        afterLabel: function(context) {
                            if (context.datasetIndex === 1) {
                                return 'Estimated 85% hatch rate';
                            }
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 50
                    }
                }
            }
        }
    });
    
    // Make charts responsive to window resize
    window.addEventListener('resize', function() {
        Chart.instances.forEach(chart => {
            chart.resize();
        });
    });
});
</script>
@endpush
@endsection
