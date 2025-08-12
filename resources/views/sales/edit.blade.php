@extends('layouts.app')

@section('title', 'Edit Sale')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Edit Sale</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sales.show', $sale) }}">{{ $sale->sale_number }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('sales.show', $sale) }}" class="btn btn-outline-secondary">
                    <i class="feather icon-arrow-left"></i>
                    Back to Sale
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card">
                <div class="card-header">
                    <h5>Edit Sale Information</h5>
                    <small class="text-muted">Sale Number: {{ $sale->sale_number }}</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.update', $sale) }}" method="POST" id="saleForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Product Selection -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="product_id" class="form-label">Select Product <span class="text-danger">*</span></label>
                                <select class="form-select @error('product_id') is-invalid @enderror" 
                                        name="product_id" id="product_id" required>
                                    <option value="">Choose a product...</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-price="{{ $product->price }}"
                                            data-quantity="{{ $product->quantity }}"
                                            data-unit="{{ $product->quantity_unit }}"
                                            {{ old('product_id', $sale->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - ZMW {{ number_format($product->price, 2) }} 
                                        ({{ $product->quantity }} {{ $product->quantity_unit }} available)
                                    </option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Quantity and Pricing -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="quantity_sold" class="form-label">Quantity <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('quantity_sold') is-invalid @enderror" 
                                           name="quantity_sold" id="quantity_sold" value="{{ old('quantity_sold', $sale->quantity_sold) }}" 
                                           min="1" step="0.01" required>
                                    <span class="input-group-text" id="quantity_unit_display">{{ $sale->quantity_unit }}</span>
                                </div>
                                <small class="text-muted" id="available_quantity"></small>
                                @error('quantity_sold')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="unit_price" class="form-label">Unit Price (ZMW) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('unit_price') is-invalid @enderror" 
                                       name="unit_price" id="unit_price" value="{{ old('unit_price', $sale->unit_price) }}" 
                                       min="0" step="0.01" required>
                                @error('unit_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="discount_amount" class="form-label">Discount (ZMW)</label>
                                <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" 
                                       name="discount_amount" id="discount_amount" value="{{ old('discount_amount', $sale->discount_amount) }}" 
                                       min="0" step="0.01">
                                @error('discount_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                                       name="customer_name" id="customer_name" value="{{ old('customer_name', $sale->customer_name) }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label">Customer Phone</label>
                                <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" 
                                       name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $sale->customer_phone) }}">
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="customer_address" class="form-label">Customer Address</label>
                                <textarea class="form-control @error('customer_address') is-invalid @enderror" 
                                          name="customer_address" id="customer_address" rows="2">{{ old('customer_address', $sale->customer_address) }}</textarea>
                                @error('customer_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sale Details -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="sale_date" class="form-label">Sale Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('sale_date') is-invalid @enderror" 
                                       name="sale_date" id="sale_date" value="{{ old('sale_date', $sale->sale_date->format('Y-m-d')) }}" required>
                                @error('sale_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" 
                                        name="payment_method" id="payment_method" required>
                                    <option value="">Select method...</option>
                                    <option value="cash" {{ old('payment_method', $sale->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="mobile_money" {{ old('payment_method', $sale->payment_method) == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                    <option value="bank_transfer" {{ old('payment_method', $sale->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="credit" {{ old('payment_method', $sale->payment_method) == 'credit' ? 'selected' : '' }}>Credit</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('payment_status') is-invalid @enderror" 
                                        name="payment_status" id="payment_status" required>
                                    <option value="">Select status...</option>
                                    <option value="completed" {{ old('payment_status', $sale->payment_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="pending" {{ old('payment_status', $sale->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="failed" {{ old('payment_status', $sale->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="refunded" {{ old('payment_status', $sale->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Sale Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        name="status" id="status" required>
                                    <option value="pending" {{ old('status', $sale->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ old('status', $sale->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status', $sale->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="payment_reference" class="form-label">Payment Reference</label>
                                <input type="text" class="form-control @error('payment_reference') is-invalid @enderror" 
                                       name="payment_reference" id="payment_reference" value="{{ old('payment_reference', $sale->payment_reference) }}"
                                       placeholder="Transaction ID, Receipt #, etc.">
                                @error('payment_reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          name="notes" id="notes" rows="3" 
                                          placeholder="Additional notes about this sale...">{{ old('notes', $sale->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('sales.show', $sale) }}" class="btn btn-outline-secondary">
                                <i class="feather icon-x"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="feather icon-save"></i> Update Sale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Current Sale Summary Card -->
            <div class="card">
                <div class="card-header">
                    <h5>Current Sale Summary</h5>
                </div>
                <div class="card-body">
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Sale Number:</span>
                            <span class="text-primary">{{ $sale->sale_number }}</span>
                        </div>
                    </div>
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Original Amount:</span>
                            <span>ZMW {{ number_format($sale->final_amount, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Status:</span>
                            <span class="badge 
                                @if($sale->status == 'completed') bg-success
                                @elseif($sale->status == 'pending') bg-warning
                                @else bg-danger
                                @endif
                            ">{{ ucfirst($sale->status) }}</span>
                        </div>
                    </div>
                    <hr>
                    <h6>New Calculation:</h6>
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Product:</span>
                            <span id="summary_product">{{ $sale->product->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Quantity:</span>
                            <span id="summary_quantity">{{ $sale->quantity_sold }} {{ $sale->quantity_unit }}</span>
                        </div>
                    </div>
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Unit Price:</span>
                            <span id="summary_unit_price">ZMW {{ number_format($sale->unit_price, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span id="summary_subtotal">ZMW {{ number_format($sale->total_amount, 2) }}</span>
                        </div>
                    </div>
                    <div class="summary-item mb-2">
                        <div class="d-flex justify-content-between">
                            <span>Discount:</span>
                            <span id="summary_discount" class="text-success">ZMW {{ number_format($sale->discount_amount, 2) }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="summary-item">
                        <div class="d-flex justify-content-between">
                            <strong>New Total:</strong>
                            <strong id="summary_total" class="text-primary">ZMW {{ number_format($sale->final_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Warning Card -->
            <div class="card mt-3" id="stock_warning" style="display: none;">
                <div class="card-body">
                    <div class="alert alert-warning mb-0">
                        <i class="feather icon-alert-triangle"></i>
                        <strong>Stock Warning!</strong>
                        <p class="mb-0" id="stock_warning_text"></p>
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

.summary-item {
    font-size: 0.95rem;
}

.form-label {
    font-weight: 600;
    color: #3f4254;
}

.text-danger {
    color: #dc3545 !important;
}

.alert-warning {
    border-left: 4px solid #f8b425;
}

.badge {
    font-size: 0.75rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity_sold');
    const unitPriceInput = document.getElementById('unit_price');
    const discountInput = document.getElementById('discount_amount');
    
    // Update summary when inputs change
    [productSelect, quantityInput, unitPriceInput, discountInput].forEach(input => {
        input.addEventListener('change', updateSummary);
        input.addEventListener('input', updateSummary);
    });
    
    // Handle product selection
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (selectedOption.value) {
            const price = parseFloat(selectedOption.dataset.price);
            const quantity = parseFloat(selectedOption.dataset.quantity);
            const unit = selectedOption.dataset.unit;
            
            // Update unit price
            unitPriceInput.value = price.toFixed(2);
            
            // Update quantity unit display
            document.getElementById('quantity_unit_display').textContent = unit;
            
            // Update available quantity display
            document.getElementById('available_quantity').textContent = 
                `Available: ${quantity} ${unit}`;
            
            // Set max quantity
            quantityInput.max = quantity;
            
            // Show stock warning if low
            showStockWarning(quantity, unit);
        } else {
            // Reset fields
            document.getElementById('quantity_unit_display').textContent = 'units';
            document.getElementById('available_quantity').textContent = '';
            quantityInput.removeAttribute('max');
            hideStockWarning();
        }
        
        updateSummary();
    });
    
    function updateSummary() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const discount = parseFloat(discountInput.value) || 0;
        
        // Update product name
        document.getElementById('summary_product').textContent = 
            selectedOption.value ? selectedOption.text.split(' - ')[0] : '-';
        
        // Update quantity
        const unit = selectedOption.dataset?.unit || document.getElementById('quantity_unit_display').textContent;
        document.getElementById('summary_quantity').textContent = 
            quantity > 0 ? `${quantity} ${unit}` : '-';
        
        // Update unit price
        document.getElementById('summary_unit_price').textContent = 
            `ZMW ${unitPrice.toFixed(2)}`;
        
        // Calculate subtotal
        const subtotal = quantity * unitPrice;
        document.getElementById('summary_subtotal').textContent = 
            `ZMW ${subtotal.toFixed(2)}`;
        
        // Update discount
        document.getElementById('summary_discount').textContent = 
            `ZMW ${discount.toFixed(2)}`;
        
        // Calculate total
        const total = subtotal - discount;
        document.getElementById('summary_total').textContent = 
            `ZMW ${total.toFixed(2)}`;
    }
    
    function showStockWarning(quantity, unit) {
        if (quantity <= 20) {
            const warningText = quantity === 0 
                ? 'This product is out of stock!' 
                : `Low stock warning: Only ${quantity} ${unit} remaining.`;
            
            document.getElementById('stock_warning_text').textContent = warningText;
            document.getElementById('stock_warning').style.display = 'block';
        } else {
            hideStockWarning();
        }
    }
    
    function hideStockWarning() {
        document.getElementById('stock_warning').style.display = 'none';
    }
    
    // Validate quantity doesn't exceed available stock
    quantityInput.addEventListener('input', function() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption.value) {
            const availableQuantity = parseFloat(selectedOption.dataset.quantity);
            const requestedQuantity = parseFloat(this.value);
            
            if (requestedQuantity > availableQuantity) {
                this.setCustomValidity(`Only ${availableQuantity} units available`);
            } else {
                this.setCustomValidity('');
            }
        }
    });
    
    // Initialize on page load
    const initialProductOption = productSelect.options[productSelect.selectedIndex];
    if (initialProductOption.value) {
        const quantity = parseFloat(initialProductOption.dataset.quantity);
        const unit = initialProductOption.dataset.unit;
        
        document.getElementById('quantity_unit_display').textContent = unit;
        document.getElementById('available_quantity').textContent = 
            `Available: ${quantity} ${unit}`;
        quantityInput.max = quantity;
        showStockWarning(quantity, unit);
    }
    
    // Initialize summary
    updateSummary();
});
</script>
@endpush
@endsection
