@extends('layouts.app')

@section('title', 'Purchase Details - ' . $purchase->purchase_number)

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Purchase Details</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $purchase->purchase_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-primary btn-sm">
                        <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                        Edit
                    </a>
                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">
                        <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Purchase Summary -->
        <div class="col-md-4">
            <!-- Purchase Summary Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Purchase Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6"><strong>Purchase #:</strong></div>
                        <div class="col-6">{{ $purchase->purchase_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Status:</strong></div>
                        <div class="col-6">
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
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Payment:</strong></div>
                        <div class="col-6">
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
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Category:</strong></div>
                        <div class="col-6">
                            <span class="badge bg-info">{{ ucfirst($purchase->category) }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Total Amount:</strong></div>
                        <div class="col-6"><strong class="text-success">ZMW {{ number_format($purchase->total_amount, 2) }}</strong></div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>Purchase Date:</strong></div>
                        <div class="col-6">{{ $purchase->purchase_date->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Supplier Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Supplier Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>{{ $purchase->supplier_name }}</strong>
                    </div>
                    @if($purchase->supplier_contact)
                        <div class="mb-2">
                            <i data-feather="phone" style="width: 14px; height: 14px;"></i>
                            <span class="ms-1">{{ $purchase->supplier_contact }}</span>
                        </div>
                    @endif
                    @if($purchase->supplier_email)
                        <div class="mb-2">
                            <i data-feather="mail" style="width: 14px; height: 14px;"></i>
                            <span class="ms-1">{{ $purchase->supplier_email }}</span>
                        </div>
                    @endif
                    @if($purchase->supplier_address)
                        <div class="mb-2">
                            <i data-feather="map-pin" style="width: 14px; height: 14px;"></i>
                            <span class="ms-1">{{ $purchase->supplier_address }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Purchase Details -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">{{ $purchase->item_name }}</h5>
                            <div class="text-muted">{{ $purchase->purchase_number }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-outline-primary">
                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('purchases.destroy', $purchase) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this purchase?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Item Description -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-1">Item Description</h6>
                        <p class="text-muted">{{ $purchase->item_description ?: 'No description available' }}</p>
                    </div>

                    <!-- Purchase Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-1">Purchase Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted small">QUANTITY & PRICING</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between">
                                        <span>Quantity:</span>
                                        <strong>{{ $purchase->quantity }} {{ $purchase->quantity_unit }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Unit Price:</span>
                                        <strong>ZMW {{ number_format($purchase->unit_price, 2) }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Total Amount:</span>
                                        <strong class="text-success">ZMW {{ number_format($purchase->total_amount, 2) }}</strong>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted small">DATES & STATUS</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between">
                                        <span>Purchase Date:</span>
                                        <strong>{{ $purchase->purchase_date->format('M d, Y') }}</strong>
                                    </li>
                                    @if($purchase->delivery_date)
                                        <li class="d-flex justify-content-between">
                                            <span>Delivery Date:</span>
                                            <strong>{{ $purchase->delivery_date->format('M d, Y') }}</strong>
                                        </li>
                                    @endif
                                    <li class="d-flex justify-content-between">
                                        <span>Created:</span>
                                        <strong>{{ $purchase->created_at->format('M d, Y') }}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-1">Additional Information</h6>
                        <div class="row">
                            @if($purchase->storage_location)
                                <div class="col-md-6">
                                    <h6 class="text-muted small">STORAGE LOCATION</h6>
                                    <p>{{ $purchase->storage_location }}</p>
                                </div>
                            @endif
                            @if($purchase->notes)
                                <div class="col-md-6">
                                    <h6 class="text-muted small">NOTES</h6>
                                    <p>{{ $purchase->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-1">Status Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted small">PURCHASE STATUS</h6>
                                <div class="d-flex align-items-center">
                                    @switch($purchase->status)
                                        @case('pending')
                                            <span class="badge bg-warning me-2">Pending</span>
                                            <small class="text-muted">Order is being processed</small>
                                            @break
                                        @case('ordered')
                                            <span class="badge bg-info me-2">Ordered</span>
                                            <small class="text-muted">Order has been placed with supplier</small>
                                            @break
                                        @case('delivered')
                                            <span class="badge bg-success me-2">Delivered</span>
                                            <small class="text-muted">Items have been received</small>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger me-2">Cancelled</span>
                                            <small class="text-muted">Order was cancelled</small>
                                            @break
                                        @default
                                            <span class="badge bg-secondary me-2">{{ ucfirst($purchase->status) }}</span>
                                    @endswitch
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted small">PAYMENT STATUS</h6>
                                <div class="d-flex align-items-center">
                                    @switch($purchase->payment_status)
                                        @case('pending')
                                            <span class="badge bg-warning me-2">Pending</span>
                                            <small class="text-muted">Payment is due</small>
                                            @break
                                        @case('paid')
                                            <span class="badge bg-success me-2">Paid</span>
                                            <small class="text-muted">Payment completed</small>
                                            @break
                                        @case('partial')
                                            <span class="badge bg-info me-2">Partial</span>
                                            <small class="text-muted">Partial payment received</small>
                                            @break
                                        @case('overdue')
                                            <span class="badge bg-danger me-2">Overdue</span>
                                            <small class="text-muted">Payment is overdue</small>
                                            @break
                                        @default
                                            <span class="badge bg-secondary me-2">{{ ucfirst($purchase->payment_status) }}</span>
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
</script>
@endpush
