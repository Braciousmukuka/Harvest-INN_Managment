@extends('layouts.app')

@section('title', 'Edit Purchase - ' . $purchase->purchase_number)

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Edit Purchase: {{ $purchase->purchase_number }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">Purchases</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">
                    <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                    Back to Purchases
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Purchase Form -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Purchase Information</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('purchases.update', $purchase) }}">
                @csrf
                @method('PUT')

                <!-- Supplier Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Supplier Information</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="{{ old('supplier_name', $purchase->supplier_name) }}" required>
                            @error('supplier_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="supplier_contact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="supplier_contact" name="supplier_contact" value="{{ old('supplier_contact', $purchase->supplier_contact) }}">
                            @error('supplier_contact')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="supplier_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="supplier_email" name="supplier_email" value="{{ old('supplier_email', $purchase->supplier_email) }}">
                            @error('supplier_email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="supplier_address" class="form-label">Address</label>
                            <textarea class="form-control" id="supplier_address" name="supplier_address" rows="2">{{ old('supplier_address', $purchase->supplier_address) }}</textarea>
                            @error('supplier_address')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Purchase Details -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Purchase Details</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="item_name" name="item_name" value="{{ old('item_name', $purchase->item_name) }}" required>
                            @error('item_name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="seeds" {{ old('category', $purchase->category) == 'seeds' ? 'selected' : '' }}>Seeds</option>
                                <option value="fertilizer" {{ old('category', $purchase->category) == 'fertilizer' ? 'selected' : '' }}>Fertilizer</option>
                                <option value="equipment" {{ old('category', $purchase->category) == 'equipment' ? 'selected' : '' }}>Equipment</option>
                                <option value="feed" {{ old('category', $purchase->category) == 'feed' ? 'selected' : '' }}>Feed</option>
                                <option value="chemicals" {{ old('category', $purchase->category) == 'chemicals' ? 'selected' : '' }}>Chemicals</option>
                                <option value="tools" {{ old('category', $purchase->category) == 'tools' ? 'selected' : '' }}>Tools</option>
                                <option value="services" {{ old('category', $purchase->category) == 'services' ? 'selected' : '' }}>Services</option>
                                <option value="other" {{ old('category', $purchase->category) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="item_description" class="form-label">Item Description</label>
                            <textarea class="form-control" id="item_description" name="item_description" rows="3">{{ old('item_description', $purchase->item_description) }}</textarea>
                            @error('item_description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Quantity and Pricing -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Quantity & Pricing</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $purchase->quantity) }}" step="0.01" min="0" required>
                            @error('quantity')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="quantity_unit" class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select" id="quantity_unit" name="quantity_unit" required>
                                <option value="">Select Unit</option>
                                <option value="kg" {{ old('quantity_unit', $purchase->quantity_unit) == 'kg' ? 'selected' : '' }}>KG</option>
                                <option value="pieces" {{ old('quantity_unit', $purchase->quantity_unit) == 'pieces' ? 'selected' : '' }}>Pieces</option>
                                <option value="liters" {{ old('quantity_unit', $purchase->quantity_unit) == 'liters' ? 'selected' : '' }}>Liters</option>
                                <option value="bags" {{ old('quantity_unit', $purchase->quantity_unit) == 'bags' ? 'selected' : '' }}>Bags</option>
                                <option value="boxes" {{ old('quantity_unit', $purchase->quantity_unit) == 'boxes' ? 'selected' : '' }}>Boxes</option>
                                <option value="tons" {{ old('quantity_unit', $purchase->quantity_unit) == 'tons' ? 'selected' : '' }}>Tons</option>
                                <option value="meters" {{ old('quantity_unit', $purchase->quantity_unit) == 'meters' ? 'selected' : '' }}>Meters</option>
                            </select>
                            @error('quantity_unit')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="unit_price" class="form-label">Unit Price (ZMW) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ old('unit_price', $purchase->unit_price) }}" step="0.01" min="0" required>
                            @error('unit_price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total Amount (ZMW) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $purchase->total_amount) }}" step="0.01" min="0" required readonly>
                            <small class="form-text text-muted">Calculated automatically</small>
                            @error('total_amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dates and Status -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Dates & Status</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" required>
                            @error('purchase_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="delivery_date" class="form-label">Expected Delivery Date</label>
                            <input type="date" class="form-control" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $purchase->delivery_date ? $purchase->delivery_date->format('Y-m-d') : '') }}">
                            @error('delivery_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Purchase Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" {{ old('status', $purchase->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ordered" {{ old('status', $purchase->status) == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                <option value="delivered" {{ old('status', $purchase->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ old('status', $purchase->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                <option value="pending" {{ old('payment_status', $purchase->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('payment_status', $purchase->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="partial" {{ old('payment_status', $purchase->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="overdue" {{ old('payment_status', $purchase->payment_status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                            @error('payment_status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-3 text-primary">Additional Information</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="storage_location" class="form-label">Storage Location</label>
                            <input type="text" class="form-control" id="storage_location" name="storage_location" value="{{ old('storage_location', $purchase->storage_location) }}" placeholder="e.g., Warehouse A, Section 2">
                            @error('storage_location')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Additional notes about this purchase">{{ old('notes', $purchase->notes) }}</textarea>
                            @error('notes')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">Reset Changes</button>
                            <button type="submit" class="btn btn-primary">Update Purchase</button>
                        </div>
                    </div>
                </div>
            </form>
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
    
    // Calculate total amount automatically
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalAmountInput = document.getElementById('total_amount');
    
    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        totalAmountInput.value = total.toFixed(2);
    }
    
    if (quantityInput && unitPriceInput && totalAmountInput) {
        quantityInput.addEventListener('input', calculateTotal);
        unitPriceInput.addEventListener('input', calculateTotal);
        
        // Calculate on page load if values exist
        calculateTotal();
    }
});
</script>
@endpush
