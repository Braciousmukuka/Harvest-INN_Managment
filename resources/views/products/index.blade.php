@extends('layouts.app')

@section('title', 'Products Management')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="page-title">Products Management</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('products.create') }}" class="btn btn-dark-green btn-xs" style="background-color: #1e5631; border-color: #1e5631; color: white; font-size: 12px; padding: 4px 8px;">
                    <i data-feather="plus" style="width: 14px; height: 14px;"></i>
                    Add Product
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
                            <h4 class="text-c-green">{{ $stockStats['total'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Total Products</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="package" class="f-28 text-c-green"></i>
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
                            <h4 class="text-c-blue">{{ $stockStats['in_stock'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">In Stock</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="check-circle" class="f-28 text-c-blue"></i>
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
                            <h4 class="text-c-yellow">{{ $stockStats['low_stock'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Low Stock</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="alert-triangle" class="f-28 text-c-yellow"></i>
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
                            <h4 class="text-c-red">{{ $stockStats['out_of_stock'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0">Out of Stock</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i data-feather="x-circle" class="f-28 text-c-red"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 mb-2 mb-md-0">
                    <h4 class="card-title mb-0">Products List</h4>
                </div>
                <div class="col-12 col-md-6">
                    <div class="row g-2">
                        <div class="col-12 col-sm-4">
                            <input type="text" class="form-control form-control-sm" placeholder="Search products..." id="searchInput">
                        </div>
                        <div class="col-12 col-sm-4">
                            <select class="form-select form-select-sm" id="categoryFilter">
                                <option value="">All Categories</option>
                                <option value="crop">Crop</option>
                                <option value="livestock">Livestock</option>
                                <option value="dairy">Dairy</option>
                                <option value="poultry">Poultry</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-4">
                            <select class="form-select form-select-sm" id="statusFilter">
                                <option value="">All Status</option>
                                <option value="in_stock">In Stock</option>
                                <option value="low_stock">Low Stock</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" type="checkbox" value="{{ $product->id }}">
                                </div>
                            </td>
                            <td><span class="fw-medium">#{{ $product->id }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" width="40">
                                        @else
                                            <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                <i data-feather="package" class="text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $product->name }}</h6>
                                        <small class="text-muted">{{ $product->sku }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($product->category == 'crop') bg-primary 
                                    @elseif($product->category == 'livestock') bg-info
                                    @elseif($product->category == 'dairy') bg-warning
                                    @elseif($product->category == 'poultry') bg-success
                                    @else bg-secondary @endif">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </td>
                            <td>
                                <h6 class="mb-0">ZMW {{ number_format($product->price, 2) }}</h6>
                                <small class="text-muted">{{ $product->price_unit }}</small>
                            </td>
                            <td>
                                <h6 class="mb-0">{{ $product->quantity }}</h6>
                                <small class="text-muted">{{ $product->quantity_unit }}</small>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($product->status == 'in_stock') bg-success 
                                    @elseif($product->status == 'low_stock') bg-warning
                                    @else bg-danger @endif">
                                    {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                                </span>
                            </td>
                            <td>{{ $product->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <ul class="list-inline me-auto mb-0">
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="btn btn-sm btn-icon btn-light-primary" 
                                           title="View Product">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="btn btn-sm btn-icon btn-light-secondary" 
                                           title="Edit Product">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item align-bottom">
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" 
                                              style="display: inline-block; margin: 0;"
                                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="btn btn-sm btn-icon btn-light-danger"
                                                title="Delete Product">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="empty-state">
                                    <i data-feather="package" class="text-muted" style="font-size: 48px;"></i>
                                    <h6 class="mt-3 text-muted">No products found</h6>
                                    <p class="text-muted">Start by adding your first product to the system.</p>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                                        <i data-feather="plus" class="me-1"></i>Add Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($products->hasPages())
            <div class="row mt-3">
                <div class="col-sm-12 col-md-5">
                    <div class="dataTables_info">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-7">
                    <div class="dataTables_paginate paging_simple_numbers">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_sku" class="form-label">SKU</label>
                                <input type="text" class="form-control" id="edit_sku" name="sku" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_category" class="form-label">Category</label>
                                <select class="form-select" id="edit_category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="crop">Crop</option>
                                    <option value="livestock">Livestock</option>
                                    <option value="dairy">Dairy</option>
                                    <option value="poultry">Poultry</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" id="edit_status" name="status" required>
                                    <option value="in_stock">In Stock</option>
                                    <option value="low_stock">Low Stock</option>
                                    <option value="out_of_stock">Out of Stock</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="edit_price" name="price" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_price_unit" class="form-label">Price Unit</label>
                                <select class="form-select" id="edit_price_unit" name="price_unit" required>
                                    <option value="per_kg">Per KG</option>
                                    <option value="per_piece">Per Piece</option>
                                    <option value="per_liter">Per Liter</option>
                                    <option value="per_dozen">Per Dozen</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_quantity_unit" class="form-label">Quantity Unit</label>
                                <select class="form-select" id="edit_quantity_unit" name="quantity_unit" required>
                                    <option value="kg">KG</option>
                                    <option value="pieces">Pieces</option>
                                    <option value="liters">Liters</option>
                                    <option value="dozens">Dozens</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div id="current_image_preview"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
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
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return; // Skip "no products" row
            
            const productName = row.cells[2].textContent.toLowerCase();
            const category = row.cells[3].textContent.toLowerCase();
            const status = row.cells[6].textContent.toLowerCase();
            
            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = !categoryValue || category.includes(categoryValue);
            const matchesStatus = !statusValue || status.includes(statusValue);
            
            row.style.display = matchesSearch && matchesCategory && matchesStatus ? '' : 'none';
        });
    }
    
    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (categoryFilter) categoryFilter.addEventListener('change', filterTable);
    if (statusFilter) statusFilter.addEventListener('change', filterTable);
    
    // Select all functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // Update select all when individual checkboxes change
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(productCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(productCheckboxes).some(cb => cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });
});
</script>
@endpush
