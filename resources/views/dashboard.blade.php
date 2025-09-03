@extends('layouts.app')

@section('title', 'Dashboard - Analytics Overview')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Dashboard - Analytics Overview</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                        <i data-feather="plus" class="me-2" style="width: 16px; height: 16px;"></i>
                        <span class="d-none d-sm-inline">New Sale</span>
                        <span class="d-sm-none">Sale</span>
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                        <i data-feather="package" class="me-2" style="width: 16px; height: 16px;"></i>
                        <span class="d-none d-sm-inline">Add Product</span>
                        <span class="d-sm-none">Product</span>
                    </a>
                    <a href="{{ route('incubations.create') }}" class="btn btn-warning btn-sm d-flex align-items-center">
                        <i data-feather="sun" class="me-2" style="width: 16px; height: 16px;"></i>
                        <span class="d-none d-sm-inline">New Incubation</span>
                        <span class="d-sm-none">Incubation</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">ZMW {{ number_format($salesStats['total_revenue'] ?? 0, 0) }}</h4>
                            <h6 class="text-muted m-b-0">Total Amount Made (Total Revenue)</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="dollar-sign" class="f-28 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-red">ZMW {{ number_format($purchaseStats['total_amount'] ?? 0, 0) }}</h4>
                            <h6 class="text-muted m-b-0">Total Expenses</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="shopping-bag" class="f-28 text-c-red"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            @php
                                $currentYear = date('Y');
                                $currentMonth = sprintf('%02d', date('n'));
                                $currentMonthRevenue = \App\Models\Sale::whereRaw("strftime('%Y', created_at) = ?", [$currentYear])
                                                                    ->whereRaw("strftime('%m', created_at) = ?", [$currentMonth])
                                                                    ->sum('total_amount') ?? 0;
                            @endphp
                            <h4 class="text-c-blue">ZMW {{ number_format($currentMonthRevenue, 0) }}</h4>
                            <h6 class="text-muted m-b-0">Current Month Income</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="trending-up" class="f-28 text-c-blue"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Second Row Cards -->
    <div class="row mb-4">
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            @php
                                $currentYear = date('Y');
                                $currentMonth = sprintf('%02d', date('n'));
                                $currentMonthExpenses = \App\Models\Purchase::whereRaw("strftime('%Y', created_at) = ?", [$currentYear])
                                                                          ->whereRaw("strftime('%m', created_at) = ?", [$currentMonth])
                                                                          ->sum('total_amount') ?? 0;
                            @endphp
                            <h4 class="text-c-yellow">ZMW {{ number_format($currentMonthExpenses, 0) }}</h4>
                            <h6 class="text-muted m-b-0">Current Month Expenses</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="credit-card" class="f-28 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-purple">{{ $stockStats['total'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Total Products</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="package" class="f-28 text-c-purple"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-orange">{{ $incubationStats['active_batches'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Active Batches</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="sun" class="f-28 text-c-orange"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
        <!-- Main Content Area -->
    <div class="container-fluid">
        <!-- Charts Section -->
        <div class="row mb-4">
            <!-- Monthly Income vs Expense Chart -->
            <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="card-title mb-1">Monthly Income vs Expenses</h5>
                                <p class="text-muted small mb-0">Current year trend</p>
                            </div>
                        </div>
                        <div style="height: 300px; position: relative;">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expenses by Category Pie Chart -->
            <div class="col-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Expenses by Category</h5>
                            <div class="bg-primary rounded-circle" style="width: 12px; height: 12px;"></div>
                        </div>
                        <div style="height: 300px; position: relative;">
                            <canvas id="expensesPieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Overview and Quick Actions Row -->
        <div class="row mb-4">
            <!-- Financial Overview -->
            <div class="col-12 col-lg-8 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="card-title mb-1">Financial Overview</h5>
                                <p class="text-muted small mb-0">Revenue vs Expenses</p>
                            </div>
                        </div>

                        @php
                            $totalRevenue = \App\Models\Sale::sum('total_amount');
                            $totalExpenses = \App\Models\Purchase::sum('total_amount');
                            $salesCount = \App\Models\Sale::count();
                            $purchaseCount = \App\Models\Purchase::count();
                        @endphp

                        <!-- Summary Cards -->
                        <div class="row mb-4">
                            <div class="col-12 col-sm-6 mb-3 mb-sm-0">
                                <div class="bg-success bg-opacity-10 rounded p-3 text-center">
                                    <h4 class="text-success fw-bold mb-1">ZMW {{ number_format($totalRevenue, 0) }}</h4>
                                    <p class="text-dark small fw-medium mb-1">Total Revenue</p>
                                    <p class="text-muted" style="font-size: 0.75rem;">{{ $salesCount }} transactions</p>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="bg-danger bg-opacity-10 rounded p-3 text-center">
                                    <h4 class="text-danger fw-bold mb-1">ZMW {{ number_format($totalExpenses, 0) }}</h4>
                                    <p class="text-dark small fw-medium mb-1">Total Expenses</p>
                                    <p class="text-muted" style="font-size: 0.75rem;">{{ $purchaseCount }} purchases</p>
                                </div>
                            </div>
                        </div>

                        <!-- Visual Comparison -->
                        <div class="mb-3">
                            @php
                                $maxAmount = max($totalRevenue, $totalExpenses, 1);
                                $revenueWidth = ($totalRevenue / $maxAmount) * 100;
                                $expensesWidth = ($totalExpenses / $maxAmount) * 100;
                            @endphp
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small fw-medium text-success">Revenue</span>
                                    <span class="small text-muted">{{ number_format($revenueWidth, 1) }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ $revenueWidth }}%"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small fw-medium text-danger">Expenses</span>
                                    <span class="small text-muted">{{ number_format($expensesWidth, 1) }}%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" style="width: {{ $expensesWidth }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Quick Actions</h5>
                        <div class="d-grid gap-3">
                            <a href="{{ route('sales.create') }}" class="btn btn-outline-primary text-start d-flex align-items-center p-3">
                                <i data-feather="plus" class="me-3" style="width: 20px; height: 20px;"></i>
                                <span class="fw-medium">Add New Sale</span>
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-outline-success text-start d-flex align-items-center p-3">
                                <i data-feather="package" class="me-3" style="width: 20px; height: 20px;"></i>
                                <span class="fw-medium">Add Product</span>
                            </a>
                            <a href="{{ route('incubations.create') }}" class="btn btn-outline-warning text-start d-flex align-items-center p-3">
                                <i data-feather="sun" class="me-3" style="width: 20px; height: 20px;"></i>
                                <span class="fw-medium">New Incubation</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Incubation Progress Chart -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="card-title mb-1">Incubation Progress</h5>
                                <p class="text-muted small mb-0">Track your hatching success rates</p>
                            </div>
                            <div class="mt-2 mt-sm-0">
                                <span class="badge bg-warning text-dark">Active Monitoring</span>
                            </div>
                        </div>
                        <div style="height: 300px; position: relative;">
                            <canvas id="incubationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.js"></script>
<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 1.5rem;
}

.text-c-green { color: #04a9f5 !important; }
.text-c-blue { color: #1dc4e9 !important; }
.text-c-yellow { color: #f8b425 !important; }
.text-c-red { color: #ff5252 !important; }
.text-c-purple { color: #8e24aa !important; }
.text-c-orange { color: #ff9800 !important; }

.f-28 { font-size: 28px; }
.m-b-0 { margin-bottom: 0; }

.feather {
    width: 28px;
    height: 28px;
    vertical-align: text-bottom;
}

/* Mobile responsiveness improvements */
@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 1.25rem;
    }
    
    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .f-28 {
        font-size: 24px;
    }
}

/* Chart container responsiveness */
canvas {
    max-width: 100% !important;
    height: auto !important;
}

/* Quick actions mobile improvements */
@media (max-width: 575.98px) {
    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }
}
</style>
<script>
// Initialize Feather icons
feather.replace();
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Income vs Expenses Chart
    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        @php
            // Get monthly sales data for current year (SQLite compatible)
            $currentYear = date('Y');
            $monthlySales = [];
            $monthlyPurchases = [];
            
            for ($month = 1; $month <= 12; $month++) {
                $salesTotal = \App\Models\Sale::whereRaw("strftime('%Y', created_at) = ?", [$currentYear])
                                             ->whereRaw("strftime('%m', created_at) = ?", [sprintf('%02d', $month)])
                                             ->sum('total_amount') ?? 0;
                                             
                $purchasesTotal = \App\Models\Purchase::whereRaw("strftime('%Y', created_at) = ?", [$currentYear])
                                                    ->whereRaw("strftime('%m', created_at) = ?", [sprintf('%02d', $month)])
                                                    ->sum('total_amount') ?? 0;
                
                $monthlySales[] = $salesTotal;
                $monthlyPurchases[] = $purchasesTotal;
            }
        @endphp
        
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Income',
                        data: @json($monthlySales),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Expenses',
                        data: @json($monthlyPurchases),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
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
                },
                elements: {
                    point: {
                        radius: 4,
                        hoverRadius: 6
                    }
                }
            }
        });
    }

    // Expenses by Category Pie Chart
    const expensesPieCtx = document.getElementById('expensesPieChart');
    if (expensesPieCtx) {
        @php
            // Get expense categories with SQLite compatible syntax
            $expenseCategories = \App\Models\Purchase::selectRaw('category, SUM(total_amount) as total')
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->groupBy('category')
                ->pluck('total', 'category');
                
            // If no categories exist, create sample data
            if ($expenseCategories->isEmpty()) {
                $expenseCategories = collect([
                    'Feed' => 15000,
                    'Equipment' => 8000,
                    'Medicine' => 3000,
                    'Labor' => 12000,
                    'Utilities' => 5000
                ]);
            }
        @endphp
        
        new Chart(expensesPieCtx, {
            type: 'pie',
            data: {
                labels: @json($expenseCategories->keys()),
                datasets: [{
                    data: @json($expenseCategories->values()),
                    backgroundColor: [
                        '#3B82F6',
                        '#EF4444',
                        '#10B981',
                        '#F59E0B',
                        '#8B5CF6',
                        '#EC4899',
                        '#6B7280'
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
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return context.label + ': ZMW ' + value.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Incubation Progress Chart
    const incubationCtx = document.getElementById('incubationChart');
    if (incubationCtx) {
        @php
            // Get incubation data by status
            $incubationData = \App\Models\Incubation::selectRaw('status, COUNT(*) as count')
                ->whereNotNull('status')
                ->groupBy('status')
                ->pluck('count', 'status');
                
            // If no incubation data exists, create sample data
            if ($incubationData->isEmpty()) {
                $incubationData = collect([
                    'active' => 3,
                    'hatching' => 2,
                    'completed' => 4,
                    'failed' => 1,
                    'cancelled' => 1
                ]);
            }
        @endphp
        
        new Chart(incubationCtx, {
            type: 'bar',
            data: {
                labels: @json($incubationData->keys()->map(function($status) {
                    return ucfirst(str_replace('_', ' ', $status));
                })),
                datasets: [{
                    label: 'Number of Batches',
                    data: @json($incubationData->values()),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(139, 92, 246, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(139, 92, 246)'
                    ],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush
