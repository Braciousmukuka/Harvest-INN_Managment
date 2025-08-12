@extends('layouts.app')

@section('title', 'Product Details - ' . $product->name)

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Product Details</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group" role="group">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">
                        <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                        Edit
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                        <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Product Image and Quick Info -->
        <div class="col-md-4">
            <!-- Product Image -->
            <div class="card">
                <div class="card-body text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="bg-light rounded d-flex justify-content-center align-items-center" style="height: 200px;">
                            <i data-feather="package" style="width: 48px; height: 48px;" class="text-muted"></i>
                        </div>
                        <p class="mt-2 text-muted">No image available</p>
                    @endif
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Info</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6"><strong>Status:</strong></div>
                        <div class="col-6">
                            <span class="badge 
                                @if($product->status === 'in_stock') bg-success 
                                @elseif($product->status === 'low_stock') bg-warning 
                                @else bg-danger 
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>SKU:</strong></div>
                        <div class="col-6">{{ $product->sku }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>Category:</strong></div>
                        <div class="col-6">
                            <span class="badge 
                                @if($product->category == 'crop') bg-primary 
                                @elseif($product->category == 'livestock') bg-info
                                @elseif($product->category == 'dairy') bg-warning
                                @elseif($product->category == 'poultry') bg-success
                                @else bg-secondary @endif">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6"><strong>Current Stock:</strong></div>
                        <div class="col-6">{{ $product->quantity }} {{ $product->quantity_unit }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title mb-0">{{ $product->name }}</h5>
                            <div class="text-muted">ZMW {{ number_format($product->price, 2) }} {{ $product->price_unit }}</div>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-primary">
                                    <i data-feather="edit" style="width: 14px; height: 14px;"></i>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-1">Product Description</h6>
                        <p class="text-muted">{{ $product->description ?: 'No description available' }}</p>
                    </div>

                    <!-- Inventory Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-1">Inventory Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted small">STOCK INFORMATION</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between">
                                        <span>Current Stock:</span>
                                        <strong>{{ $product->quantity }} {{ $product->quantity_unit }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Low Stock Alert:</span>
                                        <strong>{{ $product->low_stock_threshold ?: 'Not set' }} {{ $product->quantity_unit }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Status:</span>
                                        <span class="badge 
                                            @if($product->status === 'in_stock') bg-success 
                                            @elseif($product->status === 'low_stock') bg-warning 
                                            @else bg-danger 
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted small">DATES</h6>
                                <ul class="list-unstyled">
                                    <li class="d-flex justify-content-between">
                                        <span>Harvested/Produced:</span>
                                        <strong>{{ $product->harvested_date ? \Carbon\Carbon::parse($product->harvested_date)->format('M d, Y') : 'N/A' }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Expiry Date:</span>
                                        <strong>{{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('M d, Y') : 'N/A' }}</strong>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span>Added to System:</span>
                                        <strong>{{ $product->created_at->format('M d, Y') }}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-1">Additional Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted small">FARM LOCATION</h6>
                                <p>{{ $product->location ?: 'Not specified' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted small">NOTES</h6>
                                <p>{{ $product->notes ?: 'No additional notes' }}</p>
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
