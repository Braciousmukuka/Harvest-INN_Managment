@extends('layouts.app')

@section('title', 'Create New Product')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Create New Product</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                    <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i>
                    Back to Products
                </a>
            </div>
        </div>
    </div>
    <!-- Create Product Form -->
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-0">Product Information</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-3">Basic Information</h5>
                        
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- SKU -->
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU (Stock Keeping Unit) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku') }}" required>
                            <small class="form-text text-muted">A unique identifier for your product</small>
                            @error('sku')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Product Description</label>
                            <textarea id="description" name="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="">Select a category</option>
                                <option value="crop" {{ old('category') == 'crop' ? 'selected' : '' }}>Crop</option>
                                <option value="livestock" {{ old('category') == 'livestock' ? 'selected' : '' }}>Livestock</option>
                                <option value="dairy" {{ old('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                                <option value="poultry" {{ old('category') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-3">Inventory & Pricing</h5>
                        
                        <!-- Unit Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Unit Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">ZMW</span>
                                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required>
                                <select id="price_unit" name="price_unit" class="form-select" style="max-width: 120px;">
                                    <option value="per_kg">per kg</option>
                                    <option value="per_piece">per piece</option>
                                    <option value="per_liter">per liter</option>
                                    <option value="per_dozen">per dozen</option>
                                </select>
                            </div>
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity/Stock -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity in Stock <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" min="0" required>
                                <select id="quantity_unit" name="quantity_unit" class="form-select" style="max-width: 120px;">
                                    <option value="kg">kg</option>
                                    <option value="pieces">pieces</option>
                                    <option value="liters">liters</option>
                                    <option value="dozens">dozens</option>
                                </select>
                            </div>
                            @error('quantity')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Low Stock Alert -->
                        <div class="mb-3">
                            <label for="low_stock_threshold" class="form-label">Low Stock Alert Threshold</label>
                            <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold') }}" min="0">
                            <small class="form-text text-muted">Get notified when stock falls below this number</small>
                            @error('low_stock_threshold')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Product Status <span class="text-danger">*</span></label>
                            <div class="mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="in_stock" id="status_in_stock" checked>
                                    <label class="form-check-label" for="status_in_stock">In Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="low_stock" id="status_low_stock">
                                    <label class="form-check-label" for="status_low_stock">Low Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="out_of_stock" id="status_out_of_stock">
                                    <label class="form-check-label" for="status_out_of_stock">Out of Stock</label>
                                </div>
                            </div>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Image -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Product Image</h5>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="form-text text-muted">PNG, JPG, GIF up to 2MB</small>
                            @error('image')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Additional Information</h5>
                    </div>
                    
                    <!-- Harvested/Produced Date -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harvested_date" class="form-label">Harvested/Produced Date</label>
                            <input type="date" class="form-control" id="harvested_date" name="harvested_date" value="{{ old('harvested_date') }}">
                            @error('harvested_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Expiry Date -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date (if applicable)</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                            @error('expiry_date')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Farm Location -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location" class="form-label">Farm Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" placeholder="e.g., North Field, Greenhouse 2, Barn 3">
                            @error('location')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="form-control">{{ old('notes') }}</textarea>
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
                            <button type="reset" class="btn btn-secondary">Reset Form</button>
                            <button type="submit" class="btn btn-primary">Create Product</button>
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
});
</script>
@endpush
