<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - HarvestInn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center py-3">
                    <h1 class="h3 mb-0">Farm Products</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="box" class="text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Products</h6>
                                <h4 class="mb-0 text-primary">{{ $stockStats['total'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="check-circle" class="text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">In Stock</h6>
                                <h4 class="mb-0 text-success">{{ ($stockStats['total'] ?? 0) - ($stockStats['low_stock'] ?? 0) - ($stockStats['out_of_stock'] ?? 0) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="alert-triangle" class="text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Low Stock</h6>
                                <h4 class="mb-0 text-warning">{{ $stockStats['low_stock'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                    <i data-feather="x-circle" class="text-danger"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Out of Stock</h6>
                                <h4 class="mb-0 text-danger">{{ $stockStats['out_of_stock'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Products List</h5>
                            <button class="btn btn-primary">
                                <i data-feather="plus" class="me-1"></i> Add Product
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(isset($products) && $products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td><span class="fw-medium">#{{ $product->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded" width="40" height="40" style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                                            <i data-feather="box" class="text-secondary"></i>
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
                                                @if($product->category == 'crop') bg-success 
                                                @elseif($product->category == 'livestock') bg-primary
                                                @elseif($product->category == 'dairy') bg-warning
                                                @elseif($product->category == 'poultry') bg-info
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
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i data-feather="eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <i data-feather="box" class="mb-3" style="width: 48px; height: 48px;"></i>
                            <h5>No products found</h5>
                            <p class="text-muted">Get started by creating a new product.</p>
                            <button class="btn btn-primary mt-2">
                                <i data-feather="plus" class="me-1"></i> Add Product
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
