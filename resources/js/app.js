import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Cache busting and redirect optimization
document.addEventListener('DOMContentLoaded', function() {
    // Force reload on back/forward navigation to prevent stale cache
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
    
    // Handle form submissions to ensure proper redirects
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            // Add a timestamp parameter to bust cache
            const timestamp = Date.now();
            
            // If it's a redirect after submit, add cache buster
            setTimeout(() => {
                if (window.location.search.indexOf('t=') === -1) {
                    const separator = window.location.search ? '&' : '?';
                    window.history.replaceState({}, '', window.location.pathname + window.location.search + separator + 't=' + timestamp);
                }
            }, 100);
        });
    });
    
    // Clear browser cache headers for AJAX requests
    if (window.fetch) {
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            const [resource, config = {}] = args;
            config.headers = {
                ...config.headers,
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            };
            return originalFetch(resource, config);
        };
    }
});
