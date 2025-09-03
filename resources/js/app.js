import './bootstrap';

// Enhanced cache busting and real-time updates
document.addEventListener('DOMContentLoaded', function() {
    // Clear browser storage and force reload on load
    if (performance.navigation.type === 1) {
        localStorage.clear();
        sessionStorage.clear();
    }
    
    // Force cache clear on page load
    if ('caches' in window) {
        caches.keys().then(names => {
            names.forEach(name => {
                caches.delete(name);
            });
        });
    }
    
    // Force reload on back/forward navigation
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload(true);
        }
    });
    
    // Handle mobile app resume
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            setTimeout(() => {
                window.location.reload(true);
            }, 500);
        }
    });
    
    // Handle form submissions with CRUD operation detection
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            localStorage.clear();
            sessionStorage.clear();
            
            // Detect CRUD operation type
            const method = form.querySelector('input[name="_method"]')?.value || form.method || 'POST';
            let operationType = 'unknown';
            
            if (method.toUpperCase() === 'POST') {
                operationType = 'create';
            } else if (method.toUpperCase() === 'PUT' || method.toUpperCase() === 'PATCH') {
                operationType = 'update';
            } else if (method.toUpperCase() === 'DELETE') {
                operationType = 'delete';
            }
            
            // Add loading state
            const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('input[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML || submitBtn.value;
                
                let loadingText = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
                if (operationType === 'create') {
                    loadingText = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
                } else if (operationType === 'update') {
                    loadingText = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
                } else if (operationType === 'delete') {
                    loadingText = '<span class="spinner-border spinner-border-sm me-2"></span>Deleting...';
                }
                
                if (submitBtn.tagName === 'BUTTON') {
                    submitBtn.innerHTML = loadingText;
                } else {
                    submitBtn.value = 'Processing...';
                }
                
                setTimeout(() => {
                    submitBtn.disabled = false;
                    if (submitBtn.tagName === 'BUTTON') {
                        submitBtn.innerHTML = originalText;
                    } else {
                        submitBtn.value = originalText;
                    }
                }, 15000);
            }
            
            // Add timestamp and operation type
            const timestamp = Date.now();
            const hiddenInputs = [
                { name: '_timestamp', value: timestamp },
                { name: '_operation_type', value: operationType },
                { name: '_browser_id', value: 'browser_' + Math.random().toString(36).substr(2, 9) }
            ];
            
            hiddenInputs.forEach(input => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = input.name;
                hiddenInput.value = input.value;
                form.appendChild(hiddenInput);
            });
        });
    });
    
    // Auto-refresh for CRUD operations
    const crudOperation = document.querySelector('meta[name="X-CRUD-Operation"]');
    const refreshRequired = document.querySelector('meta[name="X-Refresh-Required"]');
    
    // Check for flash messages indicating CRUD operations
    const flashMessages = document.querySelectorAll('.alert-success, .alert-danger, .alert-warning, .alert-info');
    let hasCrudMessage = false;
    
    flashMessages.forEach(message => {
        const text = message.textContent.toLowerCase();
        if (text.includes('created') || text.includes('updated') || text.includes('deleted') || 
            text.includes('added') || text.includes('saved') || text.includes('removed')) {
            hasCrudMessage = true;
        }
    });
    
    // Auto-refresh if CRUD operation detected
    if (crudOperation || refreshRequired || hasCrudMessage) {
        setTimeout(() => {
            window.location.reload(true);
        }, 1000);
    }
    
    // Enhanced fetch with cache busting
    if (window.fetch) {
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            const [resource, config = {}] = args;
            
            config.headers = {
                ...config.headers,
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0',
                'X-Requested-With': 'XMLHttpRequest'
            };
            
            const url = new URL(resource, window.location.origin);
            url.searchParams.set('_t', Date.now());
            
            return originalFetch(url.toString(), config);
        };
    }
    
    // Listen for storage events (cross-tab updates)
    window.addEventListener('storage', function(e) {
        if (e.key === 'crud_operation_performed') {
            setTimeout(() => {
                window.location.reload(true);
            }, 500);
        }
    });
    
    // Set storage event when CRUD operation is performed
    if (hasCrudMessage || crudOperation) {
        localStorage.setItem('crud_operation_performed', Date.now());
        setTimeout(() => {
            localStorage.removeItem('crud_operation_performed');
        }, 5000);
    }
    
    // Handle success/error messages auto-hide
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 5000);
    });
    
    // Performance monitoring
    if (performance.mark) {
        performance.mark('app-js-loaded');
        console.log('HarvestInn App.js loaded with enhanced CRUD cache busting');
    }
});

// Global function to force refresh
window.forceRefresh = function() {
    localStorage.clear();
    sessionStorage.clear();
    if ('caches' in window) {
        caches.keys().then(names => {
            names.forEach(name => {
                caches.delete(name);
            });
        });
    }
    window.location.reload(true);
};