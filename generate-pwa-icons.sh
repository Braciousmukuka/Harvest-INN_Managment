#!/bin/bash

# HarvestInn PWA Icon Generator
# This script creates PWA icons from your existing Harvest.svg

echo "🎨 Generating PWA icons for HarvestInn..."

# Check if ImageMagick is installed
if ! command -v convert &> /dev/null; then
    echo "❌ ImageMagick is not installed. Please install it first:"
    echo "Ubuntu/Debian: sudo apt-get install imagemagick"
    echo "macOS: brew install imagemagick"
    echo "Or use an online converter to create icons manually"
    exit 1
fi

# Icon sizes for PWA
sizes=(72 96 128 144 152 192 384 512)

# Create icons directory
mkdir -p public/pwa-icons

# Convert SVG to different sizes
for size in "${sizes[@]}"; do
    echo "Creating ${size}x${size} icon..."
    convert -background none -resize ${size}x${size} public/Harvest.svg public/pwa-icons/icon-${size}x${size}.png
done

echo "✅ PWA icons generated successfully!"
echo "📁 Icons saved in: public/pwa-icons/"

# Create favicon.ico
echo "🖼️ Creating favicon.ico..."
convert -background none -resize 32x32 public/Harvest.svg public/favicon.ico

echo "✅ All icons generated!"
echo ""
echo "Next steps for Namecheap hosting:"
echo "1. Upload all files to your hosting account"
echo "2. Point your domain to the 'public' folder"
echo "3. Make sure storage/ and bootstrap/cache/ are writable"
echo "4. Run: php artisan migrate --force"
echo "5. Your PWA will be ready!"
