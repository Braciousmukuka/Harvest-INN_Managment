@extends('layouts.app')

@section('title', 'Products Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-3 mb-md-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-2 mb-md-0">
                <h4 class="page-title mb-1">Products Management</h4>
                <nav aria-label="breadcrumb" class="d-none d-sm-block">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 text-md-end">
                <a href="{{ route('products.create') }}" class="btn btn-dark-green btn-sm w-100 w-md-auto" style="background-color: #1e5631; border-color: #1e5631; color: white;">
                    <i data-feather="plus" style="width: 16px; height: 16px;"></i>
                    <span class="ms-1">Add Product</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green mb-1">{{ $stockStats['total'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0 small">
                                <span class="d-none d-sm-inline">Total Products</span>
                                <span class="d-sm-none">Total</span>
                            </h6>
                        </div>
                        <div class="col-4 text-end">
                            <i data-feather="package" class="f-24 text-c-green"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-blue mb-1">{{ $stockStats['in_stock'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0 small">
                                <span class="d-none d-sm-inline">In Stock</span>
                                <span class="d-sm-none">In Stock</span>
                            </h6>
                        </div>
                        <div class="col-4 text-end">
                            <i data-feather="check-circle" class="f-24 text-c-blue"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-yellow mb-1">{{ $stockStats['low_stock'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0 small">
                                <span class="d-none d-sm-inline">Low Stock</span>
                                <span class="d-sm-none">Low</span>
                            </h6>
                        </div>
                        <div class="col-4 text-end">
                            <i data-feather="alert-triangle" class="f-24 text-c-yellow"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3">
            <div class="card h-100">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-red mb-1">{{ $stockStats['out_of_stock'] ?? 0 }}</h4>
                            <h6 class="text-muted m-b-0 small">
                                <span class="d-none d-sm-inline">Out of Stock</span>
                                <span class="d-sm-none">Out</span>
                            </h6>
                        </div>
                        <div class="col-4 text-end">
                            <i data-feather="x-circle" class="f-24 text-c-red"></i>
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
                                <option value="other">Other</option>
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
                <table class="table table-hover" id="productsTable">
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
                                    @elseif($product->category == 'other') bg-secondary
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
                            <td colspan="9" class="text-center py-4">
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing functionality...');
    
    // Initialize Feather icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Table filtering functionality
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    
    function filterTable() {
        const searchValue = searchInput.value.toLowerCase();
        const categoryValue = categoryFilter.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        
        const tableRows = document.querySelectorAll('#productsTable tbody tr');
        
        tableRows.forEach(row => {
            const name = row.querySelector('td:nth-child(3)').textContent.toLowerCase(); // Product name column
            const category = row.querySelector('td:nth-child(4)').textContent.toLowerCase(); // Category column
            const status = row.querySelector('.badge').textContent.toLowerCase(); // Status badge
            
            const matchesSearch = name.includes(searchValue);
            const matchesCategory = categoryValue === '' || category.includes(categoryValue);
            const matchesStatus = statusValue === '' || status.includes(statusValue);
            
            if (matchesSearch && matchesCategory && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
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