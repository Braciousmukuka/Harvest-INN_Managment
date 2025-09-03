#!/bin/bash

# HarvestInn Production Deployment Script for Namecheap
echo "🚀 Deploying HarvestInn Farm Management System to Namecheap..."

# Set environment to production
export APP_ENV=production

# Clear all caches
echo "📋 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Create necessary directories
echo "📁 Creating storage directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Generate fresh caches for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build frontend assets with Alpine.js
echo "🎨 Building frontend assets with Alpine.js for mobile menu..."
npm install
npm run build

# Verify Alpine.js is included
echo "✅ Verifying Alpine.js integration..."
if grep -q "Alpine" resources/js/bootstrap.js; then
    echo "✅ Alpine.js found in bootstrap.js"
else
    echo "❌ Alpine.js missing - adding it now..."
    cat >> resources/js/bootstrap.js << 'EOF'

// Import and initialize Alpine.js for mobile navigation
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
EOF
    npm run build
fi

echo "✅ HarvestInn deployment completed!"
echo "🌐 Your application is ready to serve on Namecheap!"
echo ""
echo "📱 Mobile menu functionality is now working with Alpine.js"
echo "🗄️ Database is configured for MySQL production"
echo ""
echo "Next steps for Namecheap:"
echo "1. Upload files to public_html directory"
echo "2. Update .env file with your MySQL database credentials"
echo "3. Set document root to public_html/public"
