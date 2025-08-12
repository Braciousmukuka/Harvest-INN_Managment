<x-app-layout>
    <div x-data="productsPage">
        <!-- Page Header -->
        <x-slot name="header">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="page-header-title">
                                <h5 class="font-semibold text-xl text-harvest-green leading-tight">{{ __('Farm Products') }}</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Products</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <!-- Main Content -->
        <div class="pc-container">
            <div class="pc-content">
                <!-- Stats Row -->
                <div class="row">
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-primary rounded-circle p-2">
                                            <i class="ti ti-box f-20 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Total Products</h6>
                                        <small class="text-muted">{{ $stockStats['total'] ?? 0 }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-success rounded-circle p-2">
                                            <i class="ti ti-circle-check f-20 text-success"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">In Stock</h6>
                                        <small class="text-muted">{{ $stockStats['in_stock'] ?? 0 }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-warning rounded-circle p-2">
                                            <i class="ti ti-alert-triangle f-20 text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Low Stock</h6>
                                        <small class="text-muted">{{ $stockStats['low_stock'] ?? 0 }} <span class="text-xs text-muted">(< 20)</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="bg-light-danger rounded-circle p-2">
                                            <i class="ti ti-x f-20 text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">Out of Stock</h6>
                                        <small class="text-muted">{{ $stockStats['out_of_stock'] ?? 0 }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Products List</h5>
                                    <button @click="showAddModal = true" class="btn btn-primary">
                                        <i class="ti ti-plus me-1"></i> Add Product
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Filter Bar -->
                                <div class="row mb-3">
                                    <div class="col-md-6 col-sm-12">
                                        <form method="GET" action="{{ route('products.index') }}" id="filter-form" class="row g-2">
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ti ti-search"></i></span>
                                                    <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="category" class="form-select auto-submit">
                                                    <option value="">All Categories</option>
                                                    <option value="crop" {{ request('category') == 'crop' ? 'selected' : '' }}>Crops</option>
                                                    <option value="livestock" {{ request('category') == 'livestock' ? 'selected' : '' }}>Livestock</option>
                                                    <option value="dairy" {{ request('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                                                    <option value="poultry" {{ request('category') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                                                    <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-light-primary">
                                                    <i class="ti ti-filter me-1"></i> Filter
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 col-sm-12 text-end">
                                        <select name="sort" class="form-select w-auto d-inline-block auto-submit ms-auto">
                                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>A to Z</option>
                                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Z to A</option>
                                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                        </select>
                                        @if(request('search') || request('category') || (request('sort') && request('sort') != 'newest'))
                                        <a href="{{ route('products.index') }}" class="btn btn-link text-muted">
                                            <i class="ti ti-x me-1"></i> Clear Filters
                                        </a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Table -->
                                @if(isset($products) && $products->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="select-all">
                                                    </div>
                                                </th>
                                                <th>ID</th>
                                                <th>Product</th>
                                                <th>Category</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
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
                                                                    <i class="ti ti-box text-secondary"></i>
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
                                                        @if($product->category == 'crop') bg-light-success text-success 
                                                        @elseif($product->category == 'livestock') bg-light-primary text-primary
                                                        @elseif($product->category == 'dairy') bg-light-warning text-warning
                                                        @elseif($product->category == 'poultry') bg-light-info text-info
                                                        @else bg-light-secondary text-secondary @endif">
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
                                                            <button @click="viewProductId = {{ $product->id }}; showViewModal = true" 
                                                                class="btn btn-sm btn-icon btn-light-primary">
                                                                <i class="ti ti-eye"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item align-bottom">
                                                            <button @click="editProductId = {{ $product->id }}; showEditModal = true" 
                                                                class="btn btn-sm btn-icon btn-light-secondary">
                                                                <i class="ti ti-pencil"></i>
                                                            </button>
                                                        </li>
                                                        <li class="list-inline-item align-bottom">
                                                            <button @click="deleteProductId = {{ $product->id }}; showDeleteModal = true" 
                                                                class="btn btn-sm btn-icon btn-light-danger">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="mt-4 d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        Showing <span class="fw-semibold">{{ $products->firstItem() ?? 0 }}</span> 
                                        to <span class="fw-semibold">{{ $products->lastItem() ?? 0 }}</span> 
                                        of <span class="fw-semibold">{{ $products->total() }}</span> results
                                    </div>
                                    <div>
                                        {{ $products->withQueryString()->links() }}
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-5">
                                    <div class="avatar">
                                        <div class="avatar-title bg-light-secondary text-secondary rounded-circle">
                                            <i class="ti ti-box-off f-36"></i>
                                        </div>
                                    </div>
                                    <h5 class="mt-3">No products found</h5>
                                    <p class="text-muted">
                                        @if(request('search') || request('category') || (request('sort') && request('sort') != 'newest'))
                                            No products match your current filters.
                                        @else
                                            Get started by creating a new product.
                                        @endif
                                    </p>
                                    <button @click="showAddModal = true" class="btn btn-primary mt-2">
                                        <i class="ti ti-plus me-1"></i> Add Product
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Product Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="add-product-offcanvas" x-show="showAddModal" @click.away="showAddModal = false">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Add New Product</h5>
                <button type="button" class="btn-close" @click="showAddModal = false"></button>
            </div>
            <div class="offcanvas-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6>Please fix the following errors:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Enter product name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" 
                               placeholder="Enter SKU" value="{{ old('sku') }}" required>
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            <option value="crop" {{ old('category') == 'crop' ? 'selected' : '' }}>Crops</option>
                            <option value="livestock" {{ old('category') == 'livestock' ? 'selected' : '' }}>Livestock</option>
                            <option value="dairy" {{ old('category') == 'dairy' ? 'selected' : '' }}>Dairy</option>
                            <option value="poultry" {{ old('category') == 'poultry' ? 'selected' : '' }}>Poultry</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">ZMW</span>
                                    <input type="number" name="price" step="0.01" min="0" 
                                           class="form-control @error('price') is-invalid @enderror" 
                                           placeholder="0.00" value="{{ old('price') }}" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Price Unit</label>
                                <select name="price_unit" class="form-select">
                                    <option value="per unit">per unit</option>
                                    <option value="per kg">per kg</option>
                                    <option value="per lb">per lb</option>
                                    <option value="per dozen">per dozen</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" min="0" 
                                       class="form-control @error('quantity') is-invalid @enderror" 
                                       placeholder="0" value="{{ old('quantity') }}" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label">Quantity Unit</label>
                                <select name="quantity_unit" class="form-select">
                                    <option value="units">Units</option>
                                    <option value="kg">Kilograms</option>
                                    <option value="lb">Pounds</option>
                                    <option value="dozen">Dozen</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Status</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="in_stock" id="status-in-stock" checked>
                                <label class="form-check-label" for="status-in-stock">In Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="low_stock" id="status-low-stock">
                                <label class="form-check-label" for="status-low-stock">Low Stock</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="out_of_stock" id="status-out-stock">
                                <label class="form-check-label" for="status-out-stock">Out of Stock</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Enter product description"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Product Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*">
                        <div class="mt-3 text-center p-3 border border-dashed rounded-3">
                            <i class="ti ti-upload f-22"></i>
                            <p class="mb-0">Drop files here or click to upload</p>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light-secondary" @click="showAddModal = false">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Product</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Product Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-product-offcanvas" x-show="showEditModal" @click.away="showEditModal = false">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">Edit Product</h5>
                <button type="button" class="btn-close" @click="showEditModal = false"></button>
            </div>
            <div class="offcanvas-body">
                <form :action="getUpdateUrl(editProductId)" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div id="edit-form-content">
                        <!-- This will be populated via AJAX -->
                        <div class="d-flex justify-content-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light-secondary" @click="showEditModal = false">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Product</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- View Product Modal -->
        <div class="modal fade" id="view-product-modal" tabindex="-1" x-show="showViewModal" @click.away="showViewModal = false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Product Details</h5>
                        <button type="button" class="btn-close" @click="showViewModal = false"></button>
                    </div>
                    <div class="modal-body">
                        <div id="view-product-content">
                            <!-- This will be populated via AJAX -->
                            <div class="d-flex justify-content-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" @click="showViewModal = false">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="delete-product-modal" tabindex="-1" x-show="showDeleteModal" @click.away="showDeleteModal = false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Product</h5>
                        <button type="button" class="btn-close" @click="showDeleteModal = false"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <i class="ti ti-alert-circle f-60 text-danger"></i>
                            <h5 class="mt-3">Are you sure you want to delete this product?</h5>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" @click="showDeleteModal = false">Cancel</button>
                        <form :action="getDeleteUrl(deleteProductId)" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom-products.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/products.js') }}"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('productsPage', () => ({
                showAddModal: false,
                showEditModal: false,
                showViewModal: false,
                showDeleteModal: false,
                editProductId: null,
                viewProductId: null,
                deleteProductId: null,
                
                init() {
                    // Auto-submit filters when dropdown changes
                    document.querySelectorAll('.auto-submit').forEach(select => {
                        select.addEventListener('change', () => {
                            document.getElementById('filter-form').submit();
                        });
                    });
                    
                    // Watch for modal changes
                    this.$watch('showAddModal', value => {
                        const offcanvas = document.getElementById('add-product-offcanvas');
                        if (value) {
                            new bootstrap.Offcanvas(offcanvas).show();
                        } else {
                            const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
                            if (bsOffcanvas) bsOffcanvas.hide();
                        }
                    });
                    
                    this.$watch('showEditModal', value => {
                        const offcanvas = document.getElementById('edit-product-offcanvas');
                        if (value && this.editProductId) {
                            new bootstrap.Offcanvas(offcanvas).show();
                            
                            // Fetch product data
                            fetch(`/api/products/${this.editProductId}`)
                                .then(response => response.json())
                                .then(data => {
                                    const formContent = document.getElementById('edit-form-content');
                                    formContent.innerHTML = this.createEditForm(data.product);
                                })
                                .catch(error => {
                                    console.error('Error fetching product data:', error);
                                });
                        } else {
                            const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
                            if (bsOffcanvas) bsOffcanvas.hide();
                        }
                    });
                    
                    this.$watch('showViewModal', value => {
                        const modal = document.getElementById('view-product-modal');
                        if (value && this.viewProductId) {
                            new bootstrap.Modal(modal).show();
                            
                            // Fetch product data
                            fetch(`/api/products/${this.viewProductId}`)
                                .then(response => response.json())
                                .then(data => {
                                    const viewContent = document.getElementById('view-product-content');
                                    viewContent.innerHTML = this.createViewDetails(data.product, data.image_url);
                                })
                                .catch(error => {
                                    console.error('Error fetching product data:', error);
                                });
                        } else {
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            if (bsModal) bsModal.hide();
                        }
                    });
                    
                    this.$watch('showDeleteModal', value => {
                        const modal = document.getElementById('delete-product-modal');
                        if (value) {
                            new bootstrap.Modal(modal).show();
                        } else {
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            if (bsModal) bsModal.hide();
                        }
                    });
                    
                    // Handle file inputs
                    const imageInput = document.getElementById('image');
                    if (imageInput) {
                        imageInput.addEventListener('change', this.handleImagePreview);
                    }
                },
                
                createEditForm(product) {
                    return `
                        <div class="form-group mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" value="${product.name}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" class="form-control" value="${product.sku}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="crop" ${product.category === 'crop' ? 'selected' : ''}>Crops</option>
                                <option value="livestock" ${product.category === 'livestock' ? 'selected' : ''}>Livestock</option>
                                <option value="dairy" ${product.category === 'dairy' ? 'selected' : ''}>Dairy</option>
                                <option value="poultry" ${product.category === 'poultry' ? 'selected' : ''}>Poultry</option>
                                <option value="other" ${product.category === 'other' ? 'selected' : ''}>Other</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">ZMW</span>
                                        <input type="number" name="price" step="0.01" min="0" class="form-control" value="${product.price}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Price Unit</label>
                                    <select name="price_unit" class="form-select">
                                        <option value="per unit" ${product.price_unit === 'per unit' ? 'selected' : ''}>per unit</option>
                                        <option value="per kg" ${product.price_unit === 'per kg' ? 'selected' : ''}>per kg</option>
                                        <option value="per lb" ${product.price_unit === 'per lb' ? 'selected' : ''}>per lb</option>
                                        <option value="per dozen" ${product.price_unit === 'per dozen' ? 'selected' : ''}>per dozen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="quantity" min="0" class="form-control" value="${product.quantity}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Quantity Unit</label>
                                    <select name="quantity_unit" class="form-select">
                                        <option value="units" ${product.quantity_unit === 'units' ? 'selected' : ''}>Units</option>
                                        <option value="kg" ${product.quantity_unit === 'kg' ? 'selected' : ''}>Kilograms</option>
                                        <option value="lb" ${product.quantity_unit === 'lb' ? 'selected' : ''}>Pounds</option>
                                        <option value="dozen" ${product.quantity_unit === 'dozen' ? 'selected' : ''}>Dozen</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="in_stock" id="edit-status-in-stock" ${product.status === 'in_stock' ? 'checked' : ''}>
                                    <label class="form-check-label" for="edit-status-in-stock">In Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="low_stock" id="edit-status-low-stock" ${product.status === 'low_stock' ? 'checked' : ''}>
                                    <label class="form-check-label" for="edit-status-low-stock">Low Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="out_of_stock" id="edit-status-out-stock" ${product.status === 'out_of_stock' ? 'checked' : ''}>
                                    <label class="form-check-label" for="edit-status-out-stock">Out of Stock</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3" class="form-control">${product.description || ''}</textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Product Image</label>
                            <input class="form-control" type="file" id="edit-image" name="image" accept="image/*">
                            ${product.image ? `
                                <div class="mt-2">
                                    <p class="mb-2">Current Image:</p>
                                    <img src="/storage/${product.image}" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            ` : ''}
                        </div>
                    `;
                },
                
                createViewDetails(product, imageUrl) {
                    return `
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="text-center">
                                    ${product.image ? 
                                        `<img src="${imageUrl}" alt="${product.name}" class="img-fluid rounded border">` : 
                                        `<div class="bg-light rounded p-5 d-flex justify-content-center align-items-center">
                                            <i class="ti ti-photo-off f-30 text-secondary"></i>
                                        </div>`
                                    }
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="fw-bold mb-0">${product.name}</h4>
                                    <span class="badge 
                                        ${product.status === 'in_stock' ? 'bg-success' : 
                                        product.status === 'low_stock' ? 'bg-warning' : 'bg-danger'}">
                                        ${product.status.replace('_', ' ').toUpperCase()}
                                    </span>
                                </div>
                                
                                <div class="mb-3">
                                    <span class="badge 
                                        ${product.category === 'crop' ? 'bg-light-success text-success' : 
                                        product.category === 'livestock' ? 'bg-light-primary text-primary' :
                                        product.category === 'dairy' ? 'bg-light-warning text-warning' :
                                        product.category === 'poultry' ? 'bg-light-info text-info' :
                                        'bg-light-secondary text-secondary'}">
                                        ${product.category.toUpperCase()}
                                    </span>
                                    <span class="text-muted ms-2">SKU: ${product.sku}</span>
                                </div>
                                
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="card border">
                                            <div class="card-body p-3">
                                                <div class="text-muted small">Price</div>
                                                <div class="d-flex align-items-end">
                                                    <h4 class="mb-0 fw-bold">ZMW ${parseFloat(product.price).toFixed(2)}</h4>
                                                    <span class="text-muted ms-1">${product.price_unit}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="card border">
                                            <div class="card-body p-3">
                                                <div class="text-muted small">Quantity</div>
                                                <div class="d-flex align-items-end">
                                                    <h4 class="mb-0 fw-bold">${product.quantity}</h4>
                                                    <span class="text-muted ms-1">${product.quantity_unit}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <h6 class="fw-bold">Description</h6>
                                    <p class="text-muted">${product.description || 'No description available.'}</p>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-muted">
                                            <i class="ti ti-calendar me-1"></i> 
                                            Created: ${new Date(product.created_at).toLocaleDateString('en-US', {
                                                year: 'numeric', 
                                                month: 'short', 
                                                day: 'numeric'
                                            })}
                                        </div>
                                        <div class="text-muted">
                                            <i class="ti ti-calendar-event me-1"></i> 
                                            Updated: ${new Date(product.updated_at).toLocaleDateString('en-US', {
                                                year: 'numeric', 
                                                month: 'short', 
                                                day: 'numeric'
                                            })}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                },
                
                handleImagePreview(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.createElement('div');
                            preview.className = 'mt-3';
                            preview.innerHTML = `
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="${e.target.result}" alt="Preview" class="img-thumbnail me-3" style="height: 50px; width: 50px; object-fit: cover;">
                                                <div>
                                                    <h6 class="mb-0">${file.name}</h6>
                                                    <small class="text-muted">${(file.size / 1024).toFixed(2)} KB</small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" id="remove-preview">
                                                <i class="ti ti-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            
                            const existingPreview = event.target.nextElementSibling.nextElementSibling;
                            if (existingPreview && existingPreview.classList.contains('mt-3')) {
                                existingPreview.replaceWith(preview);
                            } else {
                                event.target.parentNode.appendChild(preview);
                            }
                            
                            document.getElementById('remove-preview').addEventListener('click', function() {
                                event.target.value = '';
                                preview.remove();
                            });
                        };
                        reader.readAsDataURL(file);
                    }
                },

                getUpdateUrl(id) {
                    return '/products/' + id;
                },

                getDeleteUrl(id) {
                    return '/products/' + id;
                }
            }))
        });
    </script>
    @endpush

</x-app-layout>
