@extends('layouts.app')

@section('title', 'Sales Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Sales Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Sales</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-dark-green btn-xs" onclick="location.href='{{ route('sales.create') }}'" style="background-color: #1e5631; border-color: #1e5631; color: white; font-size: 12px; padding: 4px 8px;">
                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                    New Sale
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">{{ number_format($salesStats['total_sales']) }}</h4>
                            <h6 class="text-muted m-b-0">Total Sales</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="shopping-cart" class="f-28 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-blue">{{ number_format($salesStats['today_sales']) }}</h4>
                            <h6 class="text-muted m-b-0">Today's Sales</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="calendar" class="f-28 text-c-blue"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-yellow">ZMW {{ number_format($salesStats['total_revenue'], 2) }}</h4>
                            <h6 class="text-muted m-b-0">Total Revenue</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="dollar-sign" class="f-28 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-red">ZMW {{ number_format($salesStats['today_revenue'], 2) }}</h4>
                            <h6 class="text-muted m-b-0">Today's Revenue</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="trending-up" class="f-28 text-c-red"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card">
        <div class="card-header">
            <h5>Sales List</h5>
            <div class="card-header-right">
                <div class="btn-group card-option">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="more-horizontal"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item" onclick="exportSales()"><i data-feather="download"></i>&nbsp;Export</button></li>
                        <li><button class="dropdown-item" onclick="refreshTable()"><i data-feather="refresh-cw"></i>&nbsp;Refresh</button></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <form method="GET" action="{{ route('sales.index') }}">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search sales..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i data-feather="search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select class="form-select" name="status" onchange="filterSales()">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select class="form-select" name="payment_status" onchange="filterSales()">
                        <option value="">Payment Status</option>
                        <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <input type="date" class="form-control" name="date_from" 
                           value="{{ request('date_from') }}" onchange="filterSales()">
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <input type="date" class="form-control" name="date_to" 
                           value="{{ request('date_to') }}" onchange="filterSales()">
                </div>
                <div class="col-md-1 col-sm-6">
                    <ul class="list-inline me-auto mb-0">
                        <li class="list-inline-item align-bottom">
                            <button type="button" 
                                class="btn btn-sm btn-icon btn-light-success" 
                                onclick="applyFilters()" 
                                title="Apply Filters">
                                <i class="ti ti-search"></i>
                            </button>
                        </li>
                        <li class="list-inline-item align-bottom">
                            <button type="button" 
                                class="btn btn-sm btn-icon btn-light-secondary" 
                                onclick="clearFilters()" 
                                title="Clear Filters">
                                <i class="ti ti-x"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sales Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><a href="?sort=sale_number" class="text-decoration-none">Sale #</a></th>
                            <th><a href="?sort=customer_name" class="text-decoration-none">Customer</a></th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th><a href="?sort=amount_high" class="text-decoration-none">Amount</a></th>
                            <th>Payment Status</th>
                            <th>Status</th>
                            <th><a href="?sort=newest" class="text-decoration-none">Date</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $sale->sale_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $sale->customer_name }}</strong>
                                    @if($sale->customer_phone)
                                        <br><small class="text-muted">{{ $sale->customer_phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $sale->product->name ?? 'N/A' }}</strong>
                                    <br><small class="text-muted">ZMW {{ number_format($sale->unit_price, 2) }} per {{ $sale->quantity_unit }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $sale->quantity_sold }} {{ $sale->quantity_unit }}</span>
                            </td>
                            <td>
                                <div>
                                    <strong>ZMW {{ number_format($sale->final_amount, 2) }}</strong>
                                    @if($sale->discount_amount > 0)
                                        <br><small class="text-success">Discount: ZMW {{ number_format($sale->discount_amount, 2) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @switch($sale->payment_status)
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('failed')
                                        <span class="badge bg-danger">Failed</span>
                                        @break
                                    @case('refunded')
                                        <span class="badge bg-info">Refunded</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($sale->payment_status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                @switch($sale->status)
                                    @case('completed')
                                        <span class="badge bg-success">Completed</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($sale->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $sale->sale_date->format('M d, Y') }}</strong>
                                    <br><small class="text-muted">{{ $sale->sale_date->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('sales.show', $sale) }}" 
                                            class="btn btn-sm btn-icon btn-light-primary" 
                                            title="View Sale">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('sales.edit', $sale) }}" 
                                            class="btn btn-sm btn-icon btn-light-secondary"
                                            title="Edit Sale">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" 
                                              style="display: inline-block; margin: 0;"
                                              onsubmit="return confirm('Are you sure you want to delete this sale? This will restore the product quantity.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-sm btn-icon btn-light-danger"
                                                title="Delete Sale">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="empty-state">
                                    <i data-feather="shopping-cart" class="text-muted" style="font-size: 48px;"></i>
                                    <h6 class="mt-3 text-muted">No sales found</h6>
                                    <p class="text-muted">Start by creating your first sale.</p>
                                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                        <i data-feather="plus"></i>&nbsp;Create Sale
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($sales->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <p class="text-muted">
                        Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} results
                    </p>
                </div>
                <div>
                    {{ $sales->withQueryString()->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<!-- Feather Icons -->
<link href="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.css" rel="stylesheet">
<style>
.page-header {
    margin-bottom: 2rem;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: #fff;
    border-bottom: 1px solid #ebedf2;
    border-radius: 10px 10px 0 0;
}

.table thead th {
    border-top: none;
    border-bottom: 2px solid #ebedf2;
    font-weight: 600;
    color: #3f4254;
    background-color: #f8f9fa;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75rem;
}

.empty-state {
    padding: 3rem 1rem;
}

.btn-group .dropdown-toggle::after {
    margin-left: 0.5rem;
}

/* Fix button styling */
.btn-outline-secondary {
    color: #6c757d;
    border-color: #6c757d;
    background-color: transparent;
}

.btn-outline-secondary:hover {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}

/* Feather icon fixes */
.feather {
    width: 16px;
    height: 16px;
    vertical-align: text-bottom;
}

/* Icon button styles to match products table */
.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
}

.btn-light-primary {
    background-color: rgba(4, 169, 245, 0.1);
    border-color: rgba(4, 169, 245, 0.1);
    color: #04a9f5;
}

.btn-light-primary:hover {
    background-color: rgba(4, 169, 245, 0.2);
    border-color: rgba(4, 169, 245, 0.2);
    color: #04a9f5;
}

.btn-light-secondary {
    background-color: rgba(108, 117, 125, 0.1);
    border-color: rgba(108, 117, 125, 0.1);
    color: #6c757d;
}

.btn-light-secondary:hover {
    background-color: rgba(108, 117, 125, 0.2);
    border-color: rgba(108, 117, 125, 0.2);
    color: #6c757d;
}

.btn-light-danger {
    background-color: rgba(255, 82, 82, 0.1);
    border-color: rgba(255, 82, 82, 0.1);
    color: #ff5252;
}

.btn-light-danger:hover {
    background-color: rgba(255, 82, 82, 0.2);
    border-color: rgba(255, 82, 82, 0.2);
    color: #ff5252;
}

.list-inline-item {
    margin-right: 0.5rem;
}

.list-inline-item:last-child {
    margin-right: 0;
}

/* Icon color fixes */
.text-c-green { color: #04a9f5 !important; }
.text-c-blue { color: #1dc4e9 !important; }
.text-c-yellow { color: #f8b425 !important; }
.text-c-red { color: #ff5252 !important; }

.f-28 { font-size: 28px; }
.m-b-0 { margin-bottom: 0; }

/* Dropdown fixes */
.dropdown-menu {
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
}

.dropdown-item {
    padding: 0.5rem 1rem;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}
</style>
@endpush

@push('scripts')
<!-- Feather Icons JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.js"></script>
<script>
// Initialize Feather icons
feather.replace();

// Initialize Bootstrap dropdowns
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
});

function applyFilters() {
    const form = document.createElement('form');
    form.method = 'GET';
    form.action = '{{ route("sales.index") }}';
    
    // Get all filter values
    const filters = {
        search: document.querySelector('input[name="search"]').value,
        status: document.querySelector('select[name="status"]').value,
        payment_status: document.querySelector('select[name="payment_status"]').value,
        date_from: document.querySelector('input[name="date_from"]').value,
        date_to: document.querySelector('input[name="date_to"]').value
    };
    
    // Add non-empty filters to form
    Object.keys(filters).forEach(key => {
        if (filters[key]) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = filters[key];
            form.appendChild(input);
        }
    });
    
    document.body.appendChild(form);
    form.submit();
}

function filterSales() {
    // For backward compatibility, call applyFilters
    applyFilters();
}

function clearFilters() {
    window.location.href = '{{ route("sales.index") }}';
}

function refreshTable() {
    window.location.reload();
}

function exportSales() {
    alert('Export functionality coming soon!');
}

// Auto-submit search form on Enter
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                this.closest('form').submit();
            }
        });
    }
    
    // Debug form submissions
    const deleteForms = document.querySelectorAll('form[method="POST"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            console.log('Form submitting:', this);
            console.log('Action:', this.action);
            console.log('Method:', this.method);
        });
    });
});
</script>
@endpush
@endsection
