#!/bin/bash

# HarvestInn Production Deployment Script
echo "🚀 Deploying HarvestInn Farm Management System..."

# Clear all caches
echo "📋 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

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

# Run migrations and seed initial data
echo "🗄️ Setting up database..."
php artisan migrate --force
php artisan db:seed --force

# Build frontend assets
echo "🎨 Building frontend assets..."
npm run build

echo "✅ HarvestInn deployment completed!"
echo "🌐 Your application is ready to serve!"
echo ""
echo "To start the server:"
echo "php artisan serve --host=0.0.0.0 --port=8000"
echo ""
echo "Or configure your web server to point to the 'public' directory"
