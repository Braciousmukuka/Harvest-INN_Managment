@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Edit Product: {{ $product->name }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-xs">
                    <i data-feather="arrow-left" style="width: 10px; height: 5px;"></i>
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-4 pb-2 border-bottom">Product Information</h5>
                        
                        <!-- Product Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name ?? old('name') }}" required>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- SKU -->
                        <div class="mb-3">
                            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku ?? old('sku') }}" required>
                            <small class="text-muted">A unique identifier for your product</small>
                            @error('sku')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Product Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ $product->description ?? old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option value="">Select a category</option>
                                <option value="crop" {{ (isset($product) && $product->category == 'crop') || old('category') == 'crop' ? 'selected' : '' }}>Crop</option>
                                <option value="livestock" {{ (isset($product) && $product->category == 'livestock') || old('category') == 'livestock' ? 'selected' : '' }}>Livestock</option>
                                <option value="dairy" {{ (isset($product) && $product->category == 'dairy') || old('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                                <option value="poultry" {{ (isset($product) && $product->category == 'poultry') || old('category') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                                <option value="other" {{ (isset($product) && $product->category == 'other') || old('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5 class="mb-4 pb-2 border-bottom">Inventory & Pricing</h5>
                        
                        <!-- Price -->
                        <div class="mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">ZMW</span>
                                <input type="number" class="form-control" id="price" name="price" value="{{ $product->price ?? old('price') }}" step="0.01" min="0" required>
                                <select class="form-select" id="price_unit" name="price_unit" style="max-width: 120px;">
                                    <option value="per_kg" {{ (isset($product) && $product->price_unit == 'per_kg') ? 'selected' : '' }}>per KG</option>
                                    <option value="per_piece" {{ (isset($product) && $product->price_unit == 'per_piece') ? 'selected' : '' }}>per Piece</option>
                                    <option value="per_liter" {{ (isset($product) && $product->price_unit == 'per_liter') ? 'selected' : '' }}>per Liter</option>
                                    <option value="per_dozen" {{ (isset($product) && $product->price_unit == 'per_dozen') ? 'selected' : '' }}>per Dozen</option>
                                </select>
                            </div>
                            @error('price')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity in Stock <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity ?? old('quantity') }}" min="0" required>
                                <select class="form-select" id="quantity_unit" name="quantity_unit" style="max-width: 120px;">
                                    <option value="kg" {{ (isset($product) && $product->quantity_unit == 'kg') ? 'selected' : '' }}>KG</option>
                                    <option value="pieces" {{ (isset($product) && $product->quantity_unit == 'pieces') ? 'selected' : '' }}>Pieces</option>
                                    <option value="liters" {{ (isset($product) && $product->quantity_unit == 'liters') ? 'selected' : '' }}>Liters</option>
                                    <option value="dozens" {{ (isset($product) && $product->quantity_unit == 'dozens') ? 'selected' : '' }}>Dozens</option>
                                </select>
                            </div>
                            @error('quantity')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Low Stock Alert -->
                        <div class="mb-3">
                            <label for="low_stock_threshold" class="form-label">Low Stock Alert Threshold</label>
                            <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold" value="{{ $product->low_stock_threshold ?? old('low_stock_threshold') }}" min="0">
                            <small class="text-muted">Get notified when stock falls below this number</small>
                            @error('low_stock_threshold')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="form-label">Product Status <span class="text-danger">*</span></label>
                            <div class="mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_in_stock" value="in_stock" {{ (isset($product) && $product->status == 'in_stock') || old('status') == 'in_stock' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_in_stock">In Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_low_stock" value="low_stock" {{ (isset($product) && $product->status == 'low_stock') || old('status') == 'low_stock' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_low_stock">Low Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status_out_of_stock" value="out_of_stock" {{ (isset($product) && $product->status == 'out_of_stock') || old('status') == 'out_of_stock' ? 'checked' : '' }}>
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
                <div class="mt-4">
                    <h5 class="mb-4 pb-2 border-bottom">Product Image</h5>
                    
                    @if(isset($product) && $product->image)
                    <div class="mb-3">
                        <label class="form-label">Current Image:</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload New Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">PNG, JPG, GIF up to 2MB</small>
                        @error('image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-4">
                    <h5 class="mb-4 pb-2 border-bottom">Additional Information</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Harvested Date -->
                            <div class="mb-3">
                                <label for="harvested_date" class="form-label">Harvested/Produced Date</label>
                                <input type="date" class="form-control" id="harvested_date" name="harvested_date" value="{{ isset($product->harvested_date) ? date('Y-m-d', strtotime($product->harvested_date)) : old('harvested_date') }}">
                                @error('harvested_date')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Expiry Date -->
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ isset($product->expiry_date) ? date('Y-m-d', strtotime($product->expiry_date)) : old('expiry_date') }}">
                                @error('expiry_date')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Farm Location -->
                    <div class="mb-3">
                        <label for="location" class="form-label">Farm Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="{{ $product->location ?? old('location') }}" placeholder="e.g., North Field, Greenhouse 2, Barn 3">
                        @error('location')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ $product->notes ?? old('notes') }}</textarea>
                        @error('notes')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="reset" class="btn btn-secondary me-3">Reset Changes</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection