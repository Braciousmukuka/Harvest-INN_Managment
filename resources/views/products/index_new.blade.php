@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Flash Messages -->
    <x-flash-messages />
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="page-title">Products</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i data-feather="plus" class="me-2"></i>Add Product
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted d-block">Total Products</span>
                            <h4 class="mb-0">{{ $stockStats['total'] ?? 0 }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary-subtle">
                                <span class="avatar-title text-primary">
                                    <i data-feather="package" class="font-size-18"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted d-block">In Stock</span>
                            <h4 class="mb-0">{{ $stockStats['in_stock'] ?? 0 }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success-subtle">
                                <span class="avatar-title text-success">
                                    <i data-feather="check-circle" class="font-size-18"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted d-block">Low Stock</span>
                            <h4 class="mb-0">{{ $stockStats['low_stock'] ?? 0 }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-warning-subtle">
                                <span class="avatar-title text-warning">
                                    <i data-feather="alert-triangle" class="font-size-18"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted d-block">Out of Stock</span>
                            <h4 class="mb-0">{{ $stockStats['out_of_stock'] ?? 0 }}</h4>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-danger-subtle">
                                <span class="avatar-title text-danger">
                                    <i data-feather="x-circle" class="font-size-18"></i>
                                </span>
                            </div>
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
                <div class="col">
                    <h4 class="card-title">Products List</h4>
                </div>
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <input type="text" class="form-control" placeholder="Search products..." id="searchInput">
                        </div>
                        <div class="me-3">
                            <select class="form-select" id="categoryFilter">
                                <option value="">All Categories</option>
                                <option value="crop">Crop</option>
                                <option value="livestock">Livestock</option>
                                <option value="dairy">Dairy</option>
                                <option value="poultry">Poultry</option>
                            </select>
                        </div>
                        <div>
                            <select class="form-select" id="statusFilter">
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
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="editProduct({{ $product->id }})" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editProductModal">
                                        <i data-feather="edit" class="font-size-12"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteProduct({{ $product->id }})">
                                        <i data-feather="trash-2" class="font-size-12"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i data-feather="package" class="font-size-48 mb-3"></i>
                                    <h5>No products found</h5>
                                    <p>Start by adding your first product to the system.</p>
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

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control" id="sku" name="sku" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required>
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
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
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
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price_unit" class="form-label">Price Unit</label>
                                <select class="form-select" id="price_unit" name="price_unit" required>
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
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity_unit" class="form-label">Quantity Unit</label>
                                <select class="form-select" id="quantity_unit" name="quantity_unit" required>
                                    <option value="kg">KG</option>
                                    <option value="pieces">Pieces</option>
                                    <option value="liters">Liters</option>
                                    <option value="dozens">Dozens</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
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
            if (row.querySelector('.text-muted h5')) return; // Skip "no products" row
            
            const productName = row.cells[2].textContent.toLowerCase();
            const category = row.cells[3].textContent.toLowerCase();
            const status = row.cells[6].textContent.toLowerCase();
            
            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = !categoryValue || category.includes(categoryValue);
            const matchesStatus = !statusValue || status.includes(statusValue);
            
            row.style.display = matchesSearch && matchesCategory && matchesStatus ? '' : 'none';
        });
    }
    
    searchInput.addEventListener('input', filterTable);
    categoryFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
    
    // Select all checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
            selectAllCheckbox.checked = checkedCount === productCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < productCheckboxes.length;
        });
    });
});

function editProduct(productId) {
    // Fetch product data and populate edit form
    fetch(`/products/${productId}`)
        .then(response => response.json())
        .then(product => {
            document.getElementById('edit_name').value = product.name;
            document.getElementById('edit_sku').value = product.sku;
            document.getElementById('edit_category').value = product.category;
            document.getElementById('edit_status').value = product.status;
            document.getElementById('edit_price').value = product.price;
            document.getElementById('edit_price_unit').value = product.price_unit;
            document.getElementById('edit_quantity').value = product.quantity;
            document.getElementById('edit_quantity_unit').value = product.quantity_unit;
            document.getElementById('edit_description').value = product.description || '';
            
            // Set form action
            document.getElementById('editProductForm').action = `/products/${productId}`;
            
            // Show current image if exists
            const imagePreview = document.getElementById('current_image_preview');
            if (product.image) {
                imagePreview.innerHTML = `
                    <div class="mt-2">
                        <small class="text-muted">Current image:</small><br>
                        <img src="/storage/${product.image}" alt="${product.name}" class="img-thumbnail" style="max-height: 100px;">
                    </div>
                `;
            } else {
                imagePreview.innerHTML = '';
            }
        })
        .catch(error => {
            console.error('Error fetching product:', error);
            alert('Error loading product data');
        });
}

function deleteProduct(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/products/${productId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
