@extends('layouts.app')

@section('title', 'Debug Dashboard - Data Verification')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <h4 class="page-title">Debug Dashboard - Data Verification</h4>
        <p class="text-muted">This page shows the actual data being passed to the dashboard</p>
    </div>

    <!-- Raw Data Display -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Raw Data Being Passed to Dashboard</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Stock Statistics:</h6>
                            <pre>{{ json_encode($stockStats ?? [], JSON_PRETTY_PRINT) }}</pre>
                            
                            <h6>Sales Statistics:</h6>
                            <pre>{{ json_encode($salesStats ?? [], JSON_PRETTY_PRINT) }}</pre>
                        </div>
                        <div class="col-md-6">
                            <h6>Purchase Statistics:</h6>
                            <pre>{{ json_encode($purchaseStats ?? [], JSON_PRETTY_PRINT) }}</pre>
                            
                            <h6>Incubation Statistics:</h6>
                            <pre>{{ json_encode($incubationStats ?? [], JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Low Stock Products ({{ isset($lowStockProducts) ? $lowStockProducts->count() : 0 }})</h5>
                </div>
                <div class="card-body">
                    @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>
                                            <span class="badge bg-{{ $product->status == 'out_of_stock' ? 'danger' : 'warning' }}">
                                                {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                            </span>
                                        </td>
                                        <td>ZMW {{ number_format($product->price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">No low stock products found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Direct Database Queries for Comparison -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Direct Database Queries (for comparison)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Products:</h6>
                            <ul class="list-unstyled">
                                <li>Total: {{ \App\Models\Product::count() }}</li>
                                <li>In Stock: {{ \App\Models\Product::where('status', 'in_stock')->count() }}</li>
                                <li>Low Stock: {{ \App\Models\Product::where('status', 'low_stock')->count() }}</li>
                                <li>Out of Stock: {{ \App\Models\Product::where('status', 'out_of_stock')->count() }}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6>Sales:</h6>
                            <ul class="list-unstyled">
                                <li>Total Sales: {{ \App\Models\Sale::count() }}</li>
                                <li>Total Revenue: ZMW {{ number_format(\App\Models\Sale::sum('total_amount'), 2) }}</li>
                                <li>Completed: {{ \App\Models\Sale::where('payment_status', 'completed')->count() }}</li>
                                <li>Pending: {{ \App\Models\Sale::where('payment_status', 'pending')->count() }}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6>Purchases:</h6>
                            <ul class="list-unstyled">
                                <li>Total Purchases: {{ \App\Models\Purchase::count() }}</li>
                                <li>Total Amount: ZMW {{ number_format(\App\Models\Purchase::sum('total_amount'), 2) }}</li>
                                <li>Delivered: {{ \App\Models\Purchase::where('status', 'delivered')->count() }}</li>
                                <li>Pending: {{ \App\Models\Purchase::where('status', 'pending')->count() }}</li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <h6>Incubations:</h6>
                            <ul class="list-unstyled">
                                <li>Total Batches: {{ \App\Models\Incubation::count() }}</li>
                                <li>Active: {{ \App\Models\Incubation::where('status', 'active')->count() }}</li>
                                <li>Completed: {{ \App\Models\Incubation::where('status', 'completed')->count() }}</li>
                                <li>Failed: {{ \App\Models\Incubation::where('status', 'failed')->count() }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6>Quick Actions:</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">View Main Dashboard</a>
                        <a href="{{ route('products.index') }}" class="btn btn-success">View Products</a>
                        <a href="/data-test" class="btn btn-info">Raw Data Test</a>
                        <a href="{{ route('products.create') }}" class="btn btn-warning">Add New Product</a>
                        <button onclick="window.location.reload(true)" class="btn btn-secondary">Force Refresh</button>
                        <button onclick="localStorage.clear(); sessionStorage.clear(); window.location.reload(true)" class="btn btn-danger">Clear Cache & Refresh</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection