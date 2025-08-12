@extends('layouts.app')

@section('title', 'Sale Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Sale Details</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $sale->sale_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary">
                        <i class="feather icon-edit"></i> Edit Sale
                    </a>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="feather icon-printer"></i> Print
                    </button>
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                        <i class="feather icon-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Sale Information Card -->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5>Sale Information</h5>
                            <small class="text-muted">Sale Number: {{ $sale->sale_number }}</small>
                        </div>
                        <div class="col-auto">
                            @switch($sale->status)
                                @case('completed')
                                    <span class="badge bg-success fs-6">Completed</span>
                                    @break
                                @case('pending')
                                    <span class="badge bg-warning fs-6">Pending</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger fs-6">Cancelled</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Product Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Product Details</h6>
                            <div class="info-item mb-3">
                                <strong>Product:</strong>
                                <div>{{ $sale->product->name ?? 'N/A' }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <strong>Quantity Sold:</strong>
                                <div>{{ $sale->quantity_sold }} {{ $sale->quantity_unit }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <strong>Unit Price:</strong>
                                <div>ZMW {{ number_format($sale->unit_price, 2) }}</div>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Customer Details</h6>
                            <div class="info-item mb-3">
                                <strong>Customer Name:</strong>
                                <div>{{ $sale->customer_name }}</div>
                            </div>
                            @if($sale->customer_phone)
                            <div class="info-item mb-3">
                                <strong>Phone:</strong>
                                <div>{{ $sale->customer_phone }}</div>
                            </div>
                            @endif
                            @if($sale->customer_address)
                            <div class="info-item mb-3">
                                <strong>Address:</strong>
                                <div>{{ $sale->customer_address }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <strong>Payment Method:</strong>
                                <div class="text-capitalize">{{ str_replace('_', ' ', $sale->payment_method) }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <strong>Payment Status:</strong>
                                <div>
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
                                    @endswitch
                                </div>
                            </div>
                            @if($sale->payment_reference)
                            <div class="info-item mb-3">
                                <strong>Payment Reference:</strong>
                                <div>{{ $sale->payment_reference }}</div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <strong>Sale Date:</strong>
                                <div>{{ $sale->sale_date->format('F j, Y') }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <strong>Created:</strong>
                                <div>{{ $sale->created_at->format('F j, Y \a\t g:i A') }}</div>
                            </div>
                            @if($sale->updated_at != $sale->created_at)
                            <div class="info-item mb-3">
                                <strong>Last Updated:</strong>
                                <div>{{ $sale->updated_at->format('F j, Y \a\t g:i A') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($sale->notes)
            <!-- Notes Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Notes</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $sale->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Amount Breakdown Card -->
            <div class="card">
                <div class="card-header">
                    <h5>Amount Breakdown</h5>
                </div>
                <div class="card-body">
                    <div class="breakdown-item d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <strong>ZMW {{ number_format($sale->total_amount, 2) }}</strong>
                    </div>
                    @if($sale->discount_amount > 0)
                    <div class="breakdown-item d-flex justify-content-between mb-3">
                        <span>Discount:</span>
                        <strong class="text-success">-ZMW {{ number_format($sale->discount_amount, 2) }}</strong>
                    </div>
                    @endif
                    <hr>
                    <div class="breakdown-item d-flex justify-content-between">
                        <span class="h6">Final Amount:</span>
                        <strong class="h5 text-primary">ZMW {{ number_format($sale->final_amount, 2) }}</strong>
                    </div>
                </div>
            </div>

            <!-- Product Stock Card -->
            @if($sale->product)
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Current Product Stock</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h4 class="
                            @if($sale->product->status == 'in_stock') text-success
                            @elseif($sale->product->status == 'low_stock') text-warning
                            @else text-danger
                            @endif
                        ">
                            {{ $sale->product->quantity }} {{ $sale->product->quantity_unit }}
                        </h4>
                        <p class="text-muted mb-0">
                            Status: 
                            <span class="badge 
                                @if($sale->product->status == 'in_stock') bg-success
                                @elseif($sale->product->status == 'low_stock') bg-warning
                                @else bg-danger
                                @endif
                            ">
                                {{ ucfirst(str_replace('_', ' ', $sale->product->status)) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-primary">
                            <i class="feather icon-edit"></i> Edit Sale
                        </a>
                        
                        @if($sale->status != 'completed')
                        <form action="{{ route('sales.update', $sale) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="feather icon-check"></i> Mark as Completed
                            </button>
                        </form>
                        @endif
                        
                        <button class="btn btn-outline-secondary" onclick="window.print()">
                            <i class="feather icon-printer"></i> Print Receipt
                        </button>
                        
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this sale? This will restore the product quantity.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="feather icon-trash-2"></i> Delete Sale
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
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

.info-item {
    border-bottom: 1px solid #f8f9fa;
    padding-bottom: 0.5rem;
}

.info-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.breakdown-item {
    font-size: 0.95rem;
}

.badge {
    font-size: 0.8rem;
}

.fs-6 {
    font-size: 1rem !important;
}

/* Print styles */
@media print {
    .btn, .card-header .badge, .page-header {
        display: none !important;
    }
    
    .card {
        box-shadow: none !important;
        border: 1px solid #000 !important;
    }
    
    .container-fluid {
        padding: 0 !important;
    }
}
</style>
@endpush
@endsection
