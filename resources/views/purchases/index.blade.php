@extends('layouts.app')

@section('title', 'Purchases Management')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Purchases Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Purchases</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('purchases.create') }}" class="btn btn-success btn-sm" style="background-color: #1e5631; border-color: #1e5631; color: white; font-size: 12px; padding: 4px 8px;">
                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                    Add Purchase
                </a>
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
                            <h4 class="text-c-green">{{ $purchaseStats['total_purchases'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Total Purchases</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="shopping-bag" class="f-28 text-c-green"></i>
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
                            <h4 class="text-c-blue">{{ $purchaseStats['pending_purchases'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Pending Orders</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="clock" class="f-28 text-c-blue"></i>
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
                            <h4 class="text-c-yellow">ZMW {{ number_format($purchaseStats['total_amount'] ?? 0, 2) }}</h4>
                            <h6 class="text-muted m-b-0">Total Amount</h6>
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
                            <h4 class="text-c-red">{{ $purchaseStats['pending_payments'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Pending Payments</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="credit-card" class="f-28 text-c-red"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                    <input type="text" class="form-control form-control-sm" placeholder="Search purchases..." id="searchInput">
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select class="form-select form-select-sm" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="seeds">Seeds</option>
                        <option value="fertilizer">Fertilizer</option>
                        <option value="equipment">Equipment</option>
                        <option value="feed">Feed</option>
                        <option value="chemicals">Chemicals</option>
                        <option value="tools">Tools</option>
                        <option value="services">Services</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="ordered">Ordered</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <select class="form-select form-select-sm" id="paymentFilter">
                        <option value="">Payment Status</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="overdue">Overdue</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6 mb-2 mb-md-0">
                    <input type="date" class="form-control form-control-sm" id="dateFilter">
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
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Purchases List</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><a href="?sort=purchase_number" class="text-decoration-none">Purchase #</a></th>
                            <th>Supplier</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th><a href="?sort=total_amount" class="text-decoration-none">Amount</a></th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th><a href="?sort=purchase_date" class="text-decoration-none">Date</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                        <tr>
                            <td>
                                <strong class="text-primary">{{ $purchase->purchase_number }}</strong>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $purchase->supplier_name }}</strong>
                                    @if($purchase->supplier_contact)
                                        <br><small class="text-muted">{{ $purchase->supplier_contact }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $purchase->item_name }}</strong>
                                    @if($purchase->item_description)
                                        <br><small class="text-muted">{{ Str::limit($purchase->item_description, 30) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($purchase->category) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $purchase->quantity }} {{ $purchase->quantity_unit }}</span>
                            </td>
                            <td>
                                <div>
                                    <strong>ZMW {{ number_format($purchase->total_amount, 2) }}</strong>
                                    <br><small class="text-muted">@ ZMW {{ number_format($purchase->unit_price, 2) }}</small>
                                </div>
                            </td>
                            <td>
                                @switch($purchase->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('ordered')
                                        <span class="badge bg-info">Ordered</span>
                                        @break
                                    @case('delivered')
                                        <span class="badge bg-success">Delivered</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($purchase->status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                @switch($purchase->payment_status)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('paid')
                                        <span class="badge bg-success">Paid</span>
                                        @break
                                    @case('partial')
                                        <span class="badge bg-info">Partial</span>
                                        @break
                                    @case('overdue')
                                        <span class="badge bg-danger">Overdue</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ ucfirst($purchase->payment_status) }}</span>
                                @endswitch
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $purchase->purchase_date->format('M d, Y') }}</strong>
                                    @if($purchase->delivery_date)
                                        <br><small class="text-muted">Delivery: {{ $purchase->delivery_date->format('M d') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('purchases.show', $purchase) }}" 
                                            class="btn btn-sm btn-icon btn-light-primary" 
                                            title="View Purchase">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('purchases.edit', $purchase) }}" 
                                            class="btn btn-sm btn-icon btn-light-secondary"
                                            title="Edit Purchase">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" 
                                              style="display: inline-block; margin: 0;"
                                              onsubmit="return confirm('Are you sure you want to delete this purchase?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-sm btn-icon btn-light-danger"
                                                title="Delete Purchase">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                <div class="empty-state">
                                    <i data-feather="shopping-bag" class="text-muted" style="font-size: 48px;"></i>
                                    <h6 class="mt-3 text-muted">No purchases found</h6>
                                    <p class="text-muted">Start by recording your first purchase to track farm expenses.</p>
                                    <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm">
                                        <i data-feather="plus" class="me-1"></i>Add Purchase
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($purchases->hasPages())
            <div class="row mt-3">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info">
                        Showing {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }} of {{ $purchases->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});

function applyFilters() {
    // Implement filter functionality
    console.log('Applying filters...');
}

function clearFilters() {
    // Clear all filter inputs
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('statusFilter').value = '';
    document.getElementById('paymentFilter').value = '';
    document.getElementById('dateFilter').value = '';
}
</script>
@endpush
