// Products page JavaScript for Berry Dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Initialize select all checkbox functionality
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }
    
    // Auto-submit forms for filters
    document.querySelectorAll('.auto-submit').forEach(element => {
        element.addEventListener('change', function() {
            const form = document.getElementById('filter-form');
            if (form) {
                form.submit();
            }
        });
    });
    
    // Handle file upload preview
    function handleFilePreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'mt-3 file-preview';
                preview.innerHTML = `
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="${e.target.result}" alt="Preview" class="img-thumbnail me-3" style="height: 50px; width: 50px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0">${input.files[0].name}</h6>
                                        <small class="text-muted">${(input.files[0].size / 1024).toFixed(2)} KB</small>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-light-danger remove-preview">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                // Remove existing preview
                const existingPreview = input.parentNode.querySelector('.file-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                // Add new preview
                input.parentNode.appendChild(preview);
                
                // Add remove functionality
                preview.querySelector('.remove-preview').addEventListener('click', function() {
                    input.value = '';
                    preview.remove();
                });
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Attach file preview to all file inputs
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            handleFilePreview(this);
        });
    });
    
    // Bootstrap tooltip initialization
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize dropdowns
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    const dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl);
    });
});

// Alpine.js data for products page
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
            console.log('Products page initialized');
        },
        
        openAddModal() {
            this.showAddModal = true;
            this.$nextTick(() => {
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('add-product-offcanvas'));
                offcanvas.show();
            });
        },
        
        closeAddModal() {
            this.showAddModal = false;
            const offcanvasEl = document.getElementById('add-product-offcanvas');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvas) {
                offcanvas.hide();
            }
        },
        
        openEditModal(productId) {
            this.editProductId = productId;
            this.showEditModal = true;
            
            this.$nextTick(() => {
                const offcanvas = new bootstrap.Offcanvas(document.getElementById('edit-product-offcanvas'));
                offcanvas.show();
                
                // Load product data
                this.loadProductForEdit(productId);
            });
        },
        
        closeEditModal() {
            this.showEditModal = false;
            this.editProductId = null;
            const offcanvasEl = document.getElementById('edit-product-offcanvas');
            const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (offcanvas) {
                offcanvas.hide();
            }
        },
        
        openViewModal(productId) {
            this.viewProductId = productId;
            this.showViewModal = true;
            
            this.$nextTick(() => {
                const modal = new bootstrap.Modal(document.getElementById('view-product-modal'));
                modal.show();
                
                // Load product data
                this.loadProductForView(productId);
            });
        },
        
        closeViewModal() {
            this.showViewModal = false;
            this.viewProductId = null;
            const modalEl = document.getElementById('view-product-modal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        },
        
        openDeleteModal(productId) {
            this.deleteProductId = productId;
            this.showDeleteModal = true;
            
            this.$nextTick(() => {
                const modal = new bootstrap.Modal(document.getElementById('delete-product-modal'));
                modal.show();
            });
        },
        
        closeDeleteModal() {
            this.showDeleteModal = false;
            this.deleteProductId = null;
            const modalEl = document.getElementById('delete-product-modal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        },
        
        async loadProductForEdit(productId) {
            try {
                const response = await fetch(`/api/products/${productId}`);
                const data = await response.json();
                
                const formContent = document.getElementById('edit-form-content');
                if (formContent) {
                    formContent.innerHTML = this.generateEditForm(data.product);
                }
            } catch (error) {
                console.error('Error loading product for edit:', error);
                this.showError('Failed to load product data');
            }
        },
        
        async loadProductForView(productId) {
            try {
                const response = await fetch(`/api/products/${productId}`);
                const data = await response.json();
                
                const viewContent = document.getElementById('view-product-content');
                if (viewContent) {
                    viewContent.innerHTML = this.generateViewContent(data.product, data.image_url);
                }
            } catch (error) {
                console.error('Error loading product for view:', error);
                this.showError('Failed to load product data');
            }
        },
        
        generateEditForm(product) {
            return `
                <div class="form-group mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="${product.name || ''}" required>
                </div>
                
                <div class="form-group mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="${product.sku || ''}" required>
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
                                <input type="number" name="price" step="0.01" min="0" class="form-control" value="${product.price || ''}" required>
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
                            <input type="number" name="quantity" min="0" class="form-control" value="${product.quantity || ''}" required>
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
                    <input class="form-control" type="file" name="image" accept="image/*">
                    ${product.image ? `
                        <div class="mt-2">
                            <p class="mb-2 text-muted">Current Image:</p>
                            <img src="/storage/${product.image}" class="img-fluid rounded" style="max-height: 100px;">
                        </div>
                    ` : ''}
                </div>
            `;
        },
        
        generateViewContent(product, imageUrl) {
            return `
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center">
                            ${product.image && imageUrl ? 
                                `<img src="${imageUrl}" alt="${product.name}" class="img-fluid rounded border" style="max-height: 200px;">` : 
                                `<div class="bg-light rounded p-5 d-flex flex-column justify-content-center align-items-center" style="height: 200px;">
                                    <i class="ti ti-photo-off f-30 text-secondary mb-2"></i>
                                    <small class="text-muted">No image available</small>
                                </div>`
                            }
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="fw-bold mb-0">${product.name}</h4>
                            <span class="badge ${this.getStatusBadgeClass(product.status)}">
                                ${this.formatStatus(product.status)}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="badge ${this.getCategoryBadgeClass(product.category)}">
                                ${(product.category || '').toUpperCase()}
                            </span>
                            <span class="text-muted ms-2">SKU: ${product.sku}</span>
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <div class="text-muted small">Price</div>
                                        <div class="d-flex align-items-end">
                                            <h4 class="mb-0 fw-bold">ZMW ${parseFloat(product.price || 0).toFixed(2)}</h4>
                                            <span class="text-muted ms-1">${product.price_unit || ''}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card border">
                                    <div class="card-body p-3">
                                        <div class="text-muted small">Quantity</div>
                                        <div class="d-flex align-items-end">
                                            <h4 class="mb-0 fw-bold">${product.quantity || 0}</h4>
                                            <span class="text-muted ms-1">${product.quantity_unit || ''}</span>
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
                                    Created: ${this.formatDate(product.created_at)}
                                </div>
                                <div class="text-muted">
                                    <i class="ti ti-calendar-event me-1"></i> 
                                    Updated: ${this.formatDate(product.updated_at)}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        },
        
        getStatusBadgeClass(status) {
            switch(status) {
                case 'in_stock': return 'bg-success';
                case 'low_stock': return 'bg-warning';
                case 'out_of_stock': return 'bg-danger';
                default: return 'bg-secondary';
            }
        },
        
        getCategoryBadgeClass(category) {
            switch(category) {
                case 'crop': return 'bg-light-success text-success';
                case 'livestock': return 'bg-light-primary text-primary';
                case 'dairy': return 'bg-light-warning text-warning';
                case 'poultry': return 'bg-light-info text-info';
                default: return 'bg-light-secondary text-secondary';
            }
        },
        
        formatStatus(status) {
            return (status || '').replace('_', ' ').toUpperCase();
        },
        
        formatDate(dateString) {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        },
        
        showError(message) {
            // You can implement a toast notification here
            console.error(message);
            alert(message);
        },
        
        getUpdateUrl(id) {
            return `/products/${id}`;
        },
        
        getDeleteUrl(id) {
            return `/products/${id}`;
        }
    }));
});
